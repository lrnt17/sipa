<?php 
    require("connect.php");
    require('functions.php');

    $birth_control_id = $_GET['id'];
    
    $query = "select * from birth_controls where birth_control_id = '$birth_control_id' limit 1";
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
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title><?=$row['birth_control_name']?> | SiPa</title>
    <style>
        .method-pic{
            width: 100px;
            height: 100px;
        }
        @media (max-width: 550px) {
            .method-name{
                font-size:2.5rem !important;
            }
        }

        @media (max-width: 450px) {
            .method-name{
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
                    <img src="<?=get_image($row['birth_control_img'])?>" class="method-pic " style="width: 100%; height: auto; object-fit: cover; filter: brightness(70%);">
                    <h4 class="method-name" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:3.5rem;  color:white; "><?=$row['birth_control_name']?></h4>
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
                                        <h3>About</h3>
                                    </div>
                        </div>
                    <div>

                    <div class="row mt-5 mb-4">
                        <div class="container rounded-4 shadow-sm p-4" style="background:#ffff;">
                            <h4>What is <span><?=$row['birth_control_name']?></span>?</h4>
                            <p class="mt-3" style="color:#383838;" align="justify"><?=$data = nl2br($row['birth_control_desc'])?></p>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row mx-3">
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-circle-check" style="font-size: 24px; color: #618858;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Positive</h5>
                                        <section class="js-contraceptive-positive-info">
                                            <div style="padding: 10px; text-align: center;">Loading Positive info....</div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="fa-regular fa-circle-xmark" style="font-size: 24px; color: #9D3737;"></i>
                                    </div>
                                    <div class="col">
                                        <h5 style="font-weight: bold;">Negative</h5>
                                        <section class="js-contraceptive-negative-info">
                                            <div style="padding: 10px; text-align: center;">Loading Negative info....</div>
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
                            <h5 style="font-weight:bold;">Did you know?</h5>
                            <section class="js-contraceptive-fyi-info">
                                <div style="padding:10px;text-align:center;">Loading Did you know info....</div>
                            </section>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col d-flex justify-content-center align-items-center">
                            <div class="mt-5">
                                <a href="comparison-chart.php" class="btn my-3 px-5 py-3 rounded-4 shadow-sm rounded" style="background: #ffff;">Compare contraceptive methods</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div>
                    <div>
                        Contraceptive method details not found!
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
            <h1 class="d-flex justify-content-center" style="color:#383838;">Other Contraceptive Methods</h1>
        </div>
    </div>

    <?php include('contraceptive-carousel.php') ?>
    
    <!-- template for contraceptive positive effects -->
    <template id="positive-info-template">
        <div class="js-positive-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive negative effects -->
    <template id="negative-info-template">
        <div class="js-negative-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive did you know info -->
    <template id="fyi-info-template">
        <div class="js-fyi-info-list py-2" style="color:#383838;">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <?php include('footer.php') ?>
</body>
<script>

    var birth_control_id = <?php echo json_encode($birth_control_id); ?>;
    
    var load_method_info = {

        loadData: function(id){
            console.log(id);

            let form = new FormData();
            form.append('birth_control_id', id);
            form.append('data_type', 'load_method_info');
            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let data = JSON.parse(ajax.responseText);
                        //console.log(ajax.responseText);
                        let positive_table_list = document.querySelector(".js-contraceptive-positive-info");
                        positive_table_list.innerHTML = "";

                        let negative_table_list = document.querySelector(".js-contraceptive-negative-info");
                        negative_table_list.innerHTML = "";

                        let fyi_table_list = document.querySelector(".js-contraceptive-fyi-info");
                        fyi_table_list.innerHTML = "";

                        if(data.positive_rows_success){
                            
                            let template = document.querySelector("#positive-info-template");

                            for (let i = 0; i < data.positive_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                            let text = data.positive_rows[i].positive_effect_desc;
                            text = text.replace(/\n/g, "<br>");
                            row.querySelector(".js-positive-info-list").innerHTML = text;
                                
                                positive_table_list.appendChild(row);
                            }
                        } else {
                            positive_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.negative_rows_success){
                            
                            let template = document.querySelector("#negative-info-template");

                            for (let i = 0; i < data.negative_rows.length; i++) {
                            let row = document.importNode(template.content, true);
                            let text = data.negative_rows[i].negative_effect_desc;
                            text = text.replace(/\n/g, "<br>");
                            row.querySelector(".js-negative-info-list").innerHTML = text;

                            negative_table_list.appendChild(row);
                        }

                        } else {
                            negative_table_list.innerHTML = "No data found";
                        }
                        //--------------------------------------------------------------------------
                        if(data.fyi_rows_success){
                            
                            let template = document.querySelector("#fyi-info-template");

                            for (let i = 0; i < data.fyi_rows.length; i++) {
                                let row = document.importNode(template.content, true);
                                row.querySelector(".js-fyi-info-list").textContent = data.fyi_rows[i].fyi_desc;

                                fyi_table_list.appendChild(row);
                            }
                        } else {
                            fyi_table_list.innerHTML = "No data found";
                        }
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

    };

    load_method_info.loadData(birth_control_id);
</script>
</html>