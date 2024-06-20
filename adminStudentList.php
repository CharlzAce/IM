<?php
    session_start();
    
    if(!$_SESSION['email']){
        header('location:_frontPage.php');
    }

    require_once '_db.php';

    $gr = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnGrlvl'])) {
        $gr = $_POST['btnGrlvl'];
        $_SESSION['chcGr'] = $gr;
    } else if (isset($_SESSION['chcGr'])) {
        $gr = $_SESSION['chcGr'];
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
        <title>ManSci | Student List</title>

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
        <h2 class="hFont" style="margin-left: 320px;">Students List</h2>
        <section>
        <div class="container">
            <div class="section-list-container">
                <h2>Grade Level</h2>
                <div class="section-list">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="7">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="8">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="9">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="10">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="11">
                        <input type="submit" id="btnGrlvl" name="btnGrlvl" class="section-btn" value="12">
                    </form>
                </div>
            </div>
            <div class="student-list-container">
                <div class="header-container">
                    <h5>Grade Level: <?= $gr;?></h5>
                    <div class="search-bar">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="text" id="studSearch" name="studSearch" placeholder="Search Student Lastname">
                            <button>Search</button>
                        </form>
                    </div>
                </div>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['studSearch'])) {
                        $stud_search = $_POST['studSearch'];
                            
                        if($stud_search != null) {
                            $query = "SELECT * FROM STUDENT, ENROLLMENT WHERE STUDENT.STUD_ID = ENROLLMENT.STUD_ID AND EN_APPROVAL = 'Approved' AND STUD_LNAME = ? AND STUD_GRADE_LEVEL = ?;";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$stud_search, $gr]);

                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if($result) {
                                ?>
                                    <h3>Search Result</h3>
                                <?php
                                foreach($result as $row)
                                {
                                    ?>
                                        <div class="student-list">
                                            <div class="student-box">
                                                <p><?= $row['stud_fname'], " ", $row['stud_initial'], " ", $row['stud_lname'];?></p>
                                                <div class="student-actions">
                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                        <button class="edit-btn" id="studEdit" name="studEdit" value="<?= $row['stud_id'];?>" >Edit</button>
                                                        <button type="button" class="btn delete-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" value="<?= $row['stud_id']; ?>" onclick="setDeleteId(<?= $row['stud_id']; ?>)">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }
                            else {
                                ?>
                                    <h3>Search Result</h3>
                                    <P>No Record Found</P>
                                <?php
                            }
                        }
                    }
                ?>
                <?php
                    if($gr != null) {
                        $query = "SELECT * FROM STUDENT, ENROLLMENT WHERE ENROLLMENT.STUD_ID = STUDENT.STUD_ID AND EN_APPROVAL = 'Approved' AND STUD_GRADE_LEVEL = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$gr]);

                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result){
                            ?>
                                <br><h3>Students</h3>
                            <?php
                            foreach($result as $row)
                            {
                                ?>
                                    <div class="student-list">
                                        <div class="student-box">
                                            <p><?= $row['stud_fname'], " ", $row['stud_initial'], " ", $row['stud_lname'];?></p>
                                            <div class="student-actions">
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                    <button class="edit-btn" id="studEdit" name="studEdit" value="<?= $row['stud_id'];?>" >Edit</button>
                                                    <button type="button" class="btn delete-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" value="<?= $row['stud_id']; ?>" onclick="setDeleteId(<?= $row['stud_id']; ?>)">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
            </div>
        </div>
        </section>

        <footer class="section-p1" style="background-color:antiquewhite;">
            <div class="copyright">
                <img src="images/logo.png" class="logo footerLogo" alt="" />
                <p>Copyright © 2024</p>
            </div>
        </footer>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this student account?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" id="studDelete" name="studDelete" value="">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function setDeleteId(id) {
            document.getElementById('studDelete').value = id;
        }
    </script>
    <script type="text/javascript" src="admin.js"></script>
    </body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['studEdit']) || isset($_POST['studDelete']))) {
        $stud_edit = $_POST['studEdit'];
        $stud_delete = $_POST['studDelete'];
    
        if($stud_edit != null) {
            $_SESSION['stud_id'] = $stud_edit;
    
            echo "\<script type='text/javascript'> ";
            echo "window.location.href='adminStudentEdit.php';";  
            echo "</script>";
        }

        if($stud_delete != null) {

            $stmt = $pdo->prepare("DELETE FROM STUDENT WHERE STUD_ID = ?;");
            $stmt->execute([$stud_delete]);

            echo "\<script type='text/javascript'> ";
            echo "window.location.href='adminStudentList.php';";  
            echo "</script>";
        }
    }
?>