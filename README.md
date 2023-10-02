# Kyushu-u metadata management system

## Prerequisites

1. Git
2. MySQL
3. [Composer](https://getcomposer.org/download/)
4. PHP: version starting with v8.0.2 or greater
5. [Kyushu-u metadata management code](https://github.com/mumesoft/kyushuu-meta-data-management.git)

## Installation

## For product
### 1. Dependencies package
Install package with the following command:

``` bash
composer install
```
### 2. Config .env file
**Important**: If you have not the .env file in root folder, you must copy or rename the .env.example to .env

#### Application URL
```dotenv
APP_URL=CHANGE_ME#(you must use protocol http or https)
CAS_REDIRECT_PATH=CHANGE_ME#(redirect after cas login)
```

#### Language
Options: en | ja
```dotenv
APP_LOCALE=en
```

#### Timezone
```dotenv
APP_TIMEZONE=Asia/Tokyo
```

#### Session lifetime
Unit: minutes
```dotenv
SESSION_LIFETIME=960
```
#### App key
Generate app key following command:
```bash
php artisan key:generate
```

#### Database
```dotenv
DB_CONNECTION=mysql
DB_HOST=CHANGME
DB_PORT=3306
DB_DATABASE=CHANGME
DB_USERNAME=CHANGME
DB_PASSWORD=CHANGME
```
#### Cas server
```dotenv
CAS_HOSTNAME=CHANGME
CAS_LOGOUT_URL=CHANGME
CAS_URI=CHANGME
CAS_ENABLE_SAML=CHANGME
CAS_REDIRECT_PATH=CHANGEME
```
#### Default admin user
**Important**: ```INIT_USER_USERNAME``` is email you registered at your cas server
```dotenv
INIT_USER_USERNAME=CHANGEME
```

### 3. Init database
Init database with the following command:
```bash
php artisan migrate
```

### 4. Init default database data
Run seeders
```bash
php artisan db:seed 
```

### 5. Render css, js file
```
npm run development
```
## For develop
### Config docker from .env file
```dotenv
APP_PORT=CHANGEME
COMPOSE_PROJECT_NAME=CHANGEME
```
### Build docker image
Build docker image with the following command:
```shell
./vendor/bin/sail build
```

### Run docker container
Run docker container with the following command:
```shell
./vendor/bin/sail up
```
Or run docker container in background with the following command:
```shell
./vendor/bin/sail up -d
```

### Configuring a shell alias
Add bellow command to shell configuration file in your home directory, such as ~/.zshrc or ~/.bashrc, and then restart your shell

`alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`

