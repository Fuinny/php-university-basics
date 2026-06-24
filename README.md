# PHP Basics University Coursework Archive

This repository is an archive of PHP basics university coursework.

## Repository Structure

The project is organized into task sets, each containing a web application:

- [Geometric Progression Table](src/geometric-progression-table): Renders a geometric progression table with dynamic cell coloring.
- [Geometric Progression Form](src/geometric-progression-form): An interactive form to customize and generate geometric progression tables.
- [Registration Form](src/registration-form): A procedural PHP user registration system with MySQL database storage.
- [Registration Form OOP](src/registration-form-oop): An object-oriented version of previous registration system with composer dependencies and PDF/Excel export functionalities.

## Running the Projects

1.  **Start the PHP development server**:
    Navigate to the project root and start the built-in PHP server:
    ```bash
    php -S localhost:8000
    ```

2.  **Access the applications**:
    Open your browser and navigate to:
    - Geometric Progression Table: `http://localhost:8000/src/geometric-progression-table/`
    - Geometric Progression Form: `http://localhost:8000/src/geometric-progression-form/`
    - Registration Form: `http://localhost:8000/src/registration-form/`
    - Registration Form OOP: `http://localhost:8000/src/registration-form-oop/`

3.  **Database Configuration**:
    Make sure you have a local MySQL database running named `registration`.

4.  **Install Dependencies**:
    For the OOP version, install dependencies using Composer:
    ```bash
    cd src/registration-form-oop
    composer install
    ```

## License

This project is licensed under the MIT-0 license - see the [LICENSE.md](LICENSE.md) file for details.
