# TaskFlow Pro - Mini ERP & Task Management System

A streamlined Enterprise Resource Planning (ERP) and Task Management solution built to bridge the gap between simple spreadsheets and complex enterprise software.

## 🚀 Live Demo
**URL:** [http://taskmanagererp.infinityfree.me](http://taskmanagererp.infinityfree.me)

## 🛠 Tech Stack
- **Language:** PHP 8.x (Procedural & OOP mix)
- **Database:** MySQL 5.7+ (Hosted on InfinityFree Cluster)
- **Frontend:** HTML5, CSS3, Bootstrap 5.3.3
- **Icons:** Bootstrap Icons 1.11.3
- **Server:** Apache (XAMPP / LAMPP Stack)
- **Authentication:** BCrypt password hashing

## ✨ Features Implemented

### 1. Authentication & Security
1. **Authentication & Security**
   - Email/login-based authentication with BCrypt hashing
   - Session-based authorization with middleware guards
   - Login activity tracking (user_login_records table)
   - Secure logout functionality

2. **Role-Based Access Control (RBAC)**
   - Admin and User roles with permission scaffolding
   - Role-aware UI (Employees link visible to Admin only)

3. **Employee Management**
   - Admin-only create, read, update, and soft-delete workflows
   - Bootstrap modal forms for Add/Edit operations
   - Real-time validation and error handling

4. **Project Management**
   - Admin create project via modal
   - Admin edit projects in-place with full modals
   - Project status tracking (Active/Inactive)
   - Description support for each project

5. **Task Management**
   - Admin assign tasks to employees with projects and due dates
   - Task status tracking (Pending, In Progress, Completed)
   - Task analytics dashboard (total, completed, overdue, due-soon counts)
   - Role-specific task views (admin sees all, users see assigned)
   - Task edit modals for admins with status/assignee updates
   - Mark Done action for assigned users and admins

6. **User Interface**
   - Responsive Bootstrap 5 layout
   - Shared header/footer components with search bar
   - Card layouts for projects and dashboard stats
   - Responsive table for task listings
   - Admin action buttons (Edit, Done, etc.)
   - Role-aware navigation

## 📦 Setup & Deployment

1. Configure database in config/db.php
2. Import database/schema.sql into your MySQL database
3. Start Apache and MySQL
4. Open the app at https://taskmanagererp.infinityfree.me/

## Test Credentials
- Admin
  - username: admin
  - Password: admin123
- User
  - username: amitxyz@gmail.com
  - password: amit123


## 🚧 Known Limitations
- **Case Sensitivity:** Being hosted on Linux, file paths are case-sensitive (e.g., `src/db.php` vs `src/DB.php`).
- **Email Notifications:** Currently, task assignments do not trigger automated emails.
- **File Attachments:** No current support for uploading documents to specific tasks.

## 📸 Screenshots

### Login Page
![Login Page](/assets/Login_page.png)
- Email/login input field
- Password field with secure handling
- Bootstrap alert for invalid credentials

### Dashboard
![Dashboard](/assets/Admin.png)
- Quick stats cards (Total Projects, Active Tasks, Team Members)
- Role-aware navigation (Admin sees Employees link)
- Responsive grid layout

### Employee Management
![Employee Management](/assets/Employee_details.png)
- Table with employee list
- Add/Edit modals with validation
- Status indicators (Active/Inactive)
- Action buttons (Edit, Deactivate)

### Project Board
![Project Board](/assets/projects.png)
- Card layout for projects
- Admin Edit button per project
- Status badge (Active/Inactive)
- Create New Project modal

### Task Manager
![Task Manager](/assets/task_management.png)
- Analytics cards (Total, Completed, Due Soon, Overdue)
- Responsive table with task details
- Status badges with color coding
- Admin Edit and Done buttons
- Assign New Task modal
- Role-specific view (admin sees all, users see assigned)

---
Developed by [Tarun Kumar]