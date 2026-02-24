# TaskFlow Pro - Mini ERP & Task Management System

A streamlined Enterprise Resource Planning (ERP) and Task Management solution built to bridge the gap between simple spreadsheets and complex enterprise software.

## 🚀 Live Demo
**URL:** [http://taskmanagererp.infinityfree.me](http://taskmanagererp.infinityfree.me)

## 🛠 Tech Stack
- **Language:** PHP 8.x (Procedural & OOP mix)
- **Database:** MySQL 5.7+ (Hosted on InfinityFree Cluster)
- **Frontend:** HTML5, CSS3, Bootstrap 5.3.3
- **Icons:** Bootstrap Icons 1.11.3
- **Server:** Apache (Linux/InfinityFree Stack)
- **Authentication:** Session-based with dual-table verification

## ✨ Features Implemented

### 1. Authentication & Security
- **Secure Login:** Role-aware authentication checking both `admin` and `employees` tables.
- **Session Management:** Secure session handling to prevent unauthorized dashboard access.
- **Global Config:** Centralized `db.php` for easy environment switching (Local vs. Production).

### 2. Role-Based Access Control (RBAC)
- **Admin Dashboard:** Full access to employee management, project creation, and task assignment.
- **Employee Dashboard:** Personalized view restricted to assigned tasks and personal profile data.
- **UI Logic:** Navigation links (like "Manage Employees") are dynamically hidden based on user role.

### 3. Employee Management
- **CRUD Operations:** Admin can add, view, and manage employee records.
- **Dual-Table Architecture:** Separate storage for administrative staff and general employees for better data integrity.

### 4. Task & Project Management
- **Assignment System:** Admins can link tasks to specific projects and assign them to individual employees.
- **Status Tracking:** Real-time updates for task statuses (Pending, In Progress, Completed).
- **Project Scaffolding:** Ability to categorize work into specific Project buckets.

## 📦 Setup & Deployment

1. **Database Configuration:**
   - Update `src/db.php` with your MySQL credentials.
   - For InfinityFree, use the `sqlXXX.infinityfree.com` hostname.

2. **Import Schema:**
   - Import the provided `.sql` file via phpMyAdmin.

3. **File Upload:**
   - Upload all files to the `/htdocs` directory.
   - Ensure the entry point is named `index.php`.

## 🔑 Test Credentials (Production)

| Role | Email / Username | Password |
| :--- | :--- | :--- |
| **Admin** | admin (or your admin email) | admin123 |
| **Employee** | amitxyz@gmail.com | amit123 |

## 🚧 Known Limitations
- **Case Sensitivity:** Being hosted on Linux, file paths are case-sensitive (e.g., `src/db.php` vs `src/DB.php`).
- **Email Notifications:** Currently, task assignments do not trigger automated emails.
- **File Attachments:** No current support for uploading documents to specific tasks.

## 📸 Screenshots

### 🖥 Login Interface
*Clean, Bootstrap-powered login screen with validation.*
![Login Page Interface](assets/Login Page.png)

### 📊 Admin Dashboard
*Overview of system stats, including total employees and active projects.*

---
Developed by [Your Name/Team Name]