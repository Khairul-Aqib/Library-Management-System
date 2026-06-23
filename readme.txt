------------------------------------
Software Required:
------------------------------------
1) XAMPP - to run the Apache server and PHP locally
Link: https://www.apachefriends.org

2) Visual Studio Code (VSC) - to edit the PHP file
Link: https://code.visualstudio.com

3) Web Browser - to access and view the PHP file via localhost (e.g., Chrome, Edge, Firefox)

------------------------------------
Steps to open our project
------------------------------------
Step 1: Install Required Software

- Install XAMPP

- Install Visual Studio Code

- Have a browser ready (Chrome/Edge/Firefox)

--------------------------------------------------------------------------------------------------
Step 2: Extract the Project.zip and move the folder to XAMPP's htdocs Folder

Copy or move it to:
C:\xampp\htdocs\your_project_folder (Default location)

--------------------------------------------------------------------------------------------------
Step 3: Start Apache Server

- Open XAMPP Control Panel

- Click Start next to Apache

--------------------------------------------------------------------------------------------------
Step 4: Start MySQL & Import the Database

- In XAMPP Control Panel, click Start next to MySQL

- Then click the Admin button next to MySQL

- It will open phpMyAdmin in your browser at:
http://localhost/phpmyadmin/

- To Import the Database:
	In phpMyAdmin, click on the "Import" tab

	1) Click "Choose File"

	2) Browse to your project folder and select library_management.sql

	3) Scroll down and click "Go"

	4) The database will be imported (check for success message)
--------------------------------------------------------------------------------------------------
Step 5: Run the PHP File in Browser

- Open your web browser

- Go to:
http://localhost/your_project_folder/!login.php

(Reminder: replace "your_project_folder" with your actual project name)
Example: http://localhost/myapp/!login.php

--------------------------------------------------------------------------------------------------
Tips / Common Issues
- If the file doesn't open, make sure Apache is running in XAMPP

- Don't open .php files directly by double-clicking them - it must be run through a server like localhost
