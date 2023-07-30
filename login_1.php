<?php 
    include("connect.php");
    //require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Sign in | SiPa</title>
    <style>
        /* The Modal (background) */
        .js-sched-appointment-modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        }

        /* The Close Button */
        .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }

        .block{
            display: block;
        }

        .hide{
            display: none;
        }

        table{
            table-layout: fixed;
        }

        td{
            width: 33%;
        }

        .today{
            color: orange;
        }

        
        .new-dates:hover{
            background-color: purple;
            color: white;
            cursor: pointer;
        }

        .old-dates {
            /* Style for dates that are less than the current date */
            color: gray;
        }

        .fullybooked-dates {
            color: red;
        }

        .selected {
            color: white;
            background-color: purple;
        }

        .selected-timeslot{
            color: white;
            background-color: purple;
        }

        .weekend-dates{
            opacity: 0.3;
            background-color: gray;
        }

        .current-date{
            color: orange;
        }

        .booked{
            background-color: red;
        }
    </style>
</head>
<body>

    <header>
        <a href="#"><img class="logo" src="logo1.png" alt="logo"></a>
    </header>

    <!-- parent div -->
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
            <!-- signing in -->
            <div class = "sign-in">
                <h1>Sign in</h1>
                <!--<form action="login_2_successfull.php" method="post">-->
                <form onsubmit="login.submit(event)" method="post">
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-sharp fa-solid fa-shield-halved" style="font-size:15px;"></i>
                            <label for="code">Access Code</label>
                            <input type="text" name="code" id="code" required>
                        </div>
                    </div>
                    <div class="form">
                        <div class="fonticon">
                            <i class="fas fa-eye" style="font-size:15px; cursor: pointer;" id="togglePassword"></i>
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                            <label for="pass">Password</label>
                            <input type="password" name="pass" id="pass" required>
                        </div>
                    </div>
                    <!--<input class="log-btn" type="submit" value="Sign in" name="login">-->
                    <button class="class_60 log-btn" value="Sign in">Login</button>
                    <!--<input type="checkbox" name="" id=""><p class ="checkbox-text">Keep me logged in-->
                </form>
                
                <a href="forgot_pass_1.php" id="forgotpass" class="a-forgot">Forgot password?</a>
                
                <div class="text-cont">
                    <div class="lines">
                        <p class="text-dha" id="dont_have_account">Don't have an account?</p>
                    </div>
                    <div onclick="sched_appointment.show()">Schedule an Appoitment</div>
                    <p class="text-visit">or Visit the nearest health facility in your area</p>
                </div>
                
                <!-- show password toggle script -->
                <!-- binalik ko dito, ayaw gumana sakin pag nasa baba yung script e -->
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
        </div>
    </div>
    <?php include('sched-appointment.php') ?>
    <!-- language, privacy policy, terms of use -->
        <?php include('languageprivacyterms.php') ?>
</body>

<script>
    var login = {
    
        submit: function(e){
            e.preventDefault();
            let inputs = e.currentTarget.querySelectorAll("input");
            let form = new FormData();
            
            for (var i = inputs.length - 1; i >= 0; i--) {
                form.append(inputs[i].name, inputs[i].value);
            }
            
            form.append('data_type', 'login');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //ganto daw iconvert si JSON back to javascript
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message); //nasa ajax.php yung .message

                        if(obj.success)//nasa ajax.php yung .sucess
                            window.location.href = "home_1_with_user.php";
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

</script>

</html>
