<?php 

    include("connect.php");
    session_start();
    $_SESSION["pnum"] = $_SESSION["pnum"];

    if (isset($_POST["verify"]))
    {
        $verification_code = $_POST["code"];

        // mark email as verified
        $sql = "UPDATE verification_codes SET pnum_verified_at = NOW() WHERE user_pnum = '" . $_SESSION["pnum"] . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 0)
        {
            echo "<script>
                    alert('Your validation code is invalid. Please try again.');
                    window.location.href='forgot_pass_3_recovery.php';
                </script>";
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/forms_2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Create New Password | SiPa</title>
    <script>
        function check() {
            var newpass = document.getElementById('new_pass').value;
            var conpass = document.getElementById('con_pass').value;

            if (newpass!=conpass) {
                alert("Your password are not match. Please try again.");
                return false;
            }
        }
    </script>
    
        <style>
        .header-text{
        font-size: 35px;
        color:#FFFFFF;
        font-weight: 300;
        margin-top: 25px;
        }

        .header-text2{
            font-size: 35px;
            color:#FFFFFF;
            margin-top: -40px;
            font-weight: 400;
        }
        
         @media (max-width: 1225px) {
        .reset-pass{
        margin: 0;
        position: absolute;
        top: 43%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 303px !important;
        min-height: auto;
        }

        .header-text2{
            text-align: center;
            font-size: 25px !important; 
            margin-top: -23px !important;
        }

        .header-text{
            margin-top: 0px !important;
            text-align: center;
            font-size: 22px !important;
        }

        .info-text{
            display:none;
        }
        
        .links{
            width: 100% !important;
        }
}
@media (max-width: 450px) {
            .header-text2 {
                text-align: center;
                font-size: 23px !important;
                margin-top: -22px !important;
            }
        }
    </style>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="sipa_logo.png" alt="logo"></a>
    </header>

    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctor.png" alt=""><!-- background photo-->
            <div class = "text"><!-- texts -->
                <p class = "header-text">Welcome back to</p>
                <p class = "header-text2">SiPa Siguradong Pagpaplano</p>
                <p class = "info-text">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <div class="reset-pass">
                <h1>Create New Password</h1>
                <p class="text-rem">Your password must be different from previously used password.</p>
                <p class="text-rem">Strong password includes numbers, letters, and punctuation marks.</p><br>
                <form action="forgot_pass_5_reset_success.php" method="post" onsubmit="return check(event);">
                    <div class="form">
                        <div class="fonticon" style="position: relative;">
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                             <i class="fas fa-eye" style="font-size: 15px; cursor: pointer; color: gray; position: absolute; right: 10px; left: auto; top: 50%; transform: translateY(-50%);" id="togglePassword2"></i>
                            <label for="new_pass">New password</label>
                            <input type="password" name="new_pass" id="new_pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one special character, and at least 8 or more characters" required>
                        </div>
                    </div>
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                            <label for="con_pass">Confirm new password</label>
                            <input type="password" name="con_pass" id="con_pass" required>
                            <i class="fas fa-eye" style="font-size: 15px; cursor: pointer; color: gray; position: absolute; right: 10px; left: auto; top: 50%; transform: translateY(-50%);" id="togglePassword3"></i>
                        </div>
                    </div>
                    <button type="submit" name="reset" class="class_60 log-btn">Verify Code</button>
                </form>
            </div>

            
        </div>
    </div>
    <!-- language, privacy policy, terms of use -->
    <div class="lang-box">
        <?php include('languageprivacyterms.php') ?>
    </div>
</body>
    <script>
                    const togglePassword2 = document.querySelector("#togglePassword2");
                    const password2 = document.querySelector("#new_pass");

                    togglePassword2.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password2.getAttribute("type") === "password" ? "text" : "password";
                        password2.setAttribute("type", type);

                        // toggle the icon
                    });
    </script>
    
    <script>
                    const togglePassword3 = document.querySelector("#togglePassword3");
                    const password3 = document.querySelector("#con_pass");

                    togglePassword3.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password3.getAttribute("type") === "password" ? "text" : "password";
                        password3.setAttribute("type", type);

                        // toggle the icon
                    });
    </script>
</html>



<?php 
    }
?>
