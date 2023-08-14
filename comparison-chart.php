<?php 
    require("connect.php");
    require('functions.php');

    echo $_SESSION['USER']['user_id']."<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparison Chart | SiPa</title>
</head>
<style>
    .column-1 {
        background-color: lightblue;
    }

    .rating {
    font-size: 30px;
    }

    .star {
    color: grey;
    transition: color 0.2s;
    }

    .star.active {
    color: purple;
    }

    .js-method-icon{
        width: 50px;
        height: 50px;
    }

    .js-blank-div{
        width: 50px;
        height: 50px;
    }
    
    #prices {
        max-width: 1200px;
        margin: auto;
        /*width: 100%;*/
        font-family: 'open sans';
        font-weight: normal;
    }

    .pricing-table {
        /*width: 95%;*/
        margin: auto auto 20px auto;
        position: relative;
        min-height: 340px;
        padding-bottom: 55px;
        text-align: center;
        background: #fff;
    }

    .pricing-table td {
        /*width: 33%;*/
        vertical-align: top;
    }

    .pricing-table h2 {
        display: block;
        margin-bottom: 0px;
        padding: 10px;
        font-size: 1.4em;
        background: #009342; /* Set the desired color directly */
        font-weight: 800;
        text-transform: uppercase;
    }

    #prices td:last-child h2 {
        background: #018FFF; /* Set the desired color directly */
    }

    .pricing-table h3 {
        display: block;
        margin: 0;
        padding: 0 0 10px;
        background: #102e5c;
        font-size: 0.9em;
    }

    #prices td:last-child h3 {
        background: #018FFF; /* Set the desired color directly */
    }

    .pricing-table h4 {
        display: block;
        margin: 0;
        /*width: 100%;*/
        padding: 20px;
        background: #30B643; /* Set the desired color directly */
        font-size: 1.75em;
        box-sizing: border-box;
    }

    #prices td:last-child h4 {
        background: #39B5FF; /* Set the desired color directly */
    }

    .pricing-table h5 {
        display: block;
        margin: 0 0 15px 0;
        font-weight: 700;
        padding: 10px;
        background: #44D354; /* Set the desired color directly */
    }

    #prices td:last-child h5 {
        background: #65CAFC; /* Set the desired color directly */
    }

    .pricing-table h2,
    .pricing-table h3,
    .pricing-table h4,
    .pricing-table h5 {
        color: #fff;
    }

    /* Popular Table */

    .popular .pricing-table {
        margin-top: -10px;
        min-height: 400px;
    }

    .popular .pricing-table h2 {
        font-size: 1.8em;
        background: #FF9138; /* Set the desired color directly */
    }

    .popular .pricing-table h3 {
        background: #FF9138; /* Set the desired color directly */
    }

    .popular .pricing-table h4 {
        background: #FEB63D; /* Set the desired color directly */
    }

    .popular .pricing-table h5 {
        background: #F7CD6F; /* Set the desired color directly */
    }

    .pricing-table p {
        margin: 10px auto;
        padding: 5px 0 5px;
        width: 80%;
        font-weight: 300;
        border-top: 1px solid rgba(0,0,0,0.1);
    }

    .pricing-table h5 + p {
        
    }

    .pricing-table a {
        display: block;
        margin: auto;
        width: 45%;
        padding: 10px 0;
        position: absolute;
        bottom: 15px;
        left: 0;
        right: 0;
        font-size: 0.85em;
        color: #fff;
        background: #2F333C;
        text-decoration: none;
        text-transform: uppercase;
        transition: all .3s ease-in-out;
    }

    .popular .pricing-table a {
        background: #2F333C;
    }

    .pricing-table a:hover {
        background: #505A6B;
    }

    /*------------------------------------*/
    /*---------- MEDIA QUERIES -----------*/
    /*------------------------------------*/

    @media screen and (max-width: 700px) {
        #prices td {
        display: block !important;
        width: 100% !important;
        }
        .pricing-table {
        min-height: 0;
        }
        .popular .pricing-table {
        margin-top: 0px;
        }
    }

    .hide{
        display:none;
    }

</style>
<body>

    <section class="js-comparison-chart">
        <?php include('compare-methods.php') ?>
        <!--<div>
            <table id="comparison-chart" border="1">
                <thead class="js-icons">

                </thead>
                <tbody></tbody>
            </table>
        </div>-->
        
        <table id="prices">
            <tbody>
                <tr>
                    <td>
                        <h2></h2>
                        <h4></h4>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                    </td>
                    <td>
                        <h2></h2>
                        <h4></h4>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                    </td>
                    <td>
                        <h2></h2>
                        <h4></h4>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                        <p>Feature List</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ///////////////////////////////////////////////////////////////////// -->
        <table class="js-chart" border="1">
            <tbody>
                <tr>

                </tr>
            </tbody>
        </table>
    </section>

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
                                starsDiv.classList.add("rating");

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
                                starsDiv.classList.add("rating");

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
                        row.appendChild(columnNamesCell);

                        if(response.success){

                            // Add the column names to the column names cell
                            if (data.length > 0) {
                                for (var key in data[0]) {
                                    // Skip the birth_control_chart_id and birth_control_id columns
                                    if (key === 'birth control chart id' || key === 'birth control id' || key === 'birth control name') {
                                        continue;
                                    }

                                    var columnName = document.createElement('p');
                                    columnName.textContent = key;
                                    columnNamesCell.appendChild(columnName);
                                }
                            }

                            // Loop through the data and create a new cell for each contraceptive method
                            for (var i = 0; i < data.length; i++) {
                                var methodCell = document.createElement('td');
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
                                        imgElement.width = 25;
                                        imgElement.height = 25;
                                        methodCell.appendChild(imgElement);
                                    } else {
                                        // Create a div element to hold the stars
                                        let starsDiv = document.createElement("div");
                                        starsDiv.classList.add("rating");

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

    //sample lang to pwede tanggalin
    document.addEventListener('DOMContentLoaded', function() {
        var pricesTds = document.querySelectorAll('#prices td');
        pricesTds.forEach(function(td) {
            var div = document.createElement('div');
            div.className = 'pricing-table';
            var content = td.innerHTML;
            td.innerHTML = '';
            div.innerHTML = content;
            td.appendChild(div);
        });
    });

</script>
</html>