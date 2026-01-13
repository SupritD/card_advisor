# Card Advisor

A Laravel-based application for managing and advising on credit cards, containerized with Docker.

## Prerequisites

*   **Docker Desktop**: Ensure Docker is installed and currently running on your machine.

## Getting Started

Follow these steps to set up and run the project:

1.  **Environment Setup**
    Copy the example environment file:
    ```bash
    cp .env.example .env
    ```
    *Update database credentials in `.env` if needed, but defaults usually work with Docker.*

2.  **Start the Application**
    Open your terminal in the project root directory and run:
    ```bash
    docker-compose up -d --build
    ```
    This command builds the images and starts the containers.

3.  **Run Database Seeders**
    Populate the database with default users and import credit cards:
    ```bash
    docker-compose exec app php artisan db:seed
    ```
    *This runs all seeders, including Admin, User, and the Excel Data Import.*

4.  **Access the Application**
    *   **Main Site**: [http://localhost:8000](http://localhost:8000)
    *   **Admin Login**: [http://localhost:8000/admin/login](http://localhost:8000/admin/login)

## Default Credentials

Use the following credentials to log in to the Admin Panel:

*   **Email**: `admin@gmail.com`
*   **Password**: `asdasd`

## Data Import

The project automatically imports credit card details from `Credit card details.xlsx` when you run the seed command step above.

1.  **Prerequisite**: Ensure the file `Credit card details.xlsx` is present in the root directory.
2.  **Re-running Import**: If you need to re-import specifically:
    ```bash
    docker-compose exec app php artisan db:seed --class=CardImportSeeder
    ```

## Database Management

*   **PHPMyAdmin** is available for direct database access at: [http://localhost:8080](http://localhost:8080) (Check `docker-compose.yml` if port differs).
*   **MySQL Host**: `mysql` (internal Docker network alias).
