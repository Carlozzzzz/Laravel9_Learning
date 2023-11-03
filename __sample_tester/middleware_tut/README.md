## Create middleware
        -- php artisan make:middleware CheackYear


## Register your middleware
        == go to \Http\Kernel.php
        == find the  $routeMiddleware, and add like this
        -- 'check-year' => \App\Http\Middleware\CheckYear::class,

## Summary
        -- Middleware is like a validation when you make a request 
        -- you can attach an middleware to your route and before the route is being executed, it will first run the middleware function
        