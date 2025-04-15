# Simple PHP Password Keeper

A basic web application built with PHP and SQLite for storing and managing website credentials.

## Features

*   User Registration
*   User Login / Logout
*   Add new website credentials (site name, username, password)
*   View saved credentials on a dashboard

## Technology Stack

*   **Backend:** PHP
*   **Database:** SQLite (using PDO)
*   **Frontend:** HTML, CSS (basic styling)

## Setup and Installation

1.  **Prerequisites:**
    *   A web server (like Apache or Nginx) with PHP installed.
    *   PHP must have the PDO extension enabled, specifically `pdo_sqlite`.
2.  **Clone or Download:** Get the project files and place them in your web server's document root (e.g., `htdocs` for XAMPP, `www` for WampServer).
3.  **Permissions:** Ensure the web server has write permissions for the project directory. This is necessary for the application to automatically create the `passwords.db` SQLite database file upon first use (e.g., when registering the first user).
4.  **Access:** Open your web browser and navigate to the project directory (e.g., `http://localhost/your-project-folder/`). You will be redirected to the login page or the registration page if no user exists.

## Database

*   The application uses an SQLite database named `passwords.db` stored in the project's root directory.
*   The database file is automatically created if it doesn't exist when the application runs (`database.php`).
*   The `users` and `passwords` tables are also created automatically.
*   **Note:** The `passwords.db` file is included in the `.gitignore` file, meaning it won't be tracked by Git.


## File Structure

*   `index.php`: Entry point, redirects to login or dashboard based on session status.
*   `register.php`: Handles user registration.
*   `login.php`: Handles user login.
*   `logout.php`: Handles user logout.
*   `dashboard.php`: Displays saved passwords and allows adding new entries for logged-in users.
*   `database.php`: Handles database connection (SQLite via PDO), session start, and initial table creation.
*   `style.css`: Basic CSS for styling the pages.
*   `script.js`: Minimal JavaScript file (currently empty or placeholder).
*   `passwords.db`: The SQLite database file (created automatically, ignored by Git).
*   `.gitignore`: Specifies intentionally untracked files for Git. 