<?php 

    include("connect.php");

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body>
    <div class="parent">
        <!-- 1st child div -->
        <div>
            <img src="" alt=""><!-- background photo-->
            <img src="" alt=""><!-- logo -->
            <div><!-- texts -->
                <p>Welcome back to</p>
                <h2>SiPa</h2>
                <p>Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="child">
            <h1>Create New Password</h1>
            <p>Your password must be different to previous used password.</p>
            <p>Strong password includes numbers, letters, and <br>
                punctuation marks.</p>
            <form action="forgot_pass_5_reset_success.php" method="post" onsubmit="return check(event);">
                <div class="form">
                    <input type="password" name="new_pass" id="new_pass" required>
                    <label for="new_pass">New password</label>
                </div>
                <div class="form">
                    <input type="password" name="con_pass" id="con_pass" required>
                    <label for="con_pass">Confirm new password</label>
                </div>
                <input type="submit" value="Reset Password" name="reset">
            </form>
            
            <!-- language -->
            <span>
                <div class="translate" id="google_translate_element"></div>
                <script type="text/javascript">
                    function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
                </script>
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>
            <!--<div class="dropdown">
                <form action="#">
                    <label for="cars">Language: </label>
                    <select id="language">
                        <option value="1" selected="selected">English</option>
                        <option value="2">Tagalog</option>
                    </select>
                </form>
            </div>-->
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
    </div>
</body>
</html>

<?php 
    }
?>