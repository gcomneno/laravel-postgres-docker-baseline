# Laravel PostgreSQL Docker Baseline

A minimal, reusable development baseline for Laravel applications backed by PostgreSQL and running through Docker Compose.

This repository is intentionally domain-neutral. It exists as a small foundation that other labs or application projects can build on without inheriting unrelated application decisions.

## Stack

- Laravel 13
- PHP 8.3
- PostgreSQL 17
- Docker Compose
- Composer
- pdo_pgsql

## Runtime Model

The local runtime contains two services:

    host
      |
      | 127.0.0.1:8000
      v
    Laravel app container
      |
      | db:5432
      v
    PostgreSQL container

The Laravel application is exposed only on `127.0.0.1:8000`.

PostgreSQL is reachable only from the Compose network and is not published directly to the host.

## Included

The baseline intentionally includes:

- PHP 8.3 application container
- Composer in the application image
- PostgreSQL 17 container
- pdo_pgsql
- PostgreSQL healthcheck
- persistent PostgreSQL named volume
- source bind mount for local development
- file-backed sessions
- file-backed cache
- synchronous queue driver
- minimal JSON health surface
- PHPUnit feature test for the health endpoint

## Explicitly Not Included

The baseline intentionally does not define:

- application domain models
- authentication
- authorization
- application migrations
- Redis
- queue workers
- schedulers
- reverse proxy
- production deployment topology
- frontend product architecture
- application-specific seed data

These decisions belong to the project consuming this baseline.

## Local Prerequisites

Required on the host:

- Docker
- Docker Compose

PHP and Composer may also be installed locally, but PostgreSQL connectivity does not depend on the host PHP runtime.

The application container provides `pdo_pgsql`.

## Configuration

Copy the example environment file when starting from a fresh clone:

    cp .env.example .env

The baseline expects:

    DB_CONNECTION=pgsql
    DB_HOST=db
    DB_PORT=5432
    DB_DATABASE=laravel_baseline
    DB_USERNAME=laravel_baseline

The database name and username are development defaults and should be changed by downstream projects when appropriate.

The local `.env` file is not tracked by Git.

## Build

Build the application image:

    docker compose build app

## Start

Start the local runtime:

    docker compose up -d

Check service status:

    docker compose ps

## Health Endpoint

The root endpoint provides the minimal application health contract:

    GET /

Expected response:

    {
      "status": "ok",
      "service": "laravel-postgres-docker-baseline"
    }

The endpoint intentionally does not query PostgreSQL. Database health is monitored independently by the PostgreSQL container healthcheck.

## Tests

Run the test suite locally:

    php artisan test

Or from the application container:

    docker compose run --rm --no-deps app php artisan test

## Stop

Stop the runtime:

    docker compose down

The PostgreSQL named volume is preserved.

Removing the named volume is an explicit destructive operation and is intentionally not part of the normal shutdown procedure.

## Design Principles

The baseline follows these constraints:

- minimal infrastructure
- explicit dependencies
- PostgreSQL as the database
- no hidden runtime installers
- no unnecessary distributed services
- no domain assumptions
- reproducible local runtime

It is intended to remain small enough to inspect, understand, and reuse.

## [LABs]

This repository is maintained as a reusable [LABs] building block.

Its purpose is not to be a product or a complete Laravel starter kit. It is a verified technical baseline from which larger labs can start without repeating the same environment setup.
