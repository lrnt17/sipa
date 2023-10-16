<?php 
    require("connect.php");
    require('functions.php');

    //echo $_SESSION['USER']['user_id']."<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Comparison Chart | SiPa</title>
</head>
<style>
    .chart_link{
        color: var(--bs-navbar-active-color) !important;
      }
    body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }

    .skiptranslate iframe  {
        visibility: hidden !important;
        }
        
    .column-1 {
        background-color: lightblue;
    }

    .rating {
    font-size: 30px;
    }

    .star {
    color: #DBDBDB;
    transition: color 0.2s;
    font-size:20px;
    }

    .star.active {
    color: #915E98;
    font-size:20px;
    }

    .js-method-icon{
        width: 50px;
        height: 50px;
    }

    .js-blank-div{
        width: 50px;
        height: 50px;
    }
    
/**
 * A variation on Scrolling shadows by @kizmarh and @leaverou
 * See http://lea.verou.me/2012/04/background-attachment-local/
 * Only works in browsers supporting background-attachment: local; & CSS gradients
 * Degrades gracefully
 */


/* Apply shadows to the entire table */
.table-con table {
    position: relative;
    z-index: 0; /* Ensure the table content is behind the shadows */
    width: auto;
}

/* Apply shadows to the background of the table-con container */
.table-con {
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


    table {
        border-collapse: separate; /* Use 'separate' to have space between cells */
        display: inline-block;
        min-width: 100%;
    }
    table td {
      border: 3px solid #D2E0F8; /* Adding a border for demonstration */
    }
    
    table tr{
        background-color: rgba(0,0,0,.1);
    }

    table.js-chart td:hover {
      background-color: #DBDBDB; /* Change this to the desired hover background color */
      
    }
    .methodcell {
        /* Allow the scrollable column to take remaining space */
        /* Optional: Add styles for the scrollable column */
    }

    table td.fixed {
    position: sticky;
    left: 0;
    background-color: #D2E0F8 !important; /* You can adjust the background color */
    z-index: 2; /* Ensure the fixed cell is above the scrollable content */
    border: #D2E0F8;
}
   
.rotate{
        display:none;
    }

    @media (max-width: 450px) {
            .rotate{
                display: flex;
            }
            .compare{
                font-size: 1.4rem !important;
            }
        }
</style>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Comparison</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Chart</p></div>
        </div>
    </div>

    <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center;">
                   Compare and contrast different contraceptive methods with just a glimpse!               
                </div>
                
              </div>
            </div>
    </div>

    <div class="container mt-3"> <!-- mt-3-->
        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl-header" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;">
                </div>
            </div>
        
            <div class="col-auto">
                <h3 class="compare" style="font-weight:400;"><b>Compare</b> contraceptive methods</h3>
                <p style="">Hover over the birth control icon to view its name.</p>
            </div>
        </div>

        <div class="rotate p-3  my-4 ms-2 me-2 rounded-4" style="background: #F2C1A7;">
            <p align="justify" style="font-weight:500; margin:0;">Rotate your phone to landscape mode for a better view.</p>
        </div>

    <section class="js-comparison-chart">
        <?php include('compare-methods.php') ?>
    
        <!-- ///////////////////////////////////////////////////////////////////// -->
        <div class="container table-con pt-4 pb-2 rounded-bottom-4 mb-4" style="
            padding: 0;
            margin: 0;">
                <table class="js-chart table">
                    <tbody>
                        <tr>
                            <!-- table content here -->
                        </tr>
                    </tbody>
                </table>
        </div>
    </section>

    <div class="container">
    <div class="d-flex flex-row-reverse">
        <div class="stars px-3 rounded-4 mb-5 shadow-sm" style="background-color: white;">
            <div class="row">
                <div class="col-auto mx-3">
                    <div class="row" style="display: flex;align-items: center !important;">
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col">
                            <p style="margin-top: 1rem;">Bad</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto mx-3">
                    <div class="row" style="display: flex;align-items: center !important;">
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col">
                            <p style="margin-top: 1rem;">Good</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto mx-3">
                    <div class="row" style="display: flex;align-items: center !important;">
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #DBDBDB;"></i>
                        </div>
                        <div class="col">
                            <p style="margin-top: 1rem;">Better</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto mx-3">
                    <div class="row" style="display: flex;align-items: center !important;">
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col" style="padding: 0px;">
                            <i class="fa-solid fa-star" style="color: #915E98;"></i>
                        </div>
                        <div class="col">
                            <p style="margin-top: 1rem;">Best</p>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
     
    </div>
  </div>
</div>


    <!-- Template for table row -->
    <template id="chart-template">
        <tr>
            <td class="js-name"></td>
            <td class="js-effectivity"></td>
            <td class="js-control-duration"></td>
        </tr>
    </template>

    <template id="chart">
        <td>
            <img src="assets/images/contraceptive.png" alt="sample" class="js-method-icon">
            <div class="js-effectiveness"></div>
        </td>
    </template>

    <?php include('footer.php') ?>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
    var comparison_chart = {

        load_chart2: function() {
            
            let form = new FormData();
            form.append('data_type', 'load_chart');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        //console.log(ajax.responseText);

                        // Get the thead element - for method name/icon
                        let thead = document.querySelector("#comparison-chart thead");
                        let row1 = document.createElement("tr");
                        
                        // Get the tbody element
                        let tbody = document.querySelector("#comparison-chart tbody");
                        let row2 = document.createElement("tr");

                        if(data.success){
                            
                            let blankCell = document.createElement("th");
                            row1.appendChild(blankCell);

                            for (let i = 0; i < data.chart_data.length; i++) {
                                let cell = document.createElement("th");
                                cell.innerHTML = data.chart_data[i].birth_control_name;
                                cell.classList.add("column-" + (i+1)); 
                                row1.appendChild(cell);
                            }

                            //icon yung header (th) instead na name
                            //----------------------------------------------------------

                            let cell_effectiveness = document.createElement("th");
                            cell_effectiveness.innerHTML = "effectiveness";
                            row2.appendChild(cell_effectiveness);

                            /*for (let i = 0; i < data.chart_data.length; i++) {
                                let cell = document.createElement("th");
                                cell.innerHTML = data.chart_data[i].birth_control_effectivity_rate;
                                cell.classList.add("column-" + (i+1));
                                row2.appendChild(cell);
                            }*/
                            for (let i = 0; i < data.chart_data.length; i++) {
                                let cell = document.createElement("th");
                                cell.classList.add("column-" + (i+1));
                                // Create a div element to hold the stars
                                let starsDiv = document.createElement("div");
                                starsDiv.classList.add("rating", "py-4");

                                // Create the star elements
                                for (let j = 0; j < 3; j++) {
                                    let starSpan = document.createElement("span");
                                    starSpan.classList.add("star");

                                    let starIcon = document.createElement("i");
                                    starIcon.classList.add("fas", "fa-star");

                                    // Fill up stars based on the value
                                    if (j < data.chart_data[i].birth_control_effectivity_rate) {
                                        starSpan.classList.add("active");
                                    }

                                    starSpan.appendChild(starIcon);
                                    starsDiv.appendChild(starSpan);
                                }

                                cell.appendChild(starsDiv);
                                row2.appendChild(cell);
                            }
                            //----------------------------------------------------------
                        }
                        thead.appendChild(row1);
                        tbody.appendChild(row2);
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        load_chart3: function() {
            let form = new FormData();
            form.append('data_type', 'load_chart');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){
                if(ajax.readyState == 4) {
                    if(ajax.status == 200){
                        let data = JSON.parse(ajax.responseText);
                        let tbody = document.querySelector(".js-chart tbody");
                        tbody.innerHTML = "";
                        
                        let template = document.querySelector("#chart");

                        if(data.success){

                            let blanktd = document.createElement("td");
                            
                            let div1 = document.createElement("div");
                            div1.classList.add("js-blank-div");

                            let div2 = document.createElement("div");
                            
                            let h3 = document.createElement("h3");
                            h3.textContent = "effectiveness";
                            div2.appendChild(h3);

                            blanktd.appendChild(div1);
                            blanktd.appendChild(div2);
                            tbody.appendChild(blanktd);

                            for (let i = 0; i < data.chart_data.length; i++) {
                                let clone = template.content.cloneNode(true);
                                let effectivenessDiv = clone.querySelector(".js-effectiveness");

                                // Create a div element to hold the stars
                                let starsDiv = document.createElement("div");
                                starsDiv.classList.add("rating", "py-4");

                                // Create the star elements
                                for (let j = 0; j < 3; j++) {
                                    let starSpan = document.createElement("span");
                                    starSpan.classList.add("star");

                                    let starIcon = document.createElement("i");
                                    starIcon.classList.add("fas", "fa-star");

                                    // Fill up stars based on the value
                                    if (j < data.chart_data[i].birth_control_effectivity_rate) {
                                        starSpan.classList.add("active");
                                    }

                                    starSpan.appendChild(starIcon);
                                    starsDiv.appendChild(starSpan);
                                }

                                effectivenessDiv.appendChild(starsDiv);
                                tbody.appendChild(clone);
                            }
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
        
        load_chart: function() {

            let table = document.querySelector('.js-chart');
            let row = table.querySelector('tr');

            let form = new FormData();
            form.append('data_type', 'load_chart');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){
                if(ajax.readyState == 4) {
                    if(ajax.status == 200){

                        let response = JSON.parse(ajax.responseText);
                        let data = response.chart_data;

                        // Create a cell for the column names
                        let columnNamesCell = document.createElement('td');
                        columnNamesCell.classList.add("fixed");
                        columnNamesCell.style.background="";
                        row.appendChild(columnNamesCell);

                        if(response.success){

                            // Add the column names to the column names cell
                            if (data.length > 0) {
                                // Create a div element to hold the stars
                                let nameDiv = document.createElement("div");
                                nameDiv.classList.add("nameDiv","px-1", "mx-4");
                                nameDiv.style.width="150px";
                                nameDiv.style.height="530px";
                                for (var key in data[0]) {
                                    // Skip the birth_control_chart_id and birth_control_id columns
                                    if (key === 'birth control chart id' || key === 'birth control id' || key === 'birth control name') {
                                        continue;
                                    }

                                    var columnName = document.createElement('p');
                                    //columnName.textContent = key;
                                    // Check if the key is 'birth control icons'
                                    if (key === 'birth control icon') {
                                        columnName.textContent = 'birth controls';
                                    } else {
                                        columnName.textContent = key;
                                    }
                                    columnName.classList.add("py-4", "mb-3",);
                                    columnName.style.textAlign = "right";
                                    nameDiv.appendChild(columnName);
                                }
                                
                                columnNamesCell.appendChild(nameDiv);
                            }

                            // Loop through the data and create a new cell for each contraceptive method
                            for (var i = 0; i < data.length; i++) {
                                var methodCell = document.createElement('td');
                                methodCell.classList.add("methodcell","px-2", "rounded-3");
                               // methodCell.style.width="150px";
                                
                                //methodCell.style.background="#F4F7FF"
                                row.appendChild(methodCell);

                                // Loop through the columns for this contraceptive method
                                for (var key in data[i]) {
                                    // Skip the birth_control_chart_id and birth_control_id columns
                                    if (key === 'birth control chart id' || key === 'birth control id' || key === 'birth control name') {
                                        continue;
                                    }

                                    // Check if this is the birth_control_icon column
                                    if (key === 'birth control icon') {
                                        // Create an img element to display the image
                                        let imgElement = document.createElement("img");
                                        imgElement.src = data[i][key];
                                        imgElement.title = data[i]['birth control name'];
                                        imgElement.width = 55;
                                        imgElement.height = 55;
                                        imgElement.classList.add("mx-2");
                                        methodCell.appendChild(imgElement);
                                    } else {
                                        // Create a div element to hold the stars
                                        let starsDiv = document.createElement("div");
                                        starsDiv.classList.add("rating", "py-4");

                                        // Create the star elements
                                        for (let j = 0; j < 3; j++) {
                                            let starSpan = document.createElement("span");
                                            starSpan.classList.add("star");

                                            let starIcon = document.createElement("i");
                                            starIcon.classList.add("fas", "fa-star");

                                            // Fill up stars based on the value
                                            if (j < data[i][key]) {
                                                starSpan.classList.add("active");
                                            }

                                            starSpan.appendChild(starIcon);
                                            starsDiv.appendChild(starSpan);
                                        }

                                        // Add the stars to the method cell
                                        methodCell.appendChild(starsDiv);
                                    }
                                }
                            }
                        }

                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

    comparison_chart.load_chart();



</script>






</html>