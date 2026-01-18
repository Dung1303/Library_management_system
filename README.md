📚 Library Management System
Welcome to the Library Management System project. This is a Full-stack web application built with Pure PHP using MVC architecture. It focuses on clean code, practical use, and is easy to expand.

📖 Project Introduction
This project helps manage physical books and borrowing processes. Instead of just managing book titles, the system tracks every physical copy (Book Copies) using Barcodes. This helps the librarian know the exact status of the library inventory.

Main Goals:
Apply the Model-View-Controller (MVC) pattern to organize code.

Build a clear Permission system between Admin and Member.

Work as a team using the Scrum methodology.

✨ Main Features
👤 For Members (Readers)
Account: Register, login, and manage personal profiles.

Search: View book lists (5-column Grid), search by title/author, and filter by category.

🛠 For Admin (Librarian)
Manage Books (CRUD): Manage book titles and every physical copy (book_copies).

Manage Categories: Group books by Technology, Economy, Literature, etc.

Borrow/Return: Approve borrow requests, manage overdue books, and update status via Barcodes.

Manage Members: View member details and lock/unlock accounts.

👥 Team Members
Ngô Minh Tú

Nguyễn Thị Dung

Nguyễn Phúc Khuê

Nguyễn Thu Trang

🏗 Project Structure (MVC)
The project is organized to be easy to maintain:

Plaintext
library_project/
├── config/                 # System configuration
│   └── database.php        # Connection to localhost/phpmyadmin
├── app/                    # Main MVC code
│   ├── models/             # Data logic & SQL queries
│   │   ├── User.php
│   │   ├── Book.php
│   │   ├── BookCopy.php
│   │   └── BorrowRecord.php
│   ├── controllers/        # Control logic and navigation
│   │   ├── AuthController.php
│   │   ├── AdminController.php
│   │   ├── BookController.php
│   │   ├── MemberController.php
│   │   └── TransactionController.php
├── public/                 # Public resources
│   ├── css/                # style.css file
│   ├── js/                 # script.js file
│   ├── images/             # Book covers, logos
│   └── index.php           # Main entry point (Bootstrap file)
├── views/                  # User Interface (HTML/PHP)
│   ├── layouts/            # Shared parts (header, footer, sidebar)
│   ├── auth/               # Login and Register screens
│   ├── admin/              # Admin dashboard and management
│   └── members/            # Member search and history screens
├── .htaccess               # Clean URL configuration (Pretty URL)
└── database.sql            # SQL file to set up the database
💻 Technologies
Front-end: HTML, CSS, JavaScript

Back-end: PHP

Task Management: Jira

Environment: Visual Studio Code
