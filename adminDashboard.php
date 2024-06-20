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

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
            }

            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                padding: 40px 20px;
            }

            .box {
                background: rgba(225, 225, 225, 0.3);
                border: 1px solid #fff;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                padding: 30px 40px;
                text-align: center;
                width: 300px;
                margin: 20px;
                transition: transform 0.3s ease;
            }

            .box:hover {
                transform: translateY(-5px);
            }

            .box h2 {
                font-size: 24px;
                margin-bottom: 10px;
                color: #333;
            }

            .box p {
                font-size: 36px;
                font-weight: bold;
                color: #555;
            }

            .school-year {
                background-color: #007bff;
                color: #fff;
                padding: 20px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                margin: 40px 0;
                animation: fadeIn 0.5s ease;
            }

            h1 {
                font-size: 40px;
                line-height: 64px;
                color: #222;
                text-align: center;
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
                    <li><a class="active" href="adminDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="adminStudentList.php"><i class="fa-solid fa-user"></i>Student List</a></li>
                    <li><a href="adminFailedStudents.php"><i class="fa-solid fa-user"></i>Failed Enrollments</a></li>
                    <li><a href="adminFailedExam.php"><i class="fa-solid fa-user"></i>Failed Entrance Exams</a></li>
                    <li><a href="adminTeacherList.php"><i class="fa-solid fa-chalkboard-user"></i>Teachers</a></li>
                    <li><a href="adminEnrollment.php"><i class="fa-solid fa-file"></i>Enrollment</a></li>
                    <li><a href="adminSectionList.php"><i class="fa-solid fa-list"></i>Section List</a></li>
                    <li><a href="adminStudentApproval.php"><i class="fa-solid fa-circle-check"></i>Student Approval</a></li>
                    <li><a href="adminTeacherApproval.php"><i class="fa-solid fa-circle-check"></i>Teacher Approval</a></li>
                    <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                    <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
                </ul>
                <div id="screenSize" style="margin-bottom: 22px;">
                    <i id="bar" class="fas fa-outdent"></i>
                </div>
            </div>
        </section>

        <section>
            <!-- Automatic set of school year -->
            <?php
            function getSchoolYear() {
                $currentYear = date("Y");
                $currentMonth = date("m");

                if ($currentMonth >= 8) {   // Assuming the school year starts in August
                    $startYear = $currentYear;
                    $endYear = $currentYear + 1;
                } else {
                    $startYear = $currentYear - 1;
                    $endYear = $currentYear;
                }

                return "$startYear - $endYear";
            }

            $schoolYear = getSchoolYear();
            ?>

            <h1 style="margin-top: 50px;">School Year: <?php echo $schoolYear; ?></h1>

            <div class="container">
                <?php
                    $query = "SELECT COUNT(TEACH_ID) AS NUM_TEACH FROM TEACHER WHERE TEACH_APPROVAL = 'Approved';";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                    <h2>Teachers</h2>
                    <p><?php echo $row['num_teach']; ?></p>
                </div>

                <?php
                    $query = "SELECT COUNT(EN_ID) AS NUM_EN FROM ENROLLMENT WHERE EN_APPROVAL = 'Approved';";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                    <h2>Enrolled Students</h2>
                    <p><?php echo $row['num_en']; ?></p>
                </div>

                <?php
                    $query = "SELECT COUNT(STUD_ID) AS NUM_STUD FROM STUDENT";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                    <h2>Students</h2>
                    <p><?php echo $row['num_stud']; ?></p>
                </div>
            </div>
        </section>

        <footer class="section-p1" style="background-color:antiquewhite; margin-top: 140px;">
            <div class="copyright">
                <img src="images/logo.png" class="logo footerLogo" alt="" />
                <p>Copyright © 2024</p>
            </div>
        </footer>

        <script type="text/javascript" src="admin.js"></script>
    </body>
</html>