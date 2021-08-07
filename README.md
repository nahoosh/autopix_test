This is a small application that allows the user to login to a portal and create a new articles. 

The article has a title, body and an image. 

Only one user should be able to login with credentials “test@3sixtyfactory.com” and the password of “test12345”. 

You should also expose a simple API that would allow third parties to view all articles from a given user as well as view details of a single article. 

* Once project's .env file is set up with correct database credentials, run the following commands:
php artisan storage:link
php artisan migrate
php artisan seed

For API Documentation, I have used L5-Swagger library.
To generate documentation, execute the command: 
php artisan l5-swagger:generate