🎓 Student Attendance Management System

A simple web-based application built with PHP and MySQL that lets an administrator manage students and record daily attendance, with a dashboard and reports.


✨ Features

🔐 Admin Login / Logout – session-based authentication
📊 Dashboard – shows total students and total attendance records
➕ Add Students – name, roll number and course
📋 View Students – list of all registered students
✏️ Edit / Delete Students – update or remove student records
✅ Mark Attendance – record Present / Absent by student name and date
📑 Attendance Report – view all attendance records in a table


🛠️ Tech Stack

Layer	      Technology
Frontend	  HTML5, CSS3
Backend	    PHP
Database	  MySQL (MySQLi)
Server	    Apache (XAMPP / WAMP)


📁 Project Structure

attendance-system/
├── index.php              # Landing page
├── login.php              # Admin login
├── logout.php             # Ends session
├── dashboard.php          # Admin dashboard
├── students.php           # Add student
├── report.php             # View / manage students
├── edit.php               # Edit student
├── delete.php             # Delete student
├── attendance.php         # Mark attendance
├── attendance_report.php  # Attendance records
├── db.php                 # Database connection
└── style.css              # Styling


🔑 Usage

Go to the home page and click Login.
Sign in with your admin credentials.
From the Dashboard, you can:
Add a student
View, edit or delete students
Mark attendance
View the attendance report
Click Logout when finished.


🔮 Future Improvements

Use prepared statements (PDO / MySQLi) to prevent SQL injection
Hash passwords with password_hash() / password_verify()
Escape output with htmlspecialchars() to prevent XSS
Protect all pages (students, attendance, edit, delete) with session checks
Link attendance to students by student_id (foreign key) instead of name
Filter reports by date, student or course
Export reports to PDF / Excel
Student login and attendance percentage view


📄 License

This project is for educational purposes. Feel free to use and modify it.


👩‍💻 Author

Kajal Baraiya
Aspiring Software Developer

GitHub: @kajalbaraiya
