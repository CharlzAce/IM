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
        <title>ManSci | Student Subjects</title>

        <style>
        /* Google Fonts */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

            /* General Styles */
            body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            }

            /* Container Styles */
            .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
            }

            /* Class Load Header Styles */
            .class-load-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            justify-content: space-between;
            align-items: center;
            }

            .class-load-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            }

            .class-load-header .details {
            display: flex;
            gap: 20px;
            font-size: 16px;
            font-weight: 500;
            }

            /* Class Load Table Styles */
            .class-load-table {
            background-color: #fff;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .table-header {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background-color: #f5f5f5;
            font-weight: 600;
            padding: 16px;
            border-bottom: 1px solid #ddd;
            }

            .header-item {
            text-align: center;
            }

            .table-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding: 16px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
            }

            .table-row:hover {
            background-color: #f9f9f9;
            }

            .row-item {
            text-align: center;
            }

            @media (max-width: 767px) {
            .container {
                padding: 20px;
            }

            .class-load-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .class-load-header .details {
                flex-direction: column;
                gap: 5px;
            }

            .table-header,
            .table-row {
                grid-template-columns: repeat(2, 1fr);
                grid-row-gap: 10px;
            }

            .header-item,
            .row-item {
                text-align: left;
            }
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
                    <li><a href="studentDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="studentEnrollment.php"><i class="fa-solid fa-user"></i>Enrollment</a></li>
                    <li><a class="active" href="studentSubject.php"><i class="fa-solid fa-chalkboard-user"></i>Subject</a></li>
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
                <div class="class-load-header">
                    <?php
                        $email = $_SESSION['email'];
                        $query = "SELECT * FROM STUDENT WHERE STUD_EMAIL = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$email]);

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            $stud_gr = $row['stud_grade_level'];
                            $stud_id = $row['stud_id'];

                            $stmt = null;

                            $query = "SELECT * FROM ENROLLMENT WHERE EN_APPROVAL = 'Approved' AND STUD_ID = ?;";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$stud_id]);

                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($row){
                                $s_code = $row['sec_code']; 
                            }
                            else{
                                $s_code = 0; 
                            }

                            $stmt = null;

                            $query = "SELECT * FROM SECTION WHERE SEC_CODE = ?;";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$s_code]);

                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($row){
                                $s_name = $row['sec_name']; 
                            }
                            else{
                                $s_name = "No Section"; 
                            }

                            $stmt = null;

                            $query = "SELECT * FROM TEACHER WHERE SEC_CODE = ?;";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$s_code]);

                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($row){
                                $adviser = "{$row['teach_fname']} {$row['teach_initial']} {$row['teach_lname']}";
                            }
                            else{
                                $adviser = "No Adviser"; 
                            }
                        }

                    ?>
                    <h2>Grade <?= $stud_gr;?>  - <?= $s_name;?></h2><br>
                    <h4>Adviser: <?= $adviser;?></h4>
                </div>
                
                <div class="class-load-table">
                    <div class="table-header">
                    <div class="header-item">Subject</div>
                    <div class="header-item">Time</div>
                    <div class="header-item">Day</div>
                    <div class="header-item">Teacher</div>
                    </div>

                    <?php
                        $query = "SELECT * FROM SUBJECT WHERE SEC_CODE = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$s_code]);
                    
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result){
                            foreach($result as $row){
                                $s_id = $row["teach_id"];
                                ?>
                                    <div class="table-row">
                                        <div class="row-item"><?= $row['sub_name'];?></div>
                                        <div class="row-item"><?= $row['sub_time'];?></div>
                                        <div class="row-item"><?= $row['sub_day'];?></div>
                                        <?php
                                            $query = "SELECT * FROM TEACHER WHERE TEACH_ID = ?;";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->execute([$s_id]);

                                            $rowTeacher = $stmt->fetch(PDO::FETCH_ASSOC);

                                            if($rowTeacher){
                                                $adviser = "{$rowTeacher['teach_fname']} {$rowTeacher['teach_initial']} {$rowTeacher['teach_lname']}";
                                                ?>
                                                    <div class="row-item"><?= $adviser;?></div>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                    <div class="row-item"></div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                <?php
                            }
                        }
                    ?>
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