# Modern To-Do List App

A clean, responsive, and beautifully designed **To-Do List** application built with **PHP** and **HTML5**. Perfect for learning PHP session management, form handling, and modern web UI design.

---

## Features

- **Add Tasks** – Quickly add new tasks with a sleek input form
- **Delete Tasks** – Remove tasks with a single click
- **Session-Based Storage** – Tasks persist during your browser session
- **Responsive Design** – Works seamlessly on desktop, tablet, and mobile
- **Modern UI** – Gradient backgrounds, shadows, hover effects, and smooth transitions
- **Empty State** – Friendly message when no tasks are added
- **Task Counter** – Shows current number of tasks
- **Font Awesome Icons** – Professional icons for actions
- **Google Fonts (Poppins)** – Clean, modern typography

---

## Tech Stack

- **PHP** (7.4 or higher recommended)
- **HTML5**
- **CSS3** (with modern features: flexbox, gradients, transitions)
- **Font Awesome 6** (via CDN)
- **Google Fonts (Poppins)**

---

## Installation

### 1. Prerequisites
- A web server with **PHP** installed (e.g., XAMPP, WAMP, MAMP, or any PHP-enabled host)
- PHP version **7.4 or higher**

### 2. Setup

1. **Download or copy** the `index.php` file from this project.
2. Place it in your web server's root directory:
   - XAMPP: `htdocs/`
   - Or any folder accessible via your local server
3. Start your server (Apache + PHP).
4. Open your browser and go to:
http://localhost/your-folder-name/index.php


> No database required! Uses PHP sessions for temporary storage.

---

## File Structure
todo-app/
├── index.php          ← Main application (PHP + HTML + CSS)
└── README.md          ← This file


---

## How It Works

- Tasks are stored in `$_SESSION['todo_list']`
- Adding a task: `POST` request with `action=add`
- Deleting a task: `POST` request with `action=delete` and task `index`
- Sessions keep data until the browser is closed (or session expires)

> **Note**: Data is **not persistent** across browser restarts. For permanent storage, integrate with a database (MySQL, SQLite) in the future.

---

## Customization

### Change Colors
Edit the CSS variables in the `<style>` block:
```css
:root {
    --primary: #6366f1;     /* Main accent color */
    --danger: #ef4444;      /* Delete button */
}