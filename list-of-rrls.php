<?php
    require("connect.php");
    require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>References | SiPa</title>
</head>
<body>
    <section>
        <div>
            <h1>References:</h1>
            <div class="js-rrl-container" id="rrl-container">
                <!-- List of RRLs -->
            </div>
        </div>
        
    </section>

    <template class="js-rrl-template" id="rrl-template">
        <div class="js-rrl-item">
            <h2 class="js-rrl-title">Literature 1</h2>
            <p class="js-rrl-content">Content of literature 2...</p>
            <a class="js-rrl-link" href="#"></a>
        </div>
    </template>
</body>
<script>

    var rrl = {

        load_rrl: function(e){

            let form = new FormData();

            form.append('data_type', 'load_rrl');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){
                            let rrl_container = document.getElementById("rrl-container");
                            let rrl_template = document.getElementById("rrl-template");

                            for (var i = 0; i < obj.rows.length; i++) {
                                let rrl_card = rrl_template.content.cloneNode(true);

                                rrl_card.querySelector(".js-rrl-title").innerHTML = obj.rows[i].rrl_title;
                                //rrl_card.querySelector(".js-contraceptive-short-description").innerHTML = (typeof obj.rows[i].birth_control == 'object') ? obj.rows[i].birth_control.short_desc : 'No Data';
                                rrl_card.querySelector(".js-rrl-content").innerHTML = obj.rows[i].rrl_desc;
                                
                                if (obj.rows[i].rrl_link) {
                                    let linkElement = rrl_card.querySelector(".js-rrl-link");
                                    linkElement.href = obj.rows[i].rrl_link;
                                    linkElement.innerHTML = "Reference link";
                                }
                                
                                rrl_container.appendChild(rrl_card);
                            }

                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },
    };

    rrl.load_rrl();
</script>
</html>