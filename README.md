# TrelloClone
Project based on Trello. It's only for study and skills improvement purpose.

## Overview
To improve skills, the best way is practicing. That's why this project has been created. Either to help another developers with this as a guide or starting point.

The idea of this project is based on the Trello application, this motivation comes from a Medium post (https://medium.freecodecamp.org/the-secret-to-being-a-top-developer-is-building-things-heres-a-list-of-fun-apps-to-build-aac61ac0736c).

The project will be an API, build with Laravel.

## Setup
* Clone project
* Install laravel dependencies `composer install`
* Remember to create your **.env** file so you can set yor DB configuration
* Once configured environment file and DB, run `php artisan migrate` to create migrations
* Because this project is an API, we'll use the laravel Passport service to authenticate, must run `php artisan passport:install`. (Link to passport documentation: https://laravel.com/docs/5.6/passport)
