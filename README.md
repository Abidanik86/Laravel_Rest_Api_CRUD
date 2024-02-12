# REST API Laravel CRUD Project

This README provides instructions for setting up and using the REST API Laravel CRUD project. The project enables CRUD (Create, Read, Update, Delete) operations through API endpoints using Laravel framework. You will use Visual Studio Code for code editing, Postman for API testing, and XAMPP server for running the database.

## Getting Started

### Prerequisites
- Visual Studio Code (VS Code)
- Postman
- XAMPP Server

### Installation Steps

1. **Clone the Repository**:
   Clone the project repository to your local machine using the following command:
   ```bash
   git clone <repository-url>
   ```

2. **Setup Database**:
   - Start XAMPP server and open phpMyAdmin.
   - Create a new database named `rest_api` or any desired name.

3. **Run Migrations and Seeders**:
   - Navigate to the project directory in your terminal.
   - Run the following artisan commands to run migrations and seed the database:
     ```bash
     php artisan migrate
     php artisan db:seed --class=UserSeeder
     ```

4. **Run the Project**:
   - Start the Laravel development server using the following command:
     ```bash
     php artisan serve
     ```

5. **Testing with Postman**:
   - Open Postman and import the collection provided in the repository.
   - Use the imported collection to perform CRUD operations on the API endpoints.

## Usage

### User Controller
- The `UserController` handles CRUD operations for users.
- Endpoints are prefixed with `/api/users`.

### Endpoints
- **GET `/api/users`**: Get all users.
- **GET `/api/users/{id}`**: Get a specific user by ID.
- **POST `/api/users`**: Create a new user.
- **PUT `/api/users/{id}`**: Update an existing user.
- **DELETE `/api/users/{id}`**: Delete a user by ID.

### Sample Requests
- Use Postman to send requests to the API endpoints.
- Ensure that you provide valid JSON data in the request body where required.

## Author
- Abid Hasan Anik

## Support
For any issues or inquiries, please contact the author at abidanik86@gmail.com.

