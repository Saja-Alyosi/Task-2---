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
