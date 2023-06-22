<?php 
    include("connect.php");
    session_start();
    $pnum=$_SESSION["pnum"];
    $new_pass = $_POST["con_pass"];
    $sql=("UPDATE users set user_password = '$new_pass' where user_pnum = '$pnum'");
    mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Password Changed | SiPa</title>

<style>
    .skiptranslate iframe  {
    visibility: hidden !important;
    } 

    html{
        height: 100%;
    }

    body{
        top:0!important;
        height: 100%;
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
        font-size: 15px;
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

    .logo{
        height: 65px;
        cursor: pointer;
        padding: 10px 0px 10px;
    }

    .container-box{
        position: relative;
        margin: 0 auto;
        right: 0px;
        width:100%;
        float: right;
        height: 75%;
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .box{
        width: 450px;
        height: 200px;
        background: #F4F7FF;
        border-radius: 40px;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        padding: 20px 40px;
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 390px;
        min-height: auto;
    }

    h1{
        text-align:center;
        color: #2F2F2F;
        font-weight: 500;
        font-size: 28px;
    }

    p{
        text-align:center;
        font-size: 17px;
        color: #575757;

    }

    .log{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 25%;
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
        right: 38px;
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

    <div class="container-box">
        <div class="box">
            <h1>Password changed!</h1><br>
            <p>Please login to your account again.</p>
            <a class="log" href="login_1.php">Login now</a>
        </div>
        
    </div>
</body>
</html>

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