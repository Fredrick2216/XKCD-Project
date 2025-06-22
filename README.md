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


📁 **Project Structure**
./
├── src/
│ ├── index.php # Subscription form
│ ├── unsubscribe.php # Unsubscription handler
│ ├── functions.php # Logic for verification, API, email
│ ├── cron.php # CRON-triggered comic sender
│ ├── setup_cron.sh # CRON job setup script
│ ├── registered_emails.txt # Stores registered emails
│ └── email_log.txt # Simulated sent email log

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

---

## 🚀 Getting Started

### 🔧 Prerequisites

- PHP 8.3+  
- Web server (Apache/Nginx or PHP built-in)  
- CRON (Linux/MacOS)
 
⏲️ Setup CRON Job

cd src/
chmod +x setup_cron.sh
./setup_cron.sh 

💡 Future Enhancements
🧠 AI Comic Recommendation
Learn user preferences (thumbs up/down) and personalize delivery.

📚 ExplainXKCD Integration
Hover or link explanations for complex comics.

📲 Multi-Platform Delivery
Support WhatsApp, Telegram, or push notifications.

🛠️ Custom Comic Creator
Drag-and-drop XKCD panel tool to make your own comic story.

🔍 Advanced Search
Search by title, keywords, topic, or sentiment in the XKCD archive.
