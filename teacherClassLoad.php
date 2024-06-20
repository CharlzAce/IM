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
            background: rgba(225, 225, 225, 0.3);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            border: 1px solid #fff;
        }
        h1, h2 {
            text-align: left;
            margin-bottom: 0px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: rgba(225, 225, 225, 0.3);
        }
        th, td {
            border: 1px solid #fff;
            padding: 8px;
            text-align: center;
            background: rgba(225, 225, 225, 0.3);
        }
        th {
            background-color: #f4f4f4;
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
                    <li><a class="active" href="teacherClassLoad.php"><i class="fa-solid fa-chalkboard-user"></i>Class Load</a></li>
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

            <h1>School Year: <?php echo $schoolYear; ?></h1>

            <div class="container">
                <?php
                    $email = $_SESSION['email'];
                    $query = "SELECT * FROM TEACHER WHERE TEACH_EMAIL = ?;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$email]);

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row){
                        $t_id = $row['teach_id'];
                        $s_code = $row['sec_code'];

                        $stmt = null;

                        $query = "SELECT * FROM SUBJECT WHERE TEACH_ID = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$t_id]);

                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        ?>
                            <h2>Subjects</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Subject</th>
                                        <th>Time</th>
                                        <th>Day</th>
                                    </tr>
                                </thead>
                        <?php
                        if($result){
                            foreach($result as $row){
                                ?>
                                    <tbody>
                                        <tr>
                                            <?php
                                                $query = "SELECT * FROM SECTION WHERE SEC_CODE = ?;";
                                                $stmt = $pdo->prepare($query);
                                                $stmt->execute([$row['sec_code']]);
                                            
                                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <td><?= $result['sec_name'];?></td>
                                            <td><?= $row['sub_name'];?></td>
                                            <td><?= $row['sub_time'];?></td>
                                            <td><?= $row['sub_day'];?></td>
                                        </tr>
                                    </tbody>
                                <?php
                            }
                        }
                        else {
                            ?>
                            <tr>
                                <td><P>No Record Found</P></td>
                            </tr>
                            <?php
                        }
                        ?>
                            </table>
                        <?php
                    }
                ?>
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