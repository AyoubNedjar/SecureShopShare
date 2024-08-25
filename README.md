# WebShop

## Group Members

- **SAIDI Aimane** (Matricule: 60450 - D112)
- **NEDJAR Ayoub** (Matricule: 58183 - D112)
- **El GHZAOUI Ayman** (Matricule: 58152 - D112)
- **FILALI Mohamed Yassin** (Matricule: 58651 - D111)
- **SCHLIT Allan** (Matricule: 58071 - D111)
- **ZAIR Yasine** (Matricule: 60957 - D112)

## Project Description

For our SECG4-secl course, we were tasked with creating a basic image database website where users can add photos to their wall or create albums and manage the photos within them. Additionally, we implemented various security measures to prevent SQL injection, XSS attacks, and ensured secure authentication and data handling.

## Prerequisites

### Ubuntu 22.04

- PHP 8.0 or higher
- Composer
- MySQL or MariaDB
- Node.js and npm

### Windows 10

- XAMPP (includes PHP, MySQL, and Apache)
- Composer
- Node.js and npm

## Installation

### Ubuntu 22.04

1. **Install necessary packages:** Ensure PHP, Composer, MySQL, and Node.js are installed.
2. **Clone the repository:** Use `git clone` to clone the project repository.
3. **Install dependencies:** Run `composer install` and `npm install` in the project directory.
4. **Install Laravel Breeze and Purifier:** Run `composer require laravel/breeze --dev`, `php artisan breeze:install`, and `composer require mews/purifier`.
5. **Environment setup:** Set up your environment variables in the `.env` file.
6. **Database configuration:** Update the `.env` file with your database credentials.
7. **Migrate and seed the database:** Run `php artisan migrate --seed`.

### Windows 10

1. **Install XAMPP:** Ensure Apache and MySQL are running.
2. **Install Composer and Node.js:** Download and install Composer and Node.js.
3. **Clone the repository:** Use `git clone` to clone the project repository.
4. **Install dependencies:** Run `composer install` and `npm install` in the project directory.
5. **Install Laravel Breeze and Purifier:** Run `composer require laravel/breeze --dev`, `php artisan breeze:install`, and `composer require mews/purifier`.
6. **Environment setup:** Set up your environment variables in the `.env` file.
7. **Database configuration:** Update the `.env` file with your database credentials.
8. **Migrate and seed the database:** Run `php artisan migrate --seed`.

## Usage

### To launch the project:

1. **Start Apache and MySQL:**
   - On Ubuntu, use system commands to start Apache and MySQL.
   - On Windows, use the XAMPP Control Panel to start Apache and MySQL.

2. **Run the Laravel development server:**

    ```sh
    php artisan serve
    ```

3. **Access the application:**
   Open your web browser and go to `http://localhost:8000`.

---

**Security Measures Explained**

1. **SQL Injection Prevention:** User inputs are sanitized and ORM techniques are used to prevent SQL injection.
2. **Data Encryption:** Sensitive data, like passwords, are encrypted using Laravel's `Hash` facade.
3. **XSS Prevention:** User inputs are sanitized to prevent XSS attacks using the `Purifier` package.
4. **Email Verification:** Users must verify their email addresses before accessing certain parts of the application.
5. **Secure Authentication:** Laravel Breeze is used for secure user authentication, including password hashing and session management.
6. **UUID for Secure Access Control:** All users are assigned a UUID upon registration to prevent predictable user identification, mitigating potential access control issues.


---

This concise `README.md` provides a quick overview and essential instructions for setting up and using the Laravel project, along with a brief explanation of the implemented security measures.