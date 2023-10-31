<?php 
    defined('APP') or die('direct script access denied!');
?>

<style>
    .centered-form {
        text-align: center;
    }
    .js-each-method-buttons {
        background-color: #ffff; /* Set the initial background color */
        transition: background-color 0.2s; /* Add a smooth transition effect */
    }

    .js-each-method-buttons:hover {
        background-color: #e9a886; /* Change the background color on hover */
        color: white; /* Set text color to contrast with the new background */
    }

    span{
        font-weight:bold;
    }

    
    /* CSS for screens wider than 450px */
    @media (min-width: 451px) {
        .js-birth-control-rrl-container .row {
            display: flex;
            flex-wrap: wrap;
        }

        .rrl-col {
            width: calc(33.33% - 20px); /* Adjust the width based on your layout */
            margin-right: 20px;
        }

        .rrl-col:nth-child(3n) {
            margin-right: 0;
        }
    }

    /* CSS for screens 450px or less */
    @media (max-width: 450px) {
        .js-birth-control-rrl-container .row {
            display: block;
        }

        .rrl-col {
            width: 100%;
            margin-right: 0;
        }
    }

</style>

<div>
        <div class="row">
            <div class="d-flex justify-content-start mt-4 mb-3">
                <div style="width: 15%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
        </div>
        <div class="row" class="my-1 custom-width-hidden" style="width:350px;">
            <h2 style="color:#383838;">Gaano ka epektibo ang contraception?</h2>
        </div>
        
        <div class="row">
            <p style="color:#383838;">Pumili ng method:</p>
        </div>

    <form class="js-method-buttons centered-form">
        <!--<button name="method" value="1">Patch</button>
        <button name="method" value="2">Implant</button>
        <button name="method" value="3">Condom</button>-->
    </form>

    <div class="my-4" style="display: flex; justify-content: center;"> 
        <p class="text-center" style="color:#525252;">Sa karaniwang paggamit ng <span translate="no"> <span class="js-method-name-display" id="js-method-name-display"></span></span>,
        karaniwan <span class="js-preggy"></span> sa bawat 
        <b>100</b> kababaihan ay mabubuntis sa loob ng isang taon.</p>
    </div>

    <div id="women-container" class="row justify-content-center">
        <!--<<div id="pregnant-women-container"></div>
        <div id="non-pregnant-women-container"></div>-->
    </div>

    <div class="container">
        <div class="row mt-4">
            <div class="d-flex justify-content-center mt-2 mb-3">
                <div style="width: 10%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
        </div>
            
        <center><h3>References</h3></center>
        <div class="d-flex justify-content-center mt-3" style="text-align: center;">
            <p style="font-size:14px; color:#5A5A5A; width: 400px;">Narito ang mga link na nagbibigay ng impormasyon tungkol sa epekto ng napiling contraceptive method.</p>
        </div>
        
        <div class="row mt-5 js-birth-control-rrl-container">
                <!-- rrl will display here -->
        </div>
    </div>
</div>

<!-- contraceptive method buttons template -->
<template class="js-method-buttons-template">
    <span translate="no"><button  onclick="method_display.updateDisplay(event)" name="method" value="1" class="js-each-method-buttons btn mx-3 my-2 px-4 py-2 rounded-4 shadow-sm rounded" style="min-width:235px;">Patch</button></span>
</template>
<!-- end contraceptive method buttons template -->

<template class="js-rrl-template rrl-col" id="rrl-template">
    <div class="col pb-4">
        <p class="js-rrl-title" style="margin-bottom:0px; font-weight:600;">Literature 1</p>
        <p class="js-rrl-content" style="margin-bottom:0px; display:inline;">Content of literature 2...</p>
        <a class="js-rrl-link" href="#" style="text-decoration:none;" target="_blank"></a>
    </div>
</template>

