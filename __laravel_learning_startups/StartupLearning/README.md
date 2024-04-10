# ✨ StartupLeaning
 
   ![StartupLeaningImage](https://github.com/Carlozzzzz/Laravel9_Learning/blob/main/__practice_project/QuizApp/demo_img/student_quiz_question.png)
   
# 😎 Key Learning

   ## API
      - use to access different controllers
   ## Channels
      - laravel broadcasting

   ## Console
      - allow you to create your own command
   
   ## Web
      - accept HTTP request
      - use `middlewares` to protect your routes

   ## Bootstrap
      - bundled up the core feature/classes

   ## Config
      - appnames
      - authentication
      - database (is where you edit the connection to your database)
      - caches (default in file format)
      - filesystem (need to upload/download files? update it here)

   ## Database
      - Migration files (auto create tables)
      - Factories (define the required data type for your seeders, use faker app)
      - seeders (Create default/sample data)


   ## Language
      - not commonly pay attention

   ## Public folder
      - this is where you can access public files

   ## Resources 
      - this is where add our resources like css and js (most common to be add on Public folder)
      - views

   ## Test
      - for QA

   ## Vendor
      - libraries installed from composer.json

# Important Notes
   
   ## Routes
      - authentication for the users on what they can access

      Route::get();
      Route::post();
      Route::put(); - remove whole data then change
      Route::patch(); - change small portion of data (it's okey not to use this)
      Route::delete();
      Route::options(); - controll some allowed method/origin in URL
      Route::match(['get', 'post'], '/' , function() {
         return 'POST and GET is allow';
      }); - allows specific route functions
      Route::any(); - no filter
      Route::redirect('/welcome', '/'); - redirect back to '/'
      Route::permanentRedirect('HTTP', 'HTTPS'); - When you have HTTP redirect it to HTTPS
      Route::get('/user/{id}/{group}', function($id, $group){
         return response($id.'-'.$group, 200);
      });

      ## JSON Files
      Route::get('/request-json', function(){
         return response()->json(['name' => 'PinoyFreeCoder', 'age' => '23']);
      });

      ## Downloading Files
         Route::get('/request-download', function() {
            $name = 'sample.txt';
            $path = public_path(). '/' . $name;
            $headers = array(
               'Content-type : application/text-plain'
            );
            return response()->download($path, $name, $headers);
         });


   ## if you have many rss
      - `ctrl + p` - finding files

   ## Errors
      - change it on .env files


   ## :wrench: Setup
       basic laravel installation
       php artisan migrate --seed
        
            
   ## :running: Run the APP
      npm run dev
      php artisan serve (http://127.0.0.1:8000/)

   ## :briefcase: Resources
         https://colorhunt.co/palette/fffbf5f7efe5c3acd07743db
    
# What is?
   - the use of response();

# 😎 Localhost Acc

      Username: echibot1@gmail.com
      Password: password
   
