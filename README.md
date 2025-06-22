
# 🚀 XKCD Daily Comic Subscription System

![XKCD Banner](https://imgs.xkcd.com/static/terrible_small_logo.png)

> **Unlocking Daily Laughter and Learning — One Comic at a Time!**

Welcome to the **XKCD Daily Comic Subscription System** – a fun, minimalist platform that delivers the brilliance of [XKCD](https://xkcd.com/) comics directly to your inbox, every single day!

---

## ✨ Features at a Glance

📬 **Email Verification**  
✔️ Secure and simple – ensures only legit subscriptions.

🗓️ **Daily Comic Delivery**  
🖼️ A fresh XKCD comic every 24 hours sent via email.

❌ **Effortless Unsubscription**  
One click, and you're out – no strings attached.

⏰ **Automated CRON Jobs**  
Set-and-forget script that delivers comics daily.

📧 **HTML-Formatted Emails**  
Beautifully crafted, mobile-friendly comic mails.

🗂️ **No Database Needed**  
Emails stored in `registered_emails.txt` — easy and lightweight!

---

## 🛠️ Tech Stack & Architecture

🧠 **Core Technologies**  
- ⚙️ **PHP** – Server-side scripting and logic  
- ⏱️ **CRON** – Automates daily delivery  
- 🤖 **XKCD API** – Fetches latest/random comic data

### Project Structure

The project follows a clear and intuitive directory structure:

```
./
├── src/
│   ├── index.php             # User-facing subscription and verification form
│   ├── unsubscribe.php       # User-facing unsubscription form
│   ├── functions.php         # Core logic: email handling, verification, XKCD fetching
│   ├── cron.php              # Script executed by CRON job for daily comic delivery
│   ├── setup_cron.sh         # Bash script to automate CRON job setup
│   ├── registered_emails.txt # Stores registered email addresses (our "database")
│   └── email_log.txt         # (Simulated) log of sent emails
└── README.md               # You are reading it!
```

## ⚙️ How It Works (Under the Hood)

1. **📨 Subscription & Verification**
   - User submits email via `index.php`
   - 6-digit verification code sent (simulated)
   - Verified emails added to `registered_emails.txt`

2. **🕒 Daily Comic Delivery**
   - `setup_cron.sh` sets CRON job
   - `cron.php` fetches a random XKCD comic
   - Sends HTML-formatted comic via email

3. **🚫 Unsubscription**
   - User visits `unsubscribe.php`
   - Enters email → receives verification code
   - Verified removal from the email list



## 🚀 Getting Started

Follow these simple steps to get your XKCD Daily Comic Subscription System up and running:

### Prerequisites

*   **PHP (version 8.1 or higher recommended):** Ensure PHP is installed on your system.
*   **A Web Server (e.g., Apache, Nginx, or PHP built-in server):** To serve the PHP files.
*   **CRON (usually pre-installed on Linux systems):** For scheduling the daily comic delivery.

### Installation

1.  **Clone the Repository:**
    ```bash
    >git clone https://github.com/Fredrick2216/XKCD-Project.git
    cd C:\Users\Sheeba\OneDrive\Pictures\my-projects\XKCD-Project
    ```

2.  **Configure CRON Job:**
    Navigate to the `src/` directory and run the `setup_cron.sh` script. This script will automatically add the CRON job to your system's crontab.
    ```bash
    cd src/
    chmod +x setup_cron.sh
    ./setup_cron.sh
    ```
    This will schedule `cron.php` to run daily at midnight, sending out the XKCD comics.







