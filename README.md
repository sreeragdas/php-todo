
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
2. Configure your database in `config.php` (choose MySQL or PostgreSQL and set credentials).
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
