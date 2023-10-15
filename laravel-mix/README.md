# Laravel Mix

# Process
        ** Install laravel
            -- laravel new laravel-mix
        
        ** Run laravel
            -- cd laravel-mix
            -- php artisan serve

        ** Install Tailwind
            open new termianal
            -- npm install -D tailwindcss postcss autoprefixer
            -- npx tailwindcss init

        ** Add Config at tailwind.config
            content: [
                "./resources/**/*.blade.php",
                "./resources/**/*.js",
                "./resources/**/*.vue",
            ],

        ** Add app.css
            @tailwind base;
            @tailwind components;
            @tailwind utilities;

        ** Add this to your view
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        ** Install Laravel Mix
            npm install laravel-mix --save-dev
        
        ** Create a webpack.mix.js
            -- webpack.mix.js
            == add this inside
                ===================================================
                const mix = require('laravel-mix');

                mix.js("resources/js/app.js", "public/js")
                    .postCss("resources/css/app.css", "public/css", [
                        require("tailwindcss"),
                ]);
                ===================================================

        ** Add this to your package-lock.json / "scripts"
            "development": "mix",
            "watch": "mix watch"

        ** Run the node
            npm run watch

        ** Run the laravel
            php artisan serve
# Important Notes