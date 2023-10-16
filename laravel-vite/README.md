# Tutorial

# Process
    * Run the laravel first
        php artisan serve
    
    * Install the tailwind
        -- npm install -D tailwindcss postcss autoprefixer
        -- npx tailwindcss init -p
        -- this one is using vite js
    * Vite Configuration - vite.config.js
        server: {
            hmr: {
                host: 'localhost'
            }
        },

    * Tailwind Config at tailwind.config.js
        content: [
            "./resources/**/*.blade.php",
            "./resources/**/*.js",
            "./resources/**/*.vue",
        ],

    * add the following command at public/css/app.css
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

    
    * Run the NODE JS
        npm run dev

    * Build the Vite for deployment
        npm run build


# important notes
   

