<?php 
    include("connect.php");
    session_start();
    $pnum=$_SESSION["pnum"];
    $new_pass = password_hash($_POST["con_pass"], PASSWORD_DEFAULT);
    $sql=("UPDATE users set user_password = '$new_pass' where user_pnum = '$pnum'");
    mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="assets/css/form.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Password Changed | SiPa</title>

<style>html{ height: 100%;}
.box{
            width: 350px !important;
            padding:20px 20px !important;
    }
    </style>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="logo-fill.png" alt="logo"></a>
    </header>

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