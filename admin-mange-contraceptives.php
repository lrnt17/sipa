<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section class="js-mange-contraceptives-modal hide">

    <!-- contraceptive positive & negative effects list -->
    <div>
        <div>
            <label for="select_contraceptive">Select Contraceptives to view</label>
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
                        <th><input type="checkbox" id="select-all-positive" onclick="mnge_contraceptives.select_all_positive(this);" /></th>
                        <th>Positives</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
            <!-- Delete button -->
            <div onclick="mnge_contraceptives.positive_delete()" style="cursor:pointer;color:red;" id="delete-positive">Delete</div>
        </div>

        <br><br>
        <!-- for negative -->
        <div>
            <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive_list_negative">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-negative" onclick="mnge_contraceptives.select_all_negative(this);" /></th>
                        <th>Negatives</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
            <!-- Delete button -->
            <div onclick="mnge_contraceptives.negative_delete()" style="cursor:pointer;color:red;" id="delete-negative">Delete</div>
        </div>

        <br><br>
        <!-- for did you know -->
        <div>
            <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive_list_fyi">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-fyi" onclick="mnge_contraceptives.select_all_fyi(this);" /></th>
                        <th>Did you know info</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
            <!-- Delete button -->
            <div onclick="mnge_contraceptives.fyi_delete()" style="cursor:pointer;color:red;" id="delete-fyi">Delete</div>
        </div>
    </div>

    <br>
    <div>
        <div onclick="mnge_contraceptives.add_positive_negative_effect()" style="cursor:pointer;color:green;">
            Add Contraceptive Insight
        </div>
    </div>
    <!-- end of contraceptive positive & negative effects list -->

    <br><br>

    <!-- adding of positive & negative effects -->
    <div class="js-add-positive-negative-effect hide">
        <div class="class_39" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="mnge_contraceptives.hide_positive_negative_effect()">X</div>
        <form onsubmit="mnge_contraceptives.add_method_details(event)" method="post">
            <h1>Add birth-control avantages</h1>
            <div>
                <label for="contraceptive_select">Contraceptives *</label>
                <select id="contraceptivesSelect" required>
                    <!-- The options will be dynamically populated with JavaScript -->
                </select>   
            </div>
            <div>
                <label for="advantages">Positives</label>
                <textarea name="advantages" class="js-method-advantage-input"></textarea>
            </div>
            <div>
                <label for="disadvantages">Negatives</label>
                <textarea name="disadvantages" class="js-method-disadvantage-input"></textarea>
            </div>
            <div>
                <label for="fyi">Did you know info</label>
                <textarea name="fyi" class="js-method-fyi-input"></textarea>
            </div>
            <div>
                <button>
                    Add
                </button>
            </div>
        </form> 
    </div>
    <!-- end of adding of positive & negative effects -->

    <!-- editing of positive effects -->
    <div class="js-edit-positive-effect hide">
        <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="mnge_contraceptives.hide_edit_positive_effect()">X</div>
        <h1>Editing Positive effect of <span class="js-positive-method-name"></span></h1>
        <form onsubmit="mnge_contraceptives.save_edited_positive_effect(event)" method="post">
            <div>
                <textarea name="advantages" class="js-edit-advantage-input"></textarea>
            </div>
            <button>Save</button>
        </form>
    </div>

    <!-- editing of negative effects -->
    <div class="js-edit-negative-effect hide">
        <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="mnge_contraceptives.hide_edit_negative_effect()">X</div>
        <h1>Editing Negative effect of <span class="js-negative-method-name"></span></h1>
        <form onsubmit="mnge_contraceptives.save_edited_negative_effect(event)" method="post">
            <div>
                <textarea name="disadvantages" class="js-edit-disadvantage-input"></textarea>
            </div>
            <button>Save</button>
        </form>
    </div>

    <!-- editing of fyi -->
    <div class="js-edit-fyi hide">
        <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="mnge_contraceptives.hide_edit_fyi()">X</div>
        <h1>Editing Did you know info of <span class="js-fyi-name"></span></h1>
        <form onsubmit="mnge_contraceptives.save_edited_fyi(event)" method="post">
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

