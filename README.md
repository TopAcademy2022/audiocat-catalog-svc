# audiocat-catalog-svc
Catalog service: CRUD and REST API for music metadata (tracks, albums, artists).

# Requiments
1. Php v8.2

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
