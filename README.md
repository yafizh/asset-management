<p align="center">
  <img src="assets/img/favicon.png" width="100" alt="Logo">
</p>

# Asset Management System (BPTP KALSEL)

## 📌 Introduction
The **Asset Management System** is a web-based application designed to streamline the management of office assets at **BPTP KALSEL** (Balai Pengkajian Teknologi Pertanian Kalimantan Selatan). It serves as a comprehensive solution for tracking asset conditions, managing maintenance schedules, and facilitating the lending and returning process for employees.

## ✨ Key Features

### 👥 User Roles & Permissions
- **Admin**: Full access to system configuration, user management, and master data.
- **Officer (Petugas)**: Manages asset inventory, processes lending requests, and handles maintenance records.
- **Employee (Pegawai)**: Can browse available assets, request borrowing, and view their borrowing history.
- **Head (Pimpinan)**: Access to viewing reports and dashboards for monitoring purposes.

### 📦 Asset Management
- **Inventory Tracking**: Record detailed information about assets, including type, category, and acquisition details.
- **Condition Monitoring**: Track the status of assets as **Good (Baik)**, **Broken (Rusak)**, or **Lost (Hilang)**.
- **Maintenance (Pemeliharaan)**: Schedule and log maintenance activities for assets, ensuring they are kept in good condition.

### 🔄 Lending System
- **Borrowing Requests**: Employees can submit requests to borrow assets with a specified reason and duration.
- **Approval Workflow**: Officers review and approve or reject borrowing requests.
- **Returns**: Track the return of assets, including their condition upon return.

### 📊 Reporting
- Generate printable reports for:
  - Employee Lists
  - Asset Inventory (Acquisitions, Broken, Lost)
  - Borrowing and Return History
  - Maintenance Logs

## 🛠️ Technology Stack
- **Backend**: Native PHP
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (Bootstrap 5, Material Dashboard 2)
- **Scripting**: JavaScript (jQuery, DataTables)
- **Icons**: Nucleo Icons, Font Awesome, Material Icons

## 🚀 Installation & Setup

### Prerequisites
- PHP >= 7.4
- MySQL / MariaDB
- Web Server (Apache/Nginx)

### Steps
1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yourusername/asset-management.git
    cd asset-management
    ```

2.  **Database Configuration**
    - Create a new MySQL database named `manajemen_aset`.
    - Import the database schema. *Note: Refer to `Database Schema.txt` for the table structure.*
    - Configure the database connection in `database/koneksi.php`:
      ```php
      // database/koneksi.php
      $mysqli = new mysqli("localhost", "root", "", "manajemen_aset");
      ```

3.  **Run the Application**
    - **Using XAMPP/WAMP**: Move the project folder to `htdocs` or `www` directory.
    - **Using PHP Built-in Server**:
      ```bash
      php -S localhost:8000
      ```
    - Access the application at `http://localhost/asset-management` (XAMPP) or `http://localhost:8000` (CLI).

## 📂 Project Structure
```
asset-management/
├── assets/          # Static assets (CSS, JS, Images)
├── database/        # Database connection and schema files
├── halaman/         # Page controllers and views
│   ├── aset/        # Asset CRUD
│   ├── laporan/     # Reporting modules
│   ├── pegawai/     # Employee management
│   └── ...
├── helper/          # Helper functions (e.g., date formatting)
├── komponen/        # UI Components (Navbar, Sidebar, Footer)
├── uploads/         # User uploaded files
└── index.php        # Main entry point and routing
```