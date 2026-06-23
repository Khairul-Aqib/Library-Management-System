# Library Management System

A web-based library management system built with **PHP**, **HTML/CSS**, and a **MySQL** database. It lets members browse and borrow books, manage their profile, and lets administrators manage the book catalogue, users, and borrowing/returns.

> Built to run locally on a XAMPP (Apache + MySQL + PHP) stack.

---

## Features

- **User accounts** — registration, login, profile management, and password updates.
- **Roles** — `member` and `admin`, with an admin dashboard.
- **Book catalogue** — browse books, view details, and see trending books.
- **Borrowing & returns** — borrow books, checkout, return processing, and fines for late returns.
- **Admin management** — add/remove books, manage users, and view book reports.

## Tech Stack

| Layer    | Technology              |
|----------|-------------------------|
| Backend  | PHP (procedural, `mysqli`) |
| Frontend | HTML, CSS               |
| Database | MySQL / MariaDB         |
| Server   | Apache (via XAMPP)      |

## Project Structure

```
.
├── !Login.php / !Registerform.php   # Authentication entry points
├── homepage.php                     # Public landing page
├── adminDashboard.php               # Admin dashboard
├── add_book.php / remove_book.php   # Catalogue management
├── borrow_book.php / checkout.php   # Borrowing flow
├── return.php / return_book.php / process_return.php
├── book_detail.php / book_report.php / TrendingBooks.php
├── userprofile.php / user_update.php / user_delete.php
├── includes/                        # Shared header/footer, styles, DB connect
├── assets/                          # Logos and UI images
├── uploads/                         # Book cover images
├── mysqli_connect.example.php       # Sample DB config (copy to mysqli_connect.php)
└── library_management.sample.sql    # Sample schema + book catalogue (no user data)
```

## Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org) (Apache + MySQL + PHP)
- A web browser (Chrome, Edge, or Firefox)

### Setup

1. **Clone the repository** into your XAMPP `htdocs` folder:

   ```bash
   git clone https://github.com/Khairul-Aqib/Library-Management-System.git
   ```

2. **Start Apache and MySQL** from the XAMPP Control Panel.

3. **Create the database.** Open [phpMyAdmin](http://localhost/phpmyadmin/), go to the **Import** tab, and import `library_management.sample.sql`. This creates the `library_management` database with the full schema and book catalogue.

4. **Configure the database connection.** Copy the example config files and fill in your own credentials:

   ```bash
   cp mysqli_connect.example.php mysqli_connect.php
   cp includes/mysqli_connect.example.php includes/mysqli_connect.php
   ```

   The default XAMPP values are usually:

   ```php
   DB_HOST = 'localhost'
   DB_USER = 'root'
   DB_PASSWORD = ''        // empty by default
   DB_NAME = 'library_management'
   ```

5. **Run the app.** Open your browser to:

   ```
   http://localhost/Library-Management-System/!Login.php
   ```

   Register a new account to get started. To create an admin account, you can uncomment the optional demo-admin insert at the bottom of `library_management.sample.sql` before importing (default password: `admin`).

## Configuration & Security Notes

- **`mysqli_connect.php` is not committed.** It is listed in `.gitignore` so real database credentials never reach the repository. Use the provided `*.example.php` files as templates.
- **No real user data is published.** The committed `library_management.sample.sql` contains only the schema and the book catalogue — user accounts and borrowing history are intentionally omitted.
- **Password hashing:** the current code uses SHA1. For production use, migrate to PHP's [`password_hash()`](https://www.php.net/manual/en/function.password-hash.php) / `password_verify()`.
- **SQL queries:** consider using prepared statements throughout to guard against SQL injection.

## License

This project is provided for educational purposes. Add a license of your choice if you intend to distribute it.
