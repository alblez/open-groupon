# Contributing

Thanks for your interest in contributing to Open Groupon!

## Getting Started

1. Fork the repository
2. Clone your fork: `git clone git@github.com:YOUR_USERNAME/open-groupon.git`
3. Install dependencies: `composer install`
4. Create a branch: `git checkout -b my-feature`

## Development

Run the built-in PHP server:

```bash
php app/console server:run
```

Or use Docker:

```bash
docker-compose up -d
```

## Running Tests

```bash
phpunit -c app
```

## Pull Requests

- Create feature branches from `master`
- Write clear commit messages
- Add tests for new features
- Make sure all tests pass before submitting

## Code Style

We follow PSR-2 coding standards. Run PHP-CS-Fixer before committing:

```bash
php-cs-fixer fix src/
```

## Reporting Bugs

Please use the [issue tracker](https://github.com/alblez/open-groupon/issues)
and include:

- Steps to reproduce
- Expected behavior
- Actual behavior
- PHP version and OS
