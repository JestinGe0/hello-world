<?php
require_once 'config.php';

class Timesheet {
    private $db;

    // Office hours configuration
    const OFFICE_START = '07:45';
    const OFFICE_END = '16:45';
    const MORNING_BREAK_START = '10:30';
    const MORNING_BREAK_END = '10:45';
    const LUNCH_BREAK_START = '13:00';
    const LUNCH_BREAK_END = '13:45';
    const REGULAR_HOURS_PER_DAY = 8;
    const FUEL_ALLOWANCE_RATE = 4.00;

    public function __construct() {
        $this->db = Config::getConnection();
    }

    public function columnExists($table, $column) {
        try {
            $stmt = $this->db->prepare("SHOW COLUMNS FROM $table LIKE ?");
            $stmt->execute([$column]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("PDOException in columnExists: " . $e->getMessage());
            return false;
        }
    }

    public function tableExists($table) {
        try {
            $result = $this->db->query("SELECT 1 FROM `$table` LIMIT 1");
            return true;
        } catch (PDOException $e) {
            error_log("PDOException in tableExists for table '$table': " . $e->getMessage());
            return false;
        }
    }

    public function addStaff($staffId, $name, $email = '', $earlyDay = null, $category = 'office') {
        try {
            $fuelAllowance = ($category === 'supervisor') ? self::FUEL_ALLOWANCE_RATE : 0.00;

            if ($this->columnExists('staff', 'category')) {
                $sql = "INSERT INTO staff (staff_id, name, email, early_day, category, fuel_allowance_rate)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$staffId, $name, $email, $earlyDay, $category, $fuelAllowance]);
            } else {
                $sql = "INSERT INTO staff (staff_id, name, email, early_day)
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$staffId, $name, $email, $earlyDay]);
            }
        } catch (PDOException $e) {
            error_log("Error adding staff: " . $e->getMessage());
            return false;
        }
    }

    public function updateStaffEarlyDay($staffId, $earlyDay) {
        try {
            $sql = "UPDATE staff SET early_day = ? WHERE staff_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$earlyDay, $staffId]);
        } catch (PDOException $e) {
            error_log("Error updating early day for staff '$staffId': " . $e->getMessage());
            return false;
        }
    }

    public function addTimeEntry($staffId, $dayDate, $clockIn, $clockOut) {
        try {
            $staff = $this->getStaff($staffId);
            if (!$staff) {
                throw new Exception("Staff member not found: $staffId");
            }

            $isEarlyDay = $this->isEarlyDay($dayDate, $staff['early_day']);
            $hoursData = $this->calculateHoursWithBreaks($clockIn, $clockOut, $isEarlyDay);
            $weekEnding = $this->getWeekEnding($dayDate);

            $sql = "INSERT INTO timesheets (staff_id, week_ending, day_date, clock_in, clock_out, total_hours, regular_hours, overtime_hours)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    clock_in = VALUES(clock_in),
                    clock_out = VALUES(clock_out),
                    total_hours = VALUES(total_hours),
                    regular_hours = VALUES(regular_hours),
                    overtime_hours = VALUES(overtime_hours)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $staffId,
                $weekEnding,
                $dayDate,
                $clockIn,
                $clockOut,
                $hoursData['total_hours'],
                $hoursData['regular_hours'],
                $hoursData['overtime_hours']
            ]);
        } catch (Exception $e) {
            error_log("Error adding time entry for staff '$staffId' on '$dayDate': " . $e->getMessage());
            return false;
        }
    }

    private function calculateHoursWithBreaks($clockIn, $clockOut, $isEarlyDay = false) {
        if (empty($clockIn) || empty($clockOut)) {
            return ['total_hours' => 0, 'regular_hours' => 0, 'overtime_hours' => 0];
        }

        $in = strtotime($clockIn);
        $out = strtotime($clockOut);

        if ($out < $in) {
            $out = strtotime($clockOut . ' +1 day');
        }

        $totalMinutes = ($out - $in) / 60;
        $totalHours = $totalMinutes / 60;
        $breakMinutes = $this->calculateBreakMinutes($clockIn, $clockOut);
        $netHours = ($totalMinutes - $breakMinutes) / 60;

        $regularHours = min($netHours, self::REGULAR_HOURS_PER_DAY);
        $overtimeHours = max($netHours - self::REGULAR_HOURS_PER_DAY, 0);

        if ($isEarlyDay) {
            $earlyDayRegularHours = self::REGULAR_HOURS_PER_DAY - 1;
            $regularHours = min($netHours, $earlyDayRegularHours);
            $overtimeHours = max($netHours - $earlyDayRegularHours, 0);
        }

        return [
            'total_hours' => round($netHours, 2),
            'regular_hours' => round($regularHours, 2),
            'overtime_hours' => round($overtimeHours, 2)
        ];
    }

    private function calculateBreakMinutes($clockIn, $clockOut) {
        $breakMinutes = 0;

        if ($this->isTimeBetween($clockIn, $clockOut, self::MORNING_BREAK_START, self::MORNING_BREAK_END)) {
            $breakMinutes += 15;
        }

        if ($this->isTimeBetween($clockIn, $clockOut, self::LUNCH_BREAK_START, self::LUNCH_BREAK_END)) {
            $breakMinutes += 45;
        }

        return $breakMinutes;
    }

    private function isTimeBetween($startTime, $endTime, $breakStart, $breakEnd) {
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $breakS = strtotime($breakStart);
        $breakE = strtotime($breakEnd);

        if ($end < $start) {
            $end = strtotime($endTime . ' +1 day');
        }

        return ($breakS >= $start && $breakE <= $end);
    }

    public function isEarlyDay($date, $earlyDay) {
        if (!$earlyDay) return false;
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        return $dayOfWeek === $earlyDay;
    }

    public function getStaff($staffId) {
        try {
            if ($this->columnExists('staff', 'category')) {
                $sql = "SELECT *, category, fuel_allowance_rate FROM staff WHERE staff_id = ?";
            } else {
                $sql = "SELECT *, 'office' as category, 0.00 as fuel_allowance_rate FROM staff WHERE staff_id = ?";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$staffId]);
            $staff = $stmt->fetch(PDO::FETCH_ASSOC);
            return $staff ?: null;
        } catch (PDOException $e) {
            error_log("Error getting staff details for ID '$staffId': " . $e->getMessage());
            return null;
        }
    }

    public function addHoliday($staffId, $holidayDate, $holidayType, $hours = 8, $notes = '') {
        try {
            $sql = "INSERT INTO holidays (staff_id, holiday_date, holiday_type, hours, notes)
                    VALUES (?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    holiday_type = VALUES(holiday_type),
                    hours = VALUES(hours),
                    notes = VALUES(notes)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$staffId, $holidayDate, $holidayType, $hours, $notes]);
        } catch (PDOException $e) {
            error_log("Error adding holiday for staff '$staffId' on '$holidayDate': " . $e->getMessage());
            return false;
        }
    }

    public function addWeekendWateringDuty($staffId, $dutyDate, $notes = '') {
        try {
            if (!$this->tableExists('weekend_duties')) {
                throw new Exception("Weekend duties table not available.");
            }

            if ($this->columnExists('staff', 'category')) {
                $staff = $this->getStaff($staffId);
                if ($staff && $staff['category'] !== 'supervisor') {
                    throw new Exception("Only supervisors can be assigned weekend watering duties.");
                }
            }

            $sql = "INSERT INTO weekend_duties (staff_id, duty_date, fuel_allowance, notes)
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    fuel_allowance = VALUES(fuel_allowance),
                    notes = VALUES(notes)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$staffId, $dutyDate, self::FUEL_ALLOWANCE_RATE, $notes]);
        } catch (Exception $e) {
            error_log("Error adding weekend duty for staff '$staffId' on '$dutyDate': " . $e->getMessage());
            throw $e;
        }
    }

    public function getWeekendDuties($staffId, $weekEnding) {
        try {
            if (!$this->tableExists('weekend_duties')) {
                return [];
            }

            $startDate = date('Y-m-d', strtotime($weekEnding . ' -6 days'));

            $sql = "SELECT wd.*, s.name
                    FROM weekend_duties wd
                    JOIN staff s ON wd.staff_id = s.staff_id
                    WHERE wd.duty_date BETWEEN ? AND ?
                    AND wd.staff_id = ?
                    ORDER BY wd.duty_date";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$startDate, $weekEnding, $staffId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting weekend duties: " . $e->getMessage());
            return [];
        }
    }

    public function getAllWeekendDuties($weekEnding) {
        try {
            if (!$this->tableExists('weekend_duties')) {
                return [];
            }

            $startDate = date('Y-m-d', strtotime($weekEnding . ' -6 days'));

            if ($this->columnExists('staff', 'category')) {
                $sql = "SELECT wd.*, s.name, s.category
                        FROM weekend_duties wd
                        JOIN staff s ON wd.staff_id = s.staff_id
                        WHERE wd.duty_date BETWEEN ? AND ?
                        ORDER BY s.name, wd.duty_date";
            } else {
                $sql = "SELECT wd.*, s.name, 'office' as category
                        FROM weekend_duties wd
                        JOIN staff s ON wd.staff_id = s.staff_id
                        WHERE wd.duty_date BETWEEN ? AND ?
                        ORDER BY s.name, wd.duty_date";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$startDate, $weekEnding]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all weekend duties: " . $e->getMessage());
            return [];
        }
    }

    public function deleteWeekendDuty($staffId, $dutyDate) {
        try {
            if (!$this->tableExists('weekend_duties')) {
                return false;
            }

            $sql = "DELETE FROM weekend_duties WHERE staff_id = ? AND duty_date = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$staffId, $dutyDate]);
        } catch (PDOException $e) {
            error_log("Error deleting weekend duty: " . $e->getMessage());
            return false;
        }
    }

    public function getWeekEnding($date) {
        $timestamp = strtotime($date);
        $dayOfWeek = date('N', $timestamp);

        if ($dayOfWeek == 5) {
            return date('Y-m-d', $timestamp);
        }

        $friday = date('Y-m-d', strtotime('next friday', $timestamp));
        return $friday;
    }

    public function getWeekStart($weekEnding) {
        return date('Y-m-d', strtotime($weekEnding . ' -6 days'));
    }

    public function getWeeklySummary($staffId, $weekEnding) {
        try {
            $startDate = $this->getWeekStart($weekEnding);
            $staff = $this->getStaff($staffId);
            if (!$staff) {
                return null;
            }

            $selects = [
                "staff.name",
                "staff.staff_id",
                "staff.early_day",
                "COALESCE(SUM(t.total_hours), 0) as total_weekly_hours",
                "COALESCE(SUM(t.regular_hours), 0) as total_regular_hours",
                "COALESCE(SUM(t.overtime_hours), 0) as total_overtime_hours",
                "COUNT(t.day_date) as days_worked",
                "COALESCE(SUM(h.hours), 0) as total_holiday_hours",
                "COUNT(h.holiday_date) as holiday_days"
            ];

            if ($this->columnExists('staff', 'category')) {
                $selects[] = "staff.category";
            } else {
                $selects[] = "'office' as category";
            }

            if ($this->tableExists('weekend_duties')) {
                $selects[] = "COALESCE(SUM(wd.fuel_allowance), 0) as total_fuel_allowance";
                $selects[] = "COUNT(wd.duty_date) as weekend_duties";
            } else {
                $selects[] = "0 as total_fuel_allowance";
                $selects[] = "0 as weekend_duties";
            }

            $sql = "SELECT " . implode(", ", $selects) . "
                    FROM staff
                    LEFT JOIN timesheets t ON staff.staff_id = t.staff_id AND t.week_ending = ?
                    LEFT JOIN holidays h ON staff.staff_id = h.staff_id AND h.holiday_date BETWEEN ? AND ?";

            if ($this->tableExists('weekend_duties')) {
                $sql .= " LEFT JOIN weekend_duties wd ON staff.staff_id = wd.staff_id AND wd.duty_date BETWEEN ? AND ?";
            }

            $sql .= " WHERE staff.staff_id = ?
                     GROUP BY staff.id, staff.staff_id, staff.name, staff.early_day";

            $stmt = $this->db->prepare($sql);
            $params = [$weekEnding, $startDate, $weekEnding];
            if ($this->tableExists('weekend_duties')) {
                $params[] = $startDate;
                $params[] = $weekEnding;
            }
            $params[] = $staffId;

            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error getting weekly summary: " . $e->getMessage());
            return null;
        }
    }

    public function getDailyDetails($staffId, $weekEnding) {
        try {
            $startDate = $this->getWeekStart($weekEnding);

            $sqlWork = "SELECT day_date, clock_in, clock_out, total_hours, regular_hours, overtime_hours, 'work' as type, '' as holiday_type
                        FROM timesheets WHERE staff_id = ? AND week_ending = ? ORDER BY day_date";
            $stmtWork = $this->db->prepare($sqlWork);
            $stmtWork->execute([$staffId, $weekEnding]);
            $workDays = $stmtWork->fetchAll(PDO::FETCH_ASSOC);

            $sqlHoliday = "SELECT holiday_date as day_date, '' as clock_in, '' as clock_out, hours as total_hours, 0 as regular_hours, 0 as overtime_hours, 'holiday' as type, holiday_type
                          FROM holidays WHERE staff_id = ? AND holiday_date BETWEEN ? AND ? ORDER BY holiday_date";
            $stmtHoliday = $this->db->prepare($sqlHoliday);
            $stmtHoliday->execute([$staffId, $startDate, $weekEnding]);
            $holidayDays = $stmtHoliday->fetchAll(PDO::FETCH_ASSOC);

            $allDays = array_merge($workDays, $holidayDays);
            usort($allDays, function($a, $b) {
                return strcmp($a['day_date'], $b['day_date']);
            });

            return $allDays;
        } catch (PDOException $e) {
            error_log("Error getting daily details: " . $e->getMessage());
            return [];
        }
    }

    public function getAllStaffWeeklySummary($weekEnding) {
        try {
            $startDate = $this->getWeekStart($weekEnding);

            $selects = [
                "staff.name",
                "staff.staff_id",
                "staff.early_day",
                "COALESCE(SUM(t.total_hours), 0) as total_weekly_hours",
                "COALESCE(SUM(t.regular_hours), 0) as total_regular_hours",
                "COALESCE(SUM(t.overtime_hours), 0) as total_overtime_hours",
                "COUNT(t.day_date) as days_worked",
                "COALESCE(SUM(h.hours), 0) as total_holiday_hours",
                "COUNT(h.holiday_date) as holiday_days"
            ];

            $groupBy = ["staff.staff_id", "staff.name", "staff.early_day"];

            if ($this->columnExists('staff', 'category')) {
                $selects[] = "staff.category";
                $groupBy[] = "staff.category";
            } else {
                $selects[] = "'office' as category";
            }

            if ($this->tableExists('weekend_duties')) {
                $selects[] = "COALESCE(SUM(wd.fuel_allowance), 0) as total_fuel_allowance";
                $selects[] = "COUNT(wd.duty_date) as weekend_duties";
            } else {
                $selects[] = "0 as total_fuel_allowance";
                $selects[] = "0 as weekend_duties";
            }

            $sql = "SELECT " . implode(", ", $selects) . "
                    FROM staff
                    LEFT JOIN timesheets t ON staff.staff_id = t.staff_id AND t.week_ending = ?
                    LEFT JOIN holidays h ON staff.staff_id = h.staff_id AND h.holiday_date BETWEEN ? AND ?";

            if ($this->tableExists('weekend_duties')) {
                $sql .= " LEFT JOIN weekend_duties wd ON staff.staff_id = wd.staff_id AND wd.duty_date BETWEEN ? AND ?";
            }

            $sql .= " GROUP BY " . implode(", ", $groupBy) . " ORDER BY staff.name";

            $stmt = $this->db->prepare($sql);
            $params = [$weekEnding, $startDate, $weekEnding];
            if ($this->tableExists('weekend_duties')) {
                $params[] = $startDate;
                $params[] = $weekEnding;
            }

            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all staff weekly summary: " . $e->getMessage());
            return [];
        }
    }

    public function getHolidaySummary($weekEnding) {
        try {
            $startDate = $this->getWeekStart($weekEnding);

            $sql = "SELECT staff.name, staff.staff_id, h.holiday_type, h.holiday_date, h.hours as total_hours, 1 as days_count
                    FROM holidays h
                    JOIN staff ON h.staff_id = staff.staff_id
                    WHERE h.holiday_date BETWEEN ? AND ?
                    ORDER BY staff.name, h.holiday_date, h.holiday_type";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$startDate, $weekEnding]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting holiday summary: " . $e->getMessage());
            return [];
        }
    }

    public function getStaffList() {
        try {
            if ($this->columnExists('staff', 'category')) {
                $sql = "SELECT staff_id, name, early_day, category FROM staff ORDER BY name";
            } else {
                $sql = "SELECT staff_id, name, early_day, 'office' as category FROM staff ORDER BY name";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting staff list: " . $e->getMessage());
            return [];
        }
    }

    public function getHolidayTypes() {
        return [
            'vacation' => 'Vacation Leave',
            'sick' => 'Sick Leave',
            'personal' => 'Personal Leave',
            'public' => 'Public Holiday'
        ];
    }

    public function getStaffCategories() {
        return [
            'office' => 'Office Staff',
            'supervisor' => 'Supervisor',
            'nursery' => 'Nursery Staff'
        ];
    }

    public function getWeekDays() {
        return [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday'
        ];
    }

    public function deleteTimeEntry($staffId, $dayDate) {
        try {
            $sql = "DELETE FROM timesheets WHERE staff_id = ? AND day_date = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$staffId, $dayDate]);
        } catch (PDOException $e) {
            error_log("Error deleting time entry: " . $e->getMessage());
            return false;
        }
    }

    public function deleteHoliday($staffId, $holidayDate) {
        try {
            $sql = "DELETE FROM holidays WHERE staff_id = ? AND holiday_date = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$staffId, $holidayDate]);
        } catch (PDOException $e) {
            error_log("Error deleting holiday: " . $e->getMessage());
            return false;
        }
    }

    public function getOfficeHoursInfo() {
        return [
            'office_start' => self::OFFICE_START,
            'office_end' => self::OFFICE_END,
            'morning_break' => self::MORNING_BREAK_START . ' - ' . self::MORNING_BREAK_END,
            'lunch_break' => self::LUNCH_BREAK_START . ' - ' . self::LUNCH_BREAK_END,
            'regular_hours' => self::REGULAR_HOURS_PER_DAY
        ];
    }

    public function bulkInsertTimeEntries($entries) {
        $results = [];
        foreach ($entries as $entry) {
            try {
                $success = $this->addTimeEntry(
                    $entry['staff_id'],
                    $entry['date'],
                    $entry['clock_in'],
                    $entry['clock_out']
                );
                $results[] = [
                    'date' => $entry['date'],
                    'clock_in' => $entry['clock_in'],
                    'clock_out' => $entry['clock_out'],
                    'success' => $success
                ];
            } catch (Exception $e) {
                $results[] = [
                    'date' => $entry['date'],
                    'clock_in' => $entry['clock_in'],
                    'clock_out' => $entry['clock_out'],
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }
        return $results;
    }

    public function updateStaffHours($staffId, $weeklyHours) {
        try {
            if (!$this->columnExists('staff', 'weekly_hours')) {
                error_log("Attempted to update 'weekly_hours' but the column does not exist.");
                return false;
            }

            $sql = "UPDATE staff SET weekly_hours = ? WHERE staff_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$weeklyHours, $staffId]);
        } catch (PDOException $e) {
            error_log("Error updating staff hours: " . $e->getMessage());
            return false;
        }
    }

    public function getStaffWeeklyHours($staffId) {
        try {
            if ($this->columnExists('staff', 'weekly_hours')) {
                $sql = "SELECT weekly_hours FROM staff WHERE staff_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$staffId]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result ? $result['weekly_hours'] : 39.00;
            }
            return 39.00;
        } catch (PDOException $e) {
            error_log("Error getting staff weekly hours: " . $e->getMessage());
            return 39.00;
        }
    }
}
?>