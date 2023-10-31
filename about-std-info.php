<?php 
    require("connect.php");
    require('functions.php');


    //echo $_SESSION['USER']['user_id']."<br>";

    $std_id = $_GET['id'];
    
    $query = "select * from std where std_id = '$std_id' limit 1";
	$row = query($query);

	if($row)
	{
		$row = $row[0];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title><?=$row['std_name']?> | SiPa</title>
    <style>
        .std-pic{
            width: 100px;
            height: 100px;
        }
        @media (max-width: 550px) {
            .std-name{
                font-size:2.5rem !important;
            }
        }

        @media (max-width: 450px) {
            .std-name{
                font-size:2.5rem !important;
            }
        }
    </style>
</head>
<body style="background: #F2F5FF;">
    <section>
        <!-- navigation bar with logo -->
        <?php include('header.php') ?>

        <div class="container">
            <?php if(!empty($row)):?>
                <div class="container rounded-4 justify-content-center" style="text-align: center; background: white; width: 85%; max-height: 300px; position: relative; overflow: hidden; border: 10px solid #F2F5FF; z-index: 1; padding: 0;">
                    <img src="<?=get_image($row['std_img'])?>" class="std-pic " style="width: 100%; height: auto; object-fit: cover; filter: brightness(70%);">
                    <h4 class="std-name" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:3.5rem;  color:white; "><?=$row['std_name']?></h4>
                </div>


                <div class="container rounded-4 p-5 shadow-sm" style="background: #D2E0F8;position: relative;top: -104px;">
                    <div class="row mt-5">
                        <div class="row mt-5 flex-nowrap" style="align-items: center;">
                                    <div class="col-auto">
                                        <div class="vl" style="width: 10px;
                                        background-color: #1F6CB5;
                                        border-radius: 99px;
                                        height: 75px;
                                        display: -webkit-inline-box;
                                        white-space: nowrap;"></div>
                                    </div>
                                
                                    <div class="col">
                                        <h3>Tungkol sa <span><?=$row['std_name']?></span></h3>
                                    </div>
                        </div>
                    <div>

                    <div class="row mt-5 mb-4">
                        <div class="container rounded-4 shadow-sm p-4" style="background:#ffff;">
                            <h4>Ano ang <span><?=$row['std_name']?></span>?</h4>
                            <p class="mt-3" style="color:#383838;" align="justify"><?=$data = nl2br($row['std_desc'])?></p>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row mx-3">
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-lightbulb" style="font-size:24px; color:#AFA966;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Simptomas</h5>
                                        <section class="js-std-symptoms-info">
                                            <div style="padding: 10px; text-align: center;">Loading Symptoms info....</div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-circle-check" style="font-size: 24px; color: #618858;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Senyales</h5>
                                        <section class="js-std-signs-info">
                                            <div style="padding: 10px; text-align: center;">Loading Signs info....</div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row py-5">
                        <div class="d-flex justify-content-center">
                            <div style="width: 100%;
                            background-color: #1F6CB5;
                            border-radius: 99px;
                            height: 5px;"></div>
                        </div>
                    </div>
                    
                    <div class="row mx-3">
                        <div class="col-auto">
                            <i class="fa-regular fa-lightbulb" style="font-size:24px; color:#AFA966;"></i>
                        </div>
                        <div class="col">
                            <h5 style="font-weight:bold;">Paano ako makakaiwas sa pagkakaroon ng <?=$row['std_name']?>?</h5>
                            <section class="js-std-preventions-info">
                                <div style="padding:10px;text-align:center;">Loading Preventions info....</div>
                            </section>
                        </div>
                    </div>

                    <div class="row py-5">
                        <div class="d-flex justify-content-center">
                            <div style="width: 100%;
                            background-color: #1F6CB5;
                            border-radius: 99px;
                            height: 5px;"></div>
                        </div>
                    </div>

                    <div class="row mx-3">
                        <div class="col-auto">
                            <i class="fa-solid fa-list" style="font-size:24px; color:#5a5abb;"></i>
                        </div>
                        <div class="col">
                            <h5 class="mb-3" style="font-weight:bold;">References</h5>
                            <div class="js-std-rrl-container">

                            </div>
                        </div>
                        <!-- rrl will display here -->
                    </div>

                </div>
            <?php else:?>
                <div>
                    <div>
                        Std details not found!
                    </div>
                </div>
            <?php endif;?>
        </div>
        
    </section>
    
    <div class="row">
            <div class="d-flex justify-content-center mb-4">
                <div style="width: 15%;
            background-color: #1F6CB5;
            border-radius: 99px;
            height: 6px;"></div>
            </div>
        </div>
        <div class="row">
            <h1 class="d-flex justify-content-center" style="color:#383838;">Iba pang uri ng STDs</h1>
        </div>
    </div>

    <?php include('std-carousel.php') ?>
    
    <!-- template for std symptoms -->
    <template id="symptoms-info-template">
        <div class="js-symptoms-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for std signs -->
    <template id="signs-info-template">
        <div class="js-signs-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for how to prevent std info -->
    <template id="preventions-info-template">
        <div class="js-preventions-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <template class="js-rrl-template" id="rrl-template">
        <div class="js-rrl-item pb-4">
            <p class="js-rrl-title" style="margin-bottom:0px; font-weight:600;">Literature 1</p>
            <p class="js-rrl-content" style="margin-bottom:0px; display:inline;">Content of literature 2...</p>
            <a class="js-rrl-link" href="#" style="text-decoration:none;"></a>
        </div>
    </template>

    <?php include('footer.php') ?>
</body>
<script>

    var std_id = <?php echo json_encode($std_id); ?>;
    
    var load_std_info = {

        loadData: function(id){
            console.log(id);

            let form = new FormData();
            form.append('std_id', id);
            form.append('data_type', 'load_std_info');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        //console.log(ajax.responseText);
                        let symptoms_table_list = document.querySelector(".js-std-symptoms-info");
                        symptoms_table_list.innerHTML = "";

                        let signs_table_list = document.querySelector(".js-std-signs-info");
                        signs_table_list.innerHTML = "";

                        let preventions_table_list = document.querySelector(".js-std-preventions-info");
                        preventions_table_list.innerHTML = "";

                        if(data.symptoms_rows_success){
                            
                            let template = document.querySelector("#symptoms-info-template");

                            for (let i = 0; i < data.symptoms_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-symptoms-info-list").textContent = data.symptoms_rows[i].symptom_desc;
                                
                                symptoms_table_list.appendChild(row);
                            }
                        } else {
                            symptoms_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.signs_rows_success){
                            
                            let template = document.querySelector("#signs-info-template");

                            for (let i = 0; i < data.signs_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-signs-info-list").textContent = data.signs_rows[i].sign_desc;

                                signs_table_list.appendChild(row);
                            }
                        } else {
                            signs_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.preventions_rows_success){
                            
                            let template = document.querySelector("#preventions-info-template");

                            for (let i = 0; i < data.preventions_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-preventions-info-list").textContent = data.preventions_rows[i].prevention_desc;

                                preventions_table_list.appendChild(row);
                            }
                        } else {
                            preventions_table_list.innerHTML = "No data found";
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        loadSTDReferences: function (id) {
            
            let form = new FormData();
        
            form.append('std_id', id);
            form.append('data_type', 'load_std_references');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){

                        let method_references_holder = document.querySelector(".js-std-rrl-container");
                        method_references_holder.innerHTML = "";

                        let template = document.querySelector(".js-rrl-template");
                        
                        if(typeof obj.rows == 'object') {

                            for (var i = 0; i < obj.rows.length; i++) {
                                let rrl_card = template.content.cloneNode(true);
                                
                                rrl_card.querySelector(".js-rrl-title").innerHTML = obj.rows[i].rrl_title;
                                //rrl_card.querySelector(".js-contraceptive-short-description").innerHTML = (typeof obj.rows[i].birth_control == 'object') ? obj.rows[i].birth_control.short_desc : 'No Data';
                                rrl_card.querySelector(".js-rrl-content").innerHTML = obj.rows[i].rrl_desc;
                                
                                if (obj.rows[i].rrl_link) {
                                    let linkElement = rrl_card.querySelector(".js-rrl-link");
                                    linkElement.href = obj.rows[i].rrl_link;
                                    linkElement.innerHTML = "<i class='fa-solid fa-arrow-up-right-from-square' style='font-size: 12px;'></i>";
                                }
                                
                                method_references_holder.appendChild(rrl_card);
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

    load_std_info.loadData(std_id);
    load_std_info.loadSTDReferences(std_id);
</script>
</html>