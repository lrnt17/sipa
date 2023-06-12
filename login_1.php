<?php include("connect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | SiPa</title>
</head>
<body>

    <!-- parent div -->
    <div>
        <!-- 1st child div -->
        <div>
            <img src="" alt=""><!-- background photo-->
            <img src="" alt=""><!-- logo -->
            <div><!-- texts -->
                <p>Welcome back to</p>
                <h2>SiPa Siguradong Pagpipilian</h2>
                <p>Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div>
            <!-- signing in -->
            <div>
                <h1>Sign in</h1>
                <form action="login_2_successfull.php" method="post">
                    <div class="form">
                        <input type="text" name="code" id="code" required>
                        <label for="code">Access Code</label>
                    </div>
                    <div class="form">
                        <input type="password" name="pass" id="pass" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                        <label for="pass">Password</label>
                    </div>
                    <input type="submit" value="Sign in" name="login">
                    <input type="checkbox" name="" id="">Keep me logged in
                    <a href="forgotpass_1.php" id="forgotpass">Forgot password?</a>
                </form>
                <p id="dont_have_account">---------- Don't have an account? -------------</p>
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
