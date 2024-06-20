<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $fname = $_POST["firstname"];
        $lname = $_POST["lastname"];
        $mname = $_POST["middlename"];
        $house = $_POST["houseNo"];
        $barangay = $_POST["barangay"];
        $city = $_POST["city"];
        $province = $_POST["province"];
        $zip = $_POST["zipCode"];
        $email = $_POST["email"];
        $dob = $_POST["dob"];
        $phone = $_POST["phoneNumber"];
        $gender = $_POST["gender"];
        $spassword = $_POST["password"];
        $status = "New";
        $grade = $_SESSION['gr'];
        $ad = 1;

        if (strlen($mname) > 1) {
            $error_message = "Middle initial must be exactly one letter.";
        }
        else{
            try {
                require_once "_db.php";
    
                $query = "INSERT INTO STUDENT (STUD_FNAME, STUD_LNAME, STUD_INITIAL, STUD_HOUSE_NO, STUD_BARANGAY, STUD_CITY, STUD_PROVINCE, STUD_ZIP_CODE, STUD_EMAIL, STUD_PASSWORD, STUD_BDATE, STUD_PNUMBER,  STUD_GENDER, STUD_GRADE_LEVEL, STUD_STATUS, ADMIN_ID) 
                VALUES (:FNAME, :LNAME, :MNAME, :HOUSE, :BARANGAY, :CITY, :PROVINCE, :ZIP, :EMAIL, :PW, :DOB, :PHONE, :GENDER, :GRADE, :SSTATUS, :ID);";
    
                $stmt = $pdo->prepare($query);
    
                $stmt->bindParam(":FNAME", $fname);
                $stmt->bindParam(":LNAME", $lname);
                $stmt->bindParam(":MNAME", $mname);
                $stmt->bindParam(":HOUSE", $house);
                $stmt->bindParam(":BARANGAY", $barangay);
                $stmt->bindParam(":CITY", $city);
                $stmt->bindParam(":PROVINCE", $province);
                $stmt->bindParam(":ZIP", $zip);
                $stmt->bindParam(":EMAIL", $email);
                $stmt->bindParam(":PW", $spassword);
                $stmt->bindParam(":DOB", $dob);
                $stmt->bindParam(":PHONE", $phone);
                $stmt->bindParam(":GENDER", $gender);
                $stmt->bindParam(":GRADE", $grade);
                $stmt->bindParam(":SSTATUS", $status);
                $stmt->bindParam(":ID", $ad);
    
                $stmt->execute([$fname, $lname, $mname, $house,  $barangay, $city, $province, $zip, $email, $spassword, $dob, $phone, $gender, $grade, $status, $ad]);
    
                $pdo = null;
                $stmt = null;
    
                echo "\<script type='text/javascript'> ";
                    echo "window.location.href='studentSignIn.php';";
                echo "</script>";
    
                die();
            }catch (PDOException $e){
                $error_message = $e->getMessage();
                if (strpos($error_message, 'Email already exists.') !== false)
                    $error_message = "Email Already Exists!";
                else if (strpos($error_message, 'Student already exists.') !== false)
                    $error_message = "Student Already Exists!";
                else
                    $error_message = "Account Creation Failed!";
            }
        }
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
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
          rel="stylesheet" />
    <link href="css/signin.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link rel="icon" type="image/x-icon" href="images/Icon.png">
    <title>ManSci | Grade 7 Sign Up</title>
</head>

<body class="gradientBg">

    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                        <div class="col-lg-6 d-flex align-items-center logIn-Bg">
                        </div>
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="images/logo.png" class="logo" alt="logo">
                                        <h4 class="mt-1 pb-1"><b>Mandaue City Science</b></h4>
                                        <h4 class="mb-5 pb-1"><b>High School</b></h4>
                                    </div>

                                    <form id="cusForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <p>Please login to your account</p>
                                        <?php if(isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="firstname" name="firstname" class="form-control" required />
                                            <label class="form-label" for="firstname">First Name</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="lastname" name="lastname" class="form-control" required />
                                            <label class="form-label" for="lastname">Last Name</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="middlename" name="middlename" class="form-control"/>
                                            <label class="form-label" for="middlename">Middle Initial</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="houseNo" name="houseNo" class="form-control" />
                                            <label class="form-label" for="houseNo">House No.</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="barangay" name="barangay" class="form-control" required />
                                            <label class="form-label" for="barangay">Barangay</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="city" name="city" class="form-control" required />
                                            <label class="form-label" for="city">City</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="province" name="province" class="form-control" required />
                                            <label class="form-label" for="province">Province</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="zipCode" name="zipCode" class="form-control" />
                                            <label class="form-label" for="zipCode">Zip Code</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="email" id="email" name="email" class="form-control" required />
                                            <label class="form-label" for="email">Email Adress</label>
                                        </div>

                                        <div class="col-md-6 mb-4 d-flex align-items-center">
                                            <div data-mdb-input-init class="form-outline datepicker w-100">
                                                <input type="date" class="form-control form-control-lg" id="dob" name="dob" placeholder="DD/MM/YYYY" required />
                                                <label for="dob" class="form-label">Birthday</label>
                                            </div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="number" id="phoneNumber" name="phoneNumber" class="form-control form-control-lg" required />
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                        </div>

                                        <div class="d-md-flex justify-content-start align-items-center mb-0 py-4">
                                            <div class="form-check form-check-inline mb-0 me-4">
                                                <label class="mb-0 me-4" for="gender">Gender:</label>
                                                <select id="gender" name="gender" required>
                                                    <option type="radio" value="">Select Gender</option>
                                                    <option type="radio" value="Male">Male</option>
                                                    <option type="radio" value="Female">Female</option>
                                                    <option type="radio" value="LGBTQ+">LGBTQ+</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <input type="password" id="password" name="password" class="form-control" required />
                                            <label class="form-label" for="rpassword">Password</label>
                                        </div>
                                        <div class="text-center pt-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">
                                                <b>Register</b>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <p class="mb-0 me-2">Already have an account?</p>
                                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger gradient-custom-2 btn" onclick="window.location.href='studentSignIn.php'"><b>Sign In</b></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MDB -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>