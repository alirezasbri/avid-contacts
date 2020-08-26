## Simple Contacts App

### Install Guide
You can read a complete tutorial to cloning repository in [Here](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository) But in short:
- Change the current working directory to the location where you want the cloned directory.
- Run `$ git clone https://github.com/alirezasbri/avid-contacts.git` on your cmd or terminal
- Run `composer install`
- Copy .env.example file to .env on the root folder. You can type `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
    - By default, the username is root and you can leave the password field empty. (This is for Xampp)
    - By default, the username is root and password is also root. (This is for Lamp)
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `php artisan serve`

### Api Guide
Api Authentication Is Based On **Tokens**, token is in response of register/login requests.
So obviously register/login **DO NOT Needs** to token.
set tokens in header in **Bearer** mode.   
#### User Apis
Method | Route | Description
------ | ----- | -----
POST | /register | To Register User
POST | /login | To Login User
GET | /logout | To Logout User

#### Contact Apis
Method | Route | Description
------ | ----- | -----
GET | /contacts | To Index Contacts
GET | /contacts/{id} | To Show Contact Details
POST | /contacts | To Add Contact
PUT | /contacts/{id} | To Edit Contact
DELETE | /contacts/{id} | To Delete Contact
