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
        background-color: #F2C1A7; /* Change the background color on hover */
        color: white; /* Set text color to contrast with the new background */
    }

    span{
        font-weight:bold;
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
        <div class="row" class="my-1 custom-width-hidden" style="width:300px;">
            <h2 style="color:#383838;">How effective is contraception?</h2>
        </div>
        
        <div class="row">
            <p style="color:#383838;">Choose a method:</p>
        </div>

    <form onclick="method_display.updateDisplay(event)" class="js-method-buttons centered-form">
        <!--<button name="method" value="1">Patch</button>
        <button name="method" value="2">Implant</button>
        <button name="method" value="3">Condom</button>-->
    </form>

    <div class="my-4"> 
        <p class="text-center" style="color:#525252;">Using the <span class="js-method-name"></span>, 
        typically <span class="js-preggy"></span> in 
        <b>10</b> women will get pregnant in one year. </p>
    </div>

    <div id="women-container" class="row justify-content-center">
        <!--<<div id="pregnant-women-container"></div>
        <div id="non-pregnant-women-container"></div>-->
    </div>
</div>

<!-- contraceptive method buttons template -->
<template class="js-method-buttons-template">
    <button name="method" value="1" class="js-each-method-buttons btn mx-3 my-2 px-4 py-2 rounded-4 shadow-sm rounded" style="min-width:235px;">Patch</button>
</template>
<!-- end contraceptive method buttons template -->

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
                        let methodName = document.querySelector(".js-method-name");
                        let numOfPreggy = document.querySelector(".js-preggy");

                        // Clear the containers
                        pregnantWomenContainer.innerHTML = '';
                        nonPregnantWomenContainer.innerHTML = '';
                        methodName.innerHTML = '';
                        numOfPreggy.innerHTML = '';

                        // Calculate the number of non-pregnant women icons
                        let numNonPreggy = Math.max(0, 10 - obj.preggy);

                        for (let i = 0; i < obj.preggy; i++) {
                            let col = document.createElement('div');
                            col.classList.add('col-auto');
                            
                            let preggyImg = document.createElement('img');
                            preggyImg.src = 'assets/images/preggy-1.png'; // Use the correct path for preggy image
                            preggyImg.style.height = "110px";
                            preggyImg.style.width = "50px";
                            preggyImg.classList.add('mx-3', 'my-2');
                            
                            col.appendChild(preggyImg);
                            pregnantWomenContainer.appendChild(col);
                        }
                        
                        for (let i = 0; i < numNonPreggy; i++) {
                            let col = document.createElement('div');
                            col.classList.add('col-auto');
                            
                            let nonPreggyImg = document.createElement('img');
                            nonPreggyImg.src = 'assets/images/not-preggy.png'; // Use the correct path for non-preggy image
                            nonPreggyImg.style.height = "110px";
                            nonPreggyImg.style.width = "60px";
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

        updateDisplay: function (e) {
            e.preventDefault();

            // Get the value attribute of the clicked button
            let selectedValue = event.target.value;
            method_display.selectedMethod = selectedValue;
            let method_id = method_display.selectedMethod;
            // Do something with the selected value (e.g., display it)
            //console.log("Selected Value:", method_display.selectedMethod);
            method_display.loadDisplay();
        },
    };

    method_display.loadMethodButtons();
    method_display.loadDisplay();
</script>