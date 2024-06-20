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
        <link rel="stylesheet" href="css/grade7Dashboard.css">
        <link rel="stylesheet" href="css/adminDashboard.css">
        <link rel="icon" type="image/x-icon" href="images/Icon.png">
        <title>ManSci | Grade 11 Dashboard</title>

        <style>
            .grades td.approved {
            color: #4CAF50;
            font-weight: 500;
            }

            .grades td.pending {
            color: #ffba00;
            font-weight: 500;
            }

            .grades td.failed {
            color: red;
            font-weight: 500;
            }

            .grades td.inprogress {
            color: black;
            font-weight: 500;
            }

            .grades td.not {
            color: grey;
            font-weight: 500;
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
                    <li><a class="active" href="student11Dashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="student11Enrollment.php"><i class="fa-solid fa-file"></i>Enrollment</a></li>
                    <li><a href="student11Subject.php"><i class="fa-solid fa-list"></i>Subject</a></li>
                    <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                    <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
                </ul>
                <div id="screenSize" style="margin-bottom: 22px;">
                    <i id="bar" class="fas fa-outdent"></i>
                </div>
            </div>
        </section>
        <div class="margin-center">
            <h2>Grade 11</h2>
        </div>
        <?php
            $email = $_SESSION['email'];
            $query = "SELECT * FROM STUDENT WHERE STUD_EMAIL = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <section>
            <div class="application-table">
                <p>NOTE:</p>
                <p>Please bring your registration form, ballpen and pencil.</p>
                <p>Reminder, only registrants with complete requirements submitted can take the test.</p>
                <p>Requirements: Grades from grade 10 and Good Moral</p>

                <table class="grades">
                    <tr>
                        <th>Application</th>
                        <th>Approval</th>
                    </tr>
                    <tr>
                        <?php
                            $_SESSION['id'] = $row['stud_id'];
                            $_SESSION['ap'] = $row['stud_approval'];
                            if ($row['stud_exam_sched'] != null) {
                                 $date = new DateTime($row['stud_exam_sched']);
                                $formattedDate = $date->format('d/m/Y');
                            }
                            else {
                                $formattedDate = null;
                            }
                        ?>
                        <td>Entrance Exam Date</td>
                        <td><?= $formattedDate ? $formattedDate : "No Exam Date"; ?></td>
                    </tr>
                    <tr>
                        <td>Exam & Interview</td>
                        <?php
                            if (is_null($row['stud_approval'])) {
                                $statusClass = 'inprogress';
                                $statusText = 'In Progress';
                            }
                            else {
                                $sApproval = $row['stud_approval'];

                                if($sApproval === 'Approved') {
                                    $statusClass = 'approved';
                                    $statusText = 'Approved';
                                }
                                else if ($sApproval === 'Pending') {
                                    $statusClass = 'pending';
                                    $statusText = 'Pending';
                                }
                                else if ($sApproval === 'Failed') {
                                    $statusClass = 'failed';
                                    $statusText = 'Failed';
                                }
                                else {
                                    $statusClass = 'inprogress';
                                    $statusText = 'In Progress';
                                }
                            }
                            
                            echo "<td class='{$statusClass}'>{$statusText}</td>";
                        ?>
                    </tr>
                    <tr>
                        <?php
                            try {
                                $id = $_SESSION['id'];
                                $query = "SELECT * FROM ENROLLMENT WHERE STUD_ID = ?;";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$id]);
        
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if($row) {
                                    $_SESSION['en'] = $row['en_approval'];
                                }
                                else
                                    $_SESSION['en'] = null;

                                $pdo = null;
                                $stmt = null;
                    
                            }catch (PDOException $e){
                                $_SESSION['en'] = null;
                            }
                        ?>
                        <td>Grade 11 Enrollment</td>
                        <?php
                            if ($_SESSION['ap'] == 'Pending') {
                                $statusClass = 'not';
                                $statusText = 'Not Applicable';
                            }
                            else {
                                $approval = $_SESSION['en'];

                                if($approval === 'Approved') {
                                    $statusClass = 'approved';
                                    $statusText = 'Approved';
                                }
                                else if ($approval === 'Pending') {
                                    $statusClass = 'pending';
                                    $statusText = 'Pending';
                                }
                                else if ($approval === 'Failed') {
                                    $statusClass = 'failed';
                                    $statusText = 'Failed';
                                }
                                else {
                                    $statusClass = 'inprogress';
                                    $statusText = 'In Progress';
                                }
                            }
                            
                            echo "<td class='{$statusClass}'>{$statusText}</td>";
                        ?>
                    </tr>
                </table> 
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