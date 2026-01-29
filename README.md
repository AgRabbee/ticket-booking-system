# 🎟️ Ticket Booking System (TBS)

A modern **Bus Ticket Booking System** built with **Laravel 10** and **AdminLTE**, designed to manage bus trips, seat reservations, payments, and multi-level administration efficiently.

---

## 🚀 Project Overview

The **Ticket Booking System (TBS)** is a role-based web application that allows customers to search and book bus tickets online, while enabling transport companies and system administrators to manage trips, vehicles, users, and sales reports through powerful dashboards.

The system supports **three main roles**:

* **Customer**
* **Company Admin**
* **System Admin**

It also allows **new companies** to request registration into the system.

---

## 🛠️ Tech Stack

* **Framework:** Laravel 10
* **Frontend Admin Panel:** AdminLTE
* **Database:** MySQL (or compatible)
* **Payment Gateway:** Stripe
* **Authentication:** Laravel Auth
* **Reporting:** Monthly Sales Reports

---

## 👥 User Roles & Features

### 🧑‍💼 Customer

Customers can:

* Search available buses by **route** and **travel date**
* View real-time **seat availability layout**
* Select preferred seats
* Make secure payments using **Stripe**
* Download or **print tickets** after successful payment

---

### 🏢 Company Admin

Company administrators can manage their own transport operations:

**Dashboard**

* View company-specific data summary at a glance

**Trip Management**

* View all trips as a list
* Update trip fares
* Add new trips

**Transport Management**

* View all available transports
* Add new transport vehicles

**Driver Management**

* Add users as drivers
* View all drivers under the company

**Sales & Reports**

* View all sales data
* Generate **monthly sales reports** (company-specific)

**Profile Management**

* View and update profile information
* Change password securely

---

### 🛡️ System Admin

System administrators have full system-level control:

**Dashboard**

* View overall system summary

**User Management**

* View all company users
* View all customers
* Update user status (active / inactive)

**Trip & Transport Management**

* View all trips in the system
* View all transports
* Add new transports globally

**Sales Reports**

* View **monthly sales reports** for the entire system

**Profile Management**

* View and update own profile
* Change password

---

### 📝 Company Registration Request

* Any user can submit a request to **register a new company** in the system
* Requests can be reviewed and managed by the system admin

---

## 🔐 Authentication & Authorization

* Role-based access control (Customer, Company Admin, System Admin)
* Secure login and password management
* Restricted access based on user roles

---

## 💳 Payment Integration

* Integrated with **Stripe Payment Gateway**
* Secure ticket purchase process
* Ticket generation only after successful payment

---

## 📊 Reports & Analytics

* Company-wise monthly sales reports
* System-wide monthly sales analytics
* Sales data available in list and report formats

---

## ⚙️ Installation Guide

```bash
# Clone the repository
git clone https://github.com/AgRabbee/tbs.git

# Navigate to project directory
cd tbs

# Run the project using Docker
docker compose up -d --build

# Browse project in browser with port 8080
http://localhost:8080

# To enter to the container
docker exec -it tbs_app bash

# Install dependencies
composer install

# Run migrations
php artisan migrate
```

## 🤝 Contribution

Contributions, issues, and feature requests are welcome!

---

## 📄 License

This project is open-source and available under the **MIT License**.

---

## ✨ Author

Developed by [Md Abdul Goni Rabbee](https://www.linkedin.com/in/abdul-goni-rabbee/).

