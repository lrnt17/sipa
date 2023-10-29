<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<style>
    @media (max-width: 1200px) {
        .contact{
            display:none;
        }

        .contacts{
            margin-top:100px;
        }
    }
    @media (max-width: 992px) {
        .contacts{
            margin-top:5px;
        }
    }
</style>
<section>
    <div class="row mb-5" style="margin-top:90px; align-items: center;">
        <div class="col contact">
            <img class="" src="contact.png" alt="" width="500px" style="">
        </div>
        <div class="col">
            <div class="row" style="justify-content: center;">
                <div class="col-auto contacts">
                    <div class="con px-4 py-3 rounded-4 shadow-sm" style="background:white; ">
                        <h3 style="font-weight:600;">Tumawag sa inyong barangay health center!</h3>
                        <h4 style="font-weight:400;"> <i class="fa-solid fa-location-dot me-3" style="color:#5887DE;"></i>  Barangay <span class="js-barangay-name" style="font-weight:400;"></span></h4>
                        <h4 style="font-weight:400;"> <i class="fa-solid fa-phone me-3" style="color:#5887DE;"></i>  <span class="js-barangay-health-center-pnum" style="font-weight:400;"></span></h4>
                    </div>
                    <div class="con px-4 py-3 rounded-4 shadow-sm mt-4" style="background:white; ">
                        <h3 style="font-weight:600;">RHU Bustos</h3>
                        <h4 style="font-weight:400;"><i class="fa-solid fa-phone me-3" style="color:#5887DE;"></i> (044) 792 9308</h4>
                        <h4 style="font-weight:400;"><i class="fa-solid fa-envelope me-3" style="color:#5887DE;"></i> bustosrhu@gmail.com</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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