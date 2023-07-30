<?php 
    require("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa Login | Administrator </title>
</head>
<body>
    <h1>SiPa Administrator</h1>

    <form onsubmit="admin_login.submit(event)" method="post">
        <div class="form">
            <div class="">
                <label for="emp_number">Employee Number</label>
                <input type="text" name="emp_number" id="emp_number" required>
            </div>
        </div>
        <div class="form">
            <div class="">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
        </div>
        <button class="class_60 log-btn" value="Sign in">Login</button>
    </form>
</body>
<script>
var admin_login = {

    submit: function(e) {
        e.preventDefault();
        let inputs = e.currentTarget.querySelectorAll("input");
        let form = new FormData();

        for (var i = inputs.length - 1; i >= 0; i--) {
            form.append(inputs[i].name, inputs[i].value);
            console.log(inputs[i].name, inputs[i].value);
        }
        
        form.append('data_type', 'admin_login');
        
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); 

                    if(obj.success){
                        window.location.href = "admin-main.php";
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });
        ajax.open('post','testing_only.php', true);
        ajax.send(form);
    },
};
</script>
</html>