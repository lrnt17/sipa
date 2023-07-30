<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section class="js-mange-admin-modal hide">
    <table border ="1" cellspacing="0" cellpadding="10" id="mytable">
        <thead>
            <tr>
                <th><input type="checkbox" onclick="toggle(this);" /></th>
                <th>Employee Number</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Health Facility</th>
                <th>Specialization</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div onclick="admin_mange.show_me()" style="cursor:pointer;">Add</div>
    <!-- Delete button -->
    <div onclick="admin_mange.delete()" style="cursor:pointer;" id="delete-admin">Delete</div>
</section>

<!-- Adding admin modal -->
<div class="js-admin-signup hide">
    <div class="class_39" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="admin_mange.hide()">X</div>
    <h1>Registration</h1>
    <form onsubmit="admin_mange.register(event)" method="post">
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
            <input type="checkbox" name="terms_conditions" class="js-terms-conditions" id="terms_conditions" value="I agree" required>
        </div>
        <div class="form_privacy_policy">
            <label for="privacy_policy">I agree to <b><a href="#" id="privacy_policy_link">Privacy Policy</a></b></label>
            <input type="checkbox" name="privacy_policy" class="js-privacy-policy" id="privacy_policy" value="I agree" required>
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

<!-- Editing admin modal -->
<div class="js-admin-edit hide">
    <div class="class_39" style="float:right;cursor:pointer; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="admin_mange.hide()">X</div>
    <h1>Registration</h1>
    <form onsubmit="admin_mange.save(event)" method="post">
        <div class="form">
            <label for="edit_emp_number">Employee Number *</label>
            <input type="text" name="edit_emp_number" class="js-edit-emp_number" required>
        </div>
        <div class="form">
            <label for="edit_fullname">Full Name *</label>
            <input type="text" name="edit_fullname" class="js-edit-fullname edit-admin" required>
        </div>
        <div class="form">
            <label for="edit_gmail">Gmail Address *</label>
            <input type="email" name="edit_gmail" class="js-edit-gmail edit-admin" required>
        </div>
        <div class="form">
            <label for="edit_health_facility">Clinic/Hospital/RHU Name:*</label>
            <input type="text" name="edit_health_facility" class="js-edit-health_facility edit-admin" required>
        </div>
        <div class="form">
            <label for="edit_specialization">Specialization *</label>
            <select name="edit_specialization" id="edit_specialization" class="js-edit-specialization" required>
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
            <label for="edit_pnum">Phone Number *</label>
            <input type="number" name="edit_pnum" class="js-edit-pnum edit-admin" required>
        </div>
        <div class="form">
            <label for="edit_address">Address *</label>
            <input type="text" name="edit_address" class="js-edit-address edit-admin" required>
        </div>

        <div class="class_45" >
            <button class="class_46">
                Save
            </button>
        </div>
    </form>
</div>

<!-- HTML template for table rows -->
<template id="row-template">
    <tr>
        <td align="center" id="checkbox">
            <label class="container">
                <input type="checkbox" class="js-select-employee" name="employee_num[]">
                <span class="checkmark"></span>
            </label>
        </td>
        <td class="js-emp-num"></td>
        <td class="js-fullname"></td>
        <td class="js-email"></td>
        <td class="js-health-facility"></td>
        <td class="js-specialization"></td>
        <td class="js-admin-pnum"></td>
        <td class="js-admin-address"></td>
        <td class="js-admin-edit-btn" style="cursor:pointer;">Edit</td>
    </tr>
</template>

