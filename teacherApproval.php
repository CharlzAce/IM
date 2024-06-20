<?php
    session_start();
    
    if(!$_SESSION['email']){
        header('location:_frontPage.php');
    }

    require_once '_db.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/0d33efc24c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/adminDashboard.css">
        <link rel="icon" type="image/x-icon" href="images/Icon.png">
        <title>ManSci | Admin Dashboard</title>

    <style>
      
      .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 0;
        }

        .subject-list-container,
        .student-list-container {
            background: rgba(225, 225, 225, 0.3);
            padding: 20px;
            margin: 0 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #fff;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
        }

        .approved-btn,
        .failed-btn {
            border: none;
            border-radius: 4px;
            padding: 3px 7px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .approved-btn {
            background-color: #28a745;
            color: #fff;
        }

        .failed-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .approved-btn:hover {
            background-color: #218838;
        }

        .failed-btn:hover {
            background-color: #c82333;
        }

        .student-box {
            background: rgba(225, 225, 225, 0.3);
            border: 1px solid #fff;
            border-radius: 4px;
            padding: 1px;
            margin-bottom: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-actions {
            display: flex;
            gap: 8px;
        }

        .student-list-container {
            border: 1px solid #fff;
            max-width: 1000px;
            flex: 2;
            background: rgba(225, 225, 225, 0.3);
        }
        
        h2, h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 1px;
        }

        h3 {
            display: inline-block;
            margin-right: 40px;
        }
        .subject-list-container {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 20px;
}

.subject-list-container label {
  font-weight: bold;
  margin-bottom: 5px;
}

.subject-list-container select {
  width: 200px;
  padding: 8px 12px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 18px;
}

.subject-list-container select:focus {
  outline: none;
  border-color: #66afe9;
  box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
}
    </style>
    </head>

    <body class="gradientBg">
        <section id="header">
            <div>
                <ul id="navbar2">
                    <li><a href="#"><img src="images/logo.png" class="logo" alt="" /></a></li>
                    <li><h2>ManSci</h2></li>
                </ul>
            </div>

            <div>
                <ul id="navbar">
                    <li><a href="teacherDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="teacherStudentList.php"><i class="fa-solid fa-user"></i>Student List</a></li>
                    <li><a href="teacherClassLoad.php"><i class="fa-solid fa-chalkboard-user"></i>Class Load</a></li>
                    <li><a class="active" href="teacherApproval.php"><i class="fa-solid fa-circle-check"></i>Approval</a></li>
                    <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                    <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
                </ul>
                <div id="screenSize" style="margin-bottom: 22px;">
                    <i id="bar" class="fas fa-outdent"></i>
                </div>
            </div>
        </section>
       
        <section>

        <div class="container">
            <div class="subject-list-container">
            <label for="subject">Subject</label>
                    <select id="section" name="section" required>
                    <option value="">Math</option>
                    <option value="section1">Section 1</option>
                    <option value="section2">Section 2</option>
                    <option value="section3">Section 3</option>
                 </select> 

                 <!-- <label for="subject">Subject</label> -->
                    <select id="section" name="section" required>
                    <option value="">Science</option>
                    <option value="section1">Section 1</option>
                    <option value="section2">Section 2</option>
                    <option value="section3">Section 3</option>
                 </select>      
            </div>

            <div class="student-list-container">
                <div class="header-container">
                    <h3>Section: A</h3>
                    <h3>Subject: Math</h3>
                    
                </div> 
                <div class="student-list">
                    <div class="student-box">
                        <p>John Doe</p>
                        <div class="student-actions">
                        <button class="approved-btn">Approved</button>
                        <button class="failed-btn">Failed</button>
                        </div>
                    </div>
                    <div class="student-box">
                        <p>Jane Smith</p>
                        <div class="student-actions">
                        <button class="approved-btn">Approved</button>
                        <button class="failed-btn">Failed</button>
                        </div>
                    </div>
                    <div class="student-box">
                        <p>Bob Johnson</p>
                        <div class="student-actions">
                        <button class="approved-btn">Approved</button>
                        <button class="failed-btn">Failed</button>
                        </div>
                    </div>
                </div>
            </div>
                    
        </section>

        <footer class="section-p1" style="background-color:antiquewhite;">
            <div class="copyright">
                <img src="images/logo.png" class="logo footerLogo" alt="" />
                <p>Copyright © 2024</p>
            </div>
        </footer>

        <script type="text/javascript" src="admin.js"></script>
    </body>
</html>