Open Groupon — Self-hosted Daily Deals Platform
================================================

**Open Groupon** is a self-hosted daily deals and coupons platform built with
Symfony 2.8. It provides a complete frontend for browsing deals by city, an
extranet for store owners to manage their offers, and an admin backend.

Inspired by [javiereguiluz/Cupon](https://github.com/javiereguiluz/Cupon), a
Symfony demo application originally created by Javier Eguiluz for his book
[Desarrollo web ágil con Symfony](http://www.symfony.es/libro/).

If you find any bugs, please open an issue on the
[issue tracker](https://github.com/alblez/open-groupon/issues).

Installation
------------

First, make sure [Composer](https://getcomposer.org/) is installed globally.
On Linux or Mac OS X:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

On Windows, download the [Composer installer](https://getcomposer.org/download)
and follow the instructions.

Then clone the project and install dependencies:

```bash
$ git clone git://github.com/alblez/open-groupon.git
$ cd open-groupon/
$ composer install
```

Running the Application
-----------------------

The simplest way to try it out is with PHP's built-in web server:

```bash
$ php app/console server:run
Server running on http://localhost:8000
```

Open your browser and go to `http://localhost:8000`.

This requires PHP 5.4+. For older versions, set up a virtual host in Apache
or Nginx as described in the Symfony documentation.

### Troubleshooting

If you run into issues, start by clearing the application cache:

  * Development: `php app/console cache:clear`
  * Production: `php app/console cache:clear --env=prod`

If problems persist, try removing the cache directories entirely:
`rm -rf app/cache/*`

**1. Blank page**

Likely a permissions issue. Quick fix:

```bash
$ chmod -R 777 app/cache app/logs
```

**2. Database errors**

Your PHP installation may be missing the SQLite extension. SQLite is used by
default to simplify setup. To use MySQL instead:

  1. Edit `app/config/parameters.yml` — comment out the SQLite settings and
     uncomment MySQL.
  2. Edit `app/config/config.yml` — in the `dbal` section, switch from SQLite
     to MySQL.
  3. Run:

```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
$ php app/console doctrine:fixtures:load

# if the last command fails, try:
$ php app/console doctrine:fixtures:load --append

# for simplified test data (without security), use:
$ php app/console doctrine:fixtures:load --fixtures=app/Resources
```

**3. Cannot upload images when creating an offer**

Make sure `web/uploads/images/` is writable.

Running Tests
-------------

The project includes unit and functional tests. Install
[PHPUnit](https://github.com/sebastianbergmann/phpunit/) and run:

```bash
$ phpunit -c app
```

Access Points
-------------

### Frontend

  * Development: `http://localhost:8000`
  * Production: `http://localhost:8000/app.php`
  * Credentials: `user1@localhost` / `user1` (replace `1` with any number 1–100)

### Extranet (Store Owners)

  * Development: `http://localhost:8000/extranet`
  * Production: `http://localhost:8000/app.php/extranet`
  * Credentials: `store1` / `store1` (replace `1` with any number 1–80 approx.)

### Backend (Admin)

  * Development: `http://localhost:8000/backend`
  * Production: `http://localhost:8000/app.php/backend`
  * Credentials: `admin` / `1234`

## Requirements

- PHP >= 5.3.3
- Composer
- SQLite or MySQL

## License

See [LICENSE.md](LICENSE.md). Original application code copyright (c) 2011
Javier Eguiluz. This project must remain open source per the license terms.
