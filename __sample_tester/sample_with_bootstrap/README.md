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

## Migration and seeders
    -- php artisan make:model Category -mfs
    -- php artisan make:model Product -mfs

## Running Migraiton
    ** Make sure to create your database `sample_with_bootstrap`
    -- php artisan migrate:fresh --seed