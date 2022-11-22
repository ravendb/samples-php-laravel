RavenDB Laravel Demo Application
====================================

The "RavenDB Laravel Demo Application" is a reference application created 
to show how to develop Laravel applications using RavenDB database.


## Requirements

- PHP 8.1.0 or higher
- DS PHP extension enabled
- Docker
- usual Laravel application requirements

## Installation

Before you begin, you should ensure that your local machine has PHP and [Composer](https://getcomposer.org/) installed.

```bash
composer create-project ravendb/ravendb-laravel-app demo-app
```

Copy `.env.example` to `.env` file in project root folder.

Make sure that docker is started and running. Start application containers with: 
```
./vendor/bin/sail up
```

Create secret key for the application:
```bash
./vendor/bin/sail artisan key:generate
```

## Setup database

Go to RavenDB Studio: http://localhost:8080 and follow instructions for initial setup.

Seed the database with command:

```bash
./vendor/bin/sail artisan ravendb:seed
```

## Access the application

To access the app in your browser insert the link:

http://localhost/


