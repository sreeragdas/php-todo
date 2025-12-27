# Sasti Notebook - Todo App (PHP, MySQL & MongoDB)

This is a simple PHP todo/notes app with user authentication. You can use either MySQL or MongoDB as the backend database.

## Features
- User registration, login, logout (session-based)
- Add, view, edit, delete notes
- Bootstrap 5 UI for modern look
- Switch between MySQL and MongoDB in `config.php`

## Requirements
- PHP 7.2+
- Composer (for MongoDB PHP library)
- MySQL (for MySQL mode)
- MongoDB (for MongoDB mode)

## Setup

### 1. Clone and install dependencies
```sh
# Clone the repo
git clone https://github.com/yogeshgiri904/to-do.git
cd to-do

# If using MongoDB, install PHP MongoDB library:
composer require mongodb/mongodb
```

### 2. Configure database
- Open `config.php` and set `$DB_TYPE` to `'mysql'` or `'mongodb'`.
- Edit MySQL or MongoDB connection details as needed.

### 3. MySQL setup
- Create a MySQL database (default: `notebook`).
- The app will auto-create the `users` table on registration.
- The `notes` table should have columns: `sn` (int, auto_increment, PK), `title`, `note`, `date`.

### 4. MongoDB setup
- Start your MongoDB server (default: `mongodb://localhost:27017`).
- The app will auto-create collections as needed.

## Usage
- Visit `register.php` to create an account.
- Login at `login.php`.
- Add/view/edit/delete notes on `index.php`.
- Logout with `logout.php`.

# Modern Notes

Modern Notes is a modern, colorful, and user-friendly web application for managing your notes. Built with PHP and PostgreSQL/MySQL, it features secure authentication, a beautiful UI, and essential note management features.

## Features
- Secure user registration and login
- Add, edit, and delete notes
- Responsive, modern, and colorful UI
- Card-based note display with icons and animations
- About and Contact pages
- Supports both PostgreSQL and MySQL

## Setup
1. **Clone or download this repository.**
2. **Install PHP and your preferred database (PostgreSQL or MySQL).**
3. **Configure your database credentials in `config.php`.**
4. **Start the PHP built-in server:**
	```
	php -S localhost:8000
	```
5. **Visit** [http://localhost:8000](http://localhost:8000) **in your browser.**

The app will automatically create the required database tables if they do not exist.

## Folder Structure
- `index.php` — Main dashboard and notes
- `register.php`, `login.php`, `logout.php` — Authentication
- `edit.php`, `delete.php` — Note management
- `about.php`, `contact.php` — Info pages
- `assets/modern-notes.css` — Custom styles

## Screenshots
![Modern Notes Screenshot](screenshot.png)

## License
MIT

---
Made with ❤️ for productivity!