<script>
    var method_display = {

        selectedMethod: 1,

        loadMethodButtons: function () {
            
            let form = new FormData();
        
            form.append('method_id', method_display.selectedMethod);
            form.append('data_type', 'load_all_methods');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){

                        let methodbtns_holder = document.querySelector(".js-method-buttons");
                        methodbtns_holder.innerHTML = "";

                        let template = document.querySelector(".js-method-buttons-template");
                        
                        if(typeof obj.rows == 'object') {

                            for (var i = 0; i < obj.rows.length; i++) {
                                let clone_template = template.content.cloneNode(true);
                                
                                clone_template.querySelector(".js-each-method-buttons").setAttribute('value', obj.rows[i].birth_control_id);
                                clone_template.querySelector(".js-each-method-buttons").innerHTML = obj.rows[i].birth_control_name;
                                
                                methodbtns_holder.appendChild(clone_template);
                            }
                        }
                    }
                }
            }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        loadDisplay: function () {
            
            let form = new FormData();
        
            form.append('method_id', method_display.selectedMethod);
            form.append('data_type', 'load_method');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success){
                        
                        let pregnantWomenContainer = document.getElementById('women-container');
                        let nonPregnantWomenContainer = document.getElementById('women-container');
                        let methodName = document.querySelector("#js-method-name-display");
                        let numOfPreggy = document.querySelector(".js-preggy");

                        // Clear the containers
                        pregnantWomenContainer.innerHTML = '';
                        nonPregnantWomenContainer.innerHTML = '';
                        methodName.innerHTML = '';
                        numOfPreggy.innerHTML = '';

                        // Calculate the number of non-pregnant women icons
                        let numNonPreggy = Math.max(0, 100 - obj.preggy);

                        for (let i = 0; i < obj.preggy; i++) {
                            let col = document.createElement('div');
                            col.classList.add('col-auto');
                            
                            let preggyImg = document.createElement('img');
                            preggyImg.src = 'assets/images/preggy-1.png'; // Use the correct path for preggy image
                            preggyImg.style.height = "40px";
                            preggyImg.style.width = "20px";
                            preggyImg.classList.add('mx-2', 'my-2');
                            
                            col.appendChild(preggyImg);
                            pregnantWomenContainer.appendChild(col);
                        }
                        
                        for (let i = 0; i < numNonPreggy; i++) {
                            let col = document.createElement('div');
                            col.classList.add('col-auto');
                            
                            let nonPreggyImg = document.createElement('img');
                            nonPreggyImg.src = 'assets/images/not-preggy.png'; // Use the correct path for non-preggy image
                            nonPreggyImg.style.height = "40px";
                            nonPreggyImg.style.width = "25px";
                            nonPreggyImg.classList.add('mx-2', 'my-2');
                            
                            col.appendChild(nonPreggyImg);
                            nonPregnantWomenContainer.appendChild(col);
                        }

                        methodName.innerHTML = obj.method_name;
                        numOfPreggy.innerHTML = obj.preggy;
                    }
                }
            }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        loadMethodReferences: function () {
            let form = new FormData();
            form.append('method_id', method_display.selectedMethod);
            form.append('data_type', 'load_method_references');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange', function () {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        let obj = JSON.parse(ajax.responseText);

                        if (obj.success) {
                            let method_references_holder = document.querySelector(".js-birth-control-rrl-container");
                            method_references_holder.innerHTML = "";

                            let template = document.querySelector(".js-rrl-template");
                            let maxColumnsPerRow = 3; // Adjust this to your desired maximum columns per row

                            if (typeof obj.rows == 'object') {
                                for (var i = 0; i < obj.rows.length; i++) {
                                    if (i % maxColumnsPerRow === 0) {
                                        // Start a new row when the column count reaches the maximum
                                        var row = document.createElement('div');
                                        row.className = 'row';
                                        method_references_holder.appendChild(row);
                                    }

                                    let rrl_card = template.content.cloneNode(true);
                                    rrl_card.querySelector(".js-rrl-title").innerHTML = obj.rows[i].rrl_title;
                                    rrl_card.querySelector(".js-rrl-content").innerHTML = obj.rows[i].rrl_desc;

                                    if (obj.rows[i].rrl_link) {
                                        let linkElement = rrl_card.querySelector(".js-rrl-link");
                                        linkElement.href = obj.rows[i].rrl_link;
                                        linkElement.innerHTML = "<i class='fa-solid fa-arrow-up-right-from-square' style='font-size: 12px;'></i>";
                                    }

                                    // Append the column to the current row
                                    row.appendChild(rrl_card);
                                }
                            }
                        }
                    }
                }
            });

            ajax.open('post', 'ajax.php', true);
            ajax.send(form);
        },

        updateDisplay: function (e) {
            e.preventDefault();

            // Get the value attribute of the clicked button
            let selectedValue = event.target.value;
            method_display.selectedMethod = selectedValue;
            let method_id = method_display.selectedMethod;
            // Do something with the selected value (e.g., display it)
            //console.log("Selected Value:", method_display.selectedMethod);
            method_display.loadDisplay();
            method_display.loadMethodReferences();
        },
    };

    method_display.loadMethodButtons();
    method_display.loadDisplay();
    method_display.loadMethodReferences();
</script>
