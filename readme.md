# School - API

## Dependencies
  - php 7.2
  - mysql 5.7

## How to install

[How to install video In Portugues](https://www.youtube.com/watch?v=RHxsmFYcmIc)

```shell
composer create-project emtudo/school-api
cd school-api
php artisan jwt:generate
```

Configure the `.env` file after configuring run the command below to create the database:

```shell
php artisan migrator
```

## How to test

```shell
php artisan serve
```

## Admin (Default)

- username: admin@user.com
- password: abc123
