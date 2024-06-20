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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/adminDashboard.css">
        <link rel="icon" type="image/x-icon" href="images/Icon.png">
        <title>ManSci | Edit Student</title>

        <style>
            .container {
                max-width: 1250px;
                margin: 0 auto;
                padding: 20px;
            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="date"],
            input[type="number"],
            input[type="tel"],
            input[type="email"],
            input[type="password"],
            select,
            textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #fff;
                border-radius: 4px;
                font-size: 16px;
                background: rgba(225, 225, 225, 0.3);
            }

            textarea {
                height: 120px;
                background: rgba(225, 225, 225, 0.3);
            }

            .save-btn {
                display: block;
                margin: 0 auto;
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .save-btn:hover {
                background-color: #45a049;
            }

            .btn {
                display: inline-block;
                font-weight: 400;
                color: #212529;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: transparent;
                border: 1px solid transparent;
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: 0.25rem;
                transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .btn-secondary {
                color: #fff;
                background-color: #6c757d;
                border-color: #6c757d;
            }

            .btn-secondary:hover {
                color: #fff;
                background-color: #5a6268;
                border-color: #545b62;
            }

            .mb-3 {
                margin-bottom: 1rem !important;
            }

            select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 0.5rem center;
                background-size: 1.5em 1.5em;
                padding-right: 2rem;
            }

            .form-row {
                display: flex;
                justify-content: space-between;
                gap: 10px;
            }

            .form-row .form-group {
                flex: 1;
            }

            .btnEdit {
                background-color: grey;
                border-radius: 10px;
                color: white;
                border: none;
                font-size: 20px;
                margin: 4px 2px;
                transition-duration: 0.4s;
                cursor: pointer;
                width: 100px;
                height: 50px;
            }
                
            .btnEdit:hover {
                background-color: green;
                color: white;
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

        <section>
            <div class="container">
                <h2>Student Information</h2>
                <a href="adminStudentList.php" class="btn btn-secondary mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <form id="student-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h4><b>STUDENT INFORMATION</b></h4>
                    <?php
                        $id = $_SESSION['stud_id'];
                        $query = "SELECT * FROM STUDENT, ENROLLMENT WHERE STUDENT.STUD_ID = ENROLLMENT.STUD_ID AND STUDENT.STUD_ID = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$id]);

                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($result){
                            foreach($result as $row)
                            {
                                $_SESSION['stud_id'] = $row['stud_id'];
                                $_SESSION['status'] = $row['stud_status'];
                                $_SESSION['gr'] = $row['stud_grade_level'];
                                ?>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="fname">First Name:</label>
                                            <input type="text" id="fname" name="fname" value="<?= $row['stud_fname'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="lname">Last Name:</label>
                                            <input type="text" id="lname" name="lname" value="<?= $row['stud_lname'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="mname">Middle Name:</label>
                                            <input type="text" id="mname" name="mname" value="<?= $row['stud_initial'];?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="dob">Birthdate:</label>
                                            <input type="date" id="dob" name="dob" value="<?= $row['stud_bdate'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender:</label>
                                            <select id="gender" name="gender" disabled>
                                                <option value="">Select Gender</option>
                                                <option value="Male" <?php if($row['stud_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                                <option value="Female" <?php if($row['stud_gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                                <option value="LGBTQ+" <?php if($row['stud_gender'] == 'LGBTQ+') echo 'selected'; ?>>LGBTQ+</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="pnumber">Phone Number:</label>
                                            <input type="tel" id="pnumber" name="pnumber" value="<?= $row['stud_pnumber'];?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="pob">Place of Birth:</label>
                                            <input type="text" id="pob" name="pob" value="<?= $row['stud_pob'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="lrn">LRN:</label>
                                            <input type="number" id="lrn" name="lrn" value="<?= $row['stud_lrn'];?>" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <h4><b>ADDRESS</b></h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="house">House Number:</label>
                                            <input type="text" id="house" name="house" value="<?= $row['stud_house_no'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="barangay">Barangay:</label>
                                            <input type="text" id="barangay" name="barangay" value="<?= $row['stud_barangay'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City:</label>
                                            <input type="text" id="city" name="city" value="<?= $row['stud_city'];?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="province">Province:</label>
                                            <input type="text" id="province" name="province" value="<?= $row['stud_province'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip">Zip Code:</label>
                                            <input type="text" id="zip" name="zip" value="<?= $row['stud_zip_code'];?>" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <h4><b>PARENTS</b></h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="motherName">Mother's Name:</label>
                                            <input type="text" id="motherName" name="motherName" value="<?= $row['stud_mothers_name'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="fatherName">Father's Name:</label>
                                            <input type="text" id="fatherName" name="fatherName" value="<?= $row['stud_fathers_name'];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="guardianName">Guardian's Name</label>
                                            <input type="text" id="guardianName" name="guardianName" value="<?= $row['stud_guardians_name'];?>" disabled>
                                        </div>
                                    </div>

                                    <br>
                                    <h4><b>GRADE & SECTION</b></h4>
                                    <div class="form-row">
                                    <div class="form-group">
                                            <label for="grade">Grade Level:</label>
                                            <select id="grade" name="grade">
                                                <option value="7" <?php if($row['stud_grade_level'] == 7) echo 'selected'; ?>>Grade 7</option>
                                                <option value="8" <?php if($row['stud_grade_level'] == 8) echo 'selected'; ?>>Grade 8</option>
                                                <option value="9" <?php if($row['stud_grade_level'] == 9) echo 'selected'; ?>>Grade 9</option>
                                                <option value="10" <?php if($row['stud_grade_level'] == 10) echo 'selected'; ?>>Grade 10</option>
                                                <option value="11" <?php if($row['stud_grade_level'] == 11) echo 'selected'; ?>>Grade 11</option>
                                                <option value="12" <?php if($row['stud_grade_level'] == 12) echo 'selected'; ?>>Grade 12</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="section">Section:</label>
                                            <select id="section" name="section">
                                                <option value="null" <?php if(is_null($row['sec_code'])) echo 'selected'; ?>>Select Section</option>
                                                <option value="7A" data-grade="7" <?php if($row['sec_code'] == '7A') echo 'selected'; ?>>7A</option>
                                                <option value="7B" data-grade="7" <?php if($row['sec_code'] == '7B') echo 'selected'; ?>>7B</option>
                                                <option value="8A" data-grade="8" <?php if($row['sec_code'] == '8A') echo 'selected'; ?>>8A</option>
                                                <option value="8B" data-grade="8" <?php if($row['sec_code'] == '8B') echo 'selected'; ?>>8B</option>
                                                <option value="9A" data-grade="9" <?php if($row['sec_code'] == '9A') echo 'selected'; ?>>9A</option>
                                                <option value="9B" data-grade="9" <?php if($row['sec_code'] == '9B') echo 'selected'; ?>>9B</option>
                                                <option value="10A" data-grade="10" <?php if($row['sec_code'] == '10A') echo 'selected'; ?>>10A</option>
                                                <option value="10B" data-grade="10" <?php if($row['sec_code'] == '10B') echo 'selected'; ?>>10B</option>
                                                <option value="11A" data-grade="11" <?php if($row['sec_code'] == '11A') echo 'selected'; ?>>11A</option>
                                                <option value="11B" data-grade="11" <?php if($row['sec_code'] == '11B') echo 'selected'; ?>>11B</option>
                                                <option value="12A" data-grade="12" <?php if($row['sec_code'] == '12A') echo 'selected'; ?>>12A</option>
                                                <option value="12B" data-grade="12" <?php if($row['sec_code'] == '12B') echo 'selected'; ?>>12B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="submit" id="btnsbmt" name="btnsbmt" class="btnEdit" value="Save">
                                <?php
                            }
                        } 
                        else {
                            ?>
                            <P>No Record Found</P>
                            <?php
                        }
                    ?>
                </form>
            </div>
        </section>

        <footer class="section-p1" style="background-color:antiquewhite;">
            <div class="copyright">
                <img src="images/logo.png" class="logo footerLogo" alt="" />
                <p>Copyright © 2024</p>
            </div>
        </footer>

        <script type="text/javascript" src="admin.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const gradeSelect = document.getElementById('grade');
                const sectionSelect = document.getElementById('section');
                const sectionOptions = Array.from(sectionSelect.options);

                gradeSelect.addEventListener('change', function() {
                    const selectedGrade = this.value;
                    
                    // Clear current section options
                    sectionSelect.innerHTML = '';

                    // Filter and add the corresponding sections
                    const filteredOptions = sectionOptions.filter(option => option.getAttribute('data-grade') === selectedGrade || option.value === 'null');
                    
                    filteredOptions.forEach(option => sectionSelect.appendChild(option));
                });

                // Trigger the change event on page load to set the correct options if a grade is already selected
                gradeSelect.dispatchEvent(new Event('change'));
            });
        </script>

    </body>
</html>

<?php

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $id = $_SESSION['stud_id'];
        $stat = $_SESSION['status'];
        $gr = $_SESSION['gr'];
        $grade = $_POST['grade'];
        $code = $_POST['section'];
        $status = 'Old';

        if($grade == $gr && ($stat == 'New' || $stat == 'Old')) {
            try {

                $query = "UPDATE STUDENT SET STUD_GRADE_LEVEL = :GRADE WHERE STUD_ID = :ID;";
                $stmt = $pdo->prepare($query);
        
                // Bind parameters
                $stmt->bindParam(":GRADE", $grade);
                $stmt->bindParam(":ID", $id);
    
                $stmt->execute([$grade, $id]);
    
                $stmt = null;

                $query = "UPDATE ENROLLMENT SET SEC_CODE = :CODE WHERE STUD_ID = :ID;";
                $stmt = $pdo->prepare($query);
        
                // Bind parameters
                $stmt->bindParam(":CODE", $code);
                $stmt->bindParam(":ID", $id);

                $stmt->execute([$code, $id]);
    
                echo "\<script type='text/javascript'> ";
                    echo "window.location.href='adminStudentList.php';";
                echo "</script>";
    
                die();
            }catch (PDOException $e){
                die("Update Failed! " . $e->getMessage());
            }
        }
        else {
            try {

                $query = "UPDATE STUDENT SET STUD_GRADE_LEVEL = :GRADE, STUD_STATUS = :SSTATUS WHERE STUD_ID = :ID;";
                $stmt = $pdo->prepare($query);
        
                // Bind parameters
                $stmt->bindParam(":GRADE", $grade);
                $stmt->bindParam(":SSTATUS", $status);
                $stmt->bindParam(":ID", $id);
    
                $stmt->execute([$grade, $status, $id]);
    
                $stmt = null;

                $query = "UPDATE ENROLLMENT SET EN_APPROVAL = 'In Progress' WHERE STUD_ID = :ID;";
                $stmt = $pdo->prepare($query);
        
                // Bind parameters
                $stmt->bindParam(":ID", $id);

                $stmt->execute([$id]);
    
                echo "\<script type='text/javascript'> ";
                    echo "window.location.href='adminStudentList.php';";
                echo "</script>";
    
                die();
            }catch (PDOException $e){
                die("Update Failed! " . $e->getMessage());
            }
        }
    }
?>