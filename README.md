# Laravel9_Learning
 

# tutorial
https://www.youtube.com/watch?v=sPMtPrBR5Cc&list=PLKyjE37ORK3IUmxexDccrPbjzkfPU9Vux

# Setup the Composer-laravel first
        ** run the following commands
            -- composer global require laravel/installer
            -- laravel new laravel
            -- cd laravel
            -- composer install

        **run the server
            -- php artisan serve



# Usefull commans
    
        *finding file
            -- ctrl + p

        *Create Controller
            --php artisan make:controller UserController


# notes

        dd($request); // debugger

        *Set DB
            -- set up at .env

        *Create Model
            -- php artisan make:model Students

        *Create Controller
            -- php artisan make:controller StudentController

        *Using migrate
            -- make db first
            -- php artisan migrate

        *Using seeder
            -- php artisan migrate:refresh --seed
        
        *SET UP YOUR OWN MIGRATION | FACTORY | SEEDER
            **Create Migration
                -- php artisan make:migration students_table
            
            *Create Factory
                -- php artisan make:factory StudentFactory
                -- edit your Factory


# important notes
        If separate php
            -- https://www.youtube.com/watch?v=jwPStCGrJfI&list=PLKyjE37ORK3IUmxexDccrPbjzkfPU9Vux&index=5
            -- 9:27

        Elequent class
            -- easier manipulation of data at database



# documentation
        ** Faker
            -- https://github.com/fzaninotto/Faker
