<?php
    require("connect.php");
    require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>References | SiPa</title>
</head>
<body style="background: #F2F5FF;">
<?php include('header.php') ?>
    <section>
        <div class="container">
            <div class="container rounded-5" style="background: #D2E0F8;">
                <div class="row mx-5 mb-5 justify-content-center" style="text-align:center; padding: 2%;">
                    <div class="col-auto"><p style="font-size: 3rem;">References</p></div>
                </div>
            </div>
            <div class="js-rrl-container" id="rrl-container">
                <!-- List of RRLs -->
            </div>
        </div>
        
    </section>

    <template class="js-rrl-template" id="rrl-template">
        <div class="js-rrl-item pb-4">
            <p class="js-rrl-title" style="margin-bottom:0px; font-weight:600;">Literature 1</p>
            <p class="js-rrl-content" style="margin-bottom:0px; display:inline;">Content of literature 2...</p>
            <a class="js-rrl-link" href="#" style="text-decoration:none;"></a>
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
                                    linkElement.innerHTML = "<i class='fa-solid fa-arrow-up-right-from-square' style='font-size: 12px;'></i>";
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