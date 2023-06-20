<?php include("connect.php"); session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Forgot Password | SiPa</title>
<style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
        top:0!important;
        top:0!important;
        background: linear-gradient(67deg,#70AFED ,#1F6CB5 25%);
        font-family: 'Inter', sans-serif;
	    scroll-behavior: smooth;
        letter-spacing: 1px;
    }

    nav{
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    header {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 5%;
    }

    .nav__links a,
    .cta,
    .overlay__content a {
        font-weight: 400;
        color: #edf0f1;
        text-decoration: none;
    }

    .nav__links {
        list-style: none;
        display: flex;
    }

    .nav__links li {
        padding: 0px 20px;
    }

    .nav__links li a {
        transition: color 0.3s ease 0s;
    }

    .nav__links li a:hover {
        color: #383838;
    }

    .cta {
        padding: 9px 25px;
        background-color: rgba(0, 136, 169, 1);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease 0s;
    }

    .cta:hover {
        background-color: rgba(0, 136, 169, 0.8);
    }

    .menu {
        display: none;
    }

    .overlay {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        background-color: #486ba7;
        overflow-x: hidden;
        transition: width 0.5s ease 0s;
    }

    .overlay--active {
        width: 100%;
    }

    .overlay__content {
        display: flex;
        height: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .overlay a {
        padding: 15px;
        font-size: 36px;
        display: block;
        transition: color 0.3s ease 0s;
    }

    .overlay a:hover,
    .overlay a:focus {
        color: #383838;
    }
    .overlay .close {
        position: absolute;
        top: 20px;
        right: 45px;
        font-size: 60px;
        color: #edf0f1;
    }

    .parent{
        margin: 0;
        padding: 0;
        width: 100%;
        display:flex;
    }
    
    .container{
        width:100%;
    }

    .text{
        padding-left: 70px;
    }

    p{
        white-space: nowrap;
    }

    .header-text{
        font-size: 50px;
        color:#FFFFFF;
        font-weight: 300;
        margin-top: 25px;
    }

    .header-text2{
        font-size: 50px;
        color:#FFFFFF;
        margin-top: -50px;
        font-weight: 400;
    }

    .info-text{
        font-size: 20px;
        color:#FFFFFF;
        margin-top: -40px;
        font-weight: 300;
    }

    .logo{
        height: 65px;
        cursor: pointer;
        padding: 10px 0px 10px;
    }

    .doctor{
        height: 470px;
	    position: absolute;
        bottom: 0;
        padding-left: 270px;
        z-index: -1;
    }

    .forgot_pass{
        width: 450px;
        min-height: 480px;
        background: #F4F7FF;
        border-radius: 40px;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        padding: 20px 40px;
    }

    .container-box{
        position: relative;
        margin: 0 auto;
        right: 0px;
        width:100%;
        float: right;
        padding: 0px 0px 0px 90px;
    }

    .container-box .forgot_pass .form input{
        width: 90%;
        height: 100%;
        border:none;
        border-bottom: 2px solid #B9B9B9;
        padding: 13px 35px;
        font-size: 1rem;
        border-radius: 0px;
        background: transparent;
        outline: none;
        margin-bottom: 20px;
    }

    .container-box .forgot_pass .log-btn{
        display: block;
        width: 100%;
        padding: 13px 20px;
        text-align: center;
        border: none;
        background: #F2C1A7;
        outline: none;
        border-radius: 10px;
        font-size: 1.2rem;
        color: #FFF;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .text-rem{
        font-size: 14px;
        font-weight: 400;
        text-align: left;
        color: #575757;
        width:100%;
        word-wrap: break-word;
        white-space: normal
    }

    .fonticon {
        position: relative;
        }
          
    .fonticon i{
        position: absolute;
        right: 15px;
        top: 40px;
        color: gray;
    }

    .fonticon .fa-solid{
        position: absolute;
        left: 0px;
        top: 37px;
        color: #575757;
    }

    a {
        font-weight: 300;
        text-decoration: none;
        color: #FFFFFF;
        letter-spacing: 1px;
        font-size: 15px;
    }

    .translate {
        float: left;
    }

    .links{
        position: absolute;
        padding-top: 35px;
        width: 80%;
        float: right;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        flex-wrap: nowrap;
    }

    label{
        font-size: 18px;
        color: #575757;
    }

    h1{
        color: #2F2F2F;
        font-weight: 500;
    }

    .a-cancel{
        float: right;
        margin-right: 0px;
        text-decoration: none;
        color: #404AD0;
    }

@media (max-width: 1350px) {

    .overlay a {
        font-size: 20px;
    }
    .overlay .close {
        font-size: 40px;
        top: 15px;
        right: -13px;
    }

    .header-text2{
    font-size: 40px;
    }

    .header-text{
    font-size: 40px;
    }

    .info-text{
        font-size: 15px;
    }

    .doctor{
        padding: 0px 125px ;
    }
}

@media (max-width: 1225px) {

    nav{
        position: relative;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px 32px;
    }

    .menu{
        display:none;
    }

    .nav__links,
    .cta {
        display: none;
    }
    .menu {
        display: initial;
    }

    header {
        margin-top: -20px;
        justify-content: flex-end;
    }

    .header-text2{
        text-align: center;
        font-size: 35px;
        margin-top: -37px;
    }

    .header-text{
        margin-top: 0px;
        text-align: center;
        font-size: 30px;
    }

    .info-text{
        text-align: center;
        font-size: 12px;
        margin-top: -30px;
        padding-right: 0px;
    }

    .container-box{
        height: 75%;
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -32%);
    }

    .doctor{
        display:none;
    }
    .text{
        padding-left: 0px;
    }

    .forgot_pass{
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 390px;
        min-height: auto;
    }

    .container-box .forgot_pass .form input{
        height: 90%;
        padding: 10px 27px;
        font-size: 1rem;
    }

    .container-box .forgot_pass .log-btn{
        width: 100%;
        padding: 10px 17px;
        font-size: 1rem;
    }

    label{
        font-size: 15px;
    }

    h1{
        text-align:center;
        font-size: 25px;
    }

    a {
        font-size: 13px;
        margin-right: 50px;
    }

    .links{
        position: absolute;
        bottom: 0px;
        width: 80%;
    }
}

</style>
</head>
<body>

    <!-- nav bar div -->
    <header>
        <a href="#"><img class="logo" src="logo1.png" alt="logo"></a>
            <nav>
                <ul class="nav__links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Videos</a></li>
                    <li><a href="#">Right for me</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
            </nav>
            <p class="menu cta"><i class="fa-solid fa-bars"></i></p>
    </header>

     <!-- menu div / min-width -->
    <div class="overlay">
        <a class="close">&times;</a>
        <div class="overlay__content">
            <a href="#" >Home</a>
            <a href="#">Videos</a>
            <a href="#">Right for me</a>
            <a href="#">FAQs</a>
            <a href="#">Services</a>
        </div>
    </div>

    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctor.png" alt=""><!-- background photo-->
            <div class = "text"><!-- texts -->
                <p class = "header-text">Welcome back to</p>
                <p class = "header-text2">SiPa Siguradong Pagpipilian</p>
                <p class = "info-text">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <div class="forgot_pass" id="reg_block">
                <h1>Forgot Password?</h1>
                <p class="text-rem" id="sub">Enter your phone number and we will send you a code to reset your password.<br><br>
                You will receive instructions for resetting your password.</p><br><br>
                <form action="forgot_pass_1.php" method="post">
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-solid fa-phone" style="font-size:15px;"></i>
                            <label for="pnum">Phone number</label>
                            <input type="text" name="pnum" id="pnum" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="class_60 log-btn" value="Send code">Login</button>
                    <a href="#.php" id="cancel" class="a-cancel">Cancel</a>
                </form>
            </div>

            <div class="links">
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
            
            <!--<div class="dropdown">
                <form action="#">
                    <label for="cars">Language: </label>
                    <select id="language">
                        <option value="1" selected="selected">English</option>
                        <option value="2">Tagalog</option>
                    </select>
                </form>
            </div>-->
        </div>
    </div>
</body>
</html>

<?php 
    if (isset($_POST["submit"])) {
        $_SESSION["pnum"] = $_POST['pnum'];

    echo "<script>
            window.location.href='forgot_pass_2_send.php';
            </script>";
    }
?>

<!-- open menu in min-width -->
<script>
        const doc = document;
        const menuOpen = doc.querySelector(".menu");
        const menuClose = doc.querySelector(".close");
        const overlay = doc.querySelector(".overlay");

        menuOpen.addEventListener("click", () => {
        overlay.classList.add("overlay--active");
        });

        menuClose.addEventListener("click", () => {
        overlay.classList.remove("overlay--active");
        });
</script>