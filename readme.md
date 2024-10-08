# 📝 OpenClassrooms' Project #8 - To Do List

## 🚀 Project objective 

The goal of this project was to take an old version of the ToDoList application developed in Symfony and improve it in terms of features, code quality, and performance. The focus was on adding new functionalities, enhancing the user interface, and implementing unit and functional tests, along with achieving comprehensive code coverage.

## ⚙️ Features

### Create, Update and Delete Tasks:

Users can create, modify and delete their tasks.The application provides a user-friendly interface to manage the content easily. 

### Create and Update Users:

Only admins can create, modify and delete users. The appliation provides a user-friendly interface to manage the content easily.

## 🛠️ Installing the project

1. Clone the repository
   
`git clone https://github.com/ColineLopez/OpenClassrooms_Project_8_To_Do_List.git`

`cd OpenClassrooms_Project_8_To_Do_List`

2. Install Dependencies

`composer install`

3. Set up your environment variables configuring it according to your environment.
   
4. Configure the database

`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

5. Load fixtures

`php bin/console doctrine:fixtures:load`

6. Start the Symfony server

`symfony server:start`

## 🧪 Tests

Unit and functional tests were implemented to ensure the application's proper functioning. Additionally, code coverage was conducted to ensure that the entire codebase is thoroughly tested.

`php bin/phpunit`

## 🖼️ App Overview

## 🛠️ Workspace Environment

![PHP](https://img.shields.io/badge/PHP-8.3.1-blue)

![MySQL](https://img.shields.io/badge/MySQL-8.0.31-orange)

![Symfony](https://img.shields.io/badge/Symfony-6.4-green)

