<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>
    <h1>Contact your barangay health center!</h1>
    <h2>Barangay <span class="js-barangay-name"></span></h2>
    <h2 class="js-barangay-health-center-pnum"></h2>
    
    <br>
    <h2>RHU Bustos</h2>
    <h2>(044) 792 9308</h2>
    <h2>bustosrhu@gmail.com</h2>
</section>

<script>
    var barangay = {

        load_barangay_info: function(e){

            let form = new FormData();

            form.append('data_type', 'load_barangay_info');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
                        //return;
                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){

                            if(typeof obj.rows == 'object') { 

                                for (var i = 0; i < obj.rows.length; i++) {
                                    // Assuming obj contains the properties 'barangay_name' and 'health_center_pnum'
                                    let barangayNameElement = document.querySelector(".js-barangay-name");
                                    let healthCenterPnumElement = document.querySelector(".js-barangay-health-center-pnum");
                                    
                                    barangayNameElement.innerHTML = obj.rows[i].barangay_name;
                                    healthCenterPnumElement.innerHTML = obj.rows[i].health_facility_pnum;
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

    barangay.load_barangay_info();
</script>