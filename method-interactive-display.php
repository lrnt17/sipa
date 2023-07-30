<?php 
    defined('APP') or die('direct script access denied!');
?>
<div>
    <h1>How effective is contraception?</h1>

    <h2>Choose a method:</h2>
    <form onclick="method_display.updateDisplay(event)">
        <button name="method" value="1">Patch</button>
        <button name="method" value="2">Implant</button>
        <button name="method" value="3">Condom</button>
    </form>
    <div>Using the <span class="js-method-name"></span>, 
        typically <span class="js-preggy"></span> in 
        <span class="js-not-preggy"></span> women will get pregnant in one year.
    </div>
    <div id="women-container">
        <div id="pregnant-women-container"></div>
        <div id="non-pregnant-women-container"></div>
    </div>
</div>
<script>
    var method_display = {

        selectedMethod: 1,

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
                        let numOfNonPreggy = document.querySelector(".js-not-preggy");

                        // Clear the containers
                        pregnantWomenContainer.innerHTML = '';
                        nonPregnantWomenContainer.innerHTML = '';
                        methodName.innerHTML = '';
                        numOfPreggy.innerHTML = '';
                        numOfNonPreggy.innerHTML = '';

                        // Create and append the pregnant women icons
                        for (let i = 0; i < obj.preggy; i++) {
                            let img = document.createElement('img');
                            img.src = 'assets/images/preggy.png'; // Set the URL of the image file
                            pregnantWomenContainer.appendChild(img);
                        }

                        // Create and append the non-pregnant women icons
                        for (let i = 0; i < obj.not_preggy; i++) {
                            let img = document.createElement('img');
                            img.src = 'assets/images/not_preggy.png'; // Set the URL of the image file
                            nonPregnantWomenContainer.appendChild(img);
                        }

                        methodName.innerHTML = obj.method_name;
                        numOfPreggy.innerHTML = obj.preggy;
                        numOfNonPreggy.innerHTML = obj.not_preggy;
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

    method_display.loadDisplay();
</script>