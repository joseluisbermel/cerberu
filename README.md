# Cerberu Test Jose Luis Bermejo
## About

This project is a test for a job, which, since it was not indicated that it should use a framework, goes without a framework.

## Implementation

### Server Requirements

The project has the following system requirements:
- PHP = 7.2 (installed into the Docker container when instancing it)
- Composer (installed into the Docker container when instancing it)
- NGINX (installed into the Docker container when instancing it)
- MariaDB (installed into the Docker container when instancing it)

Also, these libraries are required too but are installed into the Docker container when instancing it:
- pdo
- pdo_mysql
- session

And, for information purposes, these are its code dependencies as exposed in the `composer.json` file:

```
"php": "^7.2",
"ext-json": "*",
"doctrine/orm": "^2.6.2",
"symfony/yaml": "2.*",
"symfony/cache": "^5.3",
"doctrine/annotations": "^1.4",
"twig/twig": "^3.0"
```

## Docker compose implementation

### Server Requirements

These are the requirements to generate a docker image of the project:
 - Docker Engine
 
### Installation

1) If the project does not exist yet, clone it from the repository first using: 
   
   ```
   git clone proyect
   ```

2) Generate the image and container for the project and start them up:

Execute docker-compose.yml.

```
docker-compose up -d.
```

*Note: to check the status of the container you can use the ``docker ps -a`` command which lists all available containers.*

3) Configure the .env, you can use the example that is in the root, .env.example and edit the fields. The fields that are established would be the ones that would be used in the dockers.

```
cp .env.example .env and edit if it's necesary
```

4) Create the database, if you use docker the name of the configuration is cerberu, if you don't like it you can create it however you want, just remember to change it in the .env.

```
CREATE DATABASE cerberu
```

5) Enter the container.

```
docker-compose exec php bash
```

6) We execute the composer install:
   
```
composer install
```

7) We create the doctrine data structures.
        
```
vendor/bin/doctrine orm:schema-tool:create
```
    
8) We import the data.

```
php cli.php
```

9) We can now go to the web, if you use docker, the web is accessed through port 8082.

## I hope the project is properly adapted to the specifications