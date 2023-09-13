<?php 
    require("connect.php");
    require('functions.php');
    
    //echo $_SESSION['USER']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-ico">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    
    <title>SiPa | About STDs</title>
    
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }

        
        
        .skiptranslate iframe  {
        visibility: hidden !important;
        }
        
        

        
    </style>
  
</head>
<body style="background: #F2F5FF;">
 
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>


    

    <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;">
                </div>
            </div>
        
            <div class="col-auto mt-3">
                    <div class="col-auto"><p style="font-size: 2rem;  font-weight:bolder;">About <span style="font-weight:normal;">STDs</span></p></div>
            </div>
     </div>


     <div class="std-desc-container">
        <p>STDs are infections that are spread from one person to another, usually during vaginal, anal, and oral sex. They’re really common, and lots of people who have them don’t have any symptoms. Without treatment, STDs can lead to serious health problems. But the good news is that getting tested is no big deal, and most STDs are easy to treat.</p>
     </div>
    <div class="button-container">
        <button id="show-table-button">Compare different types of STDs</button>
    </div>
     <div class="std-img-container">
        <img src="assets/images/stds/std-illustration.png" alt="about_std" width="400px"></src>
    </div>

    <section class="js-about-std">
        <div id="table-container" style="display: none;">
            <table border ="1" cellspacing="0" cellpadding="10" id="mytable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Symptoms</th>
                        <th>Causes</th>
                        <th>Treatments</th>
                        <th>Treatment Cost</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
</section>


<!-- HTML template for table rows -->
<template id="row-template">
    <tr>
        <td class="js-type">
            <img src="" alt="std" width="100"><br>
            <span></span>
        </td>
        <td class="js-symptom"></td>
        <td class="js-cause"></td>
        <td class="js-treatment"></td>
        <td class="js-treatment-cost"></td>
    </tr>
</template>
    
    


<?php include('footer.php') ?>

</body>

<script>
        // Function to populate and append table rows
        function populateTable(data) {
            var template = document.getElementById("row-template");
            var tbody = document.querySelector("#mytable tbody");

            data.forEach(function (row) {
                var clone = document.importNode(template.content, true);
                clone.querySelector(".js-type img").src = row.std_img;
                clone.querySelector(".js-type img").alt = row.std_name;
                clone.querySelector(".js-type span").textContent = row.std_name;
                clone.querySelector(".js-symptom").textContent = row.std_symptom;
                clone.querySelector(".js-cause").textContent = row.std_cause;
                clone.querySelector(".js-treatment").textContent = row.std_treatment;
                clone.querySelector(".js-treatment-cost").textContent = row.std_treatment_cost;
                tbody.appendChild(clone);
            });
        }

        // Fetch data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "about-std-fetch-data.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var responseData = JSON.parse(xhr.responseText);
                populateTable(responseData);
            }
        };

        xhr.send();


        // Function to show/hide the table
        function toggleTableVisibility() {
            var tableContainer = document.getElementById("table-container");
            var showTableButton = document.getElementById("show-table-button");

                if (tableContainer.style.display === "none") {
                    // Show the table and change the button text
                    tableContainer.style.display = "block";
                    showTableButton.textContent = "Hide STDs";
                } else {
                    // Hide the table and change the button text
                    tableContainer.style.display = "none";
                    showTableButton.textContent = "Compare different types of STDs";
                }
        }


        // Add an event listener to the button to toggle the table visibility
        var showTableButton = document.getElementById("show-table-button");
        showTableButton.addEventListener("click", toggleTableVisibility);
    </script>

</html>
