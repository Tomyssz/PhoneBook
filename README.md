## Task: Create a phone book online:

- Phonebook entries available to registered users (private)
- A phonebook entry can be shared with another user (and unshared)
- Phonebook entry: name, phone (full CRUD)
- There must be at least one unit test
- There must be at least one feature test
- The application must use Docker

## Installation:

- To install vendors into the project, run `docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/opt \
  -w /opt \
  laravelsail/php83-composer:latest \
  composer install --ignore-platform-reqs` this will install vendors with appropriate php version.
- Copy `.env.example` file in the application root folder and paste it renamed as `.env`
- In .env file configure database configurations for example:
    - `DB_CONNECTION=mysql`
    - `DB_HOST=mysql`
    - `DB_PORT=3306`
    - `DB_DATABASE=laravel`
    - `DB_USERNAME=sail`
    - `DB_PASSWORD=password`
- In terminal, run `./vendor/bin/sail up` to start the containers, you can add `-d` flag to run in detach mode (this
  will give back control of terminal instance)
- To generate application key, run `./vendor/bin/sail artisan key:generate`.
- To perform migrations and test data seeding, run `./vendor/bin/sail artisan migrate --seed`. If only fresh database is required, skip `--seed` flag.
- To install js packages, run `./vendor/bin/sail npm install` and to build assets, run `./vendor/bin/sail npm run build`

## Usage:
- Application is accessible on http://localhost/ url. You will be redirected to login page. If migrations were executed with `--seed` flag, else, registration is accessible on `/register`.

### Example users:

| Email          | Password |
|----------------|----------|
| test@test.com  | password |
| test2@test.com | password |

Users have 5 phone entries each, all of them are shared between.
