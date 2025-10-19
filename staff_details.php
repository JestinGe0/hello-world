<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - Professional Timesheet System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2c5282;
            --accent-color: #3182ce;
            --success-color: #2d7a3e;
            --warning-color: #d97706;
            --danger-color: #c53030;
            --light-bg: #f7fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
            font-size: 14px;
            line-height: 1.6;
            color: #2d3748;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .header-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }
        
        .staff-name {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .week-info {
            font-size: 16px;
            color: #4a5568;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .content-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        .badge {
            padding: 6px 12px;
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 0.3px;
            border-radius: 6px;
        }
        
        .badge-office {
            background: #3182ce;
            color: white;
        }
        
        .badge-supervisor {
            background: #d97706;
            color: white;
        }
        
        .badge-nursery {
            background: #2d7a3e;
            color: white;
        }
        
        .badge-early {
            background: #ed8936;
            color: white;
        }
        
        .badge-overtime {
            background: #c53030;
            color: white;
        }
        
        .badge-fuel {
            background: #805ad5;
            color: white;
        }
        
        .info-box {
            background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
            border-left: 4px solid var(--accent-color);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .info-box-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 12px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-box p {
            margin-bottom: 8px;
            color: #4a5568;
        }
        
        .section-header {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--accent-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        .table {
            margin-bottom: 0;
            font-size: 13px;
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 12px;
            border: none;
            font-size: 12px;
        }
        
        .table tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table tbody tr:hover {
            background-color: #f7fafc;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .total-row {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .work-row {
            background-color: #f0fdf4;
        }
        
        .holiday-row {
            background-color: #fef3c7;
        }
        
        .type-work {
            color: var(--success-color);
            font-weight: 600;
        }
        
        .type-holiday {
            color: var(--warning-color);
            font-weight: 600;
        }
        
        .btn {
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 54, 93, 0.3);
        }
        
        .btn-danger {
            background: var(--danger-color);
            border: none;
        }
        
        .btn-danger:hover {
            background: #9b2c2c;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        @media (max-width: 768px) {
            .staff-name {
                font-size: 22px;
            }
            
            .header-card {
                padding: 20px;
            }
            
            .content-card {
                padding: 20px;
            }
            
            .table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <?php
    require_once 'Timesheet.php';
    $timesheet = new Timesheet();
    
    $staffId = $_GET['staff_id'] ?? '';
    $weekEnding = $_GET['week_ending'] ?? date('Y-m-d', strtotime('this friday'));
    
    // Handle deletions
    if (isset($_GET['delete_entry'])) {
        $timesheet->deleteTimeEntry($staffId, $_GET['date']);
        header("Location: staff_details.php?staff_id=$staffId&week_ending=$weekEnding");
        exit;
    }
    
    if (isset($_GET['delete_holiday'])) {
        $timesheet->deleteHoliday($staffId, $_GET['date']);
        header("Location: staff_details.php?staff_id=$staffId&week_ending=$weekEnding");
        exit;
    }
    
    if (isset($_GET['delete_duty'])) {
        $timesheet->deleteWeekendDuty($staffId, $_GET['date']);
        header("Location: staff_details.php?staff_id=$staffId&week_ending=$weekEnding");
        exit;
    }
    
    $weeklySummary = $timesheet->getWeeklySummary($staffId, $weekEnding);
    $dailyDetails = $timesheet->getDailyDetails($staffId, $weekEnding);
    
    $weekendDuties = [];
    if ($weeklySummary && isset($weeklySummary['category']) && $weeklySummary['category'] === 'supervisor') {
        $weekendDuties = $timesheet->getWeekendDuties($staffId, $weekEnding);
    }
    
    $holidayTypes = $timesheet->getHolidayTypes();
    $officeHoursInfo = $timesheet->getOfficeHoursInfo();
    
    if (!$weeklySummary) {
        die("<div class='alert alert-danger m-5'>Staff member not found! Staff ID: " . htmlspecialchars($staffId) . "</div>");
    }
    ?>
    
    <div class="main-container">
        <!-- Header -->
        <div class="header-card">
            <h1 class="staff-name">
                <i class="bi bi-person-circle"></i>
                <?= htmlspecialchars($weeklySummary['name']) ?>
            </h1>
            <div class="week-info">
                <span>
                    <i class="bi bi-calendar-week"></i>
                    <strong>Week Ending:</strong> <?= date('F j, Y', strtotime($weekEnding)) ?>
                </span>
                <span class="badge badge-<?= $weeklySummary['category'] ?>">
                    <?= strtoupper($weeklySummary['category']) ?> STAFF
                </span>
                <?php if ($weeklySummary['early_day']): ?>
                    <span class="badge badge-early">
                        <i class="bi bi-clock"></i> Early Day: <?= ucfirst($weeklySummary['early_day']) ?>
                    </span>
                <?php endif; ?>
                <?php if (isset($weeklySummary['total_fuel_allowance']) && $weeklySummary['total_fuel_allowance'] > 0): ?>
                    <span class="badge badge-fuel">
                        <i class="bi bi-fuel-pump"></i> Fuel Allowance: £<?= number_format($weeklySummary['total_fuel_allowance'], 2) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Office Hours Info -->
        <div class="content-card">
            <div class="info-box">
                <h3 class="info-box-title">
                    <i class="bi bi-info-circle-fill"></i>
                    Office Hours & Break Information
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="bi bi-clock"></i> <strong>Office Hours:</strong> <?= $officeHoursInfo['office_start'] ?> - <?= $officeHoursInfo['office_end'] ?></p>
                        <p><i class="bi bi-cup-hot"></i> <strong>Breaks:</strong> Morning (10:30-10:45), Lunch (13:00-13:45)</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="bi bi-hourglass-split"></i> <strong>Regular Hours:</strong> <?= $officeHoursInfo['regular_hours'] ?> hours/day
                            <?php if ($weeklySummary['early_day']): ?>
                                | Early Day (<?= ucfirst($weeklySummary['early_day']) ?>): <?= ($officeHoursInfo['regular_hours'] - 1) ?> hours
                            <?php endif; ?>
                        </p>
                        <p><i class="bi bi-clock-history"></i> <strong>Overtime:</strong> Any work beyond regular hours</p>
                        <?php if ($weeklySummary['category'] === 'supervisor'): ?>
                            <p><i class="bi bi-fuel-pump"></i> <strong>Fuel Allowance:</strong> £<?= Timesheet::FUEL_ALLOWANCE_RATE ?> for weekend watering duties</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <a href="index.php?tab=reports&week_ending=<?= $weekEnding ?>" class="btn btn-primary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Summary
            </a>
            
            <h3 class="section-header">
                <i class="bi bi-calendar-check-fill"></i>
                Daily Time Records
            </h3>
            
            <!-- Daily Details Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Type</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Leave Type</th>
                                <th>Regular Hours</th>
                                <th>Overtime Hours</th>
                                <th>Total Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $workRegularTotal = 0;
                            $workOvertimeTotal = 0;
                            $holidayTotal = 0;
                            foreach ($dailyDetails as $day): 
                                $rowClass = $day['type'] == 'holiday' ? 'holiday-row' : 'work-row';
                                $typeClass = $day['type'] == 'holiday' ? 'type-holiday' : 'type-work';
                                
                                if ($day['type'] == 'work') {
                                    $workRegularTotal += $day['regular_hours'];
                                    $workOvertimeTotal += $day['overtime_hours'];
                                } else {
                                    $holidayTotal += $day['total_hours'];
                                }
                                
                                $isEarlyDay = $timesheet->isEarlyDay($day['day_date'], $weeklySummary['early_day']);
                            ?>
                            <tr class="<?= $rowClass ?>">
                                <td><strong><?= date('Y-m-d', strtotime($day['day_date'])) ?></strong></td>
                                <td>
                                    <?= date('l', strtotime($day['day_date'])) ?>
                                    <?php if ($isEarlyDay): ?>
                                        <span class="badge badge-early">Early</span>
                                    <?php endif; ?>
                                </td>
                                <td class="<?= $typeClass ?>">
                                    <i class="bi bi-<?= $day['type'] == 'work' ? 'briefcase-fill' : 'calendar-x-fill' ?>"></i>
                                    <?= ucfirst($day['type']) ?>
                                </td>
                                <td><?= $day['clock_in'] ?: '-' ?></td>
                                <td><?= $day['clock_out'] ?: '-' ?></td>
                                <td>
                                    <?php if ($day['holiday_type']): ?>
                                        <span class="badge bg-info text-white">
                                            <?= $holidayTypes[$day['holiday_type']] ?? $day['holiday_type'] ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($day['regular_hours'], 2) ?></td>
                                <td>
                                    <?php if ($day['overtime_hours'] > 0): ?>
                                        <span class="badge badge-overtime">
                                            <?= number_format($day['overtime_hours'], 2) ?> OT
                                        </span>
                                    <?php else: ?>
                                        0.00
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= number_format($day['total_hours'], 2) ?></strong></td>
                                <td>
                                    <?php if ($day['type'] == 'work'): ?>
                                        <a href="?delete_entry=1&staff_id=<?= $staffId ?>&date=<?= $day['day_date'] ?>&week_ending=<?= $weekEnding ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this time entry?')">
                                           <i class="bi bi-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="?delete_holiday=1&staff_id=<?= $staffId ?>&date=<?= $day['day_date'] ?>&week_ending=<?= $weekEnding ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this holiday entry?')">
                                           <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Summary Rows -->
                            <tr class="total-row">
                                <td colspan="6"><i class="bi bi-calculator"></i> <strong>Work Regular Hours Total</strong></td>
                                <td><strong><?= number_format($workRegularTotal, 2) ?> hrs</strong></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="6"><i class="bi bi-clock-history"></i> <strong>Work Overtime Hours Total</strong></td>
                                <td></td>
                                <td><strong><?= number_format($workOvertimeTotal, 2) ?> hrs</strong></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="6"><i class="bi bi-calendar-x"></i> <strong>Holiday Hours Total</strong></td>
                                <td colspan="2"></td>
                                <td><strong><?= number_format($holidayTotal, 2) ?> hrs</strong></td>
                                <td></td>
                            </tr>
                            <?php if (isset($weeklySummary['total_fuel_allowance']) && $weeklySummary['total_fuel_allowance'] > 0): ?>
                            <tr class="total-row">
                                <td colspan="6"><i class="bi bi-fuel-pump"></i> <strong>Fuel Allowance Total</strong></td>
                                <td colspan="2"></td>
                                <td><strong>£<?= number_format($weeklySummary['total_fuel_allowance'], 2) ?></strong></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>
                            <tr class="total-row" style="background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);">
                                <td colspan="6"><i class="bi bi-check-circle-fill"></i> <strong>GRAND TOTAL HOURS</strong></td>
                                <td colspan="2"></td>
                                <td><strong style="font-size: 16px; color: var(--primary-color);"><?= number_format($workRegularTotal + $workOvertimeTotal + $holidayTotal, 2) ?> hrs</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Weekend Duties Section -->
            <?php if ($weeklySummary['category'] === 'supervisor'): ?>
            <h3 class="section-header">
                <i class="bi bi-droplet-fill"></i>
                Weekend Watering Duties
            </h3>
            
            <?php if (!empty($weekendDuties)): ?>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Fuel Allowance</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($weekendDuties as $duty): ?>
                            <tr class="duty-row">
                                <td><strong><?= $duty['duty_date'] ?></strong></td>
                                <td><?= date('l', strtotime($duty['duty_date'])) ?></td>
                                <td><span class="badge badge-fuel">£<?= number_format($duty['fuel_allowance'], 2) ?></span></td>
                                <td><?= htmlspecialchars($duty['notes']) ?></td>
                                <td>
                                    <a href="?delete_duty=1&staff_id=<?= $staffId ?>&date=<?= $duty['duty_date'] ?>&week_ending=<?= $weekEnding ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this watering duty?')">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No weekend watering duties recorded for this week.
            </div>
            <?php endif; ?>
            <?php endif; ?>
            
            <a href="index.php?tab=reports&week_ending=<?= $weekEnding ?>" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left"></i> Back to Summary
            </a>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>