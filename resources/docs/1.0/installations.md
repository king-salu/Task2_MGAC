# Installations

---

- [Framework](#section-1)
- [Database](#section-2)
- [Migrations](#section-3)
- [Frontend](#section-4)
- [Execution](#section-5)

<a name="section-1"></a>
## Framework
The project was built using the Laravel Framework for backend processes, authentication, and security.

<a name="section-2"></a>
## Database
The database used is an in-memory SQLite3. During installation, the `DB_DATABASE` environment variable must be set to the path where it saves the file.

<a name="section-3"></a>
## Migrations
All migrations have been set up, including Laravel's OAuth tables and configurations for each user, with additional setups for the wallet and order tables.

<a name="section-4"></a>
## Frontend
A fusion of blade and react was implemented for the frontend, using laravel-vite for the bridge with react.

<a name="section-5"></a>
## Execution
To run the application for the backend, we run the composer engine using `php artisan serve`, while we run the
frontend engine using node package manager engine using `npm run dev`