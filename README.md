# audiocat-catalog-svc
Catalog service: CRUD and REST API for music metadata (tracks, albums, artists).

The service is built with **PHP 8.2** and **Slim Framework** and is intended to be a standalone microservice within the AudioCat ecosystem.

---

## Status

![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Framework](https://img.shields.io/badge/Slim-4-lightgrey)
![License](https://img.shields.io/github/license/TopAcademy2022/audiocat-catalog-svc)

![Tests](https://github.com/TopAcademy2022/audiocat-catalog-svc/actions/workflows/tests.yml/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/TopAcademy2022/audiocat-catalog-svc/badge.svg?branch=main)](https://coveralls.io/github/TopAcademy2022/audiocat-catalog-svc?branch=main)

---

## Requirements

- PHP **8.2**
- Composer **2.x**
- (Optional) Docker & Docker Compose

---

## Project Initialization (Install Dependencies)

Before running the application, you must install PHP dependencies.

From the project root directory:

```bash
composer install
```

## How to run the Application

Run this command from the directory in which you want to rum application. You will require PHP 7.4 or newer.

```bash
php -S localhost:8080 -t public
```
Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.