<script>
    function toggle(source) {
        var checkboxes = document.getElementsByName('employee_num[]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>
<script>
    var admin_mange = {

        edit_id: '',
        load_posts: function(e){

            let form = new FormData();
            form.append('data_type', 'load_admins');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);

                        if(data.success){
                            // Get table and template elements
                            let table = document.querySelector("#mytable tbody");
                            let template = document.querySelector("#row-template");

                            // Generate table rows
                            for (let i = 0; i < data.rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-employee").setAttribute('emp_num', data.rows[i].admin_empnum);
                                row.querySelector(".js-emp-num").textContent = data.rows[i].admin_empnum;
                                row.querySelector(".js-fullname").textContent = data.rows[i].admin_fullname;
                                row.querySelector(".js-email").textContent = data.rows[i].admin_email;
                                row.querySelector(".js-health-facility").textContent = data.rows[i].health_facility;
                                row.querySelector(".js-specialization").textContent = data.rows[i].specialization;
                                row.querySelector(".js-admin-pnum").textContent = data.rows[i].admin_pnum;
                                row.querySelector(".js-admin-address").textContent = data.rows[i].admin_address;
                                row.querySelector(".js-admin-edit-btn").setAttribute('onclick',`admin_mange.edit_admin('${data.rows[i].admin_empnum}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','post_'+data.rows[i].admin_empnum);
                                let row_data = JSON.stringify(data.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                table.appendChild(clone);
                            }
                        }
                    }
                }
            });

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        delete: function(){
            // Get selected rows
            let selectedRows = document.querySelectorAll("#mytable .js-select-employee:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete");
                return;
            }

            // Get IDs of selected rows
            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("emp_num");
                ids.push(id);
            });

            console.log(JSON.stringify(ids));

            // Create FormData object
            let form = new FormData();
            form.append('ids', JSON.stringify(ids));
            form.append('data_type', 'delete_rows');

            // Send Ajax request to delete selected rows from database
            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {
                            // Delete selected rows from table
                            selectedRows.forEach(function(row) {
                                row.closest("tr").remove();
                            });
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'testing_only.php', true);
            ajax.send(form);
        },

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
                            select_element.selectedIndex = 0;
                            document.querySelector(".js-terms-conditions").checked = false;
                            document.querySelector(".js-privacy-policy").checked = false;

                            // Clear the table
                            let table = document.querySelector("#mytable tbody");
                            table.innerHTML = "";
                            
                            admin_mange.load_posts();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        show_me: function(){

			document.querySelector(".js-admin-signup").classList.remove('hide');
            document.querySelector(".js-admin-edit").classList.add('hide');
			document.querySelector(".js-mange-admin-modal").classList.add('hide');
            document.querySelector(".js-admin-main").classList.add('hide');
		},

        hide: function(){
            document.querySelector(".js-admin-edit").classList.add('hide');
			document.querySelector(".js-admin-signup").classList.add('hide');
			document.querySelector(".js-mange-admin-modal").classList.remove('hide');
            document.querySelector(".js-admin-main").classList.remove('hide');
		},

        edit_admin: function(id){

            admin_mange.edit_id = id;

            console.log(admin_mange.edit_id);
            let data = document.querySelector("#post_"+id).getAttribute("row");
			data = data.replaceAll('\\"','"');
			data = JSON.parse(data);
            
            console.log(data);

            if(typeof data == 'object')
			{
				document.querySelector(".js-edit-emp_number").value = data.admin_empnum;
				document.querySelector(".js-edit-fullname").value = data.admin_fullname;
                document.querySelector(".js-edit-gmail").value = data.admin_email;
				document.querySelector(".js-edit-health_facility").value = data.health_facility;
                document.querySelector(".js-edit-specialization").value = data.specialization;
				document.querySelector(".js-edit-pnum").value = data.admin_pnum;
                document.querySelector(".js-edit-address").value = data.admin_address;
			}else{
				alert("Invalid post data");
			}

            document.querySelector(".js-admin-edit").classList.remove('hide');
            document.querySelector(".js-admin-signup").classList.add('hide');
			document.querySelector(".js-mange-admin-modal").classList.add('hide');
            document.querySelector(".js-admin-main").classList.add('hide');
        },

        save: function(e){

            e.preventDefault();
            let inputs = document.querySelectorAll('.edit-admin');
            let select_element = document.getElementById("edit_specialization");
            let selected_value = select_element.options[select_element.selectedIndex].value;

            let form = new FormData();

            for (var i = inputs.length - 1; i >= 0; i--) {
                console.log(inputs[i].name, inputs[i].value);
                form.append(inputs[i].name, inputs[i].value);
            }

            form.append('emp_num', admin_mange.edit_id);
            form.append('selected_value', selected_value);
            form.append('data_type', 'edit_admin');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //ganto daw iconvert si JSON back to javascript
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message); //nasa ajax.php yung .message

                        if(obj.success){//nasa ajax.php yung .sucess
                            // Clear the table
                            let table1 = document.querySelector("#mytable tbody");
                            table1.innerHTML = "";
                            
                            admin_mange.load_posts();
                            admin_mange.hide();
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

    admin_mange.load_posts();
</script>