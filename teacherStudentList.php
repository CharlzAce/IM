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

        .section-list-container,
        .student-list-container {
            background: rgba(225, 225, 225, 0.3);
            padding: 20px;
            margin: 0 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #fff;
        }

        .section-list-container {
            max-width: 250px;
            flex: 1;
        }

        .student-list-container {
            max-width: 1000px;
            flex: 2;
        }

        .section-list {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .section-btn {
            background-color: #5DA9FF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .section-btn:hover {
            background-color: #0056b3;
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

        .student-info {
            display: flex;
            width: 100%;
            justify-content: space-between;
            padding: 10px;
        }

        .student-info p {
            margin: 0;
            flex: 1;
            text-align: left;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 1px;
            margin-left: auto;
        }

        .search-bar input {
            padding: 8px 12px;
            border: 1px solid #fff;
            border-radius: 4px;
            font-size: 14px;
            width: 200px;
            background: rgba(225, 225, 225, 0.3);
        }

        .search-bar button {
            background-color: #5DA9FF;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            margin-left: 8px;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
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
                    <li><a class="active" href="teacherStudentList.php"><i class="fa-solid fa-user"></i>Student List</a></li>
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
        <div class="container"> 
            <div class="student-list-container">
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

                        $query = "SELECT * FROM SECTION WHERE SEC_CODE = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$s_code]);

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if($row){
                            if($row["sec_name"] == "EINSTEIN" || $row["sec_name"] == "NEWTON"){
                                $s_name = "7 - {$row['sec_name']}"; 
                            }
                            else if($row["sec_name"] == "MENDEL" || $row["sec_name"] == "ARCHIMEDES"){
                                $s_name = "8 - {$row['sec_name']}"; 
                            }
                            else if($row["sec_name"] == "PYTHAGORAS" || $row["sec_name"] == "GALILEO"){
                                $s_name = "9 - {$row['sec_name']}"; 
                            }
                            else if($row["sec_name"] == "ARISTOTLE" || $row["sec_name"] == "RASCAL"){
                                $s_name = "10 - {$row['sec_name']}"; 
                            }
                            else if($row["sec_name"] == "KEPLER" || $row["sec_name"] == "CURIE"){
                                $s_name = "11 - {$row['sec_name']}"; 
                            }
                            else if($row["sec_name"] == "RUTHERFORD" || $row["sec_name"] == "DARWIN"){
                                $s_name = "12 - {$row['sec_name']}"; 
                            }
                        }
                        else{
                            $s_name = "No Advisory"; 
                        }

                        ?>
                        <div class="header-container">
                            <h2>Class Advisory: <?= $s_name;?></h2>
                            <div class="search-bar">
                                <input type="text" placeholder="Search students">
                                <button>Search</button>
                            </div>
                        </div>
                        <?php
                        $stmt = null;

                        $query = "SELECT * FROM ENROLLMENT WHERE SEC_CODE = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$s_code]);

                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result){
                            foreach($result as $row){
                                $student = $row['stud_id'];

                                $stmt = null;

                                $query = "SELECT * FROM STUDENT WHERE STUD_ID = ?;";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$student]);
        
                                $stud_row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if($stud_row){
                                ?>
                                    <div class="student-list">
                                        <div class="student-box">
                                            <div class="student-info">
                                                <p><?= $stud_row['stud_fname'], " ", $stud_row['stud_initial'], " ", $stud_row['stud_lname'];?></p>
                                                <p><?= $stud_row['stud_gender'];?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        }
                        else {
                            ?>
                                <P>No Record Found</P>
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