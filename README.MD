# Shopping Cart Project

## Overview

This is a simple shopping cart application built using PHP and MySQL.
It allows customers to browse products, add items to their shopping cart, and place orders.
Administrators can manage products, customers, and orders through a dedicated admin interface.
The application also provides REST APIs to access product data.

## Technologies Used

- **Backend:** PHP
- **Database:** MySQL

## Database Initialization

To set up the database, run the following SQL script in your MySQL environment:

- **File Name:** `shopping_cart.sql`

This script will create the necessary tables (`users`, `products`, `orders`, `order_items`, `customers`) and populate them with sample data.

### How to Run:

1. Open phpMyAdmin or your preferred MySQL interface.
2. Select your database (or create a new one).
3. Import the `shopping_cart.sql` file to initialize the database.

## URLs to Access the Application

- **Admin Page:** [Admin Dashboard](http://localhost:63342/shoppingCartProject/admin_dashboard.php)
- **Main/Home Page:** [Home Page](http://localhost:63342/shoppingCartProject/index.php?_ijt=jdoklbv1lvh4q93hp8e75j8ork)

## REST APIs

The application provides the following REST APIs in both XML and JSON formats:

1. **Product List**
   - **Endpoint:** `/API.php?action=product_list`
   - **Description:** Returns the entire product list.
   - **Example URLs:**
      - JSON: [Product List in JSON](http://localhost:63342/shoppingCartProject/API.php?action=product_list&format=json)
      - XML: [Product List in XML](http://localhost:63342/shoppingCartProject/API.php?action=product_list&format=xml)

2. **Product Search by Name**
   - **Endpoint:** `/API.php?action=product_search&name=product_name`
   - **Description:** Searches for products by name.
   - **Query Parameters:**
      - `name`: The name or part of the name of the product to search for.
   - **Example URLs:**
      - JSON: [Search Product by Name in JSON](http://localhost:63342/shoppingCartProject/API.php?action=product_search&name=Apple&format=json)
      - XML: [Search Product by Name in XML](http://localhost:63342/shoppingCartProject/API.php?action=product_search&name=Apple&format=xml)

3. **Product Search by Price Range**
   - **Endpoint:** `/API.php?action=product_price_range&low=min_price&high=max_price`
   - **Description:** Retrieves products within a specified price range.
   - **Query Parameters:**
      - `low`: The minimum price.
      - `high`: The maximum price.
   - **Example URLs:**
      - JSON: [Search Product by Price Range in JSON](http://localhost:63342/shoppingCartProject/API.php?action=product_price_range&low=1&high=10&format=json)
      - XML: [Search Product by Price Range in XML](http://localhost:63342/shoppingCartProject/API.php?action=product_price_range&low=1&high=10&format=xml)

## Notes

- Ensure your server is running with the correct configurations to execute PHP files.
- If using XAMPP or a similar tool, ensure that Apache and MySQL services are running.
