<?php 
    require("connect.php");
    require('functions.php');

    if(!logged_in()){
		header("Location: home_1_with_user.php");
		die;
	}

    echo $_SESSION['USER']['user_id']."<br>";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$row['birth_control_name']?> | SiPa</title>
    <style>
        .method-pic{
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <section>
        <!-- navigation bar with logo -->
        <?php include('header.php') ?>
        <div>
            <?php if(!empty($row)):?>
                <div>
                    <img src="<?=get_image($row['birth_control_img'])?>" class="method-pic">
                    <h1><?=$row['birth_control_name']?></h1>
                </div>
                <div>
                    <h2>About</h2>
                    <div>
                        <h3>What is <span><?=$row['birth_control_name']?></span>?</h3>
                        <p><?=$row['birth_control_desc']?></p>
                    </div>
                </div>
                <div>
                    <h1>Positive</h1>
                    <section class="js-contraceptive-positive-info">
                        <div style="padding:10px;text-align:center;">Loading Positive info....</div>
                    </section>
                </div>
                <div>
                    <h1>Negative</h1>
                    <section class="js-contraceptive-negative-info">
                        <div style="padding:10px;text-align:center;">Loading Negative info....</div>
                    </section>
                </div>
                <div>
                    <h1>Did you know?</h1>
                    <section class="js-contraceptive-fyi-info">
                        <div style="padding:10px;text-align:center;">Loading Did you know info....</div>
                    </section>
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

    <!-- template for contraceptive positive effects -->
    <template id="positive-info-template">
        <div class="js-positive-info-list">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive negative effects -->
    <template id="negative-info-template">
        <div class="js-negative-info-list">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>

    <!-- template for contraceptive did you know info -->
    <template id="fyi-info-template">
        <div class="js-fyi-info-list">
            is simply dummy text of the printing and typesetting industry.
        </div>
    </template>
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
                                row.querySelector(".js-positive-info-list").textContent = data.positive_rows[i].positive_effect_desc;
                                
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
                                row.querySelector(".js-negative-info-list").textContent = data.negative_rows[i].negative_effect_desc;

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