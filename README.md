# SaaS Clinic Management System

## 1. Project Overview
This project is a Multi-Tenant SaaS (Software as a Service) application designed for managing medical clinics. It provides a comprehensive solution for clinics to manage their daily operations, including patient records, appointments, billing, and staff roles. 

The architecture is multi-tenant, meaning a single instance of the software serves multiple clinics (tenants), with strict data isolation between them.

## 2. Tech Stack & Environment
* **Backend Framework:** Laravel (PHP)
* **Frontend Build Tool:** Vite (configured via `vite.config.js`)
* **Database:** MySQL / PostgreSQL (Relational Database)
* **Architecture:** MVC (Model-View-Controller)
* **Package Manager:** Composer (PHP) & NPM (Node.js)

## 3. Core Entities & Database Relationships
To help the AI agent understand the data flow, here is the core architecture:

1. **Tenants (Clinics):**
   * The core of the SaaS. Every other entity (except super-admin data) belongs to a specific tenant.
   * *Relationships:* Has many Users, Patients, Appointments, Invoices.

2. **Users (Staff/Roles):**
   * Belongs to a Tenant.
   * Roles include: `Clinic Admin`, `Doctor`, `Secretary`.
   * *Relationships:* A Doctor has many Appointments.

3. **Patients:**
   * Belongs to a Tenant.
   * *Relationships:* Has many Appointments, Medical Records, Invoices.

4. **Appointments:**
   * Belongs to a Tenant, a Doctor (User), and a Patient.
   * Tracks scheduling, time slots, and status (Pending, Completed, Cancelled).

5. **Medical Records:**
   * Belongs to a Patient and a Doctor.
   * Contains diagnoses, symptoms, and prescriptions.

6. **Invoices & Billing:**
   * Belongs to a Patient and a Tenant.
   * Tracks payments for consultations or treatments.

## 4. Directory Structure Context
Based on the standard Laravel structure present in this repository:
* `app/Models/`: Eloquent Models defining relationships and scopes.
* `app/Http/Controllers/`: Logic for handling requests.
* `database/migrations/`: Schema definitions.
* `routes/web.php`: Application routes.
* `resources/views/`: Blade templates for the frontend UI.

---

## 5. 🤖 SYSTEM INSTRUCTIONS FOR JULES (AI AGENT)
**IMPORTANT:** Jules, when assisting with this project, you MUST strictly adhere to the following rules:

1. **Role Context:** Act as an expert, Senior Laravel Developer building a scalable multi-tenant SaaS application.
2. **Coding Standards:** 
   * Strictly follow standard Laravel conventions and PSR-12 coding standards.
   * Use clean, readable, and well-commented code.
3. **Multi-Tenancy Rule:** 
   * NEVER forget data isolation. Every query, model, and controller must account for the current Tenant. Use Laravel Global Scopes or a multi-tenancy package (like `stancl/tenancy` or single-database tenant_id columns) to ensure users can only access their clinic's data.
4. **Development Workflow:** When asked to create a new feature, always provide the complete set of required files:
   * Database Migration (with proper foreign keys).
   * Eloquent Model (with fillables, casts, and relationships).
   * Controller (using RESTful resource methods).
   * FormRequest (for strict validation rules).
   * Blade View or API Resource (depending on the requested frontend approach).
5. **Security First:** 
   * Always validate inputs using Laravel Form Requests.
   * Never trust user input.
   * Protect routes using appropriate middleware (Auth, Role-based, Tenant-aware).
6. **Step-by-Step Execution:** Do not write the entire application in one go. Break down tasks logically, explain what you are about to do, write the code, and instruct the user on which Artisan commands to run (e.g., `php artisan migrate`).
7. **System Name & Localization:** The system is named "Atlas". The entire SaaS application dashboard MUST be in Arabic with Right-to-Left (RTL) UI support. 
8. **Marketing Page:** The project includes a public-facing marketing landing page for the SaaS.
9. **Features Blueprint:** Refer to the `FEATURES.md` file for the exact business logic and feature requirements before creating database schemas.

I am ready. Let's build this SaaS!
