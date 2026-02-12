# PHP_Laravel11_Larecipe

## Project Description

This project is a Laravel 11 application integrated with LaRecipe, a documentation builder for Laravel projects. It allows you to create interactive, versioned documentation using simple Markdown files. LaRecipe automatically generates a clean, responsive UI with a sidebar, search functionality, and a modern code-friendly design.

## Purpose:

The project serves as a demo or template for building and managing project documentation. Developers can:

- Write documentation in Markdown files.

- Organize content using versions (e.g., 1.0, 2.0) for release-specific docs.

- Generate a professional-looking documentation website without manual HTML/CSS.

- Optionally restrict access using Laravel authentication if needed.


## Use Case:

This project is ideal for:

- Teams who want internal or public documentation for their Laravel applications.

- Developers who want to create documentation websites quickly without building custom UI.

- Anyone learning Laravel + LaRecipe integration and Markdown-based documentation.


## Technology Used

- PHP – Programming language

- Laravel 11 – Web framework

- LaRecipe – Documentation generator

- MySQL – Optional database

- Markdown – For writing docs

- HTML / CSS / JS – Frontend rendering




---

#  Full Step-by-Step Setup (Laravel 11 + Larecipe)

---


## STEP 1: Create Laravel 11 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel11_Larecipe "11.*"

```

### Go inside project:

```
cd PHP_Laravel11_Larecipe

```

#### Explanation: 

This command installs a fresh Laravel 11 application using Composer.

The "11.*" ensures that Laravel 11 is installed and compatible with Larecipe.

This will create a fresh Laravel project with all default files and folders.

After this, your project folder will contain all default Laravel files and folders.




## STEP 2: Database setup optional (not required for demo APIs)

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel11_Larecipe
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel11_Larecipe

```

#### Explanation:

You only need a database if you plan to protect docs with authentication or store user-specific content.

Setting up a database is only needed if you plan to store user data or authentication for docs.





## STEP 3: Install Larecipe

### Run:

```
composer require binarytorch/larecipe

```

#### Explanation:

This command installs the LaRecipe package into your Laravel project.

It adds all necessary files to generate and display interactive documentation from markdown.




## STEP 4: Publish LaRecipe Setup Files

### Now run the special install command:

```
php artisan larecipe:install

```
#### What this does

- Publishes configuration file

- Creates docs folder structure (resources/docs)

- Publishes assets, views, and all necessary files for LaRecipe

- Config file appears at config/larecipe.php

- Documentation source folder appears at resources/docs

 This is similar to how the reference project configures LaRecipe.




## STEP 5: Configure Documentation

### Open:

```
config/larecipe.php

```

### And update values such as:

```
'docs' => [
    'route' => '/docs',
    'path' => resource_path('docs'),
    'landing' => 'overview',
    'middleware' => ['web'],
],


'versions' => [
    'default' => '1.0',
    'published' => ['1.0']
],


```

#### Explanation:

The path points LaRecipe to the folder where your markdown files live.

The route is the URL prefix for your docs (e.g., /docs).

You can version your docs for multiple releases (v1.0, v2.0, etc.).

The default version is the one that users see when they visit /docs.



## STEP 6: Create/Edit Markdown Docs

### Go to:

```
resources/docs/1.0/ 

```

#### Then create your own:

### Example: index.md

```
- ## Get Started
    - [Overview](/{{route}}/{{version}}/overview)

```


### Example: overview.md

```
# Overview

Welcome to **LaRecipe Documentation**

LaRecipe is a documentation builder for Laravel applications. It generates clean, interactive documentation pages from simple markdown files.

This documentation uses:

- Markdown files
- Versioning
- Sidebar navigation
- A modern UI generated from Laravel and Vue

---

## Why LaRecipe?

LaRecipe allows you to:

- Write docs in Markdown  
- Support multiple versions  
- Add search  
- Customize theme  
- Add code examples easily

---

## What’s Next?

Use the sidebar to explore installation, configuration, features and examples.

```


### Example: sidebar.md

```
## Get Started

- [Overview](/{{route}}/{{version}}/overview)

```

#### Explanation:

Markdown files contain the content of your documentation pages.

Sidebar defines the navigation links displayed on the left panel of docs.



## STEP 7: Redirect Root to Docs

### Open routes/web.php and add:

```
<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/docs');

```

#### Explanation:

This ensures that when someone visits http://localhost:8000, they are redirected to your docs.

It makes accessing the documentation easier and user-friendly.




## STEP 8: Launch the Server

### Run:

```
php artisan serve

```
### Then open your browser:

```
http://localhost:8000/docs

```

#### Explanation:

This starts the local Laravel development server.

Now you can view your interactive LaRecipe documentation in the browser.



## Expected Output:


<img width="1919" height="969" alt="Screenshot 2026-02-12 100919" src="https://github.com/user-attachments/assets/59789af6-6aa2-42e3-b4fc-63d2f961d469" />



---

# Project Folder Structure:

```

PHP_Laravel11_Larecipe/
│
├── app/
├── bootstrap/
├── config/
│   └── larecipe.php      <-- LaRecipe config file
├── database/
├── public/
│   └── vendor/           <-- LaRecipe assets
├── resources/
│   └── docs/
│       └── en/           <-- Default language docs (you can add 1.0, 2.0 versions if needed)
│           ├── index.md
│           ├── overview.md
│           └── sidebar.md
├── routes/
│   └── web.php
├── storage/
├── tests/
└── composer.json

```
