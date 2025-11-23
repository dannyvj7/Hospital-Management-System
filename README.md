# 🏥 Hospital Management System (HMS)

A complete PHP-based Hospital Management System built with:

- HTML
- CSS (no frameworks)
- JavaScript
- PHP
- MySQL (XAMPP)

This project supports multiple user roles:

- **Admin** – Manage doctors, patients, appointments
- **Doctor** – View appointments, patient records
- **Patient** – Register, book appointments, view status

---

## 🚀 Features

### 🔐 Authentication

- Secure login system (Admin / Doctor / Patient)
- Password hashing (PHP `password_hash()`)

### 🏥 Hospital Modules

- Manage doctors
- Manage patients
- Create & manage appointments
- Update appointment status
- View medical records

### 📊 Dashboards

- Admin dashboard
- Doctor dashboard
- Patient dashboard

### 🎨 Frontend

- Clean UI built with **plain CSS**
- Font Awesome icons
- Responsive layout

---

## 📁 Project Structure

hospital_management/
│
├── index.php # Login page
├── register.php # Patient registration
├── dashboard.php # Admin dashboard
├── doctor_dashboard.php # Doctor dashboard
├── patient_dashboard.php # Patient dashboard
├── appointments.php # Appointment handling
├── manage_patients.php # Admin manages patients
├── manage_doctors.php # Admin manages doctors
├── logout.php # Logout script
│
├── includes/
│ ├── db.php # Database connection
│ ├── auth.php # Session protection
│
├── assets/
│ ├── css/style.css # Main styling
│ ├── js/script.js # Optional JS
│ ├── images/ # Logo / icons
│
└── README.md
