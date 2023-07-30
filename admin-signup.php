<?php 
    require("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Worker Regisration | SiPa</title>
</head>
<body>
    <div>
        <h1>Welcome to Sipa</h1>
    </div>
    
    <br>

    <!-- signing in -->
    <div>
        <h1>Registration</h1>
        <form onsubmit="admin_signup.register(event)" method="post">
            <div class="form">
                <label for="emp_number">Employee Number *</label>
                <input type="text" name="emp_number" id="emp_number" required>
            </div>
            <div class="form">
                <label for="fullname">Full Name *</label>
                <input type="text" name="fullname" id="fullname" required>
            </div>
            <div class="form">
                <label for="gmail">Gmail Address *</label>
                <input type="email" name="gmail" id="gmail" required>
            </div>
            <div class="form">
                <label for="health_facility">Clinic/Hospital/RHU Name:*</label>
                <input type="text" name="health_facility" id="health_facility" required>
            </div>
            <div class="form">
                <label for="specialization">Specialization *</label>
                <select name="specialization" id="specialization" required>
                    <option value="" disabled selected>Select Specialization</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Obstetrician-Gynecologist (OB-GYN)">Obstetrician-Gynecologist (OB-GYN)</option>
                    <option value="Obstetrician">Obstetrician</option>
                    <option value="Gynecologist">Gynecologist</option>
                    <option value="Family Medicine Physician">Family Medicine Physician</option>
                    <option value="Nurse Practitioner">Nurse Practitioner</option>
                    <option value="Nurse-Midwife">Nurse-Midwife</option>
                    <option value="Sexual Health Specialist">Sexual Health Specialist</option>
                    <option value="Urologist">Urologist</option>
                    <option value="Adolescent Medicine Specialist">Adolescent Medicine Specialist</option>
                    <option value="Planned Parenthood Clinician">Planned Parenthood Clinician</option>
                    <option value="Reproductive Health Counselor">Reproductive Health Counselor</option>
                </select>
            </div>
            <div class="form">
                <label for="pnum">Phone Number *</label>
                <input type="number" name="pnum" id="pnum" required>
            </div>
            <div class="form">
                <label for="address">Address *</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div class="form">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <div class="form">
                <label for="con_pass">Confirm Password</label>
                <input type="password" name="con_pass" id="con_pass" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <div class="form_terms_conditions">
                <label for="terms_conditions">I accept the <b><a href="#" id="terms_condi_link">Terms and Conditions</a></b></label>
                <input type="checkbox" name="terms_conditions" id="terms_conditions" value="I agree" required>
            </div>
            <div class="form_privacy_policy">
                <label for="privacy_policy">I agree to <b><a href="#" id="privacy_policy_link">Privacy Policy</a></b></label>
                <input type="checkbox" name="privacy_policy" id="privacy_policy" value="I agree" required>
            </div>

            <div class="class_45" >
                <button class="class_46">
                    Register
                </button>
            </div>
        </form>
        <p id="dont_have_account">---------- Already have an account? -------------</p>
        <a href="admin-login.php"><u>Log in</u></a>
    </div>
</body>
<script>
var admin_signup = {

    register: function(e){

        e.preventDefault();
        let inputs = e.currentTarget.querySelectorAll("input");
        let select_element = document.getElementById("specialization");
        let selected_value = select_element.options[select_element.selectedIndex].value;

        let form = new FormData();
        
        for (var i = inputs.length - 1; i >= 0; i--) {
            form.append(inputs[i].name, inputs[i].value);
        }

        form.append('selected_value', selected_value);
        form.append('data_type', 'admin_signup');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        inputs.forEach(input => input.value = "");
                        select_element.selectedIndex = -1;
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