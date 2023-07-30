<?php 
    include("connect.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa | Registration</title>
<style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    }
</style>
</head>
<body>
    
    <div>
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
        <div>
            <!-- signing in -->
            <div>
                <h1>Register</h1>
                <form action="registration_1.php" method="post">
                    <div class="form">
                        <input type="text" name="fname" id="fname" required>
                        <label for="fname">First name *</label> 
                    </div>
                    <div class="form">
                        <input type="text" name="lname" id="lname" required>                
                        <label for="lname">Last name *</label>
                    </div>
                    <div class="form">
                        <input type="email" name="email" id="email" required>
                        <label for="email">Email *</label>
                    </div>
                    <div class="form">
                        <input type="text" name="pnum" id="pnum" required>
                        <label for="pnum">Phone number *</label>
                    </div>
                    <div class="form">
                        <input type="password" name="pass" id="pass" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                        <label for="pass">Password *</label>
                    </div>
                    <div class="form">
                        <input type="password" name="con_pass" id="con_pass" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                        <label for="con_pass">Confirm Password</label>
                    </div>
                    <div class="form_terms_conditions">
                        <input type="checkbox" name="terms_conditions" id="terms_conditions" value="I agree" required>
                        <label for="terms_conditions">I accept the <b><a href="#" id="terms_condi_link">Terms and Conditions</a></b></label>
                    </div>
                    <div class="form_privacy_policy">
                        <input type="checkbox" name="privacy_policy" id="privacy_policy" value="I agree" required>
                        <label for="privacy_policy">I agree to <b><a href="#" id="privacy_policy_link">Privacy Policy</a></b></label>
                    </div>
                    <input type="submit" value="Register" name="submit">
                </form>
                <p id="dont_have_account">---------- Already have an account? -------------</p>
                <a href="#"><u>Sign in</u></a>
                <p>Visit the nearest health facility in your area</p>
                
                <!-- show password toggle script -->
                <script>
                    const togglePassword = document.querySelector("#togglePassword");
                    const password = document.querySelector("#pass");

                    togglePassword.addEventListener("click", function () {
                        this.classList.toggle("fa-eye-slash");
                        // toggle the type attribute
                        const type = password.getAttribute("type") === "password" ? "text" : "password";
                        password.setAttribute("type", type);
                        
                        // toggle the icon
                    });
                </script>
            </div>
            
            <!-- language -->
            <span>
                <div class="translate" id="google_translate_element"></div>
                <script type="text/javascript">
                        function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,tl',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                            autoDisplay: false,
                            multilanguagePage: true
                        }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
    </div>

</body>
</html>

<?php 
    
    if (isset($_POST["submit"])){

        $_SESSION["fname"] = $_POST['fname'];
        $_SESSION["lname"] = $_POST['lname'];
        $_SESSION["email"] = $_POST['email'];
        $_SESSION["pnum"] = $_POST['pnum'];
        $_SESSION["pass"] = $_POST['pass'];
        $_SESSION["terms_conditions"] = $_POST['terms_conditions'];
        $_SESSION["privacy_policy"] = $_POST['privacy_policy'];          

        $sql_sms = "SELECT user_id FROM users WHERE user_pnum = '".$_SESSION["pnum"]."'";
        $result = mysqli_query($conn,$sql_sms);

        $count = mysqli_num_rows($result);

        if ($count == 1) {
            echo "<script>
                    alert('Your mobile number is already in used, please use another mobile number.');
                    window.location.href='registration_1.php';
                  </script>";
        }else{

            $pnum = $_SESSION["pnum"];
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $ch = curl_init();
            $parameters = array(
                'apikey' => 'c17f81a2eb07d0ad839118cad67d2c55', //Your API KEY
                'number' => $pnum,
                'message' => 'Welcome to SiPa! Use this key for confirmation: ' . $verification_code,
                'sendername' => 'SiPa'
            );
            curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
            curl_setopt( $ch, CURLOPT_POST, 1 );

            //Send the parameters set above with the request
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

            // Receive response from server
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            curl_close ($ch);


            //Show the server response
            echo $output;
            
            // insert in users table
            $sql = "INSERT INTO verification_codes(user_pnum, verification_code, pnum_verified_at) VALUES ('" . $_SESSION["pnum"] . "', '" . $verification_code . "', NULL)";
            mysqli_query($conn, $sql);
            
            echo "<script>
                            window.location.href='registration_2_verification.php';
                        </script>";
        }
    }
?>
