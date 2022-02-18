## SavonsMy - Online Purchase Order System

As a side project I have developed a web-app that enables a company to receive and handle all their purchase orders online.

All you have to do is login as the admin user, and then create your purchase order form
using categories and variants. Each time you save the form, a new version is created to allow pending orders and historical orders to 
remain intact.

Your customers will simply have to create an account on the portal and submit a purchase order based on the information entered in the 
admin area.

Once a purchase order has been submitted, the admin user will receive an email notification and will be able to change the 
status of the order to "IN PROGRESS" and then "COMPLETED".

The client will also receive email notifications when the status of its order changes.

## Demo
Visit [Savons My - Purchase Order DEMO](https://savonsmy.simonmallet.com/login)
- Admin portal
  - username: admin@mysite.com
  - password: password
- Client portal
  - username: partner@mysite.com
  - password: password

## How to install
- git clone git@github.com:simonmallet/savonsmy.git
- To facilitate development I use [docker-compose-laravel](https://github.com/aschmelyun/docker-compose-laravel) 
to create the base sandbox
- Modify the docker-compose.yml to point to your cloned project and ensure mysql is included.
You can view an example in ./docs/docker-compose.example.yml
- Run the following commands from the container:
  - composer install
  - php artisan migrate
  - php artisan db:seed
  - npm run dev
- By default, the site will be available at http://localhost/login

## Database schema
View PDF file in ./docs/db_schema.pdf for the most up-to-date version (although it may not be 100% up-to-date like any good docs ;))
