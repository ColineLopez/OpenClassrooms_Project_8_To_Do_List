# OpenClassrooms' Project #8 - To Do List

## Context 

This is the documentation for the ToDoList project from OpenClassrooms. This project aims to improve a Symfony ToDoList application and add or fix some additional features. It also involves developing unit and functionel tests.  

## Workspace environment

This project was developed only on a local server. 

`PHP version : 8.3.1
MySQL version : 8.0.31
Composer required`

## Install project on your machine

`git clone https://github.com/ColineLopez/todolist.git
cd todolist
composer install`

## Database

### Create database 

`php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate`

### Load fixtures 

`php bin/console doctrine:fixtures:load`

### Start tests

`php bin/phpunit`

## Features

### Create, Update and Delete Tasks:

Users can create, modify and delete their tasks.The application provides a user-friendly interface to manage the content easily. 

### Create and Update Users:

Only admins can create, modify and delete users. The appliation provides a user-friendly interface to manage the content easily.

