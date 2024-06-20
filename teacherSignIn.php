<?php
    session_start();
    require_once('_db.php');

    function authenticateAdmin($email, $password, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM administrator WHERE admin_email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC); 

        if ($admin && $password == $admin['admin_password']) {
            return true; // Authentication successful
        } 
        else {
            return false; // Authentication failed
        }
    }

    function authenticateTeacher($email, $password, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM TEACHER WHERE TEACH_EMAIL = ? AND TEACH_APPROVAL = 'Approved'");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password == $admin['teach_password']) {
            return true; // Authentication successful
        } 
        else {
            return false; // Authentication failed
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate username and password
        if (!empty($email) && !empty($password)) {
            if($email == 'admin@mansci.com') {
                // Authenticate admin
                if (authenticateAdmin($email, $password, $pdo)) {
                    // Redirect to admin panel or perform desired action
                    $_SESSION['email'] = $email;
                    header("Location: adminDashboard.php");
                    exit();
                } 
                else {
                    $error_message = "Invalid username or password";
                }
            }
            else {
                // Authenticate Customer
                if (authenticateTeacher($email, $password, $pdo)) {
                    // Redirect to Customer Dashboard
                    $_SESSION['email'] = $email;
                    header("Location: teacherDashboard.php");
                    exit();
                } 
                else {
                    $error_message = "Invalid Username or Password";
                }
            }
        } 
        else {
            $error_message = "Username and password are required";
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
        <title>ManSci | Teacher Sign In</title>
    </head>

    <body class="gradientBg">

        <section class="h-100 gradient-form">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4">

                                        <div class="text-center">
                                            <img src="images/logo.png" class="logo" alt="logo">
                                            <h4 class="mt-1 pb-1"><b>Mandaue City Science</b></h4>
                                            <h4 class="mb-5 pb-1"><b>High School</b></h4>
                                        </div>

                                        <form id="cusLog" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <p>Please login to your account</p>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="email" id="email" name="email" class="form-control" required/>
                                                <label class="form-label" for="email">Email Adress</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="password" id="password" name="password" class="form-control" required/>
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <?php if(isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
                                            <div class="text-center pt-1 mb-5 pb-1">
                                                <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">
                                                    <b>Sign In</b>
                                                </button>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-center pb-4">
                                                <p class="mb-0 me-2">Don't have an account?</p>
                                                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn gradient-custom-2 btn" onclick="window.location.href='teacherSignUp.php'"><b>Sign Up</b></button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex align-items-center logIn-Bg">
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