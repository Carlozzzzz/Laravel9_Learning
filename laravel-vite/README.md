# Tutorial

# Process
    * Run the laravel first
        php artisan serve
    
    * Install the tailwind
        npx tailwindcss init -p
        -- this one is using vite js

    * add the following command at public/css/app.css
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

    
    * Run the NODE JS
        npm run dev

    * Build the Vite for deployment
        npm run build


# important notes
    * Change Vite Confiuration : add the ff
         server: {
            hmr: {
                host: 'localhost'
            }
        },

