<?php 
    defined('APP') or die('direct script access denied!');
?>
<div>
    <h1>How effective is contraception?</h1>

    <h2>Choose a method:</h2>
    <form onclick="method_display.updateDisplay(event)" class="js-method-buttons">
        <!--<button name="method" value="1">Patch</button>
        <button name="method" value="2">Implant</button>
        <button name="method" value="3">Condom</button>-->
    </form>
    <div>Using the <span class="js-method-name"></span>, 
        typically <span class="js-preggy"></span> in 
        10 women will get pregnant in one year.
    </div>
    <div id="women-container">
        <div id="pregnant-women-container"></div>
        <div id="non-pregnant-women-container"></div>
    </div>
</div>

<!-- contraceptive method buttons template -->
<template class="js-method-buttons-template">
    <button name="method" value="1" class="js-each-method-buttons">Patch</button>
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
                        
                        let pregnantWomenContainer = document.getElementById('pregnant-women-container');
                        let nonPregnantWomenContainer = document.getElementById('non-pregnant-women-container');
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
                            let img = document.createElement('img');
                            img.src = 'assets/images/preggy.png';
                            pregnantWomenContainer.appendChild(img);
                        }
                        
                        for (let i = 0; i < numNonPreggy; i++) {
                            let img = document.createElement('img');
                            img.src = 'assets/images/not_preggy.png';
                            nonPregnantWomenContainer.appendChild(img);
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