<?php 
    include("connect.php");
    require('functions.php'); 
    //session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/forms.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Forgot Password | SiPa</title>
    <script>
        function check() {
            let pnum = document.getElementById('pnum').value;

            if (!/^\d+$/.test(pnum)) {
                alert('Contact number should only contain numbers');
                return false;
            }
        }
    </script>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="logo1.png" alt="logo"></a>
    </header>


    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctor.png" alt="" style="height: 450px;"><!-- background photo-->
            <div class = "text"><!-- texts -->
                <p class = "header-text">Welcome back to</p>
                <p class = "header-text2">SiPa Siguradong Pagpaplano</p>
                <p class = "info-text">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <div class="forgot_pass" id="reg_block">
                <h1>Forgot Password?</h1>
                <p class="text-rem" id="sub">Enter your phone number and we will send you a code to reset your password.<br><br>
                You will receive instructions for resetting your password.</p><br><br>
                <form action="forgot_pass_1.php" method="post" onsubmit="return check(event);">
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-solid fa-phone" style="font-size:15px;"></i> 
                            <label for="pnum">Phone number</label>
                            +63 <input type="text" name="pnum" id="pnum" minlength="10" maxlength="10" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="class_60 log-btn" value="Send code">Send Code</button>
                    <a href="login_1.php" id="cancel" class="a-cancel">Cancel</a>
                </form>
            </div>

            

        </div>
    </div>
    <!-- language, privacy policy, terms of use -->
    <div class="lang-box">
        <?php include('languageprivacyterms.php') ?>
    </div>
</body>
</html>

<?php 
    if (isset($_POST["submit"])) {
        $_SESSION["pnum"] = $_POST['pnum'];

        //echo "<script>alert('goods');</script>";
        //echo "<script>window.location.href='forgot_pass_2_send.php';</script>";
        // Check if contact number already exists
        $contact = $_SESSION["pnum"];
        $checkQuery = "SELECT * FROM users WHERE user_pnum = '$contact'";
        $result = query($checkQuery);

        if($result){
            //echo "<script>alert('Your contact number already exists.');</script>";
            echo "<script>window.location.href='forgot_pass_2_send.php';</script>";
        } else {
            echo "<script>alert('Contact number does not exist.');</script>";
        }
    }
?>

