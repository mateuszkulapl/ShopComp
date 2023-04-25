# ShopComp - Price Tracker Application

A web application to track and compare prices in online shops, built using the PHP language with the Laravel framework. The application compares product prices based on their EAN codes. Adding and updating product data (including prices) is done through an API.

## Features

*   Track and compare product prices across different stores
*   Utilizes EAN codes for accurate product comparison
*   Add and update product data through a dedicated API

## Technology Stack

*   PHP
*   Laravel Framework
*   Tailwind CSS
*   ApexCharts.js


## Getting Started

To set up the Price Tracker Application on your local machine, follow these steps:

1.  **Clone the repository**: Clone this repository to your local machine using `git clone`.

2.  **Install dependencies**: Run `composer install` to install the required dependencies.

3.  **Configure environment**: Copy the `.env.example` file to `.env` and fill in the required information, including database connection credentials and any API keys.

4.  **Run migrations**: Execute `php artisan migrate` to set up the necessary database tables.

5.  **Start the application**: Run `php artisan serve` to start the local development server.

6.  **Insert data**: Use the API to insert data into the database.

For more information on configuring and deploying the application, refer to the Laravel [documentation](http1s://laravel.com/docs).


## Screenshots

**Home page above the fold**

![Screenshot of the homepage](/readme_screenshots/homepage-atf.png?raw=true "Homepage above the fold")

**Home page below the fold**

![Screenshot of the homepage](/readme_screenshots/homepage-btf.png?raw=true "Homepage below the fold")

**Product page**

![Screenshot of the homepage](/readme_screenshots/product-page.png?raw=true "Product page")

**Product search**

![Product searching](/readme_screenshots/search.gif?raw=true "Product search")

**Product category with breadcumbs category path**

![Product category](/readme_screenshots/shop-category.png?raw=true "Product category")