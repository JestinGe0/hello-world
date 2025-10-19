-- Professional Timesheet Management System
-- Database Schema Setup
-- MySQL/MariaDB Compatible

-- Drop existing tables if you want to start fresh (CAUTION: This will delete all data!)
-- DROP TABLE IF EXISTS weekend_duties;
-- DROP TABLE IF EXISTS holidays;
-- DROP TABLE IF EXISTS timesheets;
-- DROP TABLE IF EXISTS staff;

-- Create database (if needed)
-- CREATE DATABASE IF NOT EXISTS timesheet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE timesheet_db;

-- Staff Table
-- Stores employee information including categories and settings
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    early_day VARCHAR(20) DEFAULT NULL,
    category ENUM('office', 'supervisor', 'nursery') DEFAULT 'office',
    fuel_allowance_rate DECIMAL(10,2) DEFAULT 0.00,
    weekly_hours DECIMAL(5,2) DEFAULT 39.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_staff_id (staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Timesheets Table
-- Stores daily time entries for staff
CREATE TABLE IF NOT EXISTS timesheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    week_ending DATE NOT NULL,
    day_date DATE NOT NULL,
    clock_in TIME DEFAULT NULL,
    clock_out TIME DEFAULT NULL,
    total_hours DECIMAL(5,2) DEFAULT 0.00,
    regular_hours DECIMAL(5,2) DEFAULT 0.00,
    overtime_hours DECIMAL(5,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_entry (staff_id, day_date),
    INDEX idx_week_ending (week_ending),
    INDEX idx_staff_id (staff_id),
    INDEX idx_day_date (day_date),
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Holidays Table
-- Stores holiday and leave records
CREATE TABLE IF NOT EXISTS holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    holiday_date DATE NOT NULL,
    holiday_type VARCHAR(50) DEFAULT 'vacation',
    hours DECIMAL(5,2) DEFAULT 8.00,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_holiday (staff_id, holiday_date),
    INDEX idx_staff_id (staff_id),
    INDEX idx_holiday_date (holiday_date),
    INDEX idx_holiday_type (holiday_type),
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Weekend Duties Table
-- Stores weekend watering duty assignments (supervisors only)
CREATE TABLE IF NOT EXISTS weekend_duties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    duty_date DATE NOT NULL,
    fuel_allowance DECIMAL(10,2) DEFAULT 4.00,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_duty (staff_id, duty_date),
    INDEX idx_staff_id (staff_id),
    INDEX idx_duty_date (duty_date),
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data (Optional - Remove if not needed)
-- Insert sample staff members
INSERT INTO staff (staff_id, name, email, category, early_day, fuel_allowance_rate, weekly_hours) VALUES
('EMP001', 'John Smith', 'john.smith@company.com', 'office', 'friday', 0.00, 39.00),
('EMP002', 'Sarah Johnson', 'sarah.johnson@company.com', 'supervisor', NULL, 4.00, 39.00),
('EMP003', 'Michael Brown', 'michael.brown@company.com', 'nursery', NULL, 0.00, 39.00),
('EMP004', 'Emily Davis', 'emily.davis@company.com', 'office', 'wednesday', 0.00, 30.00)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Insert sample time entries for current week
-- Note: Adjust dates as needed for your testing
INSERT INTO timesheets (staff_id, week_ending, day_date, clock_in, clock_out, total_hours, regular_hours, overtime_hours) VALUES
('EMP001', DATE_ADD(CURDATE(), INTERVAL (5 - DAYOFWEEK(CURDATE())) DAY), CURDATE(), '07:45:00', '16:45:00', 8.00, 8.00, 0.00)
ON DUPLICATE KEY UPDATE clock_in=VALUES(clock_in), clock_out=VALUES(clock_out);

-- Insert sample holiday entry
INSERT INTO holidays (staff_id, holiday_date, holiday_type, hours, notes) VALUES
('EMP001', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'vacation', 8.00, 'Planned vacation day')
ON DUPLICATE KEY UPDATE holiday_type=VALUES(holiday_type);

-- Insert sample weekend duty
INSERT INTO weekend_duties (staff_id, duty_date, fuel_allowance, notes) VALUES
('EMP002', DATE_ADD(CURDATE(), INTERVAL (6 - DAYOFWEEK(CURDATE())) DAY), 4.00, 'Weekend watering duty')
ON DUPLICATE KEY UPDATE fuel_allowance=VALUES(fuel_allowance);

-- Verification Queries
-- Run these to verify your setup

-- Check staff count
SELECT COUNT(*) as total_staff FROM staff;

-- View all staff
SELECT * FROM staff ORDER BY name;

-- Check timesheet entries
SELECT s.name, t.day_date, t.clock_in, t.clock_out, t.total_hours 
FROM timesheets t 
JOIN staff s ON t.staff_id = s.staff_id 
ORDER BY t.day_date DESC 
LIMIT 10;

-- Check holidays
SELECT s.name, h.holiday_date, h.holiday_type, h.hours 
FROM holidays h 
JOIN staff s ON h.staff_id = s.staff_id 
ORDER BY h.holiday_date DESC 
LIMIT 10;

-- Check weekend duties
SELECT s.name, w.duty_date, w.fuel_allowance 
FROM weekend_duties w 
JOIN staff s ON w.staff_id = s.staff_id 
ORDER BY w.duty_date DESC 
LIMIT 10;

-- Performance Optimization
-- These indexes should already be created above, but verify them:
SHOW INDEX FROM staff;
SHOW INDEX FROM timesheets;
SHOW INDEX FROM holidays;
SHOW INDEX FROM weekend_duties;

-- Maintenance Queries

-- Clean up old timesheet data (older than 2 years)
-- CAUTION: Uncomment only if you want to delete old data
-- DELETE FROM timesheets WHERE day_date < DATE_SUB(CURDATE(), INTERVAL 2 YEAR);

-- Archive old data (create archive tables first)
-- CREATE TABLE timesheets_archive LIKE timesheets;
-- INSERT INTO timesheets_archive SELECT * FROM timesheets WHERE day_date < DATE_SUB(CURDATE(), INTERVAL 1 YEAR);
-- DELETE FROM timesheets WHERE day_date < DATE_SUB(CURDATE(), INTERVAL 1 YEAR);

-- Backup reminder
-- Remember to regularly backup your database:
-- mysqldump -u username -p timesheet_db > timesheet_backup_$(date +%Y%m%d).sql

-- End of Schema