<script>
    var mnge_contraceptives = {

        selectOption: '1',
        selectOptionName: 'Hormonal IUD',
        edit_id: '',

        load_contraceptives: function(){

            let form = new FormData();

            form.append('data_type', 'load_all_methods');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            // Get the select element
                            let selectElement = document.getElementById("contraceptivesSelect");

                            // Clear any existing options
                            selectElement.innerHTML = "";

                            // Add the initial blank option
                            let blankOption = document.createElement("option");
                            blankOption.value = "";
                            blankOption.text = "Select a Contraceptive";
                            blankOption.disabled = true;
                            blankOption.selected = true;
                            selectElement.appendChild(blankOption);

                            // Loop through the contraceptive methods data and add options to the select element
                            obj.rows.forEach(function(contraceptive) {
                                let option = document.createElement("option");
                                option.value = contraceptive.birth_control_id;
                                option.text = contraceptive.birth_control_name;
                                option.setAttribute("data-name", contraceptive.birth_control_name);
                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        add_method_details: function(e){

            e.preventDefault();
            let advantages_input = document.querySelector(".js-method-advantage-input").value.trim();
            let disadvantages_input = document.querySelector(".js-method-disadvantage-input").value.trim();
            let fyi_input = document.querySelector(".js-method-fyi-input").value.trim();
            let select_element = document.getElementById("contraceptivesSelect");
            let selected_method_id = select_element.options[select_element.selectedIndex].value;

            let selectedOptionElement = select_element.options[select_element.selectedIndex]; // Get the selected option element
            let selected_method_name = selectedOptionElement.getAttribute("data-name"); 
            //mnge_contraceptives.selectOption = '1';
            console.log(advantages_input);
            console.log(disadvantages_input);
            console.log(selected_method_id);
            console.log(selected_method_name);
            //return;
            let form = new FormData();

            form.append('advantages_input', advantages_input);
            form.append('disadvantages_input', disadvantages_input);
            form.append('fyi_input', fyi_input);
            form.append('selected_method_id', selected_method_id);
            form.append('data_type', 'add_method_details');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            document.querySelector(".js-method-advantage-input").value = "";
                            document.querySelector(".js-method-disadvantage-input").value = "";
                            document.querySelector(".js-method-fyi-input").value = "";
                            select_element.selectedIndex = 0;

                            let selectOption = document.getElementById("select_contraceptive");
                            let integerValue = Number(selected_method_id);
                            let result = integerValue - 1;
                            selectOption.selectedIndex = result;
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);

                            let all_positive = document.getElementById("select-all-positive");
                            if (all_positive.checked) {
                                all_positive.checked = false;
                            }

                            let all_negative = document.getElementById("select-all-negative");
                            if (all_negative.checked) {
                                all_negative.checked = false;
                            }

                            let all_fyi = document.getElementById("select-all-fyi");
                            if (all_fyi.checked) {
                                all_fyi.checked = false;
                            }

                            mnge_contraceptives.hide_positive_negative_effect();
                            // Clear the table
                            //let table = document.querySelector("#mytable tbody");
                            //table.innerHTML = "";
                            
                            //admin_mange.load_posts();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        load_contraceptive_list: function(){

            let form = new FormData();

            form.append('data_type', 'load_all_methods');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            // Get the select element
                            let selectElement = document.getElementById("select_contraceptive");

                            // Clear any existing options
                            selectElement.innerHTML = "";

                            // Loop through the contraceptive methods data and add options to the select element
                            obj.rows.forEach(function(contraceptive) {
                                let option = document.createElement("option");
                                option.value = contraceptive.birth_control_id;
                                option.text = contraceptive.birth_control_name;
                                option.setAttribute("data-name", contraceptive.birth_control_name);
                                selectElement.appendChild(option);
                            });
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        loadData: function(selectedOption, selectedOptionName){
            
            mnge_contraceptives.selectOption = selectedOption;
            mnge_contraceptives.selectOptionName = selectedOptionName;
            console.log(mnge_contraceptives.selectOption);
            console.log(mnge_contraceptives.selectOptionName);

            let form = new FormData();
            form.append('selectedOption', selectedOption);
            form.append('data_type', 'load_method_effects');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        //console.log(ajax.responseText);
                        let positive_table = document.querySelector("#contraceptive_list_positive tbody");
                        positive_table.innerHTML = "";

                        let negative_table = document.querySelector("#contraceptive_list_negative tbody");
                        negative_table.innerHTML = "";

                        let fyi_table = document.querySelector("#contraceptive_list_fyi tbody");
                        fyi_table.innerHTML = "";
                        //console.log(negative_table);
                        if(data.positive_rows_success){
                            
                            let template = document.querySelector("#positive-row-template");

                            for (let i = 0; i < data.positive_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-positive-effect").setAttribute('positive_method_id', data.positive_rows[i].positive_effect_id);
                                row.querySelector(".js-positive-effect").textContent = data.positive_rows[i].positive_effect_desc;
                                row.querySelector(".js-positive-effect-edit-btn").setAttribute('onclick',`mnge_contraceptives.edit_positive_effect('${data.positive_rows[i].positive_effect_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','positive_contraceptive_'+data.positive_rows[i].positive_effect_id);
                                let row_data = JSON.stringify(data.positive_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                positive_table.appendChild(clone);
                            }
                        } else {
                            positive_table.innerHTML = "<tr><td></td><td>No data found</td></tr>";
                        }
                        //--------------------------------------------------------------------------
                        if(data.negative_rows_success){
                            
                            let template = document.querySelector("#negative-row-template");

                            for (let i = 0; i < data.negative_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-negative-effect").setAttribute('negative_method_id', data.negative_rows[i].negative_effect_id);
                                row.querySelector(".js-negative-effect").textContent = data.negative_rows[i].negative_effect_desc;
                                row.querySelector(".js-negative-effect-edit-btn").setAttribute('onclick',`mnge_contraceptives.edit_negative_effect('${data.negative_rows[i].negative_effect_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','negative_contraceptive_'+data.negative_rows[i].negative_effect_id);
                                let row_data = JSON.stringify(data.negative_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                negative_table.appendChild(clone);
                            }
                        } else {
                            negative_table.innerHTML = "<tr><td></td><td>No data found</td></tr>";
                        }
                        //--------------------------------------------------------------------------
                        if(data.fyi_rows_success){
                            
                            let template = document.querySelector("#fyi-row-template");

                            for (let i = 0; i < data.fyi_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-fyi").setAttribute('fyi_id', data.fyi_rows[i].fyi_id);
                                row.querySelector(".js-fyi").textContent = data.fyi_rows[i].fyi_desc;
                                row.querySelector(".js-fyi-edit-btn").setAttribute('onclick',`mnge_contraceptives.edit_fyi('${data.fyi_rows[i].fyi_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','fyi_contraceptive_'+data.fyi_rows[i].fyi_id);
                                let row_data = JSON.stringify(data.fyi_rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                fyi_table.appendChild(clone);
                            }
                        } else {
                            fyi_table.innerHTML = "<tr><td></td><td>No data found</td></tr>";
                        }
                    }
                }
            });

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
            
        },

        loadDefaultData: function() {
            let defaultSelectedOption = mnge_contraceptives.selectOption;
            let defaultSelectedOptionName = mnge_contraceptives.selectOptionName;
            //console.log(defaultSelectedOptionName);
            mnge_contraceptives.loadData(defaultSelectedOption, defaultSelectedOptionName);
        },

        positive_delete: function(){

            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectedOptionName;
            //console.log(selected_method);
            // Get selected rows
            let selectedRows = document.querySelectorAll("#contraceptive_list_positive .js-select-positive-effect:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete");
                return;
            }

            // Get IDs of selected rows
            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("positive_method_id");
                ids.push(id);
            });

            console.log(JSON.stringify(ids));

            // Create FormData object
            let form = new FormData();
            form.append('positive_effect_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_positive_effects');

            // Send Ajax request to delete selected rows from database
            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {
                            // Delete selected rows from table
                            /*selectedRows.forEach(function(row) {
                                row.closest("tr").remove();
                            });*/

                            let selectOption = document.getElementById("select_contraceptive");
                            let integerValue = Number(selected_method_id);
                            let result = integerValue - 1;
                            selectOption.selectedIndex = result;
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);

                            let all_positive = document.getElementById("select-all-positive");
                            if (all_positive.checked) {
                                all_positive.checked = false;
                            }

                            //document.getElementById("#select-all-positive").checked = false;
                        }
                    } else {
                        alert("Please check your internet connection");
                    }
                }
            });
            ajax.open('post', 'testing_only.php', true);
            ajax.send(form);
        },

        negative_delete: function(){

            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectedOptionName;
            // Get selected rows
            let selectedRows = document.querySelectorAll("#contraceptive_list_negative .js-select-negative-effect:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete");
                return;
            }

            // Get IDs of selected rows
            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("negative_method_id");
                ids.push(id);
            });

            console.log(JSON.stringify(ids));

            // Create FormData object
            let form = new FormData();
            form.append('negative_effect_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_negative_effects');

            // Send Ajax request to delete selected rows from database
            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            let selectOption = document.getElementById("select_contraceptive");
                            let integerValue = Number(selected_method_id);
                            let result = integerValue - 1;
                            selectOption.selectedIndex = result;
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);

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
            ajax.open('post', 'testing_only.php', true);
            ajax.send(form);
        },

        fyi_delete: function(){

            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectedOptionName;
            // Get selected rows
            let selectedRows = document.querySelectorAll("#contraceptive_list_fyi .js-select-fyi:checked");
            if (selectedRows.length == 0) {
                alert("Please select at least one row to delete");
                return;
            }

            // Get IDs of selected rows
            let ids = [];
            selectedRows.forEach(function(row) {
                let id = row.getAttribute("fyi_id");
                ids.push(id);
            });

            console.log(JSON.stringify(ids));

            // Create FormData object
            let form = new FormData();
            form.append('fyi_ids', JSON.stringify(ids));
            form.append('data_type', 'delete_fyi');

            // Send Ajax request to delete selected rows from database
            let ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if (obj.success) {

                            let selectOption = document.getElementById("select_contraceptive");
                            let integerValue = Number(selected_method_id);
                            let result = integerValue - 1;
                            selectOption.selectedIndex = result;
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);

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
            ajax.open('post', 'testing_only.php', true);
            ajax.send(form);
        },

        select_all_positive: function(source){
            let checkboxes = document.getElementsByName('all_positive_effects[]');
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        },

        select_all_negative: function(source){
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

        hide_edit_positive_effect: function(){
            document.querySelector(".js-edit-positive-effect").classList.add('hide');
        },

        edit_positive_effect: function(positive_effect_id){

            document.querySelector(".js-edit-positive-effect").classList.remove('hide');

            mnge_contraceptives.edit_id = positive_effect_id;
            let method_name = mnge_contraceptives.selectOptionName;

            document.querySelector(".js-positive-method-name").innerHTML = method_name;

            let data = document.querySelector("#positive_contraceptive_"+positive_effect_id).getAttribute("row");
			data = data.replaceAll('\\"','"');
			data = JSON.parse(data);
            
            console.log(data);
            if(typeof data == 'object') {
				document.querySelector(".js-edit-advantage-input").value = data.positive_effect_desc;
			} else {
				alert("Invalid post data");
			}
        },

        save_edited_positive_effect: function(e){

            e.preventDefault();
            let advantages_input = document.querySelector(".js-edit-advantage-input").value.trim();
            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectOptionName;
            let positive_effect_id = mnge_contraceptives.edit_id;
            console.log(positive_effect_id, advantages_input, selected_method_id, selected_method_name);
            //return;
            let form = new FormData();
            form.append('positive_effect_id', positive_effect_id);
            form.append('advantages_input', advantages_input);
            form.append('data_type', 'edit_positive_desc');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);
                            mnge_contraceptives.hide_edit_positive_effect();

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

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        hide_edit_negative_effect: function(){
            document.querySelector(".js-edit-negative-effect").classList.add('hide');
        },

        edit_negative_effect: function(negative_effect_id){

            document.querySelector(".js-edit-negative-effect").classList.remove('hide');
            console.log(negative_effect_id);
            mnge_contraceptives.edit_id = negative_effect_id;
            let method_name = mnge_contraceptives.selectOptionName;

            document.querySelector(".js-negative-method-name").innerHTML = method_name;

            let data = document.querySelector("#negative_contraceptive_"+negative_effect_id).getAttribute("row");
			data = data.replaceAll('\\"','"');
			data = JSON.parse(data);
            
            console.log(data);
            if(typeof data == 'object') {
				document.querySelector(".js-edit-disadvantage-input").value = data.negative_effect_desc;
			} else {
				alert("Invalid post data");
			}
        },

        save_edited_negative_effect: function(e){

            e.preventDefault();
            let disadvantages_input = document.querySelector(".js-edit-disadvantage-input").value.trim();
            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectOptionName;
            let negative_effect_id = mnge_contraceptives.edit_id;
            console.log(negative_effect_id, disadvantages_input, selected_method_id, selected_method_name);
            //return;
            let form = new FormData();
            form.append('negative_effect_id', negative_effect_id);
            form.append('disadvantages_input', disadvantages_input);
            form.append('data_type', 'edit_negative_desc');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);
                            mnge_contraceptives.hide_edit_negative_effect();

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

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        hide_edit_fyi: function(){
            document.querySelector(".js-edit-fyi").classList.add('hide');
        },

        edit_fyi: function(fyi_id){

            document.querySelector(".js-edit-fyi").classList.remove('hide');
            console.log(fyi_id);
            mnge_contraceptives.edit_id = fyi_id;
            let method_name = mnge_contraceptives.selectOptionName;

            document.querySelector(".js-fyi-name").innerHTML = method_name;

            let data = document.querySelector("#fyi_contraceptive_"+fyi_id).getAttribute("row");
            data = data.replaceAll('\\"','"');
            data = JSON.parse(data);

            console.log(data);
            if(typeof data == 'object') {
                document.querySelector(".js-edit-fyi-input").value = data.fyi_desc;
            } else {
                alert("Invalid post data");
            }
        },

        save_edited_fyi: function(e){

            e.preventDefault();
            let fyi_input = document.querySelector(".js-edit-fyi-input").value.trim();
            let selected_method_id = mnge_contraceptives.selectOption;
            let selected_method_name = mnge_contraceptives.selectOptionName;
            let fyi_id = mnge_contraceptives.edit_id;
            console.log(fyi_input, fyi_input, selected_method_id, selected_method_name);
            //return;
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
                            mnge_contraceptives.loadData(selected_method_id, selected_method_name);
                            mnge_contraceptives.hide_edit_fyi();

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

            ajax.open('post','testing_only.php', true);
            ajax.send(form);
        },

        hide_positive_negative_effect: function(){
            document.querySelector(".js-add-positive-negative-effect").classList.add('hide');
        },

        add_positive_negative_effect: function(){
            document.querySelector(".js-add-positive-negative-effect").classList.remove('hide');
        },

    };

    document.addEventListener("DOMContentLoaded", function() {
        let selectOption = document.getElementById("select_contraceptive");
        mnge_contraceptives.loadDefaultData();
        selectOption.addEventListener("change", function() {
            let selectedOption = selectOption.value;
            let selectedOptionElement = selectOption.options[selectOption.selectedIndex]; // Get the selected option element
            let selectedOptionName = selectedOptionElement.getAttribute("data-name"); // Or use selectedOptionElement.dataset.name;
            //alert(selectedOptionName);
            mnge_contraceptives.loadData(selectedOption, selectedOptionName);
        });
    });
    
    mnge_contraceptives.load_contraceptives();
    mnge_contraceptives.load_contraceptive_list();
        
</script>

