<<<<<<< HEAD
<?php 
    include("connect.php");

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
    <title>Password Changed | SiPa</title>
</head>
<body>
    <div id="reg_block">
        <h1>Password changed!</h1>
        <p>Please login to your account again.</p>
        <a href="login_1.php">Login now</a>
    </div>
</body>
=======
<?php 
    include("connect.php");

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
    <title>Password Changed | SiPa</title>
</head>
<body>
    <div id="reg_block">
        <h1>Password changed!</h1>
        <p>Please login to your account again.</p>
        <a href="login_1.php">Login now</a>
    </div>
</body>
>>>>>>> 85a723fa38235a6f59ff026a8c9f7d1ce95f6815
</html>