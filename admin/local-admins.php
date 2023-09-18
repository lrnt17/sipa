<?php 
    require('../connect.php');
    require('../functions.php');

    $city = $_SESSION['USER']['city_municipality'];
    $facility_name = $_SESSION['USER']['health_facility_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $city?> Administrators | SiPa</title>
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
        <?php include('header.php') ?>

        <!-- List of admins -->
        <div>
            <h1><?= $city?> Administrators</h1>
            <table border ="1" cellspacing="0" cellpadding="10" id="admin_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="bustos_admins.select_all_admins(this);" /></th>
                        <th>Administrators</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br>
            <div onclick="bustos_admins.show_add_admin()" style="cursor:pointer;">Add</div>
            <div onclick="bustos_admins.delete_admin()" style="cursor:pointer;color:red;" id="delete-admin">Delete</div>
        </div>
    </section>

    <template id="row-template">
        <tr>
            <td align="center" id="checkbox">
                <label class="container">
                    <input type="checkbox" class="js-select-admin" name="all_admins[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td>
                <img src="../assets/images/user.jpg" class="js-admin-image" width="25" height="25">
                <p class="js-admin-fullname"></p>
            </td>
            <td class="js-admin-email"></td>
            <td class="js-specialization"></td>
            <td class="js-admin-pnum"></td>
            <td>
                <div class="js-admin-edit-btn" style="cursor:pointer;color:blue;">Edit</div>
                <div class="js-admin-details-btn" style="cursor:pointer;">View Details</div>
            </td>
        </tr>
    </template>
</body>
<script>

    var bustos_admins = {

        load_admins: function(){

            let form = new FormData();

            let city = '<?= $city?>';
            let facility_name = '<?= $facility_name?>';
            //console.log(city, facility_name);return;
            form.append('city_municipality', city);
            form.append('health_facility_name', facility_name);
            form.append('data_type', 'load_local_admins');
            
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);

                        if(data.success){
                            // Get table and template elements
                            let table = document.querySelector("#admin_table tbody");
                            let template = document.querySelector("#row-template");

                            // Generate table rows
                            for (let i = 0; i < data.rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-select-admin").setAttribute('user_id', data.rows[i].user_id);
                                row.querySelector(".js-admin-image").src = data.rows[i].user_image;
                                row.querySelector(".js-admin-fullname").textContent = data.rows[i].user_fname + ' ' + data.rows[i].user_lname;
                                row.querySelector(".js-admin-email").textContent = data.rows[i].user_email;
                                row.querySelector(".js-specialization").textContent = data.rows[i].specialization;
                                row.querySelector(".js-admin-pnum").textContent = data.rows[i].user_pnum;
                                row.querySelector(".js-admin-edit-btn").setAttribute('onclick',`manage_admins.edit_admin('${data.rows[i].user_id}')`);
                                row.querySelector(".js-admin-details-btn").setAttribute('onclick',`manage_admins.view_admin('${data.rows[i].user_id}')`);
                                
                                //copying the content of postCard
                                let clone = row.cloneNode(true);

                                // Get root element of cloned template
                                let rootElement = clone.querySelector(':first-child');
                                rootElement.setAttribute('id','admin_'+data.rows[i].user_id);
                                let row_data = JSON.stringify(data.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                rootElement.setAttribute('row',row_data);

                                table.appendChild(clone);
                            }
                        }
                    }
                }
            });

            ajax.open('post','ajax-admin.php', true);
            ajax.send(form);
        },
    };

    bustos_admins.load_admins();
</script>
</html>