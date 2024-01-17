# ✨ BlogPlatform - [Repo](https://github.com/Carlozzzzz/Laravel9_Learning/tree/main/__practice_project/BlogPlatform)

   ![Dashboard1](https://github.com/Carlozzzzz/Laravel9_Learning/blob/main/__practice_project/BlogPlatform/demo_img/dashboard_1.png)

   ![Dashboard2](https://github.com/Carlozzzzz/Laravel9_Learning/blob/main/__practice_project/BlogPlatform/demo_img/dashboard_2.png)

   ![Profile](https://github.com/Carlozzzzz/Laravel9_Learning/blob/main/__practice_project/BlogPlatform/demo_img/profile.png)

   ![CreatePost](https://github.com/Carlozzzzz/Laravel9_Learning/blob/main/__practice_project/BlogPlatform/demo_img/create_post.png)


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


### Migration -- update existing migration table
    -- php artisan make:migration update_countryid_to_users_table --table=users


## Running Migraiton
    ** Make sure to create your database `blogplatform`
    -- php artisan migrate:fresh --seed


## Components
    -- php artisan make:component postcard  --view


## Package required
    Intervention
        -- composer require intervention/image
    Bootstrap && Laravel UI
        -- composer require twbs/bootstrap:5.3.2
        -- composer require laravel/ui
        -- php artisan ui bootstrap --auth
        -- npm install
    Alphine
        -- <script src="//unpkg.com/alpinejs" defer></script>
    Boxicons
        -- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
