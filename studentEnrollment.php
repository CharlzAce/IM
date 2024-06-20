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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0d33efc24c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link rel="icon" type="image/x-icon" href="images/Icon.png">
    <title>ManSci | Enrollment Form</title>

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
                <li><a href="studentDashboard.php"><i class="fa-brands fa-microsoft"></i>Dashboard</a></li>
                <li><a class="active" href="studentEnrollment.php"><i class="fa-solid fa-file"></i>Enrollment</a></li>
                <li><a href="studentSubject.php"><i class="fa-solid fa-list"></i>Subject</a></li>
                <li><input type="submit" class="btnclck" value="Sign Out" onclick="window.location.href='_signOut.php'"></li>
                <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
            </ul>
            <div id="screenSize" style="margin-bottom: 22px;">
                <i id="bar" class="fas fa-outdent"></i>
            </div>
        </div>
    </section>
    <section class="container mt-5">
        <h1 class="text-center">Enrollment Form</h1>
        <form id="student-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
                $email = $_SESSION['email'];
                $query = "SELECT * FROM STUDENT WHERE STUD_EMAIL = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$email]);

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($result){
                    foreach($result as $row)
                    {
                        $_SESSION['stud_id'] = $row['stud_id'];
                        $approval = $row['stud_approval'];
                        ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fname">First Name:</label>
                                <input type="text" id="fname" name="fname" value="<?= $row['stud_fname'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name:</label>
                                <input type="text" id="lname" name="lname" value="<?= $row['stud_lname'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mname">Middle Initial:</label>
                                <input type="text" id="mname" name="mname" value="<?= $row['stud_initial'];?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dob">Birthdate:</label>
                                <input type="date" id="dob" name="dob" value="<?= $row['stud_bdate'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if($row['stud_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if($row['stud_gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="LGBTQ+" <?php if($row['stud_gender'] == 'LGBTQ+') echo 'selected'; ?>>LGBTQ+</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pnumber">Phone Number:</label>
                                <input type="tel" id="pnumber" name="pnumber" value="<?= $row['stud_pnumber'];?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pob">Place of Birth:</label>
                                <input type="text" id="pob" name="pob" value="<?= $row['stud_pob'];?>">
                            </div>
                            <div class="form-group">
                                <label for="lrn">LRN:</label>
                                <input type="number" id="lrn" name="lrn" value="<?= $row['stud_lrn'];?>" required>
                            </div>
                        </div>
                        <br>
                        <h4><b>ADDRESS</b></h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="house">House Number:</label>
                                <input type="text" id="house" name="house" value="<?= $row['stud_house_no'];?>">
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay:</label>
                                <input type="text" id="barangay" name="barangay" value="<?= $row['stud_barangay'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" id="city" name="city" value="<?= $row['stud_city'];?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="province">Province:</label>
                                <input type="text" id="province" name="province" value="<?= $row['stud_province'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="zip">Zip Code:</label>
                                <input type="text" id="zip" name="zip" value="<?= $row['stud_zip_code'];?>" required>
                            </div>
                        </div>
                        <br>
                        <h4><b>PARENTS</b></h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="motherName">Mother's Name:</label>
                                <input type="text" id="motherName" name="motherName" value="<?= $row['stud_mothers_name'];?>">
                            </div>
                            <div class="form-group">
                                <label for="fatherName">Father's Name:</label>
                                <input type="text" id="fatherName" name="fatherName" value="<?= $row['stud_fathers_name'];?>">
                            </div>
                            <div class="form-group">
                                <label for="guardianName">Guardian's Name</label>
                                <input type="text" id="guardianName" name="guardianName" value="<?= $row['stud_guardians_name'];?>">
                            </div>
                        </div>
                        <br>
                        <h4><b>GRADE & SECTION</b></h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="grade">Grade Level:</label>
                                <select id="grade" name="grade" required>
                                    <option value="7" <?php if($row['stud_grade_level'] == 7) echo 'selected'; ?>>Grade 7</option>
                                </select>
                            </div>
                        </div>

                        <?php
                            try {
                                $id = $_SESSION['stud_id'];
                                $query = "SELECT * FROM ENROLLMENT WHERE STUD_ID = ?;";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$id]);
        
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if($row) {
                                    $en = $row['en_approval'];
                                }
                                else
                                    $en = null;
                    
                            }catch (PDOException $e){
                                $en = null;
                            }
                        ?>
                        
                        <input type="submit" id="btnsbmt" name="btnsbmt" class="btnEdit" value="Submit" <?php if ($approval == 'Pending' || $en == 'Pending' || $en == 'Approved' || $en == 'Failed') echo 'disabled'; ?>>
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

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
            
        $email2 = $_SESSION['email'];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $mname = $_POST["mname"];
        $dob = $_POST["dob"];
        $phone = $_POST["pnumber"];
        $gender = $_POST["gender"];
        $pob = $_POST["pob"];
        $lrn = $_POST["lrn"];
        $house = $_POST["house"];
        $barangay = $_POST["barangay"];
        $city = $_POST["city"];
        $province = $_POST["province"];
        $zip = $_POST["zip"];
        $mother = $_POST["motherName"];
        $father = $_POST["fatherName"];
        $guardian = $_POST["guardianName"];
        $grade = $_POST["grade"];
        $ad = 1;

        try {
            $query = "UPDATE STUDENT 
            SET STUD_FNAME = :FNAME, STUD_LNAME = :LNAME, STUD_INITIAL = :MNAME, STUD_HOUSE_NO = :HOUSE, STUD_BARANGAY = :BARANGAY, STUD_CITY = :CITY, STUD_PROVINCE = :PROVINCE, STUD_ZIP_CODE = :ZIP, STUD_BDATE = :DOB, STUD_PNUMBER = :PHONE,  STUD_GENDER = :GENDER, STUD_POB = :POB, STUD_LRN = :LRN, STUD_MOTHERS_NAME = :MOTHER, STUD_FATHERS_NAME = :FATHER, STUD_GUARDIANS_NAME = :GUARDIAN, STUD_GRADE_LEVEL = :GRADE, ADMIN_ID = :ID
            WHERE STUD_EMAIL = :EMAIL";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":FNAME", $fname);
            $stmt->bindParam(":LNAME", $lname);
            $stmt->bindParam(":MNAME", $mname);
            $stmt->bindParam(":HOUSE", $house);
            $stmt->bindParam(":BARANGAY", $barangay);
            $stmt->bindParam(":CITY", $city);
            $stmt->bindParam(":PROVINCE", $province);
            $stmt->bindParam(":ZIP", $zip);
            $stmt->bindParam(":DOB", $dob);
            $stmt->bindParam(":PHONE", $phone);
            $stmt->bindParam(":GENDER", $gender);
            $stmt->bindParam(":POB", $pob);
            $stmt->bindParam(":LRN", $lrn);
            $stmt->bindParam(":MOTHER", $mother);
            $stmt->bindParam(":FATHER", $father);
            $stmt->bindParam(":GUARDIAN", $guardian);
            $stmt->bindParam(":GRADE", $grade);
            $stmt->bindParam(":ID", $ad);
            $stmt->bindParam(":EMAIL", $email2);

            $stmt->execute([$fname, $lname, $mname, $house,  $barangay, $city, $province, $zip, $dob, $phone, $gender, $pob, $lrn, $mother, $father, $guardian, $grade, $ad, $email2]);

            $pdo = null;
            $stmt = null;

            echo "\<script type='text/javascript'> ";
                echo "window.location.href='_enrollment.php';";
            echo "</script>";

            die();
        }catch (PDOException $e){
            die("Query failed: ". $e->getMessage());
        }
    }
?>