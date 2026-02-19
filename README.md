# COP 4331 Spring 2026 Personal Contact Manager

A secure, private contact management web application built on the **LAMP stack**. This project features a REST-style API, AJAX-enabled client-server communication, and a remote MySQL database.

## 🌐 Live Demo
**URL:** [http://cop4331-kn2026.me/](http://cop4331-kn2026.me/)  
*Note: This application is hosted on a remote server as per project requirements.*

---

## 🚀 Features
* **User Authentication:** Secure Registration (Sign up) and Login functionality.
* **Private Contact Management:** Each user manages their own contacts independently; data is never shared between accounts.
* **Server-Side Search:** High-performance search with **partial matching** support.
* **No Client-Side Caching:** All search queries hit the server API directly to ensure data integrity.
* **AJAX-Enabled UI:** Asynchronous API calls provide a seamless user experience without page refreshes.
* **JSON Communication:** All client-server data exchange is handled via JSON.

---

## 🛠️ Tech Stack
* **Operating System:** Linux
* **Web Server:** Apache
* **Database:** MySQL (Remote)
* **Backend:** PHP (REST-style API)
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla AJAX/Fetch)



---

## 🔌 API Documentation
Our application utilizies 6 APIs which follow REST principles.

### Key Endpoints
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/login.php` | Authenticates user credentials and returns a JSON object. |
| `POST` | `/api/register.php` | Creates a new user account. |
| `POST` | `/api/deleteContact.php` | Deletes a contact from user's account. |
| `POST` | `/api/addContact.php` | Creates a new contact for the authenticated user. |
| `POST` | `/api/search.php` | Searches contacts using partial matching (Server-side)
| `POST` | `/api/update.php` | Updates information for an existing contact. |

---

## 📁 Project Structure
```text
├── api/                # PHP REST API Endpoints
│   ├── login.php
│   ├── register.php
│   ├── addContact.php
│   ├── deleteContact.php
│   ├── searchContact.php
│   ├── updateContact.php
├── css/                # Stylesheets
├── js/                 # AJAX logic and UI handling
├── sql/                # Database schema exports
└── index.html          # Landing page
└── contacts.html    # Add or search contacts
└── login.html    # Login page
└── signup.html    # Register page
```
---
## 👥 Team Members
* **API:** Cavan O'Horo, Daniel Efres
* **Database:** Kaden Nash
* **Frontend:** Gregory Berzinski, Joshua Berger
* **Project Manager:** Simone Chrastek

---

## AI Assistance Disclosure
This project was developed with assistance from generative AI tools:
- **Tool**: Gemini 3
- **Dates**: February 13-15, 2026
- **Scope**: Create documentation and describing project for README
- **Use**: Generated initial markdown template, helped provide explanation of tools and tech stack

All AI-generated code was reviewed, tested, and modified to meet
assignment requirements. Final implementation reflects my understanding
of the concepts.
