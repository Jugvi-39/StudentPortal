# Student Portal with Role Management  

A **multi-role web application** that allows students to register, log in, and manage their profiles, while admins can view, search, update, and delete student records.  
The project is designed for **clarity, simplicity, and best practices**, making it ideal for learning or as a starter template.  

---


## 🖥️ Tech Stack  

**Frontend:**  
- HTML5, CSS3 (custom & Bootstrap 5)  
- Font Awesome (icons)  
- Responsive design  

**Backend:**  
- PHP (OOP, PDO for database)  
- MySQL  

**Other Tools:**  
- XAMPP (for local development)  
- Sessions & cookies for authentication  
- Secure password hashing (`MD5` for demo, recommend `bcrypt`/`Argon2` for production)  

---

## 📋 Features  

### 👩‍🎓 Student Features  
- Secure **registration & login**  
- “Remember Me” login with cookies  
- Password hashing  
- **Dashboard**: view & edit profile (modal popup)  
- Change password  
- Secure logout  

### 👨‍💼 Admin Features  
- Admin login (default: `admin/admin`)  
- View all students  
- Search student records  
- Update & delete student records  

### 🎨 UI/UX  
- Modern, responsive design  
- Custom color palette: **dark navy blue, orange, white**  
- Clean navigation & feedback messages  

---

## 🔄 Workflow  

1. **Landing Page**  
   - Welcome page with a quote and two cards: **Students (Get Started)** and **Admin Panel**.  

2. **Student Registration**  
   - Students register with their details.  
   - Input validated on both client & server side.  

3. **Student Login**  
   - Login with ID & password.  
   - “Remember Me” option sets a cookie for auto-login.  

4. **Student Dashboard**  
   - View personal info, edit profile, and change password.  

5. **Admin Login**  
   - Admin logs in using credentials.  

6. **Admin Dashboard**  
   - View, search, update, and delete student records.  

7. **Logout**  
   - Secure logout for both students & admins.  

---


## 🛠️ Setup Instructions  


```bash
# 1. Clone the repository
git clone https://github.com/your-username/Student_Portal.git
cd Student_Portal

# 2. Set up the database
# - Import the provided database.sql into your MySQL server
# - Open private/config/database.php and update it with your DB credentials

# 3. Run locally with XAMPP
# - Place this project folder inside XAMPP htdocs (e.g., C:\xampp\htdocs\Student_Portal)
# - Start Apache and MySQL from the XAMPP Control Panel

# 4. Open in browser
http://localhost/Student_Portal/public/welcome.php

