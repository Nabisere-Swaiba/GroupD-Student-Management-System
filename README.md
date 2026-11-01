# CampusDesk — Student Management System

Laravel application for **BUC3131 Advanced Web Application Development – Coursework Two**
(Makerere University Business School, 2026/2027).

Administrators manage students, courses, registrations and user access. Lecturers view their
assigned courses and the students registered for them. Students view available courses,
register for them and see their own registrations.

**Stack:** Laravel 12 · Eloquent ORM · Blade · [spatie/laravel-permission](https://spatie.be/docs/laravel-permission) · SQLite (default) or MySQL.

---

## 1. Requirements
- PHP 8.2+ (with the `pdo_sqlite` or `pdo_mysql`, `mbstring`, `openssl`, `fileinfo` extensions)
- Composer 2+
- Git

## 2. Installation

This repository contains the **application files** (models, migrations, controllers, routes,
views, seeders, CSS). They are placed on top of a fresh Laravel install:

```bash
# 1. create a fresh Laravel project
composer create-project laravel/laravel student-management
cd student-management

# 2. copy EVERYTHING from this repository into student-management/
#    (answer "yes" / overwrite when asked)

# 3. run the setup script
./setup.sh          # macOS / Linux / Git Bash
setup.bat           # Windows CMD
```

The setup script does these steps (you can also run them manually):

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
cp .env.example .env            # skip if .env already exists
php artisan key:generate
php artisan migrate:fresh --seed
```

Start the server:

```bash
php artisan serve
```
Open <http://127.0.0.1:8000>.

## 3. Database setup

**SQLite (default, zero config).** Laravel's default `.env` already uses SQLite and creates
`database/database.sqlite`. If the file is missing: `touch database/database.sqlite`
(Windows: `type nul > database\database.sqlite`).

**MySQL.** Create a database (e.g. `campusdesk`) and edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campusdesk
DB_USERNAME=root
DB_PASSWORD=
```
Then run `php artisan migrate:fresh --seed`.

### Tables
| Table | Purpose |
|---|---|
| `users` | Login accounts (Laravel default) |
| `students` | Student profiles; `user_id` → `users.id` (nullOnDelete) |
| `courses` | Courses; `lecturer_id` → `users.id` (nullOnDelete) |
| `course_registrations` | Pivot: `student_id` → `students`, `course_id` → `courses` (cascade) with **unique(student_id, course_id)** |
| `roles`, `permissions`, `model_has_roles`, … | Created by spatie/laravel-permission |

### Eloquent relationships
- `User hasOne Student`, `User hasMany Course` (as lecturer)
- `Course belongsTo User` (lecturer), `Course hasMany CourseRegistration`
- `Student hasMany CourseRegistration`, `CourseRegistration belongsTo Student / Course`
- `Student belongsToMany Course` → `$student->courses` (a student's courses)
- `Course belongsToMany Student` → `$course->students` (students on a course)

## 4. Roles, permissions and sample logins

All sample accounts use the password **`password`**.

| Role | Email | Can do |
|---|---|---|
| **Administrator** | `admin@campusdesk.test` | Everything: CRUD students & courses, manage registrations, change user roles |
| **Lecturer** | `peter.tumusiime@campusdesk.test` | View **their own** assigned courses and the students registered on them |
| **Lecturer** | `sarah.nabirye@campusdesk.test` | same |
| **Lecturer** | `daniel.kato@campusdesk.test` | same |
| **Student** | `aisha.namukasa@campusdesk.test` | View available courses, register/cancel, view **own** registrations |
| **Student** | `david.okello@campusdesk.test` | same (also `grace.nakato@…`, `brian.mugisha@…`, `esther.atim@…`, `joel.ssemakula@…`) |

Permissions are created in `database/seeders/RolesAndPermissionsSeeder.php`
(e.g. `view students`, `create courses`, `register courses`, `manage users`, …).
Routes are protected with `auth` and `permission:` middleware (set in each controller via
`HasMiddleware`), and record-level access (lecturers → own courses only, students → own
registrations only) is enforced in `CoursePolicy` and `CourseRegistrationPolicy`.

## 5. Seeding
`php artisan migrate:fresh --seed` creates roles/permissions, 10 users, 5 courses, 6 students
and sample registrations. Seeders use `updateOrCreate` / `firstOrCreate`, so
`php artisan db:seed` can be re-run without creating duplicates.

## 6. Screenshots
Add screenshots of the running app to `docs/screenshots/` and link them here:

- `docs/screenshots/home.png`
- `docs/screenshots/login.png`
- `docs/screenshots/admin-dashboard.png`
- `docs/screenshots/students.png`
- `docs/screenshots/courses.png`
- `docs/screenshots/registrations.png`
- `docs/screenshots/lecturer-view.png`
- `docs/screenshots/student-view.png`

## 7. Group work (GitHub)
`main` = stable, `develop` = integration, each member works on `feature/<name>` and opens
pull requests into `develop`. See the contribution report for members, branches and PRs.

| Member | Reg. no. | Branch | Contribution |
|---|---|---|---|
| _name_ | _reg no_ | `feature/relationships` | Migrations, models, relationships |
| _name_ | _reg no_ | `feature/seeders` | Seeders and sample data |
| _name_ | _reg no_ | `feature/auth-roles` | Authentication, roles, permissions, policies |
| _name_ | _reg no_ | `feature/student-management` | Student & course CRUD |
| _name_ | _reg no_ | `feature/registration-ui` | Registrations, Blade layout, CSS, README |
