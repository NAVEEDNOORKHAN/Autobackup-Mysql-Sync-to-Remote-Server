# Autobackup-Mysql-Sync-to-Remote-Server
Perfect ✅
Here’s your **complete `README.md` file** with everything already filled in — just copy and save this as `README.md` in your project:

---

```markdown
# 📦 PHP MySQL Auto Backup Script

A lightweight PHP script to **automatically back up your MySQL database**, **compress it**, **email it as an attachment**, and **archive it** locally.

---

## 📁 Project Structure

```

project-folder/
│
├── index.php        # Main backup script
├── settings.php     # Database connection settings
│
├── backups/         # Temporary backup storage (auto-created)
└── archive/         # Archived backup storage (auto-created)

````

---

## ⚙️ Requirements

- PHP 7.4+  
- `mysqldump` installed and available in your system PATH  
- `mail()` function enabled and configured on your server  

---

## ⚙️ Setup

### 1. Configure Database Credentials

Edit **`settings.php`**:

```php
<?php
$dbHost = 'localhost';
$dbUser = 'database_user';
$dbPassword = 'database_pass';
$dbName = 'database_name';
?>
````

### 2. Configure Email Settings

Open **`index.php`** and update:

```php
$to = 'user@website.com';             // your email address
$headers = "From: username@website.com";  // sender email address
```

---

## ▶️ Usage

### Run Manually

Open the script in a browser:

```
http://yourdomain.com/index.php
```

Or run from the command line:

```bash
php index.php
```

### Run Automatically with Cron (optional)

Add this to your crontab to run daily at 2 AM:

```bash
0 2 * * * php /path/to/project/index.php
```

---

## 📬 What Happens

* Dumps your MySQL database using `mysqldump`
* Compresses the `.sql` file into a `.zip`
* Emails the `.zip` as an attachment
* Moves the `.zip` file to the `archive/` folder for storage

---

## ⚡ Notes

* `backups/` and `archive/` directories will be auto-created if missing
* Ensure PHP has permission to run `system()` commands
* Ensure `mail()` is properly configured and working on your server

---

## 📜 License

This project is licensed under the **MIT License** — feel free to use and modify it.

---

## 💡 Author

**Your Name**
[GitHub Profile](https://github.com/NAVEEDNOORKHAN)

```

---
