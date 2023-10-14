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
    <title>Contraceptive Chart | SiPa</title>
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
                                <h2 style="font-weight: 400;"><b>Contraceptive</b> Chart</h2>
                            </div>
                        </div>
                    </div>
                </div>
            <div>
            <div>
                <table border ="1" cellspacing="0" cellpadding="10" id="contraceptive-table-chart" class="table-bordered">
                    <thead></thead>
                    <tbody></tbody>
                </table>
                <br>
            </div>
        </div>

        <div>
            <h1>Add New Factor</h1>
            <form onsubmit="contraceptive_chart.add_column(event)" method="post">
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

        <div class="js-edit-chart-row hide">
            <div class="" style="float:right;cursor:pointer;margin:10px;padding:5px;padding-left:10px;padding-right:10px;" onclick="contraceptive_chart.close_modal()">X</div>
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
    var contraceptive_chart = {

        load_contraceptive_chart: function(){

            let tableHead = document.querySelector('#contraceptive-table-chart thead');
            let tableBody = document.querySelector('#contraceptive-table-chart tbody');
            
            let form = new FormData();
            form.append('data_type', 'load_contraceptive_chart');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        console.log(obj);
                        
                        if(obj.success){
                            console.log(obj.columns);
                            //let selectedRow = document.querySelector('.selectedRow');
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
                                tr.setAttribute('birth_control_chart_id', row.birth_control_chart_id);
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
                                td.setAttribute('onclick',`contraceptive_chart.edit_row('${row.birth_control_chart_id}')`);
                                td.style = 'cursor:pointer;color:blue;';
                                /*td.addEventListener('click', function() {
                                    // Add class to highlight the selected row
                                    if (selectedRow) {
                                        selectedRow.classList.remove('selectedRow');
                                    }
                                    tr.classList.add('selectedRow');
                                });*/
                                tr.appendChild(td);
                            }

                            // Add a click event listener to each "Edit" button
                            /*tableBody.addEventListener('click', function(event) {
                                console.log('test');
                                if (event.target.classList.contains('editButton')) {
                                    console.log('hoy');
                                    document.querySelector('.js-edit-chart-row').classList.remove('hide');
                                    let rowData = JSON.parse(event.target.closest('tr').getAttribute('data-row'));

                                    let editForm = document.querySelector('.js-display-form');
                                    editForm.innerHTML = ''; // Clear previous input fields
                                    console.log(editForm);
                                    console.log(obj.columns);
                                    let columnNames = Object.values(obj.columns);
                                    console.log(columnNames.length);
                                    for (let i = 0; i < columnNames.length; i++) {
                                        let columnName = columnNames[i].replace(/_/g, ' ');
                                        let input = document.createElement('input');
                                        input.type = 'text';
                                        input.id = `edit_${columnNames[i]}`;
                                        input.value = rowData[i];

                                        let label = document.createElement('label');
                                        label.textContent = columnName;
                                        label.for = `edit_${columnNames[i]}`;

                                        let br = document.createElement('br');

                                        editForm.appendChild(br);
                                        editForm.appendChild(label);
                                        editForm.appendChild(input);
                                    }

                                    let br = document.createElement('br');
                                    editForm.appendChild(br);
                                    // Add a "Save" button to the form
                                    let saveButton = document.createElement('button');
                                    saveButton.textContent = 'Save';
                                    editForm.appendChild(saveButton);

                                    // Add a click event listener to the "Save" button
                                    saveButton.addEventListener('click', function(event) {
                                        event.preventDefault();

                                        let updatedData = [];
                                        for (let i = 0; i < columnNames.length; i++) {
                                            let input = document.getElementById(`edit_${columnNames[i]}`);

                                            console.log(input.value);
                                            //updatedData.push(input.value);
                                        }

                                        // Update the row data in the table and close the form
                                        //let selectedRow = document.querySelector('.selectedRow');
                                        for (let i = 0; i < updatedData.length; i++) {
                                            selectedRow.cells[i].textContent = updatedData[i];
                                        }

                                        // Clear the form
                                        //editForm.innerHTML = '';
                                    });
                                }
                            });*/
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
            form.append('data_type', 'add_new_column');

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

        edit_row: function(birth_control_chart_id) {
            
            document.querySelector('.js-edit-chart-row').classList.remove('hide');
            
            let form = new FormData();
            form.append('birth_control_chart_id', birth_control_chart_id);
            form.append('data_type', 'load_data_edit_chart');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
                        let data = JSON.parse(ajax.responseText);
                       
                        let form = document.querySelector(".js-edit-chart-row form");
                        form.innerHTML = "";
                        
                        let excludedColumns = ["birth_control_chart_id", "birth_control_id", "birth_control_icon"];

                        if(data.success){
                            let chartRowData = data.chart_row_data[0];

                            for (let key in chartRowData) {
                                console.log(key);
                                if (!excludedColumns.includes(key)) {

                                    if (key === "birth_control_name") {

                                        let div = document.createElement("div");
                                        let span = document.createElement("span");
                                        span.textContent = chartRowData[key];
                                        div.innerHTML = key.replace(/_/g, ' ') + ": ";
                                        div.appendChild(span);
                                        form.appendChild(div);

                                    } else {
                                    
                                        let label = document.createElement("label");
                                        label.textContent = key.replace(/_/g, ' ') + ": ";

                                        let input = document.createElement("input");
                                        input.setAttribute('type', 'number');
                                        input.setAttribute('name', key);
                                        input.setAttribute('min', 0);
                                        input.setAttribute('max', 3);
                                        input.value = chartRowData[key];
                                        input.addEventListener('keydown', function(event) {
                                            event.preventDefault(); // Prevent any keyboard input
                                        });

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

                                formData.append("birth_control_chart_id", birth_control_chart_id);
                                formData.append("data_type", "update_chart_row");

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

            document.querySelector(".js-edit-chart-row").classList.add('hide');
        },

    };

    contraceptive_chart.load_contraceptive_chart();
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