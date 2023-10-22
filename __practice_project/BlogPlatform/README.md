## Install Laravel
    -- cd parent directory
    -- laravel new sample_with_boostrap
    -- cd sample_with_boostrap

## Boostrap
    -- composer require twbs/bootstrap:5.3.2
    -- composer require laravel/ui

## Using boostrap
    -- php artisan ui bootstrap --auth
    -- npm install

## Model | Controller | Migration | Factory | Seeders
    -- php artisan make:model Post -mfs
    -- php artisan make:controller PostController
    -- php artisan make:controller UserController

    ** Make sure to update the migration files | factories | seeders

## Running Migraiton
    ** Make sure to create your database `blogplatform`
    -- php artisan migrate:fresh --seed