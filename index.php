<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Timesheet Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <!-- Google Fonts - Professional Typography -->
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
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
        
        .system-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .system-subtitle {
            font-size: 14px;
            color: #718096;
            margin-top: 5px;
            font-weight: 400;
        }
        
        .content-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        /* Professional Tab Navigation */
        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            color: #4a5568;
            font-weight: 500;
            padding: 12px 24px;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            font-size: 15px;
        }
        
        .nav-tabs .nav-link:hover {
            color: var(--accent-color);
            border-bottom-color: #cbd5e0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: transparent;
            border-bottom-color: var(--accent-color);
            font-weight: 600;
        }
        
        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }
        
        /* Professional Buttons */
        .btn {
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            letter-spacing: 0.3px;
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
        
        .btn-success {
            background: var(--success-color);
            border: none;
        }
        
        .btn-success:hover {
            background: #276749;
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background: var(--warning-color);
            border: none;
            color: white;
        }
        
        .btn-danger {
            background: var(--danger-color);
            border: none;
        }
        
        .btn-outline-secondary {
            border: 2px solid #cbd5e0;
            color: #4a5568;
        }
        
        .btn-outline-secondary:hover {
            background: #f7fafc;
            border-color: #a0aec0;
        }
        
        /* Professional Tables */
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
        
        /* Badges */
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
        
        /* Alert Messages */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 16px 20px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Section Headers */
        .section-header {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--accent-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Info Box */
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
        }
        
        /* Total Row Styling */
        .total-row {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Card Headers */
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        /* Time Entry Grid */
        .time-grid {
            overflow-x: auto;
        }
        
        .weekend-row {
            background-color: #fef5e7;
        }
        
        .holiday-row {
            background-color: #fce4ec;
        }
        
        .duty-row {
            background-color: #e8f5e9;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .system-title {
                font-size: 22px;
            }
            
            .header-card {
                padding: 20px;
            }
            
            .content-card {
                padding: 20px;
            }
            
            .nav-tabs .nav-link {
                padding: 10px 16px;
                font-size: 13px;
            }
            
            .table {
                font-size: 12px;
            }
            
            .table thead th, .table tbody td {
                padding: 10px 8px;
            }
        }
        
        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        
        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spinner 0.6s linear infinite;
        }
        
        @keyframes spinner {
            to { transform: rotate(360deg); }
        }
        
        /* Status Indicators */
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .status-success {
            background: #48bb78;
        }
        
        .status-warning {
            background: #ed8936;
        }
        
        .status-danger {
            background: #f56565;
        }
    </style>
