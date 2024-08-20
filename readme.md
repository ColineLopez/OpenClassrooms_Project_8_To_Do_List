# 📝 OpenClassrooms' Project #8 - To Do List

## 🚀 Project objective 

The goal of this project was to take an old version of the ToDoList application developed in Symfony and improve it in terms of features, code quality, and performance. The focus was on adding new functionalities, enhancing the user interface, and implementing unit and functional tests, along with achieving comprehensive code coverage.

## ⚙️ Features

### Create, Update and Delete Tasks:

Users can create, modify and delete their tasks.The application provides a user-friendly interface to manage the content easily. 

### Create and Update Users:

Only admins can create, modify and delete users. The appliation provides a user-friendly interface to manage the content easily.

## 🛠️ Installing the project

1. Clone the project
   
`git clone https://github.com/ColineLopez/todolist.git
cd todolist
composer install`

2. Configure the database

`php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate`

3. Load fixtures

`php bin/console doctrine:fixtures:load`

## 🧪 Tests

Unit and functional tests were implemented to ensure the application's proper functioning. Additionally, code coverage was conducted to ensure that the entire codebase is thoroughly tested.

`php bin/phpunit`

## 🖼️ App Overview

## 🛠️ Workspace environment

`PHP version : 8.3.1
MySQL version : 8.0.31
Symfony 6.4`

