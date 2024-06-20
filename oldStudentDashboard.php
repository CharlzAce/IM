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
        <title>ManSci | Old Student Dashboard</title>

      <style>
        /* General Styles */
        body {
          font-family: 'Roboto', sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f5f5f5;
        }

        /* Container Styles */
        .container {
          max-width: 800px;
          margin: 0 auto;
          padding: 20px;
        }

        /* Table Styles */
        table {
          width: 100%;
          border-collapse: collapse;
          border-radius: 8px;
          overflow: hidden;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
          padding: 16px;
          text-align: left;
        }

        /* Student Information Table Styles */
        .student-info {
          background-color: #fff;
          margin-bottom: 20px;
        }

        .student-info th {
          background-color: #4CAF50;
          color: #fff;
          font-weight: 500;
        }

        .student-info td {
          color: #6c757d;
        }

        /* Grades Table Styles */
        .grades {
          background-color: #fff;
        }

        .grades th {
          background-color: #f3f3f3;
          font-weight: 500;
        }

        .grades tr:nth-child(even) {
          background-color: #f9f9f9;
        }

        .grades tr:hover {
          background-color: #f3f3f3;
        }

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

        /* Responsive Styles */
        @media (max-width: 767px) {
          .container {
            padding: 10px;
          }

          table th, table td {
            padding: 12px;
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
                    <li><a class="active" href="oldstudentDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                    <li><a href="oldStudentEnrollment.php"><i class="fa-solid fa-user"></i>Enrollment</a></li>
                    <li><a href="oldStudentSubject.php"><i class="fa-solid fa-chalkboard-user"></i>Subject</a></li>
                    <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                    <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
                </ul>
                <div id="screenSize" style="margin-bottom: 22px;">
                    <i id="bar" class="fas fa-outdent"></i>
                </div>
            </div>
        </section>

        <section>
        <?php
            $email = $_SESSION['email'];
            $query = "SELECT * FROM STUDENT, ENROLLMENT WHERE STUDENT.STUD_ID = ENROLLMENT.STUD_ID AND STUD_EMAIL = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email]);
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="container">
            <table class="student-info">
                <thead>
                    <tr>
                    <th colspan="2">Student Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>LRN:</td>
                    <td><?= $row['stud_lrn'];?></td>
                    </tr>
                    <tr>
                    <td>Student Name:</td>
                    <td><?= $row['stud_fname'], " ", $row['stud_initial'], " ", $row['stud_lname'];?></td>
                    </tr>
                    <tr>
                    <td>Email Address:</td>
                    <td><?= $row['stud_email'];?></td>
                    </tr>
                </tbody>
            </table>

            <table class="grades">
                <thead>
                    <tr>
                    <th>Grade Level</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $currentGrade = $row['stud_grade_level'];
                        $approval = $row['en_approval'];

                        if($currentGrade < 11) {
                          for ($i = 7; $i <= 10; $i++) {
                            if($i < $currentGrade || ($i == $currentGrade && $approval === 'Approved')) {
                                $statusClass = 'approved';
                                $statusText = 'Approved';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'Pending')) {
                                $statusClass = 'pending';
                                $statusText = 'Pending';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'Failed')) {
                                $statusClass = 'failed';
                                $statusText = 'Failed';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'In Progress')) {
                              $statusClass = 'inprogress';
                              $statusText = 'In Progress';
                          }
                            else {
                                $statusClass = 'not';
                                $statusText = 'Not Applicable';
                            }
                            
                            echo "<tr>
                                    <td>{$i}</td>
                                    <td class='{$statusClass}'>{$statusText}</td>
                                </tr>";
                          }
                        }
                        else {
                          for ($i = 11; $i <= 12; $i++) {
                            if($i < $currentGrade || ($i == $currentGrade && $approval === 'Approved')) {
                                $statusClass = 'approved';
                                $statusText = 'Approved';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'Pending')) {
                                $statusClass = 'pending';
                                $statusText = 'Pending';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'Failed')) {
                                $statusClass = 'failed';
                                $statusText = 'Failed';
                            }
                            else if ($i < $currentGrade || ($i == $currentGrade && $approval === 'In Progress')) {
                              $statusClass = 'inprogress';
                              $statusText = 'In Progress';
                          }
                            else {
                                $statusClass = 'not';
                                $statusText = 'Not Applicable';
                            }
                            
                            echo "<tr>
                                    <td>{$i}</td>
                                    <td class='{$statusClass}'>{$statusText}</td>
                                </tr>";
                          }
                        }
                    ?>
                </tbody>
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