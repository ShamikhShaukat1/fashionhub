
# Fashion Hub

Fashion Hub is a Laravel-based fashion e-commerce management system designed to provide a simple and organized platform for managing fashion products, customers, orders, categories, and vendors.

The system provides separate functionality for **administrators** and **customers**, allowing administrators to manage the store while customers can browse products and place orders.

---

## Features

### Authentication

* User registration
* User login
* User logout
* Role-based access
* Secure admin access

### Admin Panel

The admin panel provides centralized management of the Fashion Hub system.

Administrators can manage:

* Products
* Categories
* Customers
* Orders
* Vendors

### Product Management

Administrators can:

* Add products
* View products
* Update products
* Delete products
* Organize products by category

Customers can browse available products and view individual product details.

### Category Management

Administrators can:

* Create categories
* View categories
* Edit categories
* Delete categories
* Manage products according to their categories

### Customer Management

Administrators can:

* View customers
* View customer information
* Update customer information
* Delete customers

### Order Management

Customers can:

* Place orders
* View their orders

Administrators can:

* View customer orders
* View order details
* Manage orders

### Vendor Management

Administrators can:

* Add vendors
* View vendors
* Update vendors
* Delete vendors

The vendor section allows the admin to maintain vendor information within the system.

---

## User Roles

### Administrator

Administrators have access to the management panel and can manage the main areas of the system.

Admin functionality includes:

* Product management
* Category management
* Customer management
* Order management
* Vendor management
* Dashboard access

### Customer

Customers can use the shopping side of the application.

Customer functionality includes:

* Account registration
* Login
* Product browsing
* Product details
* Order placement
* Order access

---

## Technologies Used

* **Laravel** – Backend framework
* **PHP** – Programming language
* **MySQL** – Database
* **Blade** – Template engine
* **Tailwind CSS** – User interface styling
* **JavaScript** – Frontend functionality

---

## Application Structure

Fashion Hub consists of two main areas:

### Customer Side

The customer side allows users to browse the fashion catalog and interact with the shopping functionality.

### Admin Side

The admin side provides centralized control over the store's data and operations.

---

## Admin Dashboard

The admin dashboard provides access to the main management sections of Fashion Hub.

The dashboard is designed with a consistent dark-themed interface and provides navigation to:

* Products
* Categories
* Customers
* Orders
* Vendors

---

## Product and Category Organization

Products are organized through categories to make the fashion catalog easier to manage and browse.

Each product can be associated with a category, allowing administrators to maintain a structured product catalog.

---

## Customer and Order Management

Customers are connected to their orders within the system.

This allows the administrator to view customer-related order information and manage orders from the admin panel.

---

## Vendor Management

The vendor module allows administrators to maintain vendor information within Fashion Hub.

Vendor records can be created, viewed, updated, and deleted from the admin panel.

---

## User Interface

Fashion Hub uses a modern dark-themed interface designed for consistency across the application.

The admin interface uses:

* Dark stone-colored backgrounds
* Amber action buttons
* Rounded content sections
* Sidebar navigation
* Responsive layouts
* Consistent typography and spacing

---

## Project Requirements

Before running Fashion Hub, make sure the development environment has:

* PHP
* Composer
* MySQL
* Laravel
* A web browser
* A local development environment such as XAMPP, Laragon, or Laravel Herd

---

## Installation

### 1. Clone the Project

Clone the Fashion Hub repository and open the project directory.

### 2. Install Dependencies

Install the project's PHP dependencies using Composer.

### 3. Configure the Environment

Create the application's environment configuration and connect it to a MySQL database.

### 4. Set Up the Database

Create the Fashion Hub database and run the project's database migrations.

### 5. Start the Application

Start the Laravel development server and open the application in your web browser.

---

## Main Modules

| Module         | Description                                         |
| -------------- | --------------------------------------------------- |
| Authentication | Registration, login, and logout                     |
| Dashboard      | Main application and admin overview                 |
| Products       | Product management and browsing                     |
| Categories     | Product category management                         |
| Customers      | Customer management                                 |
| Orders         | Customer order placement and admin order management |
| Vendors        | Vendor management                                   |

---

## Project Workflow

The general workflow of Fashion Hub is:

**Customer**

Register → Login → Browse Products → View Product → Place Order

**Administrator**

Login → Dashboard → Manage Products, Categories, Customers, Orders, and Vendors

---

## Security

Fashion Hub separates administrator and customer functionality through authentication and role-based access.

Administrative features are restricted to authorized administrator accounts.

---

## Future Enhancements

The project can be expanded with additional e-commerce features such as:

* Shopping cart
* Wishlist
* Product search
* Product filtering
* Product images
* Product sizes and colors
* Inventory management
* Payment integration
* Order tracking
* Product reviews and ratings
* Discounts and coupons
* Sales reports
* Customer profile management
* Email notifications

---

## Project Status

Fashion Hub currently includes the core functionality required for a fashion e-commerce management system, including authentication, product management, category management, customer management, order management, and vendor management.

The project can be further expanded with advanced e-commerce and business management features.

---

## License

This project is developed for educational and project development purposes.
