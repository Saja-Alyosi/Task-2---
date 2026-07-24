# User Management Dashboard

## Key Features

🎯 **Full CRUD Operations** - Create, retrieve, update, and manage user records  
🎨 **Modern UI/UX** - Glassmorphic design with animated gradient backgrounds  
⚡ **Real-time Toggles** - Instant status management without page reloads  
📊 **Responsive Layout** - Optimized for desktop and mobile environments  
🔒 **Prepared Statements** - SQL injection prevention through parametrized queries  
✨ **Dynamic Feedback** - Toast notifications for user actions

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: Vanilla JS, HTML5, CSS3
- **Design**: Tailwind-inspired custom styling with backdrop filters

## Prerequisites

```bash
- PHP >= 7.4
- MySQL >= 5.7
- PDO extension enabled
- Web server (Apache, Nginx, or built-in PHP server)
```

## Installation Guide

### Step 1: Clone & Setup

```bash
git clone <repository-url>
cd user-management
```

### Step 2: Configure Database Connection

Edit `config.php` with your credentials:

```php
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'db_user';
$password = 'db_password';
```

### Step 3: Create Database Schema

Execute this SQL to set up the required table:

```sql
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `age` INT NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Step 4: Launch Application

**Using built-in PHP server:**
```bash
php -S localhost:8000
```

**Using Apache/Nginx:**
Navigate to your project directory via your web server configuration

## Project Architecture

```
user-management/
├── config.php          # Database configuration & connection
├── index.php           # Dashboard interface & data display
├── insert.php          # User creation endpoint
├── select.php          # Data retrieval function
├── update.php          # Status toggle functionality
└── README.md
```

### File Responsibilities

| File | Purpose |
|------|---------|
| `config.php` | Singleton PDO connection with error handling |
| `index.php` | Primary UI with form and data table |
| `insert.php` | POST handler for new user records |
| `select.php` | Query function for retrieving users |
| `update.php` | Status toggle with redirect logic |

## API Endpoints

### GET `/index.php`
Displays the dashboard with all users and notifications

**Query Parameters:**
- `msg=added` - Success notification for new user
- `msg=updated` - Success notification for status change
- `msg=error` - Error notification

### POST `/insert.php`
Creates a new user record

**Required Parameters:**
- `name` - User full name (string)
- `age` - User age (integer)

### GET `/update.php`
Toggles user status between active/inactive

**Query Parameters:**
- `id` - User ID (integer)

## Security Considerations

✅ **Prepared Statements** - All queries use parameterized PDO statements  
✅ **Input Validation** - Type casting and trim functions  
✅ **Output Escaping** - htmlspecialchars() for XSS prevention  
✅ **Error Handling** - Try-catch blocks for exception management  

## Performance Optimizations

- Database indexing on frequently queried columns
- Minimal dependencies for faster load times
- CSS animations using GPU acceleration
- Efficient DOM manipulation

## Browser Support

| Browser | Support |
|---------|---------|
| Chrome | ✅ Latest 2 versions |
| Firefox | ✅ Latest 2 versions |
| Safari | ✅ Latest 2 versions |
| Edge | ✅ Latest 2 versions |

## Customization

### Modify Color Scheme
Edit the CSS gradient variables in `index.php` styles section:
```css
background: linear-gradient(135deg, #f8fafc 0%, #60a5fa 50%, #a78bfa 100%);
```

### Adjust Table Columns
Extend the `user` table with additional fields and update the HTML table structure accordingly

## Troubleshooting

**Database Connection Failed**
- Verify credentials in `config.php`
- Ensure MySQL service is running
- Check PDO extension is enabled: `php -m | grep PDO`

**Users Not Displaying**
- Verify table exists in database
- Check file permissions on upload directory
- Clear browser cache and reload

## Future Enhancements

- [ ] User authentication & authorization
- [ ] Search and filter functionality
- [ ] Batch operations
- [ ] Export to CSV/PDF
- [ ] Admin activity logging
- [ ] Email notifications

