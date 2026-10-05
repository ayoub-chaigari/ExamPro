# ExamPro

ExamPro is a Laravel-based exam and quiz management platform designed for teachers and administrators to create, organize, and deliver assessments efficiently.

It includes a question bank, subject/category management, exam creation with sections and variants, quiz code access for students, grading workflows, and export features for exams and results.

## Features

- Teacher dashboard for exam and question management
- Category and subject organization
- Question bank with import capabilities
- Exam creation with duration, level, module, and grading metadata
- Section-based exam structure
- Variant generation for different versions of the same exam
- Quiz generation with code-based student access
- Student result tracking and scoring
- PDF and Word export support
- Role-based access for admin, teacher, and student users

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL / SQLite / other Laravel-supported databases
- Tailwind CSS
- Vite
- Dompdf for PDF export
- PhpWord for Word export
- Laravel Breeze for authentication scaffolding

## Project Structure

- `app/` — application logic, controllers, models, and services
- `routes/` — web routes
- `resources/` — Blade views, CSS, and frontend assets
- `database/` — migrations, seeders, and schema
- `public/` — public assets
- `storage/` — generated user files and logs
- `tests/` — application tests

## Requirements

Before running the project, make sure you have:

- PHP 8.2 or higher
- Composer
- Node.js and npm
- A supported database (SQLite for local development is included by default)

## Getting Started

1. Clone the repository

   ```bash
   git clone https://github.com/your-username/ExamPro.git
   cd ExamPro
   ```

2. Install PHP dependencies

   ```bash
   composer install
   ```

3. Configure environment

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Set up the database

   ```bash
   php artisan migrate
   ```

   For a fresh local development setup, you can also use:

   ```bash
   composer run setup
   ```

5. Install frontend dependencies

   ```bash
   npm install
   ```

6. Run the app

   ```bash
   npm run dev
   ```

   Or run Laravel and Vite together:

   ```bash
   composer run dev
   ```

7. Open the application in your browser

   ```text
   http://localhost:8000
   ```

## Default Admin / Teacher Workflow

- Sign in as an admin or teacher
- Create subjects/categories
- Add exam questions to the question bank
- Create exams and assign sections
- Generate exam variants if needed
- Share quiz access codes with students
- Review submitted results and scores

## Available Scripts

```bash
composer run setup
composer run dev
composer run test
npm run build
npm run dev
```

## Production Notes

- Update the `.env` file with your production database and mail settings.
- Ensure storage permissions are configured for uploaded files.
- Build assets before deployment:

  ```bash
  npm run build
  ```

## License

This project is open-source and available under the MIT license.
