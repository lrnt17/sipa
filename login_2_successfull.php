<?php 
    include("connect.php");
    $code = $_POST['code'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn,$sql);

    while ($row=mysqli_fetch_assoc($result)) {
        $code_encrypted = $row['access_code'];
        $pass_encrypted = $row['user_password'];
        //$pass_test = $row['pass'];

        if ($code == $code_encrypted && $pass == $pass_encrypted) {
            $_SESSION["code"] = $code;
            $sql1 = "SELECT * FROM users WHERE access_code = '$code' and user_password = '$pass_encrypted'";
            $result1 = mysqli_query($conn,$sql1);
            echo '<script>
                        window.location.href="home_1.php"; 
                    </script>';
        }
    }
    echo '<script>
                alert("Incorrect code or password. Please try again.");
                window.location.href="login_1.php";
            </script>';
?>