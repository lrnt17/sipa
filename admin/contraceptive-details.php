<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraceptive Details | SiPa</title>
</head>
<style>
    body {
    font-family: "Lato", sans-serif;
    }

    /* Fixed sidenav, full height */
    .sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    padding-top: 20px;
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav a, .dropdown-btn {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 20px;
    color: #818181;
    display: block;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    outline: none;
    }

    /* On mouse-over */
    .sidenav a:hover, .dropdown-btn:hover {
    color: #f1f1f1;
    }
    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
    display: none;
    background-color: #262626;
    padding-left: 8px;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
    float: right;
    padding-right: 8px;
    }

    /* Some media queries for responsiveness */
    @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
    }
</style>
<style>
    .hide{
        display: none;
    }
</style>
<body style="background: #F2F5FF;">

<?php include('admin-header.php') ?>
    <section class="main">

        <div class="topbar" style="width:100%;">
                <div class="toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
        </div>

        <!-- List of admins -->
        <div class="container"style="margin-top:85px;">
                <div class="row flex-nowrap mb-3" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                    
                    <div class="col-auto mt-1">
                        <div class="row">
                            <div class="col-auto">
                                <h2 style="font-weight: 400;"><b>Contraceptive</b> Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
            <div>
                <b>Select a Contraceptive: </b>
                <select id="select_contraceptive">
                    <!-- The options will be dynamically populated with JavaScript -->
                </select>   
            </div>
            <br>

            <!-- for positive -->
            <div>
                <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive_list_positive">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-positive" onclick="manage_contraceptives.select_all_positive_effect(this);" /></th>
                            <th>Positives</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <!-- Delete button -->
                <div onclick="manage_contraceptives.delete_positive_effects()" style="cursor:pointer;color:red;" id="delete-positive">Delete</div>
            </div>

            <br><br>
            <!-- for negative -->
            <div>
                <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive_list_negative">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-negative" onclick="manage_contraceptives.select_all_negative_effect(this);" /></th>
                            <th>Negatives</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <!-- Delete button -->
                <div onclick="manage_contraceptives.delete_negative_effects()" style="cursor:pointer;color:red;" id="delete-negative">Delete</div>
            </div>

            <br><br>
            <!-- for did you know -->
            <div>
                <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive_list_fyi">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-fyi" onclick="manage_contraceptives.select_all_fyi(this);" /></th>
                            <th>Did you know info</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <!-- Delete button -->
                <div onclick="manage_contraceptives.delete_fyi_info()" style="cursor:pointer;color:red;" id="delete-fyi">Delete</div>
            </div>

            <br>
            <div>
                <div onclick="manage_contraceptives.open_add_contraceptive_details()" style="cursor:pointer;">
                    Add Contraceptive Insights
                </div>
            </div>

            <br><br>
        </div>
        
        <!-- adding of contraceptive details -->
        <div class="js-add-new-contraceptive-details hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_contraceptives.close_modal()">X</div>
            <form onsubmit="manage_contraceptives.add_method_details(event)" method="post">
                <h1>Add Contraceptive Details</h1>
                <div>
                    <b>Select a Contraceptive: </b>
                    <select id="select_contraceptive_for_add" required>
                        <!-- The options will be dynamically populated with JavaScript -->
                    </select>   
                </div>
                <div>
                    <label for="add_new_advantages">Positives</label>
                    <textarea name="add_new_advantages" class="js-method-advantage-input js-add-new"></textarea>
                </div>
                <div>
                    <label for="add_new_disadvantages">Negatives</label>
                    <textarea name="add_new_disadvantages" class="js-method-disadvantage-input js-add-new"></textarea>
                </div>
                <div>
                    <label for="add_new_fyi">Did you know info</label>
                    <textarea name="add_new_fyi" class="js-method-fyi-input js-add-new"></textarea>
                </div>
                <div>
                    <button>
                        Add
                    </button>
                </div>
            </form> 
        </div>
        <!-- end of adding of contraceptive details -->

        <!-- editing of positive effects -->
        <div class="js-edit-positive-effect hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_contraceptives.close_modal()">X</div>
            <h1>Editing Positive effect of <span class="js-positive-method-name"></span></h1>
            <form onsubmit="manage_contraceptives.save_edited_positive_effect(event)" method="post">
                <div>
                    <textarea name="advantages" class="js-edit-advantage-input"></textarea>
                </div>
                <button>Save</button>
            </form>
        </div>

        <!-- editing of negative effects -->
        <div class="js-edit-negative-effect hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_contraceptives.close_modal()">X</div>
            <h1>Editing Negative effect of <span class="js-negative-method-name"></span></h1>
            <form onsubmit="manage_contraceptives.save_edited_negative_effect(event)" method="post">
                <div>
                    <textarea name="disadvantages" class="js-edit-disadvantage-input"></textarea>
                </div>
                <button>Save</button>
            </form>
        </div>

        <!-- editing of fyi -->
        <div class="js-edit-fyi hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="manage_contraceptives.close_modal()">X</div>
            <h1>Editing Did you know info of <span class="js-fyi-name"></span></h1>
            <form onsubmit="manage_contraceptives.save_edited_fyi(event)" method="post">
                <div>
                    <textarea name="fyi" class="js-edit-fyi-input"></textarea>
                </div>
                <button>Save</button>
            </form>
        </div>
    </section>

    <!-- table template for contraceptive positive effects -->
    <template id="positive-row-template">
        <tr>
            <td align="center" class="positive-effect-checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-positive-effect" name="all_positive_effects[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="js-positive-effect"></td>
            <td class="js-positive-effect-edit-btn" style="cursor:pointer;color:blue;">Edit</td>
        </tr>
    </template>

    <!-- table template for contraceptive negative effects -->
    <template id="negative-row-template">
        <tr>
            <td align="center" class="negative-effect-checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-negative-effect" name="all_negative_effects[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="js-negative-effect"></td>
            <td class="js-negative-effect-edit-btn" style="cursor:pointer;color:blue;">Edit</td>
        </tr>
    </template>

    <!-- table template for contraceptive did you know -->
    <template id="fyi-row-template">
        <tr>
            <td align="center" class="fyi-checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-fyi" name="all_fyi[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="js-fyi"></td>
            <td class="js-fyi-edit-btn" style="cursor:pointer;color:blue;">Edit</td>
        </tr>
    </template>

