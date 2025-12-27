
# Modern Notes

Modern Notes is a simple PHP web application for managing your notes with user authentication. It supports MySQL and PostgreSQL as the backend database.

## Features
- User registration, login, logout (session-based)
- Add, view, edit, delete notes
- Bootstrap 5 UI for a modern look
- Switch between MySQL and PostgreSQL in `config.php`

## Requirements
- PHP 7.2+
- MySQL or PostgreSQL

## Setup
1. Clone the repository and enter the folder.
2. Copy `.env.example` to `.env` and fill in your database credentials (see below). The app will load DB settings from `.env`.
## .env Example

Create a `.env` file in your project root (or copy from `.env.example`) and fill in your database details:

```env
DB_TYPE=mysql
MYSQL_SERVER=localhost
MYSQL_USERNAME=your_mysql_user
MYSQL_PASSWORD=your_mysql_password
MYSQL_DATABASE=notebook
PGSQL_HOST=localhost
PGSQL_PORT=5432
PGSQL_USERNAME=your_pgsql_user
PGSQL_PASSWORD=your_pgsql_password
PGSQL_DATABASE=notebook
```

**Note:** Never commit your real `.env` file to version control. Use `.env.example` for sharing config structure.
3. Start the PHP built-in server:
   ```sh
   php -S localhost:8000
   ```
4. Visit [http://localhost:8000](http://localhost:8000) in your browser.

The app will automatically create the required tables if they do not exist.

## Main Files
- `index.php` — Dashboard, add/view notes
- `register.php`, `login.php`, `logout.php` — Authentication
- `edit.php`, `delete.php` — Note management
- `about.php`, `contact.php` — Info pages
- `config.php` — Database configuration

---
Made with ❤️ for productivity!
