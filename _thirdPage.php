<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/loginPage.css">
        <link rel="icon" type="image/x-icon" href="images/Icon.png">
        <title>ManSci</title>
    </head>

    <body class="gradientBg">
        <div class="container mt-5 gradientBg parentBox">
            <div class="row align-items-start">
                <div class="col-sm-6 text-center childBox1">
                    <img class="logo m-3" src="images/logo.png" alt="ManSci Logo" title="Manschi Logo"/>
                </div>

                <div class="col-sm-6 childBox2">
                    <div class="divCenter">
                        <h2 class="loginText"><b>Grade Level</b></h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="submit" id="btnGrlvl" name="btnGrlvl" class="btnclck button1" value="7">
                            <h2>or</h2>
                            <input type="submit" id="btnGrlvl" name="btnGrlvl" class="btnclck button1" value="11">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    </body>
</html>

<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gradel = $_POST['btnGrlvl'];

        $_SESSION['gr'] = $gradel;

        if($gradel == 7) {
            echo "\<script type='text/javascript'> ";
            echo "window.location.href='studentSignIn.php';";
            echo "</script>";
        }
        else if ($gradel == 11) {
            echo "\<script type='text/javascript'> ";
            echo "window.location.href='student11SignIn.php';";
            echo "</script>";
        }
    }
?>