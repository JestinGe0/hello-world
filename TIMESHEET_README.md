# Professional Timesheet Management System

## Overview
A complete redesign of the PHP timesheet application with a professional corporate look and feel using Bootstrap 5.

## What's New

### Design Improvements

#### 1. **Professional Typography**
- **Primary Font**: Inter - A modern, highly legible font designed for UI
- **Fallback**: Segoe UI, System UI for optimal cross-platform display
- **Font Sizes**: Carefully calibrated for readability (13-14px body, proper heading hierarchy)
- **Letter Spacing**: Enhanced for better readability in uppercase labels

#### 2. **Corporate Color Scheme**
- **Primary**: Deep Navy Blue (#1a365d) - Professional and trustworthy
- **Secondary**: Steel Blue (#2c5282) - Complementary professional tone
- **Accent**: Bright Blue (#3182ce) - For interactive elements
- **Success**: Forest Green (#2d7a3e) - Positive actions
- **Warning**: Amber (#d97706) - Attention items
- **Danger**: Crimson Red (#c53030) - Critical actions
- **Background**: Professional gradient (Purple to Blue)

#### 3. **Modern UI Components**

**Navigation**
- Clean tab interface with hover effects
- Active state indicators with accent color underline
- Icon support for visual clarity

**Forms**
- Professional input styling with 2px borders
- Focus states with subtle shadow effects
- Uppercase labels with letter spacing
- Proper validation states
- Grouped form sections for better organization

**Tables**
- Gradient headers (navy to steel blue)
- Hover effects on rows
- Professional padding and spacing
- Color-coded row types (work, holiday, weekend)
- Responsive design with horizontal scroll on mobile

**Buttons**
- Multiple styles (primary, success, warning, danger)
- Hover animations (lift effect)
- Icon support
- Loading states
- Proper sizing hierarchy

**Badges**
- Color-coded for different categories
- Consistent padding and border radius
- Professional typography

#### 4. **Enhanced User Experience**

**Visual Feedback**
- Auto-dismissing alerts (5 seconds)
- Success/error messages with icons
- Loading animations for async operations
- Status indicators with color coding

**Information Display**
- Info boxes with gradient backgrounds
- Clear section headers with icons
- Professional card layouts with shadows
- Proper visual hierarchy

**Responsive Design**
- Mobile-optimized layouts
- Collapsible navigation on small screens
- Touch-friendly button sizes
- Responsive tables with scroll

#### 5. **Professional Elements**

**Icons**
- Bootstrap Icons throughout the interface
- Contextual icon usage for better UX
- Consistent icon sizing

**Shadows and Depth**
- Card shadows for elevation
- Hover effects for interactivity
- Gradient overlays for visual interest

**Spacing**
- Consistent padding and margins
- Proper whitespace for readability
- Grid-based layouts

## Files Included

1. **config.php** - Database configuration
2. **Timesheet.php** - Business logic class
3. **index.php** - Main application interface with tabs
4. **staff_details.php** - Individual staff timesheet view
5. **README.md** - This documentation file

## Features

### Staff Management
- Add new staff members with categories (Office, Supervisor, Nursery)
- Update staff settings (early day assignments)
- Visual category badges
- Email support

### Time Entry
- Single time entry input
- Automatic calculations (regular hours, overtime, breaks)
- Holiday/leave tracking with types
- Weekend watering duty assignments (supervisors only)

### Reports & Summary
- Weekly summaries for all staff
- Fuel allowance tracking
- Holiday breakdown
- Weekend duties summary
- Export-ready tables
- View individual staff details

### Professional Design Features
- Gradient backgrounds
- Card-based layouts
- Professional color scheme
- Responsive design
- Icon-enhanced navigation
- Form validation
- Auto-dismissing alerts

## Technical Stack

- **Backend**: PHP 7.4+ with PDO
- **Frontend**: Bootstrap 5.3.2
- **Icons**: Bootstrap Icons 1.11.2
- **Fonts**: Google Fonts (Inter & Roboto)
- **Database**: MySQL/MariaDB

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Database Schema

The application expects the following tables:

```sql
-- Staff table
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    early_day VARCHAR(20),
    category ENUM('office', 'supervisor', 'nursery') DEFAULT 'office',
    fuel_allowance_rate DECIMAL(10,2) DEFAULT 0.00,
    weekly_hours DECIMAL(5,2) DEFAULT 39.00
);

-- Timesheets table
CREATE TABLE timesheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    week_ending DATE NOT NULL,
    day_date DATE NOT NULL,
    clock_in TIME,
    clock_out TIME,
    total_hours DECIMAL(5,2),
    regular_hours DECIMAL(5,2),
    overtime_hours DECIMAL(5,2),
    UNIQUE KEY unique_entry (staff_id, day_date)
);

-- Holidays table
CREATE TABLE holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    holiday_date DATE NOT NULL,
    holiday_type VARCHAR(50),
    hours DECIMAL(5,2),
    notes TEXT,
    UNIQUE KEY unique_holiday (staff_id, holiday_date)
);

-- Weekend duties table
CREATE TABLE weekend_duties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(50) NOT NULL,
    duty_date DATE NOT NULL,
    fuel_allowance DECIMAL(10,2),
    notes TEXT,
    UNIQUE KEY unique_duty (staff_id, duty_date)
);
```

## Installation

1. Upload all PHP files to your web server
2. Configure database connection in `config.php`
3. Create database tables using the schema above
4. Access `index.php` in your browser
5. Start adding staff and time entries

## Customization

### Colors
Edit CSS variables in `<style>` section of both PHP files:
```css
:root {
    --primary-color: #1a365d;
    --secondary-color: #2c5282;
    --accent-color: #3182ce;
    /* ... etc */
}
```

### Fonts
Change font families in the Google Fonts link and CSS:
```css
font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
```

### Branding
Update the system title in `index.php`:
```php
<h1 class="system-title">Your Company Name - Timesheet System</h1>
```

## Support

For issues or questions, refer to the inline code comments or consult PHP/Bootstrap documentation.

## License

Proprietary - For internal use only

---

**Version**: 2.0  
**Last Updated**: 2025  
**Design**: Professional Corporate Theme  
**Framework**: Bootstrap 5.3.2