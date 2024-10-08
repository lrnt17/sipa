<?php 
    require("connect.php");
    require('functions.php');

   // echo $_SESSION['USER']['user_id']."<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Compare Side-by-side | SiPa</title>
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
        
    @keyframes appear {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    /*li, .js-options{
        animation: appear 1s ease-in-out; /* Apply the 'appear' animation with a duration of 1 second and ease-in-out timing function 
    }*/

    ul {
        list-style-type: none;
    }

    .clearfix:after {
        content: '';
        height: 0;
        width: 0;
    }
    /** ========================
    * Contenedor
    ============================*/
    .pricing-wrapper {
        width: 960px;
        margin: 40px auto 0;
    }

    .pricing-table {
        text-align: center;
        float: left;
        width: 300px;
    }

    .table-list li:nth-child(2n) {
        background: #F0F0F0;
    }

    .table-buy {
        background: #FFF;
        text-align: left;
        overflow: hidden;
    }


    .table-buy .pricing-action:hover {
        background: #cf4f3e;
    }

    .recommended .table-buy .pricing-action:hover {
        background: #228799;	
    }

    .js-table{
        float: left;
    }

    ul {
      list-style: none;
      margin: 0;
      padding: 0;
      float:left;
    }
    li {
      padding: 10px;
      width: fit-content;
    }

    .js-select_2{
        background-color:#ffff !important;
        min-width: 10px;
    }
    .js-list1, .js-list2, .js-list3{
        padding:0 !important;
        max-width: 350px;
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

    .nav-item, .li{
        padding:0 !important;
    }

    .horizontal-scroll {
            overflow-x: auto;
        }

    #side_by_side {
        width: 100%; /* Set the width to 100% to match the table */
        display: block; /* Ensure it takes up the full width */
        overflow-x: auto; /* Add horizontal scrolling if needed */
    }

    @media (max-width: 768px) {
            .sidebyside_row{
                width:700px !important;
            }
            
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
            .label{
                text-align: center !important;
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
                    Ihambing at ikumpara ang iba't ibang paraan ng Contraceptive.               
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
                <h3 class="compare" style="font-weight:400;"><b>Ikumpara</b> ang paraang contraceptive</h3>
            </div>
        </div>

        <div class="rotate p-3  my-4 ms-2 me-2 rounded-4" style="background: #e9a886;">
            <div class="row" style="
                display: flex;
                align-items: center;
                ">
                <div class="col-1 me-3">
                    <i class="fa-solid fa-rotate" style="font-size:25px;"></i>
                </div>
                <div class="col"> 
                    <p align="justify" style="font-weight:500; margin:0;">I-rotate ang iyong cellphone sa landscape mode para sa mas maayos na view.</p>
                </div>
            </div>
        </div>
        
    <section class="js-comparison-sidebyside hide">
        <?php include('compare-methods.php') ?>

            <div class="container rounded-bottom-4 pb-5 mb-5" style="background-color:#D2E0F8;" id="side_by_side">
                <div class="con horizontal-scroll table-con">
                    <div class="row pe-2 pt-4 sidebyside_row">
                        <div class="col-2 js-table js-column-labels pt-4 mt-2">
                            <ul class="js-list1">
                                
                            </ul>
                        </div>
                        <div class="col js-table js-select_1 rounded-3 p-4 m-2 shadow-sm" style="background-color:#ffff; min-width: 10px;">
                            
                        </div>
                        <div class="col js-table js-select_2 rounded-3 p-4 m-2 shadow-sm">

                        </div>

                    </div>
                </div>
            </div>
    </section>   
</div> 

<?php include('footer.php') ?>
</body>
<script>
    //var secondDiv = document.querySelector('.js-select_2');
    // disable the click event on the second div element by default
    //secondDiv.style.pointerEvents = 'none';

    var compare_sidebyside = {

        secondDiv: document.querySelector('.js-select_2'),
        birth_control_id: null,
        correspondingDiv: null,

        load_column_labels: function(){

            let column_labels = document.querySelector('.js-column-labels ul');
            
            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                    
                        if(obj.success){

                            let li = document.createElement('li');
                            li.innerHTML = '‎';
                            column_labels.appendChild(li);

                            for (let column in obj.columns) {
                                let li = document.createElement('li');
                                li.textContent = obj.columns[column].replace(/_/g, ' ');
                                column_labels.appendChild(li);
                            }
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },

        load_contraceptive_options_1: function () {
            let select_method_holder = document.querySelector('.js-select_1');

            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange', function () {
                if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);

                    if (obj.success) {
                    // Create a new row div
                    let newRow = document.createElement('div');
                    newRow.classList = 'row';

                    // Create a column with class 'js-options-title'
                    let titleColumn = document.createElement('div');
                    titleColumn.classList = 'col js-options-title';
                    titleColumn.innerHTML = 'Select Method #1';

                    // Create a column for the custom content
                    let customColumn = document.createElement('div');
                    customColumn.classList = 'col-auto';
                    customColumn.innerHTML = '<div class="vl" style="width: 7px; background-color: #1F6CB5; border-radius: 99px; height: 25px; display: -webkit-inline-box;"></div>';

                    // Append the titleColumn and customColumn to the newRow
                    newRow.appendChild(customColumn);
                    newRow.appendChild(titleColumn);
                    

                    // Append the newRow to the select_method_holder
                    select_method_holder.appendChild(newRow);

                    // Create a line break
                    let br = document.createElement('br');
                    select_method_holder.appendChild(br);

                    for (let i = 0; i < obj.rows.length; i++) {
                        let birthControlName = obj.rows[i].birth_control_name;
                        let birthControlImage = obj.rows[i].birth_control_icon;

                        // Create a div with class "row"
                        let rowElement = document.createElement('div');
                        rowElement.classList.add("row");

                        // Create a div with class "col" for the image
                        let imageCol = document.createElement('div');
                        imageCol.classList.add("col-auto","rounded-4", "ms-2", "shadow-sm");
                        imageCol.style.background="white";
                        imageCol.style.width="70px";
                        imageCol.style.height="60px";
                        imageCol.style.position="relative";
                        imageCol.style.overflow="hidden";
                        imageCol.style.padding="10px";
                        imageCol.style.display="flex";
                        imageCol.style.justifyContent="center";

                        // Create an image element
                        let imageElement = document.createElement('img');
                        imageElement.src = birthControlImage;
                        imageElement.style.width="auto";
                        imageElement.style.height="100%";
                        imageElement.style.objectFit="cover";

                        // Append the image to the image column
                        imageCol.appendChild(imageElement);

                        // Create a div with class "col" for the text
                        let textCol = document.createElement('div');
                        textCol.classList.add("col");
                        textCol.style.display="flex";
                        textCol.style.alignItems="center";

                        // Create a text element for the option name
                        let textElement = document.createElement('div');
                        textElement.textContent = birthControlName;
                        
                        // Append the text to the text column
                        textCol.appendChild(textElement);

                        // Append the image column and text column to the row
                        rowElement.appendChild(imageCol);
                        rowElement.appendChild(textCol);

                        // Create a container for the entire option
                        let optionContainer = document.createElement('div');
                        optionContainer.classList.add("js-options", "p-2","ps-3", "my-2", "rounded-4", "shadow-sm");
                        optionContainer.style.background = "white";
                        optionContainer.style.cursor = "pointer";
                        optionContainer.setAttribute('onclick', `compare_sidebyside.selected_contraceptive_1('${obj.rows[i].birth_control_id}')`);


                        // Append the row to the option container
                        optionContainer.appendChild(rowElement);

                        // Append the option container to the select_method_holder
                        select_method_holder.appendChild(optionContainer);
                    }

                    }
                } else {
                    alert('Please check your internet connection');
                }
                }
            });

            ajax.open('post', 'ajax.php', true);
            ajax.send(form);

        },

        load_contraceptive_options_2: function(){

            let select_method_holder = document.querySelector('.js-select_2');

            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){

                            // Create a new row div
                            let newRow = document.createElement('div');
                            newRow.classList = 'row';

                            // Create a column with class 'js-options-title'
                            let titleColumn = document.createElement('div');
                            titleColumn.classList = 'col js-options-title';
                            titleColumn.innerHTML = 'Select Method #2';

                            // Create a column for the custom content
                            let customColumn = document.createElement('div');
                            customColumn.classList = 'col-auto';
                            customColumn.innerHTML = '<div class="vl" style="width: 7px; background-color: #1F6CB5; border-radius: 99px; height: 25px; display: -webkit-inline-box;"></div>';

                            // Append the titleColumn and customColumn to the newRow
                            newRow.appendChild(customColumn);
                            newRow.appendChild(titleColumn);

                            // Append the newRow to the select_method_holder
                            select_method_holder.appendChild(newRow);

                            // Create a line break
                            let br = document.createElement('br');
                            select_method_holder.appendChild(br);

                            for (let i = 0; i < obj.rows.length; i++) {
                                let birthControlName = obj.rows[i].birth_control_name;
                                let birthControlImage = obj.rows[i].birth_control_icon;

                                // Create a div with class "row"
                                let rowElement = document.createElement('div');
                                rowElement.classList.add("row");

                                // Create a div with class "col" for the image
                                let imageCol = document.createElement('div');
                                imageCol.classList.add("col-auto","rounded-4", "ms-2", "shadow-sm");
                                imageCol.style.background="white";
                                imageCol.style.width="70px";
                                imageCol.style.height="60px";
                                imageCol.style.position="relative";
                                imageCol.style.overflow="hidden";
                                imageCol.style.padding="10px";
                                imageCol.style.display="flex";
                                imageCol.style.justifyContent="center";

                                // Create an image element
                                let imageElement = document.createElement('img');
                                imageElement.src = birthControlImage;
                                imageElement.style.width="auto";
                                imageElement.style.height="100%";
                                imageElement.style.objectFit="cover";

                                // Append the image to the image column
                                imageCol.appendChild(imageElement);

                                // Create a div with class "col" for the text
                                let textCol = document.createElement('div');
                                textCol.classList.add("col");
                                textCol.style.display="flex";
                                textCol.style.alignItems="center";

                                // Create a text element for the option name
                                let textElement = document.createElement('div');
                                textElement.textContent = birthControlName;
                                
                                // Append the text to the text column
                                textCol.appendChild(textElement);

                                // Append the image column and text column to the row
                                rowElement.appendChild(imageCol);
                                rowElement.appendChild(textCol);

                                // Create a container for the entire option
                                let optionContainer = document.createElement('div');
                                optionContainer.classList.add("js-options", "p-2","ps-3", "my-2", "rounded-4", "shadow-sm");
                                optionContainer.style.background = "white";
                                optionContainer.style.cursor = "pointer";
                                optionContainer.setAttribute('onclick', `compare_sidebyside.selected_contraceptive_2('${obj.rows[i].birth_control_id}')`);


                                // Append the row to the option container
                                optionContainer.appendChild(rowElement);

                                // Append the option container to the select_method_holder
                                select_method_holder.appendChild(optionContainer);
                                    }
                                }
                                compare_sidebyside.add_pointer_event(compare_sidebyside.birth_control_id);
                            }else{
                                alert("Please check your internet connection");
                            }
                        }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        enable_second_div_click: function(){
            compare_sidebyside.secondDiv.style = "";
            compare_sidebyside.secondDiv.style.pointerEvents = 'auto';
        },

        disable_second_div_click: function(){
            compare_sidebyside.secondDiv.style = "";
            compare_sidebyside.secondDiv.style.pointerEvents = 'none';
        },

        selected_contraceptive_1: function(birth_control_id){
            
            compare_sidebyside.enable_second_div_click();

            // Make the corresponding div element unclickable
            compare_sidebyside.birth_control_id = birth_control_id;
            compare_sidebyside.add_pointer_event(compare_sidebyside.birth_control_id);

            let select_method_holder = document.querySelector('.js-select_1');
            select_method_holder.innerHTML = "";

            let form = new FormData();
            form.append('birth_control_id', birth_control_id);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        
                        let excludedColumns = ["sidebyside_id", "birth_control_id", "birth_control_chart_id"];
                        let ul = document.createElement("ul");
                        ul.classList = 'js-list2';

                        if(obj.success){
                            
                            let div = document.createElement("div");
                            div.classList = 'js-close-selected1';
                            div.style = "float:right;cursor:pointer;";
                            div.setAttribute('onclick',`compare_sidebyside.close_selected_contraceptive(this)`);
                            div.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                            select_method_holder.appendChild(div);
                            console.log(obj.chart);

                            for (let i = 0; i < obj.rows.length; i++) {
                                
                                let row = obj.rows[i];
                                let li = document.createElement('li');

                                // Create a div element with class "row"
                                let rowDiv = document.createElement('div');
                                rowDiv.className = 'row';

                                // Create a div element for the column containing the image
                                let imgCol = document.createElement('div');
                                imgCol.className = 'col';

                                // Create an img element and set its source to the value of birth_control_icon
                                let img = document.createElement('img');
                                img.src = row['birth_control_icon'];
                                img.style.width="auto";
                                img.style.height="100%";
                                img.style.objectFit="cover";

                                // Create a new div inside the imgCol for the image
                                let imgContainerDiv = document.createElement('div');
                                imgContainerDiv.classList.add("col-auto","rounded-4", "shadow-sm");
                                imgContainerDiv.style.background="white";
                                imgContainerDiv.style.width="70px";
                                imgContainerDiv.style.height="60px";
                                imgContainerDiv.style.position="relative";
                                imgContainerDiv.style.overflow="hidden";
                                imgContainerDiv.style.padding="10px";
                                imgContainerDiv.style.display="flex";
                                imgContainerDiv.style.justifyContent="center";

                                // Append the img element to the imgContainerDiv
                                imgContainerDiv.appendChild(img);

                                // Append the imgContainerDiv to the imgCol
                                imgCol.appendChild(imgContainerDiv);

                                // Append the img column to the row
                                rowDiv.appendChild(imgCol);

                                // Create a div element for the column containing the text
                                let textCol = document.createElement('div');
                                textCol.classList.add('col-auto','mt-2');
                                textCol.style.display="flex";
                                textCol.style.alignItems="center";

                                // Create a p element and set its text content to the value of birth_control_name
                                let p = document.createElement('h6');
                                p.textContent = row['birth_control_name'];
                                textCol.appendChild(p);

                                // Append the text column to the row
                                rowDiv.appendChild(textCol);

                                // Append the row div to the li element
                                li.appendChild(rowDiv);
                                ul.appendChild(li);


                                for (let key in row) {

                                    if (!excludedColumns.includes(key) && key !== 'birth_control_name' && key !== 'birth_control_icon') {
                                        //console.log(key);
                                        let value = row[key];

                                        // Create a new row for each item
                                        let rowDiv = document.createElement('div');
                                        rowDiv.classList.add("row");
                                        rowDiv.style.alignItems="center";

                                        // Create the column for the stars
                                        let starsDiv = document.createElement('div');
                                        starsDiv.classList.add("col-auto");

                                        // Create the column for the rating text
                                        let ratingDiv = document.createElement('div');
                                        ratingDiv.classList.add("col-auto");
                                        ratingDiv.style.paddingTop="5px";
                                        ratingDiv.style.fontWeight="700";

                                        let additionalContentDiv = document.createElement('div');
                                        additionalContentDiv.classList.add("col-1","mt-3");

                                        // Check if chart data exists for this row
                                        if (obj.chart && obj.chart[i]) {
                                            let chartValue = obj.chart[i][key];
                                            if (chartValue !== undefined) {
                                                // Create the star elements
                                                for (let j = 0; j < 3; j++) {
                                                    let starSpan = document.createElement("span");
                                                    starSpan.classList.add("star");

                                                    let starIcon = document.createElement("i");
                                                    starIcon.classList.add("fas", "fa-star");

                                                    // Fill up stars based on the value
                                                    if (j < chartValue) {
                                                        starSpan.classList.add("active");
                                                    }

                                                    starSpan.appendChild(starIcon);
                                                    starsDiv.appendChild(starSpan);
                                                }

                                                // Set the text for the rating text column
                                                switch (+chartValue) {
                                                    case 0:
                                                        ratingDiv.textContent = "Bad";
                                                        break;
                                                    case 1:
                                                        ratingDiv.textContent = "Good";
                                                        break;
                                                    case 2:
                                                        ratingDiv.textContent = "Better";
                                                        break;
                                                    case 3:
                                                        ratingDiv.textContent = "Best";
                                                        break;
                                                }
                                            }
                                        }

                                        // Add the additional content column
                                        let additionalContent = document.createElement('p');
                                        additionalContent.innerHTML = "&mdash;"; // Adding "—" using HTML entity
                                        additionalContentDiv.appendChild(additionalContent);

                                        // Append the stars column and rating text column to the row
                                        rowDiv.appendChild(starsDiv);
                                        rowDiv.appendChild(additionalContentDiv);
                                        rowDiv.appendChild(ratingDiv);
                                        

                                        // Create a list item and append the row to it
                                        let li = document.createElement('li');
                                        li.textContent = value;
                                        li.appendChild(rowDiv);

                                        // Append the list item to the ul
                                        ul.appendChild(li);
                                    }
                                }
                            }
                            select_method_holder.appendChild(ul);
                            compare_sidebyside.list_height_adjust();

                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },

        selected_contraceptive_2: function(birth_control_id){
            
            compare_sidebyside.enable_second_div_click();

            // Make the corresponding div element unclickable
            //compare_sidebyside.birth_control_id = birth_control_id;
            //compare_sidebyside.add_pointer_event(compare_sidebyside.birth_control_id);

            let select_method_holder = document.querySelector('.js-select_2');
            select_method_holder.innerHTML = "";

            let form = new FormData();
            form.append('birth_control_id', birth_control_id);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        
                        let excludedColumns = ["sidebyside_id", "birth_control_id", "birth_control_chart_id"];
                        let ul = document.createElement("ul");
                        ul.classList = 'js-list3';

                        if(obj.success){
                            
                            let div = document.createElement("div");
                            div.classList = 'js-close-selected2';
                            div.style = "float:right;cursor:pointer;pointer-events: auto;";
                            div.setAttribute('onclick',`compare_sidebyside.close_selected_contraceptive(this)`);
                            div.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                            select_method_holder.appendChild(div);

                            for (let i = 0; i < obj.rows.length; i++) {
                                
                                let row = obj.rows[i];
                                let li = document.createElement('li');

                                // Create a div element with class "row"
                                let rowDiv = document.createElement('div');
                                rowDiv.className = 'row';

                                // Create a div element for the column containing the image
                                let imgCol = document.createElement('div');
                                imgCol.className = 'col';

                                // Create an img element and set its source to the value of birth_control_icon
                                let img = document.createElement('img');
                                img.src = row['birth_control_icon'];
                                img.style.width="auto";
                                img.style.height="100%";
                                img.style.objectFit="cover";

                                // Create a new div inside the imgCol for the image
                                let imgContainerDiv = document.createElement('div');
                                imgContainerDiv.classList.add("col-auto","rounded-4", "shadow-sm");
                                imgContainerDiv.style.background="white";
                                imgContainerDiv.style.width="70px";
                                imgContainerDiv.style.height="60px";
                                imgContainerDiv.style.position="relative";
                                imgContainerDiv.style.overflow="hidden";
                                imgContainerDiv.style.padding="10px";
                                imgContainerDiv.style.display="flex";
                                imgContainerDiv.style.justifyContent="center";

                                // Append the img element to the imgContainerDiv
                                imgContainerDiv.appendChild(img);

                                // Append the imgContainerDiv to the imgCol
                                imgCol.appendChild(imgContainerDiv);

                                // Append the img column to the row
                                rowDiv.appendChild(imgCol);

                                // Create a div element for the column containing the text
                                let textCol = document.createElement('div');
                                textCol.classList.add('col-auto','mt-2');
                                textCol.style.display="flex";
                                textCol.style.alignItems="center";

                                // Create a p element and set its text content to the value of birth_control_name
                                let p = document.createElement('h6');
                                p.textContent = row['birth_control_name'];
                                textCol.appendChild(p);

                                // Append the text column to the row
                                rowDiv.appendChild(textCol);

                                // Append the row div to the li element
                                li.appendChild(rowDiv);
                                ul.appendChild(li);

                                for (let key in row) {
                                    if (!excludedColumns.includes(key) && key !== 'birth_control_name' && key !== 'birth_control_icon') {
                                        let value = row[key];

                                        // Create a new row for each item
                                        let rowDiv = document.createElement('div');
                                        rowDiv.classList.add("row");
                                        rowDiv.style.alignItems="center";

                                        // Create the column for the stars
                                        let starsDiv = document.createElement('div');
                                        starsDiv.classList.add("col-auto");

                                        // Create the column for the rating text
                                        let ratingDiv = document.createElement('div');
                                        ratingDiv.classList.add("col-auto");
                                        ratingDiv.style.paddingTop="5px";
                                        ratingDiv.style.fontWeight="700";

                                        let additionalContentDiv = document.createElement('div');
                                        additionalContentDiv.classList.add("col-1","mt-3");

                                        // Check if chart data exists for this row
                                        if (obj.chart && obj.chart[i]) {
                                            let chartValue = obj.chart[i][key];
                                            if (chartValue !== undefined) {
                                                // Create the star elements
                                                for (let j = 0; j < 3; j++) {
                                                    let starSpan = document.createElement("span");
                                                    starSpan.classList.add("star");

                                                    let starIcon = document.createElement("i");
                                                    starIcon.classList.add("fas", "fa-star");

                                                    // Fill up stars based on the value
                                                    if (j < chartValue) {
                                                        starSpan.classList.add("active");
                                                    }

                                                    starSpan.appendChild(starIcon);
                                                    starsDiv.appendChild(starSpan);
                                                }

                                                // Set the text for the rating text column
                                                switch (+chartValue) {
                                                    case 0:
                                                        ratingDiv.textContent = "Bad";
                                                        break;
                                                    case 1:
                                                        ratingDiv.textContent = "Good";
                                                        break;
                                                    case 2:
                                                        ratingDiv.textContent = "Better";
                                                        break;
                                                    case 3:
                                                        ratingDiv.textContent = "Best";
                                                        break;
                                                }
                                            }
                                        }

                                        // Add the additional content column
                                        let additionalContent = document.createElement('p');
                                        additionalContent.innerHTML = "&mdash;"; // Adding "—" using HTML entity
                                        additionalContentDiv.appendChild(additionalContent);

                                        // Append the stars column and rating text column to the row
                                        rowDiv.appendChild(starsDiv);
                                        rowDiv.appendChild(additionalContentDiv);
                                        rowDiv.appendChild(ratingDiv);
                                        

                                        // Create a list item and append the row to it
                                        let li = document.createElement('li');
                                        li.textContent = value;
                                        li.appendChild(rowDiv);

                                        // Append the list item to the ul
                                        ul.appendChild(li);
                                    }
                                }

                            }
                            select_method_holder.appendChild(ul);
                            compare_sidebyside.list_height_adjust();

                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },

        list_height_adjust: function() {
            /*
            // Get the first and second list elements
            let list1 = document.querySelector(".js-list1");
            let list2 = document.querySelector(".js-list2");
            let list3 = document.querySelector(".js-list3");

            // Get the list items from each list
            let items1 = list1.getElementsByTagName("li");
            let items2 = list2.getElementsByTagName("li");
            let items3 = list3 ? list3.getElementsByTagName("li") : null;

            // Loop over the list items
            for (let i = 0; i < items1.length; i++) {

                // Get the current list item from each list
                let item1 = items1[i];
                let item2 = items2[i];
                let item3 = items3 ? items3[i] : null;

                // Get the computed height of each item
                let item1Height = window.getComputedStyle(item1).getPropertyValue("height");
                let item2Height = window.getComputedStyle(item2).getPropertyValue("height");
                let item3Height = item3 ? window.getComputedStyle(item3).getPropertyValue("height") : "0px";

                // Set the height of both items to the maximum height
                let maxHeight = Math.max(parseInt(item1Height), parseInt(item2Height), parseInt(item3Height));
                item1.style.height = maxHeight + "px";
                item2.style.height = maxHeight + "px";
                if (item3) {
                    item3.style.height = maxHeight + "px";
                }
            }
            */
            let list1 = document.querySelector(".js-list1");
            let list2 = document.querySelector(".js-list2");
            let list3 = document.querySelector(".js-list3");

            // Get the list items from each list
            let items1 = list1.getElementsByTagName("li");
            let items2 = list2 ? list2.getElementsByTagName("li") : null;
            let items3 = list3 ? list3.getElementsByTagName("li") : null;

            // Get the number of list items in each list
            let numItems1 = items1.length;
            let numItems2 = items2 ? items2.length : 0;
            let numItems3 = items3 ? items3.length : 0;

            // Get the maximum number of list items
            let maxNumItems = Math.max(numItems1, numItems2, numItems3);

            // Loop over the list items
            for (let i = 0; i < maxNumItems; i++) {
                // Get the current list item from each list
                let item1 = i < numItems1 ? items1[i] : null;
                let item2 = i < numItems2 ? items2[i] : null;
                let item3 = i < numItems3 ? items3[i] : null;

                // Remove the style attribute from each item
                if (item1) {
                    item1.removeAttribute("style");
                }
                if (item2) {
                    item2.removeAttribute("style");
                }
                if (item3) {
                    item3.removeAttribute("style");
                }

                // Get the computed height of each item
                let item1Height = item1 ? window.getComputedStyle(item1).getPropertyValue("height") : "0px";
                let item2Height = item2 ? window.getComputedStyle(item2).getPropertyValue("height") : "0px";
                let item3Height = item3 ? window.getComputedStyle(item3).getPropertyValue("height") : "0px";

                // Set the height of all items to the maximum height
                let maxHeight = Math.max(parseInt(item1Height), parseInt(item2Height), parseInt(item3Height));
                if (item1) {
                    item1.style.height = maxHeight + "px";
                }
                if (item2) {
                    item2.style.height = maxHeight + "px";
                }
                if (item3) {
                    item3.style.height = maxHeight + "px";
                }
            }
        },

        close_selected_contraceptive: function(clickedElement) {

            // Now you can access properties of the clickedElement to determine which div was clicked.
            if (clickedElement.className.includes('js-close-selected1')) {
                
                // This was the first div element
                document.querySelector('.js-select_1').innerHTML = "";
                compare_sidebyside.list_height_adjust();
                compare_sidebyside.remove_pointer_event(compare_sidebyside.birth_control_id);
                compare_sidebyside.disable_second_div_click();
                compare_sidebyside.load_contraceptive_options_1();
                
            } else if (clickedElement.className.includes('js-close-selected2')) {

                // This was another div element
                document.querySelector('.js-select_2').innerHTML = "";
                compare_sidebyside.list_height_adjust();
                compare_sidebyside.load_contraceptive_options_2();
            }
        },

        add_pointer_event: function(birth_control_id){
            // Find the corresponding div element in the second set
            let secondSet = document.querySelectorAll('.js-select_2 .js-options');

            compare_sidebyside.correspondingDiv = Array.from(secondSet).find(function(div) {
                return div.getAttribute('onclick').includes(`selected_contraceptive_2('${birth_control_id}')`);
            });

            if (compare_sidebyside.correspondingDiv) {
                compare_sidebyside.correspondingDiv.style.pointerEvents = 'none';
            }
        },

        remove_pointer_event: function(birth_control_id){
            // Find the corresponding div element in the second set
            let secondSet = document.querySelectorAll('.js-select_2 .js-options');

            if (secondSet.length === 0) {
                
                compare_sidebyside.birth_control_id = null;
                compare_sidebyside.correspondingDiv = null;

                return;
            } 

            compare_sidebyside.correspondingDiv = Array.from(secondSet).find(function(div) {
                return div.getAttribute('onclick').includes(`selected_contraceptive_2('${birth_control_id}')`);
            });

            if (compare_sidebyside.correspondingDiv) {
                compare_sidebyside.correspondingDiv.style.pointerEvents = '';
            }
        },
    };
    
    compare_sidebyside.load_column_labels();
    compare_sidebyside.load_contraceptive_options_1();
    compare_sidebyside.load_contraceptive_options_2();
    window.onload = function() {
        compare_sidebyside.disable_second_div_click();
    };

</script>
</html>


