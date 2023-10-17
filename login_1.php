<?php 
    include("connect.php");
    //require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function preventBack() {
            window.history.forward()
        };
        setTimeout("preventBack()", 0);
        window.onunload=function(){null;}
    </script>
    <title>Sign in | SiPa</title>

    <style>
       @media (max-width: 1225px) {

        .header2{
            text-align: center;
            font-size: 25px !important; 
            margin-top: -23px !important;
        }

        .header1{
            margin-top: 0px !important;
            text-align: center;
            font-size: 22px !important;
        }

        .info{
            display:none;
        }

        .container-box{
            height: 75%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -34%);
        }

        .doctor1{
            display:none;
        }
        .text{
            padding-left: 0px !important;
        }

        .sign-in{
            margin: 0;
            position: absolute;
            top: 47%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 383px !important;
            min-height: auto;
        }

        .container-box .sign-in .form input{
            height: 80%;
            padding: 5px 27px;
            font-size: .8rem;
        }

        .container-box .sign-in .log-btn{
            width: 100%;
            padding: 5px 17px;
            font-size: 1rem;
        }

        label{
            font-size: 14px;
        }

        h1{
            text-align:center;
            font-size: 23px;
        }

        .text-dha{
            font-size: 12px !important;
        }

        .visit{
            font-size: 12px !important;
        }

        a {
            font-size: 12px !important;
        }

        .links{
            bottom: 10px;
            position: absolute;
            width: 100%;
        }

        .sched{
            font-size:13px !important;
        }

        .modal-content {
            width: 90% !important;
        }

        }

        @media (max-width: 540px) {
            .lines::after, .lines::before {
                width: 20% !important;
            }
        }
    </style>
    <style>
        /* The Modal (background) */
        .js-sched-appointment-modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 35px; /* Location of the box */
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
            width: 70%;
            border-radius: 40px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            padding: 3%;
            max-height: 89vh; /* Set a maximum height for the container (adjust as needed) */
            overflow-y: auto; 
        }

        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* The Close Button */
        .close, .close-policies {
        color: black;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .btn-success{
            color: black;
            background-color: #d2e0f8;
            border-color: #d2e0f8;
        }

        .btn-success:hover{
            color: white !important;
            background-color: #CAA4D0 !important;
            border-color: #d2e0f8;
        }

        .span_time{
            pointer-events: none;
        }

        .span_slots{
            pointer-events: none;
        }

        .close:hover,
        .close:focus, .close-policies:hover, .close-policies:focus {
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

        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
            border: none !important;
        }

        .table-bordered {
            border: none !important;
        }
        
        td{
            width: 33%;
        }

        tbody{
            text-align:center;
        }

        th{
            text-align:center;
            color: #184DA8;
            font-weight: 600;
        }

        .today{
            color: #F0C2A9;
        }

        
        .new-dates:hover{
            background-color: #CAA4D0;
            color: white;
            cursor: pointer;
        }

        .old-dates {
            /* Style for dates that are less than the current date */
            color: gray;
        }

        .fullybooked-dates {
            color: #BA2229;
        }

        .selected {
            color: white;
            background-color: #CAA4D0;
        }

        .selected-timeslot{
            color: white;
            background-color: #CAA4D0;
        }

        .weekend-dates{
            opacity: 0.3;
            background-color: gray;
        }

        .current-date{
            color: #F0C2A9;
        }

        .booked{
            background-color: #B12229;
            color: white;
        }

        .booked:hover{
            background-color: #9E1E24 !important;
            color: white;
        }

        .label-1 {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 500;
            position: unset;
        }
    </style>
    
    <!--Ito yung may iaagree na modal-->
    <style>

    </style>
</head>
<body>

    <header>
        <div class="d-flex justify-content-center" style="text-align: center; padding:.6%;">
            <a href="home_1_with_user.php"><img class="logo" style="height:85px;" src="logo1.png" alt="logo"></a>
        </div>
    </header>

    <!-- parent div -->
    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor1" src="doctor.png" alt="" style="height: 450px;
            position: absolute;
            bottom: 0;
            padding-left: 118px;
            z-index: -1;"><!-- background photo-->
            <div class = "text" style="padding-left: 64px;"><!-- texts -->
                <p class = "header1" style="font-size: 40px;
                color:#FFFFFF;
                font-weight: 300;
                margin-top: 18px;">Welcome back to</p>
                <p class = "header2" style="font-size: 40px;
                color:#FFFFFF;
                margin-top: -29px;
                font-weight: 400;"><span translate="no">SiPa Siguradong Pagpaplano</span></p>
                <p class = "info" style="font-size: 15px;
                color:#FFFFFF;
                margin-top: -16px;
                font-weight: 300;">Find out your top contraceptive methods.</p>
            </div>
        </div>

        <!-- 2nd child div -->
        <div class="container-box">
            <!-- signing in -->
            <div class = "sign-in" style="width: 510px;">
                <h1>Login</h1>
                <!--<form action="login_2_successfull.php" method="post">-->
                <form onsubmit="login.submit(event)" method="post">
                    <div class="form">
                        <div class="fonticon">
                            <i class="fa-sharp fa-solid fa-shield-halved" style="font-size:15px;"></i>
                            <label for="username" style="font-weight:normal;">Username</label>
                            <input type="text" name="username" id="username" required style="width: 100%; font-size:1.4rem; padding: 11px 35px;">
                        </div>
                    </div>
                    <div class="form">
                        <div class="fonticon">
                            <i class="fas fa-eye" style="font-size:15px; cursor: pointer;" id="togglePassword"></i>
                            <i class="fa-solid fa-lock" style="font-size:15px;"></i>
                            <label for="pass" style="font-weight:normal;">Password</label>
                            <input type="password" name="pass" id="pass" required style="width: 100%; font-size:1.4rem; padding: 11px 35px;">
                        </div>
                    </div>
                    <!--<input class="log-btn" type="submit" value="Sign in" name="login">-->
                    <button class="class_60 log-btn" value="Sign in" style="font-size:1.8rem;">Login</button>
                    <!--<input type="checkbox" name="" id=""><p class ="checkbox-text">Keep me logged in-->
                </form>
                
                <!--<button id="myBtn">Open Modal</button>-->
                <a href="forgot_pass_1.php" id="forgotpass" class="a-forgot">Forgot password?</a>
                
                <div class="text-cont" style="margin-top: 9%;">
                    <div class="lines">
                        <p class="text-dha" id="dont_have_account">Don't have an account?</p>
                    </div>
                    <center><div onclick="sched_appointment.show()" class="sched" style="cursor:pointer; margin: 3px; color:#1F6CB5;">Click here to Schedule an Appointment</div></center>
                    <center><p class="visit" style="font-size: 13px; margin: 0;">to your nearest health facility in your area</p></center>
                    <center><p class="visit" style="font-size: 13px; margin: 0;">or</p></center>
                    <center><a href="home_1_with_user.php" class="visit" style="cursor:pointer; color:#1F6CB5; text-decoration:none; font-weight:400;">Continue as Guest</a></center>
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
    <?php include('agree-to-policies.php') ?>
    <!-- language, privacy policy, terms of use -->
        <?php include('languageprivacyterms.php') ?>
</body>

<script>
    var login = {

        username: null,
        password: null,
    
        submit: function(e){

            e.preventDefault();

            let inputs = e.currentTarget.querySelectorAll("input");

            let form = new FormData();
            
            for (var i = inputs.length - 1; i >= 0; i--) {
                form.append(inputs[i].name, inputs[i].value);

                if (inputs[i].name === 'username') {
                    login.username = inputs[i].value;
                } else if (inputs[i].name === 'pass') {
                    login.password = inputs[i].value;
                }
            }
            
            form.append('data_type', 'login');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.user_success){
                            
                            window.location.href = "home_1_with_user.php";
                            login.password = null;
                            login.password = null;
                        }else if (obj.admin_success) {
                            
                            window.location.href = "admin/index.php";
                            login.password = null;
                            login.password = null;
                        }else if (obj.head_admin_success) {
                            
                            window.location.href = "admin/index.php";
                            login.password = null;
                            login.password = null;
                        }else if (typeof obj.user_success != 'undefined' && !obj.user_success) {
                            console.log('hoy', obj.user_success);
                            document.getElementById("myModal").style.display = "block";
                        }else if (!obj.success) {
                            return;
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        agree_to_policies: function(e) {
            
            e.preventDefault();

            let inputs = e.currentTarget.querySelectorAll("input");
            let username = login.username;
            let password = login.password;

            let form = new FormData();

            for (var i = inputs.length - 1; i >= 0; i--) {
                form.append(inputs[i].name, inputs[i].value);
                console.log(inputs[i].name, inputs[i].value);
            }
            console.log(username, password);
            //return;
            form.append('username', username);
            form.append('pass', password);
            form.append('data_type', 'login_with_agree');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            login.password = null;
                            login.password = null;
                            window.location.href = "right_for_me_quiz.php";
                        }
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
