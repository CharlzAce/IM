<?php
    session_start();
    
    if(!$_SESSION['email']){
        header('location:_frontPage.php');
    }

    require_once '_db.php';

    $sec = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnSection'])) {
        $sec = $_POST['btnSection'];
        $_SESSION['chcSec'] = $sec;
    } else if (isset($_SESSION['chcSec'])) {
        $sec = $_SESSION['chcSec'];
    }
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
        <title>ManSci | Section List</title>

        <style>
            .container {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                padding: 40px 0;
            }

            .section-list-container,
            .student-list-container {
                /* background-color: rgba(248, 249, 250, 0.8); */
                background: rgba(225, 225, 225, 0.3);
                padding: 20px;
                margin: 0 10px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid #fff;
            }

            .section-list-container {
                max-width: 200px;
                text-align: center ;
                flex: 1;
            }

            .student-list-container {
                border: 1px solid #fff;
                max-width: 1000px;
                flex: 2;
                background: rgba(225, 225, 225, 0.3);
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
                margin-bottom: 10px;
                margin-left: 7px;
            }

            .section-btn:hover {
                background-color: #0056b3;
            }

            h2, h3 {
                font-size: 24px;
                color: #333;
                margin-bottom: 1px;
            }
            
            .hFont {
                font-size: 50px;
            }

            h3 {
                display: inline-block;
                margin-right: 40px;
            }

            .student-box {
                background: rgba(225, 225, 225, 0.3);
                border: 1px solid #fff;
                border-radius: 4px;
                padding-left: 10px;
                padding-right: 10px;
                margin-top: 3px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .student-actions {
                display: flex;
                gap: 8px;
            }

            .edit-btn,
            .delete-btn {
                border: none;
                border-radius: 4px;
                padding: 3px 7px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .edit-btn {
                background-color: #28a745;
                color: #fff;
            }

            .delete-btn {
                background-color: #dc3545;
                color: #fff;
            }

            .edit-btn:hover {
                background-color: #218838;
            }

            .delete-btn:hover {
                background-color: #c82333;
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
                    <li><a href="adminDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a class="active" href="adminStudentList.php"><i class="fa-solid fa-user"></i>Student List</a></li>
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
        <br><br>
        <h2 class="hFont" style="margin-left: 320px;">Subjects</h2>
        <section>
        <div class="container">
            <div class="section-list-container">
                <h2>Section</h2>
                <div class="section-list">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="7A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="7B">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="8A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="8B">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="9A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="9B">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="10A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="10B">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="11A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="11B">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="12A">
                        <input type="submit" id="btnSection" name="btnSection" class="section-btn" value="12B">
                    </form>
                </div>
            </div>
            <div class="student-list-container">
                <div class="header-container">
                    <h5>Section: <?= $sec;?></h5>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Time</th>
                <th>Day</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if($sec != null) {
                    $query = "SELECT * FROM SECTION, SUBJECT WHERE SECTION.SEC_CODE = SUBJECT.SEC_CODE AND SUBJECT.SEC_CODE = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$sec]);

                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if($result){
                        foreach($result as $row)
                        {
                            $_SESSION['subT'] = $row['teach_id'];
                            $_SESSION['subcode'] = $row['sub_code'];
                            $uniqueKey = $row['sub_code']; // Unique key for each row
                            ?>
                                <tr>
                                    <td><input type="text" id="subname_<?= $uniqueKey ?>" name="subname[<?= $uniqueKey ?>]" value="<?= $row['sub_name'];?>"></td>
                                    <td><input type="text" id="subtime_<?= $uniqueKey ?>" name="subtime[<?= $uniqueKey ?>]" value="<?= $row['sub_time'];?>"></td>
                                    <td><input type="text" id="subday_<?= $uniqueKey ?>" name="subday[<?= $uniqueKey ?>]" value="<?= $row['sub_day'];?>"></td>
                                    <?php
                                        $sub_t = $_SESSION['subT'];
                                        $query = "SELECT * FROM TEACHER WHERE TEACH_ID = ?;";
                                        $stmt = $pdo->prepare($query);
                                        $stmt->execute([$sub_t]);

                                        $rowTeacher = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if($rowTeacher){
                                            ?>
                                                <td><input type="text" id="teachname_<?= $uniqueKey ?>" name="teachname[<?= $uniqueKey ?>]" value="<?= $rowTeacher['teach_fname'], " ", $rowTeacher['teach_initial'], " ", $rowTeacher['teach_lname'];?>"></td>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <td><input type="text" id="teachname_<?= $uniqueKey ?>" name="teachname[<?= $uniqueKey ?>]" value=""></td> 
                                            <?php
                                        }
                                    ?>
                                </tr>
                            <?php
                        }
                    } 
                    else {
                        ?>
                            <P>No Record Found</P>
                        <?php
                    }
                }
            ?>
        </tbody>
    </table> 
    <button type="submit" class="btn btn-primary">Save</button>
</form> 

            </div>
        </div>
        </section>

        <footer class="section-p1" style="background-color:antiquewhite;">
            <div class="copyright">
                <img src="images/logo.png" class="logo footerLogo" alt="" />
                <p>Copyright © 2024</p>
            </div>
        </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="admin.js"></script>
    </body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['subname'])) {
        foreach ($_POST['subname'] as $subcode => $subname) {
            $subtime = $_POST['subtime'][$subcode];
            $subday = $_POST['subday'][$subcode];
            $teachname = $_POST['teachname'][$subcode];
            $ad_id = 1;

            $query = "SELECT * FROM TEACHER;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result){
                foreach($result as $row) {
                    if(is_null($row['teach_initial'])) {
                        $concat = "{$row['teach_fname']} {$row['teach_lname']}";
                    }
                    else {
                        $concat = "{$row['teach_fname']} {$row['teach_initial']} {$row['teach_lname']}";
                    }

                    if ($teachname == $concat) {
                        $tid = $row['teach_id'];

                        try {
                            $query = "UPDATE SUBJECT SET SUB_NAME = :SNAME, SUB_TIME = :STIME, SUB_DAY = :SDAY, TEACH_ID = :TID, ADMIN_ID = :ADID WHERE SUB_CODE = :CODE;";

                            $stmt = $pdo->prepare($query);

                            $stmt->bindParam(":SNAME", $subname);
                            $stmt->bindParam(":STIME", $subtime);
                            $stmt->bindParam(":SDAY", $subday);
                            $stmt->bindParam(":TID", $tid);
                            $stmt->bindParam(":ADID", $ad_id);
                            $stmt->bindParam(":CODE", $subcode);

                            $stmt->execute();

                        }catch (PDOException $e){
                            die("Query Failed: " .$e->getMessage());
                        }
                    }
                }
            }
        }

        // Redirect after processing
        echo '<script type="text/javascript">';
        echo 'window.location.href="adminSectionList.php";';
        echo '</script>';
    }
?>
