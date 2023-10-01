<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>
    <div>
        <h1>Top 3 Most Used Contraceptives</h1>
        <div class="js-most-used-contraceptives" id="most-used-contraceptives">

        </div>
    </div>
    
</section>

<template class="js-most-used-template" id="most-used-template">
    <div class="contraceptive-item">
        Used by <p class="js-contraceptive-number-of-users">Number of users: ...</p>
        <h3 class="js-contraceptive-name">Contraceptive Name</h3>
        <div class="contraceptive-icon">
            <img src="" alt="" class="js-contraceptive-icon" width="25" height="25">
        </div>
        <p class="js-contraceptive-short-description">Description of the contraceptive...</p>
        <p class="read px-2 mt-2"><a class='js-contraceptive-link' href='#' style="text-decoration: none; color: black; font-size:13px;"><i class="fa-solid fa-circle-info"> </i> READ MORE</a></p>
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

                            for (var i = 0; i < obj.rows.length; i++) {
                                let most_used_card = most_used_template.content.cloneNode(true);
                                
                                if(typeof obj.rows[i].birth_control == 'object'){
                                    most_used_card.querySelector(".js-contraceptive-icon").src = obj.rows[i].birth_control.icon;
                                    most_used_card.querySelector(".js-contraceptive-link").href = 'about-contraceptive.php?id=' + obj.rows[i].birth_control.id;
                                }

                                most_used_card.querySelector(".js-contraceptive-name").innerHTML = obj.rows[i].birth_control_name;
                                most_used_card.querySelector(".js-contraceptive-short-description").innerHTML = (typeof obj.rows[i].birth_control == 'object') ? obj.rows[i].birth_control.short_desc : 'No Data';
                                most_used_card.querySelector(".js-contraceptive-number-of-users").innerHTML = obj.rows[i].usage_count;
                                
                                most_used_container.appendChild(most_used_card);
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