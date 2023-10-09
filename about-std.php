<?php 
    require("connect.php");
    require('functions.php');
    
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

        tr:hover {
            background-color: #FFF2EB !important;
            cursor: pointer; /* Change the cursor to a pointer on hover for better UX */
            border-radius: 10px;
        }

        .horizontal-scroll {
            overflow-x: auto;
        }

        #table-container {
            width: 100%; /* Set the width to 100% to match the table */
            display: block; /* Ensure it takes up the full width */
            overflow-x: auto; /* Add horizontal scrolling if needed */
        }

        #table-container{
            position: relative; /* Make sure the shadows are positioned correctly */
            overflow: auto;
            background-image:
                /* Shadows */
                linear-gradient(to right, #D2E0F8, #D2E0F8),
                linear-gradient(to right, #D2E0F8, #D2E0F8),
            
            /* Shadow covers */
                linear-gradient(to right, rgba(0,0,0,.25), rgba(255,255,255,0)),
                linear-gradient(to left, rgba(0,0,0,.25), rgba(255,255,255,0));

            background-position: left center, right center, left center, right center;
            background-repeat: no-repeat;
            background-color: #D2E0F8;
            background-size: 20px 100%, 20px 100%, 10px 100%, 10px 100%;
            background-attachment: local, local, scroll, scroll;
            
            z-index: 1; /* Ensure the shadows are on top of the table content */
        }
        
        @media (max-width: 768px) {
            .std-img-container {
            display: none; 
            }

            #mytable {
                width: 100%; 
                white-space: nowrap; 
            }
            

            #mytable td.my-table-cell  {
                max-width: 150px; 
            }
            
            #mytable td.my-table-cell p {
                max-width: 100%; 
                white-space: normal;
            }
        }
    </style>
  
</head>
<body style="background: #F2F5FF;">
 
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>


    <div class="container">
        <div class="row my-5">
            <div class="col">
                <div class="row mt-3 mb-5" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 70px;
                        display: -webkit-inline-box;">
                        </div>
                    </div>
                
                    <div class="col-auto">
                            <div class="col-auto"><p style="font-size: 2rem;  font-weight:bolder;">About <span style="font-weight:normal;">STDs</span></p></div>
                    </div>
                </div>


                <div class="std-desc-container mt-2">
                    <p>STDs are infections that are spread from one person to another, usually during vaginal, anal, and oral sex. They’re really common, and lots of people who have them don’t have any symptoms. Without treatment, STDs can lead to serious health problems. But the good news is that getting tested is no big deal, and most STDs are easy to treat.</p>
                </div>

                <div class="button-container" id="button-container">
                    <button class="btn shadow-sm rounded-pill py-2 px-3" style="background-color:#5887DE; color:white;" id="show-table-button">Compare different types of STDs</button>
                </div>
                
            </div>
            <div class="col-auto mb-5">
                <div class="std-img-container">
                    <img src="assets/images/stds/std-illustration.png" alt="about_std" width="400px"></src>
                </div>
            </div>
        </div>
    </div>


    <section class="js-about-std">
        <div class="container rounded-4 shadow-sm p-5 mb-5" id="table-container" style="display: none; background-color:#D2E0F8;">
            <table class="horizontal-scroll" cellpadding="15" id="mytable">
                <thead>
                    <tr style="background-color:#D2E0F8; pointer-events:none; text-align: center;">
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
    <tr data-std-id="" style="background-color:white;">
        <td class="js-type my-table-cell" style="text-align: center;">
            <img src="" alt="std" width="100" class="m-3"><br>
            <span style="font-weight:500; text-wrap: wrap;"></span>
        </td>
        <td class="my-table-cell">
            <p class="js-symptom"></p>
        </td>
        <td class="my-table-cell">
            <p class="js-cause"></p>
        </td>
        <td class="my-table-cell">
            <p class="js-treatment"></p>
        </td>
        <td class="my-table-cell">
            <p class="js-treatment-cost me-4"></p>
        </td>
    </tr>
    <div class="m-4"></div>
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
                var rowElement = clone.querySelector("tr");
                rowElement.dataset.stdId = row.std_id; // Set the std_id as a data attribute
                clone.querySelector(".js-type img").src = row.std_img;
                clone.querySelector(".js-type img").alt = row.std_name;
                clone.querySelector(".js-type span").textContent = row.std_name;
                clone.querySelector(".js-symptom").textContent = row.std_symptom;
                clone.querySelector(".js-cause").textContent = row.std_cause;
                clone.querySelector(".js-treatment").textContent = row.std_treatment;
                clone.querySelector(".js-treatment-cost").textContent = row.std_treatment_cost;
                
                // Add an event listener to the row for redirection
                rowElement.addEventListener("click", function () {
                    var stdId = this.dataset.stdId;
                    window.location.href = "about-std-info.php?id=" + stdId;
                });

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
            var buttonContainer = document.getElementById("button-container");
            var showTableButton = document.getElementById("show-table-button");

                if (tableContainer.style.display === "none") {
                    // Show the table and change the button text
                    tableContainer.style.display = "block";
                    buttonContainer.style.display = "none";
                } 
        }
        
        // Function to scroll to the table
        function scrollToTable() {
            var tableContainer = document.getElementById("table-container");
            tableContainer.scrollIntoView({ behavior: "smooth" }); // This will scroll to the table with smooth animation
        }


        // Add an event listener to the button to toggle the table visibility
        var showTableButton = document.getElementById("show-table-button");
        showTableButton.addEventListener("click", toggleTableVisibility);
        showTableButton.addEventListener("click", scrollToTable);

    </script>

</html>
