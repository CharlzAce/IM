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
        <title>ManSci | Teacher Dashboard</title>

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
                font-size: 30px;
                line-height: 64px;
                color: #222;
                text-align: center;
            }

            .teacher-info {
                /* border: 1px solid #ddd; */
                padding: 20px;
                border-radius: 5px;
                max-width: 700px;
            }

            .teacher-info h2 {
                margin-top: 0;
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
                    <li><a class="active" href="teacherDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="teacherStudentList.php"><i class="fa-solid fa-user"></i>Student List</a></li>
                    <li><a href="teacherClassLoad.php"><i class="fa-solid fa-chalkboard-user"></i>Class Load</a></li>
                    <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                    <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
                </ul>
                <div id="screenSize" style="margin-bottom: 22px;">
                    <i id="bar" class="fas fa-outdent"></i>
                </div>
            </div>
        </section>

        
        <section>
           <!-- Teachers Info --->
           <?php
                $email = $_SESSION['email'];
                $query = "SELECT * FROM TEACHER WHERE TEACH_EMAIL = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$email]);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row){
                    $section_code = $row['sec_code']; 
                }
            ?>

        <div class="teacher-info">
            <!-- <h2>Teacher Information</h2> -->
            <p><strong>Name: </strong><?= $row['teach_fname'], " ", $row['teach_initial'], " ", $row['teach_lname'];?></p>
            <p><strong>Email: </strong><?= $row['teach_email'];?></p>
            <p><strong>Address: </strong><?= $row['teach_house_no'], ", ", $row['teach_barangay'], ", ", $row['teach_city'], ", ", $row['teach_province'], ", ", $row['teach_zip_code'];?></p>
</div>
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

            <h1>School Year: <?php echo $schoolYear; ?></h1>

            <div class="container">
                <div class="box">
                    <?php
                        $query = "SELECT COUNT(EN_ID) AS NUM_CLASS FROM ENROLLMENT WHERE EN_APPROVAL = 'Approved' AND SEC_CODE = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$section_code]);

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h2>Advisory Class</h2>
                    <p><?php echo $row['num_class']; ?></p>
                </div>
                <div class="box">
                    <?php
                        $query = "SELECT COUNT(EN_ID) AS NUM_EN FROM ENROLLMENT WHERE EN_APPROVAL = 'Approved';";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h2>Enrolled Students</h2>
                    <p><?php echo $row['num_en']; ?></p>
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