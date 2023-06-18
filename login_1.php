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
    <title>Sign in | SiPa</title>

<style>
    .skiptranslate iframe  {
        visibility: hidden !important;
    } 

    body{
        top:0!important;
        background: linear-gradient(67deg,#70AFED ,#1F6CB5 25%);
        font-family: Helvetica Neue;
	    scroll-behavior: smooth;
        letter-spacing: 1px;
    }

    .parent{
        margin: 0;
        padding: 0;
        width: 100%;
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
        font-weight: 500;
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
        padding: 20px 50px 20px;
    }

    .doctor{
        height: 470px;
	    position: absolute;
        bottom: 0;
        padding-left: 270px;
        z-index: -1;
    }

    .sign-in{
        width: 450px;
        min-height: 480px;
        background: #F4F7FF;
        border-radius: 40px;
        box-shadow: 0 0 5px rgba(0,0,0,.3);
        padding: 20px 40px;
    }

    .container-box{
        right: 0px;
        margin-top: -170px;
        float: right;
        padding-right: 50px;
    }

    .container-box .sign-in .form input{
        width: 90%;
        height: 100%;
        border: 2px solid #B9B9B9;
        padding: 13px 20px;
        font-size: 1rem;
        border-radius: 0px;
        background: transparent;
        outline: none;
        margin-bottom: 20px;
    }

    .container-box .sign-in .log-btn{
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

    a {
        font-weight: 300;
        text-decoration: none;
        color: #FFFFFF;
        letter-spacing: 1px;
        margin-right:100px;
    }

    .translate {
        padding-top: 30px;
        float: right;
        z-index: -1;
    }

    .links{
        position: absolute;
        padding-top: 30px;
        float: right;
        padding-right: 10px;
    }

    .checkbox-text{
        margin: -20px 0px 20px 24px;
        font-size: 15px;
        font-weight: 300;
        color: #575757;
        
    }
    
    label{
        font-size: 18px;
        color: #575757;
    }

    h1{
        color: #2F2F2F;
        font-weight: 500;
    }

    .a-forgot{
        float: right;
        margin-right: 0px;
        text-decoration: none;
        color: #404AD0;
    }

    .text-dha{
        font-size: 15px;
        font-weight: 300;
        text-align: center;
        color: #575757;
        padding: 12px;
    }

    .lines{
        width: 100%;
        height: 45px;
        position: relative;
    }

    .lines::after, .lines::before{
        content: '';
        position: absolute;
        height: 1px;
        margin: auto;
        background: #2F2F2F;
        width: 25%;
        top: 45%;
    }

    .lines::after{
        left: 0;
    }

    .lines::before{
        right: 0;
    }

    .text-visit{
        font-size: 15px;
        font-weight: 400;
        text-align: center;
        color: #575757;
        width:100%;
    }

    @media (max-width: 1350px) {

        .header-text2{
        font-size: 40px;
        }

        .header-text{
        font-size: 40px;
        }

        .info-text{
            font-size: 15px;
        }

        .container-box{
        margin-top: -112px;
        }

        .doctor{
        padding: 0px 125px ;
        }
    }

    @media (max-width: 1225px) {

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
            position: absolute;
            top: 50%;
            right: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(50%, -8%);
            padding-right: 0px;
        }

        .doctor{
            display:none;
        }
        .text{
            padding-left: 0px;
        }

        .sign-in{
            width: 390px;
            min-height: auto;
        }

        .container-box .sign-in .form input{
            height: 90%;
            padding: 10px 17px;
            font-size: 1rem;
        }

        .container-box .sign-in .log-btn{
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

        .checkbox-text{
            font-size: 13px;
        }

        .text-dha{
            font-size: 13px;
        }

        .text-visit{
            font-size: 13px;
        }

        a {
            font-size: 13px;
            margin-right: 50px;
        }

        .translate {
            padding-top: 25px;
            float: right;
            z-index: -1;
        }

        .links{
            padding-top: 25px;
        }
    }

</style>
<body>

    <!-- parent div -->
    <div class="parent">
        <!-- 1st child div -->
        <div class = "container">
            <img class="doctor" src="doctor.png" alt=""><!-- background photo-->
            <img class="logo" src="logo1.png" alt=""><!-- logo -->
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
                        <label for="code">Access Code</label>
                        <input type="text" name="code" id="code" required>
                    </div>
                    <div class="form">
                    <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </div>
                    <!--<input class="log-btn" type="submit" value="Sign in" name="login">-->
                    <button class="class_60 log-btn" value="Sign in">Login</button>
                    <!--<input type="checkbox" name="" id=""><p class ="checkbox-text">Keep me logged in-->
                </form>
                
                <a href="forgotpass_1.php" id="forgotpass" class="a-forgot">Forgot password?</a>
                
                <div class="lines">
                    <p class="text-dha" id="dont_have_account">Don't have an account?</p>
                </div>
                <p class="text-visit">Visit the nearest health facility in your area</p>
                
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
</body>
</html>
