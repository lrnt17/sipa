<?php 
    require('../connect.php');
    require('../functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraceptive Side-by-Side | SiPa</title>
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

        /* Main content */
        .main {
        margin-left: 200px; /* Same as the width of the sidenav */
        font-size: 13px; /* Increased text to enable scrolling */
        padding: 0px 10px;
        }

        /* Add an active class to the active dropdown button */
        .active {
        background-color: green;
        color: white;
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
</head>
<body>
    <section class="main">
        <?=$_SESSION['USER']['user_id']; ?>
        <?php include('header.php') ?>

        <div>
            <h1>Contraceptive Side-by-Side</h1>
            <div>
                <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive-table-alongside">
                    <thead></thead>
                    <tbody></tbody>
                </table>
                <br>
            </div>
        </div>

        <div>
            <h1>Add New Factor</h1>
            <form onsubmit="contraceptive_alongside.add_column(event)" method="post">
                <div class="">
                    <label class="">
                        Factor Name:
                    </label>
                    <input type="text" name="factor_name" class="js-factor-name"  required="true">
                </div>
                <div class="">
                    <button class="">Add Factor</button>
                </div>
            </form>
        </div>

        <div>
            <h1>Rename a Factor</h1>
            <form onsubmit="contraceptive_alongside.edit_column(event)" method="post">
                <div class="">
                    <label class="">Old Factor Name:</label>
                    <input type="text" name="old_factor_name" class="js-old-factor-name" required="true">
                </div>
                <div class="">
                    <label class="">New Factor Name:</label>
                    <input type="text" name="new-factor_name" class="js-new-factor-name" required="true">
                </div>
                <div class="">
                    <button class="">Rename Factor</button>
                </div>
            </form>
        </div>

        <div class="js-edit-alongside-row hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="contraceptive_alongside.close_modal()">X</div>
            <h1>Edit Contraceptive Chart</h1>
            <div>
                <form>
                    <!-- Input fields will be added dynamically using JavaScript -->
                </form>
            </div>
        </div>

    </section>
</body>
<script>

    var contraceptive_alongside = {

        load_contraceptive_sidebyside: function(){

            let tableHead = document.querySelector('#contraceptive-table-alongside thead');
            let tableBody = document.querySelector('#contraceptive-table-alongside tbody');

            let form = new FormData();
            form.append('data_type', 'load_contraceptive_sidebyside');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        console.log(obj);
                        
                        if(obj.success){
                            console.log(obj.columns);
                            
                            // Populate table headers
                            let headerRow = tableHead.insertRow();

                            for (let column in obj.columns) {
                                let th = document.createElement('th');
                                th.textContent = obj.columns[column].replace(/_/g, ' ');
                                headerRow.appendChild(th);
                            }

                            let th = document.createElement('th');
                            th.textContent = 'Action';
                            headerRow.appendChild(th);
                            //--------------------------------------------
                            // Populate table rows
                            for (let row of obj.rows) {

                                let tr = tableBody.insertRow();
                                tr.setAttribute('sidebyside_id', row.sidebyside_id);
                                let rowData = [];

                                for (let column in obj.columns) {
                                    let td = tr.insertCell();
                                    td.textContent = row[obj.columns[column]];
                                    rowData.push(row[obj.columns[column]]);
                                }

                                tr.setAttribute('data-row', JSON.stringify(rowData));

                                let td = document.createElement('td');
                                td.textContent = 'Edit';
                                td.classList.add('editButton');
                                td.setAttribute('onclick',`contraceptive_alongside.edit_row('${row.sidebyside_id}')`);
                                td.style = 'cursor:pointer;color:blue;';
                               
                                tr.appendChild(td);
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

        add_column: function(e){

            e.preventDefault();

            function replaceSpacesWithUnderscores(inputValue) {
                return inputValue.replace(/\s/g, '_');
            }

            let factorInput = document.querySelector(".js-factor-name").value.trim();
            // Call the function to replace spaces with underscores
            let factor_name = replaceSpacesWithUnderscores(factorInput);

            let form = new FormData();

            form.append('column_name', factor_name);
            form.append('data_type', 'add_new_column_sidebyside');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            document.querySelector(".js-factor-name").value = '';
                            window.location.reload();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        edit_column: function(e) {

            e.preventDefault();

            function replaceSpacesWithUnderscores(inputValue) {
                return inputValue.replace(/\s/g, '_');
            }

            let old_factorInput = document.querySelector(".js-old-factor-name").value.trim();
            let new_factorInput = document.querySelector(".js-new-factor-name").value.trim();
            
            // Call the function to replace spaces with underscores
            let old_factor_name = replaceSpacesWithUnderscores(old_factorInput);
            let new_factor_name = replaceSpacesWithUnderscores(new_factorInput);

            let form = new FormData();
            console.log(old_factor_name, new_factor_name);
            form.append('old_column_name', old_factor_name);
            form.append('new_column_name', new_factor_name);
            form.append('data_type', 'modify_column_name_sidebyside');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        alert(obj.message);

                        if(obj.success){
                            document.querySelector(".js-old-factor-name").value = '';
                            document.querySelector(".js-new-factor-name").value = '';
                            window.location.reload();
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        edit_row: function(sidebyside_id) {
            
            document.querySelector('.js-edit-alongside-row').classList.remove('hide');
            
            let form = new FormData();
            form.append('sidebyside_id', sidebyside_id);
            form.append('data_type', 'load_data_edit_sidebyside');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
                        let data = JSON.parse(ajax.responseText);
                       
                        let form = document.querySelector(".js-edit-alongside-row form");
                        form.innerHTML = "";
                        
                        let excludedColumns = ["sidebyside_id", "birth_control_id", "birth_control_icon"];

                        if(data.success){
                            let sidebysideRowData = data.sidebyside_row_data[0];

                            for (let key in sidebysideRowData) {
                                console.log(key);
                                if (!excludedColumns.includes(key)) {

                                    if (key === "birth_control_name") {

                                        let div = document.createElement("div");
                                        let span = document.createElement("span");
                                        span.textContent = sidebysideRowData[key];
                                        div.innerHTML = key.replace(/_/g, ' ') + ": ";
                                        div.appendChild(span);
                                        form.appendChild(div);

                                    } else {
                                    
                                        let label = document.createElement("label");
                                        label.textContent = key.replace(/_/g, ' ') + ": ";

                                        let input = document.createElement("input");
                                        input.setAttribute('type', 'text');
                                        input.setAttribute('name', key);
                                        input.setAttribute('max', 100);
                                        input.value = sidebysideRowData[key];
                                        /*input.addEventListener('keydown', function(event) {
                                            event.preventDefault(); // Prevent any keyboard input
                                        });*/

                                        let br = document.createElement("br");

                                        form.appendChild(br);
                                        form.appendChild(label);
                                        form.appendChild(input);
                                    }
                                }
                            }

                            let br = document.createElement("br");
                            let saveButton = document.createElement("button");
                            saveButton.textContent = 'Save';

                            form.appendChild(br);
                            form.appendChild(saveButton);

                            // save row
                            saveButton.addEventListener("click", function (event) {
                                event.preventDefault();
                                let formData = new FormData(form);

                                formData.append("sidebyside_id", sidebyside_id);
                                formData.append("data_type", "update_sidebyside_row");

                                var ajax = new XMLHttpRequest();
                                ajax.addEventListener('readystatechange',function(){

                                        if(ajax.readyState == 4)
                                        {
                                            if(ajax.status == 200){

                                                let obj = JSON.parse(ajax.responseText);
                                                alert(obj.message);

                                                if(obj.success){
                                                    window.location.reload();
                                                }
                                            }else{
                                                alert("Please check your internet connection");
                                            }
                                        }
                                });

                                ajax.open("post", "ajax-admin.php", true);
                                ajax.send(formData);

                            });
                        }

                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },

        close_modal: function() {

            document.querySelector(".js-edit-alongside-row").classList.add('hide');
        },

    };

    contraceptive_alongside.load_contraceptive_sidebyside();
</script>
</html>