</body>
<script>
    var manage_contraceptives = {

        selectOption: '1',
        selectOptionName: 'Hormonal IUD',
        edit_id: '',

        load_contraceptive_list: function(){

            let form = new FormData();

            form.append('data_type', 'load_contraceptive_list');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            
                            let selectElement = document.getElementById("select_contraceptive");
                            selectElement.innerHTML = "";

                            obj.rows.forEach(function(contraceptive) {
                                let option = document.createElement("option");
                                option.value = contraceptive.birth_control_id;
                                option.text = contraceptive.birth_control_name;
                                option.setAttribute("contraceptive-name", contraceptive.birth_control_name);
                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        load_default_contraceptive: function() {
            let defaultSelectedOption = manage_contraceptives.selectOption;
            let defaultSelectedOptionName = manage_contraceptives.selectOptionName;
            
            manage_contraceptives.load_contraceptive_data(defaultSelectedOption, defaultSelectedOptionName);
        },

        load_contraceptive_data: function(selectedOption, selectedOptionName){
            
            manage_contraceptives.selectOption = selectedOption;
            manage_contraceptives.selectOptionName = selectedOptionName;

            let form = new FormData();
            form.append('selectedOption', selectedOption);
            form.append('data_type', 'load_contraceptive_data');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        
                        let positive_table = document.querySelector("#contraceptive_list_positive tbody");
                        positive_table.innerHTML = "";

                        let negative_table = document.querySelector("#contraceptive_list_negative tbody");
                        negative_table.innerHTML = "";

                        let fyi_table = document.querySelector("#contraceptive_list_fyi tbody");
                        fyi_table.innerHTML = "";

                        ["select-all-positive", "select-all-negative", "select-all-fyi"].forEach(id => {
                            let checkbox = document.getElementById(id);
                            if (checkbox.checked) checkbox.checked = false;
                        });
                        
                        if(data.positive_rows_success){
                            
                            let template = document.querySelector("#positive-row-template");

                            for (let i = 0; i < data.positive_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-positive-effect").setAttribute('positive_method_id', data.positive_rows[i].positive_effect_id);
                                row.querySelector(".js-positive-effect").textContent = data.positive_rows[i].positive_effect_desc;
                                row.querySelector(".js-positive-effect-edit-btn").setAttribute('onclick',`manage_contraceptives.edit_positive_effect('${data.positive_rows[i].positive_effect_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','positive_effect_id_'+data.positive_rows[i].positive_effect_id);
                                let row_data = JSON.stringify(data.positive_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                positive_table.appendChild(clone);
                            }
                        } else {
                            positive_table.innerHTML = "<tr><td></td><td>No data found</td><td></td></tr>";
                        }
                        //--------------------------------------------------------------------------
                        if(data.negative_rows_success){
                            
                            let template = document.querySelector("#negative-row-template");

                            for (let i = 0; i < data.negative_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-negative-effect").setAttribute('negative_method_id', data.negative_rows[i].negative_effect_id);
                                row.querySelector(".js-negative-effect").textContent = data.negative_rows[i].negative_effect_desc;
                                row.querySelector(".js-negative-effect-edit-btn").setAttribute('onclick',`manage_contraceptives.edit_negative_effect('${data.negative_rows[i].negative_effect_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','negative_effect_id_'+data.negative_rows[i].negative_effect_id);
                                let row_data = JSON.stringify(data.negative_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                negative_table.appendChild(clone);
                            }
                        } else {
                            negative_table.innerHTML = "<tr><td></td><td>No data found</td><td></td></tr>";
                        }
                        //--------------------------------------------------------------------------
                        if(data.fyi_rows_success){
                            
                            let template = document.querySelector("#fyi-row-template");

                            for (let i = 0; i < data.fyi_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-fyi").setAttribute('fyi_id', data.fyi_rows[i].fyi_id);
                                row.querySelector(".js-fyi").textContent = data.fyi_rows[i].fyi_desc;
                                row.querySelector(".js-fyi-edit-btn").setAttribute('onclick',`manage_contraceptives.edit_fyi('${data.fyi_rows[i].fyi_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','fyi_id_'+data.fyi_rows[i].fyi_id);
                                let row_data = JSON.stringify(data.fyi_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                fyi_table.appendChild(clone);
                            }
                        } else {
                            fyi_table.innerHTML = "<tr><td></td><td>No data found</td><td></td></tr>";
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
            
        },

        load_contraceptive_list_for_add: function(){

            let form = new FormData();

            form.append('data_type', 'load_contraceptive_list');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                        
                            let selectElement = document.getElementById("select_contraceptive_for_add");
                            selectElement.innerHTML = "";

                            let blankOption = document.createElement("option");
                            blankOption.value = "";
                            blankOption.text = "Select a Contraceptive";
                            blankOption.disabled = true;
                            blankOption.selected = true;
                            selectElement.appendChild(blankOption);

                            obj.rows.forEach(function(contraceptive) {
                                let option = document.createElement("option");
                                option.value = contraceptive.birth_control_id;
                                option.text = contraceptive.birth_control_name;
                                option.setAttribute("contraceptive-name", contraceptive.birth_control_name);
                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },
        
        add_method_details: function(e){

            e.preventDefault();
            let new_details_list = document.querySelectorAll(".js-add-new");

            let select_element = document.getElementById("select_contraceptive_for_add");
            let selected_method_id = select_element.options[select_element.selectedIndex].value;

            let selectedOptionElement = select_element.options[select_element.selectedIndex];
            let selected_method_name = selectedOptionElement.getAttribute("contraceptive-name"); 
            
            let form = new FormData();

            for (var i = new_details_list.length - 1; i >= 0; i--) {
                let value = new_details_list[i].value.trim();
                form.append(new_details_list[i].name, value);
            }

            form.append('selected_method_id', selected_method_id);
            form.append('data_type', 'add_new_contraceptive_details');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            new_details_list.forEach(textarea => textarea.value = '');

                            select_element.selectedIndex = 0;

                            document.getElementById("select_contraceptive").selectedIndex = Number(selected_method_id) - 1;
                            
                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);

                            ["select-all-positive", "select-all-negative", "select-all-fyi"].forEach(id => {
                                let checkbox = document.getElementById(id);
                                if (checkbox.checked) checkbox.checked = false;
                            });

                            manage_contraceptives.close_modal();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        edit_positive_effect: function(positive_effect_id){

            document.querySelector(".js-edit-positive-effect").classList.remove('hide');

            manage_contraceptives.edit_id = positive_effect_id;
            let method_name = manage_contraceptives.selectOptionName;

            document.querySelector(".js-positive-method-name").innerHTML = method_name;

            let data = document.querySelector("#positive_effect_id_"+positive_effect_id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);

            if(typeof data == 'object') {
                document.querySelector(".js-edit-advantage-input").value = data.positive_effect_desc;
            } else {
                alert("Invalid post data");
            }
        },

        edit_negative_effect: function(negative_effect_id){

            document.querySelector(".js-edit-negative-effect").classList.remove('hide');

            manage_contraceptives.edit_id = negative_effect_id;
            let method_name = manage_contraceptives.selectOptionName;

            document.querySelector(".js-negative-method-name").innerHTML = method_name;

            let data = document.querySelector("#negative_effect_id_"+negative_effect_id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);

            if(typeof data == 'object') {
                document.querySelector(".js-edit-disadvantage-input").value = data.negative_effect_desc;
            } else {
                alert("Invalid post data");
            }
        },

        edit_fyi: function(fyi_id){

            document.querySelector(".js-edit-fyi").classList.remove('hide');
            
            manage_contraceptives.edit_id = fyi_id;
            let method_name = manage_contraceptives.selectOptionName;

            document.querySelector(".js-fyi-name").innerHTML = method_name;

            let data = document.querySelector("#fyi_id_"+fyi_id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);

            if(typeof data == 'object') {
                document.querySelector(".js-edit-fyi-input").value = data.fyi_desc;
            } else {
                alert("Invalid post data");
            }
        },

        save_edited_positive_effect: function(e){

            e.preventDefault();
            let advantages_input = document.querySelector(".js-edit-advantage-input").value.trim();
            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectOptionName;
            let positive_effect_id = manage_contraceptives.edit_id;

            let form = new FormData();
            form.append('positive_effect_id', positive_effect_id);
            form.append('advantages_input', advantages_input);
            form.append('data_type', 'edit_positive_effect_desc');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);
                            manage_contraceptives.close_modal();

                            let all_positive = document.getElementById("select-all-positive");
                            if (all_positive.checked) {
                                all_positive.checked = false;
                            }
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        save_edited_negative_effect: function(e){

            e.preventDefault();
            let disadvantages_input = document.querySelector(".js-edit-disadvantage-input").value.trim();
            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectOptionName;
            let negative_effect_id = manage_contraceptives.edit_id;
            
            let form = new FormData();
            form.append('negative_effect_id', negative_effect_id);
            form.append('disadvantages_input', disadvantages_input);
            form.append('data_type', 'edit_negative_effect_desc');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);
                            manage_contraceptives.close_modal();

                            let all_negative = document.getElementById("select-all-negative");
                            if (all_negative.checked) {
                                all_negative.checked = false;
                            }
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        save_edited_fyi: function(e){

            e.preventDefault();
            let fyi_input = document.querySelector(".js-edit-fyi-input").value.trim();
            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectOptionName;
            let fyi_id = manage_contraceptives.edit_id;
            
            let form = new FormData();
            form.append('fyi_id', fyi_id);
            form.append('fyi_input', fyi_input);
            form.append('data_type', 'edit_fyi_desc');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);
                            manage_contraceptives.close_modal();

                            let all_fyi = document.getElementById("select-all-fyi");
                            if (all_fyi.checked) {
                                all_fyi.checked = false;
                            }
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },
        
        delete_positive_effects: function(){

            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectedOptionName;
            
            let selectedRows = document.querySelectorAll("#contraceptive_list_positive .js-select-positive-effect:checked");
            
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete in Positive Effects");
                return;
            } else if (!confirm("Are you sure you want to delete this positive effect/s?")){
                return;
            }

            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("positive_method_id");
                ids.push(id);
            });

            let form = new FormData();
            form.append('positive_effect_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_positive_effects');

            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            document.getElementById("select_contraceptive").selectedIndex = Number(selected_method_id) - 1;
                            
                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);

                            let all_positive = document.getElementById("select-all-positive");
                            if (all_positive.checked) {
                                all_positive.checked = false;
                            }
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },

        delete_negative_effects: function(){

            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectedOptionName;
            
            let selectedRows = document.querySelectorAll("#contraceptive_list_negative .js-select-negative-effect:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete in Negative Effects");
                return;
            } else if (!confirm("Are you sure you want to delete this negative effect/s?")){
                return;
            }

            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("negative_method_id");
                ids.push(id);
            });

            let form = new FormData();
            form.append('negative_effect_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_negative_effects');

            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            document.getElementById("select_contraceptive").selectedIndex = Number(selected_method_id) - 1;

                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);

                            let all_negative = document.getElementById("select-all-negative");
                            if (all_negative.checked) {
                                all_negative.checked = false;
                            }
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },

        delete_fyi_info: function(){

            let selected_method_id = manage_contraceptives.selectOption;
            let selected_method_name = manage_contraceptives.selectedOptionName;
            
            let selectedRows = document.querySelectorAll("#contraceptive_list_fyi .js-select-fyi:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete in Did you know infos");
                return;
            } else if (!confirm("Are you sure you want to delete this did you know info/s?")){
                return;
            }

            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("fyi_id");
                ids.push(id);
            });

            let form = new FormData();
            form.append('fyi_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_fyi_infos');

            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            document.getElementById("select_contraceptive").selectedIndex = Number(selected_method_id) - 1;

                            manage_contraceptives.load_contraceptive_data(selected_method_id, selected_method_name);

                            let all_fyi = document.getElementById("select-all-fyi");
                            if (all_fyi.checked) {
                                all_fyi.checked = false;
                            }
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },

        open_add_contraceptive_details: function(){
            document.querySelector(".js-add-new-contraceptive-details").classList.remove('hide');
        },

        close_modal: function(){
            document.querySelector(".js-add-new-contraceptive-details").classList.add('hide');
            document.querySelector(".js-edit-positive-effect").classList.add('hide');
            document.querySelector(".js-edit-negative-effect").classList.add('hide');
            document.querySelector(".js-edit-fyi").classList.add('hide');
        },

        select_all_positive_effect: function(source){
            let checkboxes = document.getElementsByName('all_positive_effects[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },

        select_all_negative_effect: function(source){
            let checkboxes = document.getElementsByName('all_negative_effects[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },

        select_all_fyi: function(source){
            let checkboxes = document.getElementsByName('all_fyi[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },

    };

    document.addEventListener("DOMContentLoaded", function() {
        let selectOption = document.getElementById("select_contraceptive");
        manage_contraceptives.load_default_contraceptive();
        selectOption.addEventListener("change", function() {
            let selectedOption = selectOption.value;
            let selectedOptionElement = selectOption.options[selectOption.selectedIndex]; // Get the selected option element
            let selectedOptionName = selectedOptionElement.getAttribute("contraceptive-name"); // Or use selectedOptionElement.dataset.name;
            //alert(selectedOptionName);
            manage_contraceptives.load_contraceptive_data(selectedOption, selectedOptionName);
        });
    });
    
    manage_contraceptives.load_contraceptive_list_for_add();
    manage_contraceptives.load_contraceptive_list();
        
</script>

<script>
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    };
</script>
</html>