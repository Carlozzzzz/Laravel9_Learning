## Process
        Route -> Controller -> View -> View


        ** Install Vite
            -- see installation process at laravel-vite repo
        
## Notes
        ** You can pass globally data to any view using AppServiceProvider
            -- you can also use query there
            -- View::share('title', 'Student Admin');

        ** you can attacher data on view when you load it
            -- do this inside the AppSeviceProvider
            -- commonly used on dropdowns like Country
            View::composer('students.index',function($view){
                $view->width('students', Students::all());
            });

        ** Shortcut keys
            -- alt + z :: format vscode text

# Run the APP
        -- npm run dev
        -- php artisan serve


## Package needed
        ** Intervention image
            -- composer require intervention/image
            -- php artisan storage:link
            
            == using this package, you need to link the storage blablabla
            == cofigure this when will try to upload on server at (**config/filesystems.php => 'links')

            Sample code to execute
                -- create sumlink.php
                -- symlink("/home/{clientid}/{your_domain}/storage/app/public", "/home/{clientid}/public_html/storage");

        ** Dicebear
            -- https://www.dicebear.com/introduction/

        ** Alphine
            -- <script src="//unpkg.com/alpinejs" defer></script>

## Creating migration file | running single file
        ** Single Migration file/run
            -- php artisan make:migration add_student_image_field --table=students
            -- php artisan migrate --path=/database/migrations/2023_10_16_130956_add_student_image_field.php
