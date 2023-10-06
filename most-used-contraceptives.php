<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<style>
.lines{
    width: 100%;
    height: 28px;
    position: relative;
}

.lines::after, .lines::before{
    content: '';
    position: absolute;
    height: 2.5px;
    margin: auto;
    background: #F2C1A7;
    width: 25%;
    top: 45%;
}

.lines::after{
    left: 0;
}

.lines::before{
    right: 0;
}</style>

<section>
    <div>

        <div class="d-flex justify-content-center mt-5" style="text-align: center;">  
            <p class="mt-4"style="font-size:14px; color:#5A5A5A; width: 400px;">
            Discover the Top 3 Most Used Contraceptives! Explore the preferred methods 
            chosen by our users on the 'SIPA' website to make informed decisions about birth control.
            </p>
        </div>

        <div class="row">
            <div class="d-flex justify-content-center mt-2 mb-3">
                <div style="width: 10%;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 6px;"></div>
            </div>
        </div>


        <h2 class="d-flex justify-content-center mb-3" style="color:#383838;">Top 3 Most Used Contraceptives</h2>
        <div class="row js-most-used-contraceptives" id="most-used-contraceptives" style="justify-content: center;">

        </div>
    </div>
    
</section>

<template class="js-most-used-template" id="most-used-template">

    <div class="col-lg-3 contraceptive-item my-3 mx-4 rounded-3 p-4 shadow-sm" style="background:white;">
        
        <div style="text-align: center; position: relative;" class="container mb-4 mt-3">
            <h3 class="js-contraceptive-rank" style="display: inline-block; vertical-align: middle; position: absolute; margin-left: 28px; margin-top: 21px;"></h3>
            <i class="fa-solid fa-award" style="font-size: 100px; display: inline-block; vertical-align: middle;"></i>
        </div>
        <div class="contraceptive-icon p-3 rounded-3" style="display: flex;justify-content: center; background:white; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
            <img src="" alt="" class="js-contraceptive-icon" width="60" height="60">
        </div>
        <center><h3 class="js-contraceptive-name p-3">Contraceptive Name</h3></center>
        <div class="lines">
            <p style="text-align: center;">Used by <span class="js-contraceptive-number-of-users">Number of users: ...</span></p>
        </div>
        
        
        
        <p class="js-contraceptive-short-description mt-3">Description of the contraceptive...</p>
        <p class="read px-2 mt-2"><a class='js-contraceptive-link' href='#' style="text-decoration: none; color: #1F6CB5; font-size:13px;"><i class="fa-solid fa-circle-info"> </i> READ MORE</a></p>
    </div>
</template>

<script>
    var most_used_method = {

        load_most_used_contraceptives: function(e){

            let form = new FormData();

            form.append('data_type', 'load_most_used_contraceptives');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            let most_used_container = document.getElementById("most-used-contraceptives");
                            let most_used_template = document.getElementById("most-used-template");
                            let rank = 1; // Initialize rank counter

                            for (var i = 0; i < obj.rows.length; i++) {
                                let most_used_card = most_used_template.content.cloneNode(true);
                                
                                most_used_card.querySelector(".js-contraceptive-rank").innerHTML = "" + rank; // Set the rank

                                // Set the color of the <i> tag based on rank
                                let iconElement = most_used_card.querySelector(".fa-award");
                                if (rank === 1) {
                                    iconElement.style.color = "#ffd700"; // Change color for rank 1
                                } else if (rank === 2) {
                                    iconElement.style.color = "#929292"; // Change color for rank 2
                                } else if (rank === 3) {
                                    iconElement.style.color = "#CD7F32"; // Change color for rank 3
                                }

                                if(typeof obj.rows[i].birth_control == 'object'){
                                    most_used_card.querySelector(".js-contraceptive-icon").src = obj.rows[i].birth_control.icon;
                                    most_used_card.querySelector(".js-contraceptive-link").href = 'about-contraceptive.php?id=' + obj.rows[i].birth_control.id;
                                }

                                most_used_card.querySelector(".js-contraceptive-name").innerHTML = obj.rows[i].birth_control_name;
                                most_used_card.querySelector(".js-contraceptive-short-description").innerHTML = (typeof obj.rows[i].birth_control == 'object') ? obj.rows[i].birth_control.short_desc : 'No Data';
                                most_used_card.querySelector(".js-contraceptive-number-of-users").innerHTML = obj.rows[i].usage_count;
                                
                                most_used_container.appendChild(most_used_card);
                                rank++; // Increment the rank counter
                            }

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

    most_used_method.load_most_used_contraceptives();
</script>