</head>
<body>
    <?php
    require_once 'Timesheet.php';
    
    $timesheet = new Timesheet();
    $message = '';
    $messageType = '';
    
    // Handle form submissions
    try {
        // Add Staff
        if (isset($_POST['add_staff'])) {
            $staffId = $_POST['staff_id'];
            $name = $_POST['name'];
            $email = $_POST['email'] ?? '';
            $category = $_POST['category'] ?? 'office';
            $earlyDay = ($_POST['early_day'] !== '' && $_POST['early_day'] !== 'none') ? $_POST['early_day'] : null;
            
            if ($timesheet->addStaff($staffId, $name, $email, $earlyDay, $category)) {
                $message = "Staff member added successfully!";
                $messageType = "success";
            } else {
                $message = "Failed to add staff member. Staff ID might already exist.";
                $messageType = "danger";
            }
        }
        
        // Update Staff Settings
        if (isset($_POST['update_staff'])) {
            $staffId = $_POST['update_staff_id'];
            $earlyDay = ($_POST['update_early_day'] !== '' && $_POST['update_early_day'] !== 'none') ? $_POST['update_early_day'] : null;
            
            if ($timesheet->updateStaffEarlyDay($staffId, $earlyDay)) {
                $message = "Staff settings updated successfully!";
                $messageType = "success";
            } else {
                $message = "Failed to update staff settings.";
                $messageType = "danger";
            }
        }
        
        // Add Single Time Entry
        if (isset($_POST['add_entry'])) {
            $staffId = $_POST['entry_staff_id'];
            $date = $_POST['entry_date'];
            $clockIn = $_POST['clock_in'];
            $clockOut = $_POST['clock_out'];
            
            if ($timesheet->addTimeEntry($staffId, $date, $clockIn, $clockOut)) {
                $message = "Time entry added successfully!";
                $messageType = "success";
            } else {
                $message = "Failed to add time entry.";
                $messageType = "danger";
            }
        }
        
        // Add Holiday
        if (isset($_POST['add_holiday'])) {
            $staffId = $_POST['holiday_staff_id'];
            $date = $_POST['holiday_date'];
            $type = $_POST['holiday_type'];
            $hours = $_POST['holiday_hours'] ?? 8;
            $notes = $_POST['holiday_notes'] ?? '';
            
            if ($timesheet->addHoliday($staffId, $date, $type, $hours, $notes)) {
                $message = "Holiday/leave added successfully!";
                $messageType = "success";
            } else {
                $message = "Failed to add holiday/leave.";
                $messageType = "danger";
            }
        }
        
        // Add Weekend Duty
        if (isset($_POST['add_duty'])) {
            $staffId = $_POST['duty_staff_id'];
            $date = $_POST['duty_date'];
            $notes = $_POST['duty_notes'] ?? '';
            
            try {
                if ($timesheet->addWeekendWateringDuty($staffId, $date, $notes)) {
                    $message = "Weekend watering duty added successfully!";
                    $messageType = "success";
                }
            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = "danger";
            }
        }
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "danger";
    }
    
    // Handle deletions
    if (isset($_GET['delete_entry'])) {
        $timesheet->deleteTimeEntry($_GET['staff_id'], $_GET['date']);
        header("Location: index.php?tab=reports&week_ending=" . $_GET['week_ending']);
        exit;
    }
    
    if (isset($_GET['delete_holiday'])) {
        $timesheet->deleteHoliday($_GET['staff_id'], $_GET['date']);
        header("Location: index.php?tab=reports&week_ending=" . $_GET['week_ending']);
        exit;
    }
    
    if (isset($_GET['delete_duty'])) {
        $timesheet->deleteWeekendDuty($_GET['staff_id'], $_GET['date']);
        header("Location: index.php?tab=reports&week_ending=" . $_GET['week_ending']);
        exit;
    }
    
    // Get data for display
    $weekEnding = $_GET['week_ending'] ?? date('Y-m-d', strtotime('this friday'));
    $staffList = $timesheet->getStaffList();
    $weeklySummary = $timesheet->getAllStaffWeeklySummary($weekEnding);
    $holidaySummary = $timesheet->getHolidaySummary($weekEnding);
    $weekendDuties = $timesheet->getAllWeekendDuties($weekEnding);
    $holidayTypes = $timesheet->getHolidayTypes();
    $staffCategories = $timesheet->getStaffCategories();
    $weekDays = $timesheet->getWeekDays();
    
    $activeTab = $_GET['tab'] ?? 'staff';
    ?>
    
    <div class="main-container">
        <!-- Header -->
        <div class="header-card">
            <h1 class="system-title">
                <i class="bi bi-clock-history"></i>
                Professional Timesheet Management System
            </h1>
            <p class="system-subtitle">Comprehensive Employee Time Tracking & Reporting</p>
        </div>
        
        <!-- Alert Messages -->
        <?php if ($message): ?>
        <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?= $messageType === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <!-- Main Content -->
        <div class="content-card">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $activeTab === 'staff' ? 'active' : '' ?>" 
                            data-bs-toggle="tab" data-bs-target="#staff-tab" type="button">
                        <i class="bi bi-people-fill"></i> Staff Management
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $activeTab === 'entries' ? 'active' : '' ?>" 
                            data-bs-toggle="tab" data-bs-target="#entries-tab" type="button">
                        <i class="bi bi-calendar-check"></i> Time Entries
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $activeTab === 'reports' ? 'active' : '' ?>" 
                            data-bs-toggle="tab" data-bs-target="#reports-tab" type="button">
                        <i class="bi bi-file-earmark-bar-graph"></i> Reports & Summary
                    </button>
                </li>
            </ul>
            
            <!-- Tab Content -->
            <div class="tab-content mt-4">
                <!-- Staff Management Tab -->
                <div class="tab-pane fade <?= $activeTab === 'staff' ? 'show active' : '' ?>" id="staff-tab">
                    <div class="row">
                        <!-- Add New Staff -->
                        <div class="col-lg-6 mb-4">
                            <h3 class="section-header">
                                <i class="bi bi-person-plus-fill"></i>
                                Add New Staff Member
                            </h3>
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Staff ID</label>
                                    <input type="text" name="staff_id" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <?php foreach ($staffCategories as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Early Day (Optional)</label>
                                    <select name="early_day" class="form-select">
                                        <option value="none">No Early Day</option>
                                        <?php foreach ($weekDays as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="add_staff" class="btn btn-primary w-100">
                                    <i class="bi bi-check-lg"></i> Add Staff Member
                                </button>
                            </form>
                        </div>
                        
                        <!-- Update Staff Settings -->
                        <div class="col-lg-6 mb-4">
                            <h3 class="section-header">
                                <i class="bi bi-gear-fill"></i>
                                Update Staff Settings
                            </h3>
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Select Staff</label>
                                    <select name="update_staff_id" class="form-select" required>
                                        <option value="">Choose staff member...</option>
                                        <?php foreach ($staffList as $staff): ?>
                                        <option value="<?= htmlspecialchars($staff['staff_id']) ?>">
                                            <?= htmlspecialchars($staff['name']) ?> (<?= htmlspecialchars($staff['staff_id']) ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Early Day</label>
                                    <select name="update_early_day" class="form-select">
                                        <option value="none">No Early Day</option>
                                        <?php foreach ($weekDays as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="update_staff" class="btn btn-warning w-100">
                                    <i class="bi bi-arrow-clockwise"></i> Update Settings
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Add Weekend Duty -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <h3 class="section-header">
                                <i class="bi bi-droplet-fill"></i>
                                Add Weekend Watering Duty
                            </h3>
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Select Supervisor</label>
                                    <select name="duty_staff_id" class="form-select" required>
                                        <option value="">Choose supervisor...</option>
                                        <?php foreach ($staffList as $staff): ?>
                                            <?php if ($staff['category'] === 'supervisor'): ?>
                                            <option value="<?= htmlspecialchars($staff['staff_id']) ?>">
                                                <?= htmlspecialchars($staff['name']) ?>
                                            </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Duty Date</label>
                                    <input type="date" name="duty_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="duty_notes" class="form-control" rows="2"></textarea>
                                </div>
                                <button type="submit" name="add_duty" class="btn btn-success w-100">
                                    <i class="bi bi-check-lg"></i> Add Watering Duty
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Time Entries Tab -->
                <div class="tab-pane fade <?= $activeTab === 'entries' ? 'show active' : '' ?>" id="entries-tab">
                    <div class="row">
                        <!-- Add Single Entry -->
                        <div class="col-lg-6 mb-4">
                            <h3 class="section-header">
                                <i class="bi bi-clock-fill"></i>
                                Add Single Time Entry
                            </h3>
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Select Staff</label>
                                    <select name="entry_staff_id" class="form-select" required>
                                        <option value="">Choose staff member...</option>
                                        <?php foreach ($staffList as $staff): ?>
                                        <option value="<?= htmlspecialchars($staff['staff_id']) ?>">
                                            <?= htmlspecialchars($staff['name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="entry_date" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Clock In</label>
                                        <input type="time" name="clock_in" class="form-control" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Clock Out</label>
                                        <input type="time" name="clock_out" class="form-control" required>
                                    </div>
                                </div>
                                <button type="submit" name="add_entry" class="btn btn-primary w-100">
                                    <i class="bi bi-check-lg"></i> Add Time Entry
                                </button>
                            </form>
                        </div>
                        
                        <!-- Add Holiday -->
                        <div class="col-lg-6 mb-4">
                            <h3 class="section-header">
                                <i class="bi bi-calendar-x-fill"></i>
                                Add Holiday/Leave
                            </h3>
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Select Staff</label>
                                    <select name="holiday_staff_id" class="form-select" required>
                                        <option value="">Choose staff member...</option>
                                        <?php foreach ($staffList as $staff): ?>
                                        <option value="<?= htmlspecialchars($staff['staff_id']) ?>">
                                            <?= htmlspecialchars($staff['name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="holiday_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Leave Type</label>
                                    <select name="holiday_type" class="form-select" required>
                                        <?php foreach ($holidayTypes as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hours</label>
                                    <input type="number" name="holiday_hours" class="form-control" value="8" step="0.5" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="holiday_notes" class="form-control" rows="2"></textarea>
                                </div>
                                <button type="submit" name="add_holiday" class="btn btn-success w-100">
                                    <i class="bi bi-check-lg"></i> Add Holiday/Leave
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Reports Tab -->
                <div class="tab-pane fade <?= $activeTab === 'reports' ? 'show active' : '' ?>" id="reports-tab">
                    <!-- Week Selection -->
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <form method="GET" class="d-flex gap-2">
                                <input type="hidden" name="tab" value="reports">
                                <input type="date" name="week_ending" class="form-control" 
                                       value="<?= htmlspecialchars($weekEnding) ?>">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> View
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <h3 class="section-header">
                        <i class="bi bi-calendar-week"></i>
                        Weekly Summary - Week Ending: <?= date('F j, Y', strtotime($weekEnding)) ?>
                    </h3>
                    
                    <!-- Weekly Summary Table -->
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Early Day</th>
                                        <th>Work Days</th>
                                        <th>Regular Hrs</th>
                                        <th>Overtime Hrs</th>
                                        <th>Holiday Days</th>
                                        <th>Holiday Hrs</th>
                                        <th>Weekend Duties</th>
                                        <th>Fuel Allow.</th>
                                        <th>Total Hours</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $grandTotalHours = 0;
                                    $grandTotalFuel = 0;
                                    foreach ($weeklySummary as $summary): 
                                        $totalHours = $summary['total_regular_hours'] + $summary['total_overtime_hours'] + $summary['total_holiday_hours'];
                                        $grandTotalHours += $totalHours;
                                        $grandTotalFuel += $summary['total_fuel_allowance'];
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($summary['staff_id']) ?></strong></td>
                                        <td><?= htmlspecialchars($summary['name']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= $summary['category'] ?>">
                                                <?= strtoupper($summary['category']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($summary['early_day']): ?>
                                                <span class="badge badge-early"><?= ucfirst($summary['early_day']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $summary['days_worked'] ?></td>
                                        <td><?= number_format($summary['total_regular_hours'], 2) ?></td>
                                        <td>
                                            <?php if ($summary['total_overtime_hours'] > 0): ?>
                                                <span class="badge badge-overtime">
                                                    <?= number_format($summary['total_overtime_hours'], 2) ?>
                                                </span>
                                            <?php else: ?>
                                                0.00
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $summary['holiday_days'] ?></td>
                                        <td><?= number_format($summary['total_holiday_hours'], 2) ?></td>
                                        <td><?= $summary['weekend_duties'] ?></td>
                                        <td>
                                            <?php if ($summary['total_fuel_allowance'] > 0): ?>
                                                <span class="badge badge-fuel">
                                                    £<?= number_format($summary['total_fuel_allowance'], 2) ?>
                                                </span>
                                            <?php else: ?>
                                                £0.00
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?= number_format($totalHours, 2) ?></strong></td>
                                        <td>
                                            <a href="staff_details.php?staff_id=<?= $summary['staff_id'] ?>&week_ending=<?= $weekEnding ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr class="total-row">
                                        <td colspan="11"><strong>GRAND TOTAL</strong></td>
                                        <td><strong><?= number_format($grandTotalHours, 2) ?> hrs</strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Weekend Duties Summary -->
                    <?php if (!empty($weekendDuties)): ?>
                    <h3 class="section-header mt-4">
                        <i class="bi bi-droplet-fill"></i>
                        Weekend Duties Summary
                    </h3>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Staff Name</th>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>Fuel Allowance</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($weekendDuties as $duty): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($duty['name']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($duty['duty_date'])) ?></td>
                                        <td><?= date('l', strtotime($duty['duty_date'])) ?></td>
                                        <td><span class="badge badge-fuel">£<?= number_format($duty['fuel_allowance'], 2) ?></span></td>
                                        <td><?= htmlspecialchars($duty['notes']) ?></td>
                                        <td>
                                            <a href="?delete_duty=1&staff_id=<?= $duty['staff_id'] ?>&date=<?= $duty['duty_date'] ?>&week_ending=<?= $weekEnding ?>&tab=reports" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Delete this duty?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Holiday Breakdown -->
                    <?php if (!empty($holidaySummary)): ?>
                    <h3 class="section-header mt-4">
                        <i class="bi bi-calendar-x"></i>
                        Holiday Breakdown
                    </h3>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Staff Name</th>
                                        <th>Date</th>
                                        <th>Leave Type</th>
                                        <th>Hours</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($holidaySummary as $holiday): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($holiday['name']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($holiday['holiday_date'])) ?></td>
                                        <td>
                                            <span class="badge bg-info text-white">
                                                <?= $holidayTypes[$holiday['holiday_type']] ?? $holiday['holiday_type'] ?>
                                            </span>
                                        </td>
                                        <td><?= number_format($holiday['total_hours'], 2) ?></td>
                                        <td>
                                            <a href="?delete_holiday=1&staff_id=<?= $holiday['staff_id'] ?>&date=<?= $holiday['holiday_date'] ?>&week_ending=<?= $weekEnding ?>&tab=reports" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Delete this holiday?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
        
        // Auto-dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>