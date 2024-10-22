<?php

    require("connect.php");
    require('functions.php');
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>SiPa | Right for Me</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    }

    input:disabled + label {
  color: lightgray;
    }
    #start_date_picker {
    display: none;
  }
  /* CSS to resize the calendar container */
  .flatpickr-calendar {
    width: fit-content; /* You can adjust this value to your preferred width */
    border-radius: 5%;
    padding: 20px;
    margin-left: 50px;
  }

  /* Adjust the positioning and styling of the dropdown menu */
  .input-container {
  display: flex;
  align-items: center;
  padding: 10px;
}

label {
  margin-right: 10px;
}

.separator {
  color: #888;
  margin: 0 10px;
}

#usage-input {
  padding: 5px;
  width: 80px; /* Adjust this width as needed */
}

select {
  padding: 5px;
  color: blue;
}

.img_container {
    overflow: hidden; /* Hide any overflow from the image */
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }

  /* Add blue hover effect */
  .method_btn.hover:hover {
      background-color: #D2E0F8;
  }

  input:focus{
      outline: none;
  }

  .custom-width-hidden {
  display: none;
  }

  .custom-width-hidden p {
    width: 600px; /* Set the desired width */
  } 

  .circle {
    padding: 1%;
    background-color: #D2E0F8;
    width: 3em;
    height: 3em;
    border-radius: 100%;
    text-align: center;
    font-size: 3em;
    line-height: 2.2em;
    font-weight: 100;
    margin-left: auto;
    margin-right: auto;
    margin-top: 1.5%; 
    margin-bottom: 1.5%; 
  }

  .continue_btn:hover{
    /*background-color: #F2C1A7 !important;*/
     color:#1F6CB5 !important;
  }

  .read:hover {
            opacity: 0.6;
  }


  .rating {
  font-size: 30px;
  }

  .star {
  color: #DBDBDB;
  transition: color 0.2s;
  font-size:20px;
  }

  .star.active {
  color: #915E98;
  font-size:20px;
  }

  .swipe{
        display:none;
    }

    @media (max-width: 450px) {
            .swipe{
                display: flex;
            }
        }

   </style>
   

</head>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row justify-content-center" style="text-align:center; padding: 2%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Contraception Method</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Result</p></div>
        </div>
    </div>
    <br><br>
    <div class="container mt-3">
        <div class="row flex-nowrap pb-4" id="reco-title" style="align-items: center;"> 
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col mt-3">
                <h5>Your recommendation</h5>
                <p> Batay sa iyong mga sagot, ito ang mga top <span class="js-num-of-rank-methods"></span> na mga method na maaari mong i-consider.</p>
            </div>
        </div>

    
  <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recommendations from the POST data
    $recommendationsJson = $_POST['recommendations'];

    // Convert the JSON string back to a PHP array
    $recommendations = json_decode($recommendationsJson, true);
    //print_r($recommendations);
    //$recommendationsJson = json_encode($recommendations);
    // Check if $recommendations is not empty
    if (!empty($recommendations)) {
        // Start a flex container to display items horizontally
        echo '<div class="container d-flex justify-content-center">';
        echo '<div class="row" style="justify-content: space-evenly;">';
        $birthControlIds = array();
        // Now, you can use the $recommendations array as needed
        // For example, you can loop through the recommended contraceptive methods:
        // Loop through the recommendations and fetch the corresponding contraceptive method information
        foreach ($recommendations as $method) {
            $methodSafe = mysqli_real_escape_string($conn, $method);
            // Remove spaces from the method name and convert to lowercase
            $methodSafeFormatted = strtolower(str_replace(' ', '', $methodSafe));
            //print_r($methodSafeFormatted);
            // Query the database to fetch the contraceptive method information
            $query = "SELECT * FROM birth_controls WHERE LOWER(REPLACE(birth_control_name, ' ', '')) = '$methodSafeFormatted'";
            $result = mysqli_query($conn, $query);
            
            // Check if the method exists in the birth_controls table
            if (mysqli_num_rows($result) > 0) {
                // Fetch all rows corresponding to the contraceptive method (in case there are multiple matches)
                while ($row = mysqli_fetch_assoc($result)) {
                    //print_r($row['birth_control_id']);
                    $birthControlIds[] = $row['birth_control_id'];
                    // Display the contraceptive method information
                    // Insert the missing HTML code here
                    echo '<div class="col-sm-12 col-lg-4">';
                    echo '<div class="container d-flex justify-content-center">';
                   // echo '<div class="card mx-1 my-5 rounded-4" style="width: 80%; min-height: 450px; background-color:#BDD8F0;">';
                   // echo '<div class="container rounded-4 justify-content-center" style="text-align: center; background: white; width: 100%; max-height: 200px; position: relative; overflow: hidden; padding: 0;">';
                   // echo '<img src="' . $row["birth_control_img"] . '" class="card-img-top" style="width: 100%; height: auto; object-fit: cover;" alt="...">';
                   // echo '</div>';
                   // echo '<div class="card-body" style=" min-height:14rem; overflow:hidden;">';
                   // echo '<h5 class="card-title" style="text-align:center; color:#3B3B3B; cursor:pointer;"><a href="about-contraceptive.php?id=' . $row['birth_control_id'] . '" style="text-decoration: none;">' . $row["birth_control_name"] . '</h5></a>';
                   // echo '<p class="card-text mt-3">What it is?</p>';
                   // echo '<p class="card-text" style="overflow: hidden;margin-top: -3%;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 4;text-overflow: ellipsis;">' . $row["birth_control_short_desc"] . '</p>';
                   // echo '<p class="read px-2 mt-2"><a class="js-method-link" href="about-contraceptive.php?id=' . $row['birth_control_id'] . '" style="text-decoration: none; color: black; font-size:13px;"><i class="fa-solid fa-circle-info"> </i> READ MORE</a></p>';
                   // echo '</div>';
                   // echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Handle the case where the method name is not found in the birth_controls table
                echo "<p>Contraceptive method '$method' not found.</p>";
            }
        }

        $top_three_method_ids = json_encode($birthControlIds);
        // Close the div tags for the flex container
        echo "</div>";
        echo "</div>";
    }
     
    else {
        // Handle the case where $recommendations is empty, ***IF ALANG MARERECOMMEND DAHIL NAUBOS NA SCORE OR NADISABLE NA YUNG METHOD, ETO LALABAS NA MESSAGE WITH CONTINUE BUTTON****
        //------------------------------Pacss nalang po ito ng mas maayos ---------------------------------------
        echo"<div class='row my-5' style='align-items: center;'>";
          echo"<div class='col-md-7 py-3 px-4 mb-4 ' style='background:;'>";
            echo"<center><h1><i class='fa-solid  fa-face-frown my-4' style='color:#4C5DA9; font-size:4rem;'></i></h1></center>";
            echo "<h5 class='mb-4'>Batay sa resulta ng iyong pagsusuri, wala kaming maire-rekomenda na method sa iyo sa ngayon. Ipinapayo na makipag-ugnayan sa isang doktor upang tulungan ka sa pagpili ng pinakamahusay paraan para sa iyo.</h5>";
          echo "</div>";

          echo"<div class='col'>";
            echo"<img class='' src='no_reco.png' alt='' width='100%' style=''>";
          echo "</div>";
        echo "</div>";

        echo "<div class='col mt-3 d-flex justify-content-center'>";
        echo "<a class='js-link' href='right_for_me_1.php' style=' text-decoration: none; color:black;'>";
        echo "<button class='btn my-3 px-4 py-2 rounded-3 shadow-sm rounded continue_btn' style='background: #ffff;'>Continue</button>";
        echo "</a>";
        echo "</div>"; //-------------gang dito langs------------------
        
        echo '<form id= "back_btn" action="right_for_me_quiz.php" method="post">';
        echo  '<div class="row mt-2" >';
        echo '<div class="col-auto">';
        echo '<button id="next-3-months" class="btn" style="font-size:20px; color:#1F6CB5; float:right;"><i class="fa-solid fa-circle-chevron-left"></i></button>';
        echo '</div>';       
        echo '<div class="col-auto">';         
        echo '<p style="margin-top:10px;">Back</p>';            
        echo '</div>';       
        echo '</div>'; 
        echo '</form>';

        // JavaScript code to hide the reco-title div if recommendations are empty
        echo '<script type="text/javascript">';
        echo '    document.getElementById("reco-title").style.display = "none";';
        echo '</script>';
       include('footer.php');
        return;
    }
}
?>

<p align="justify" class="mb-5 mt-3" style="font-weight:300; font-size:15px;"> 
        <b>Paalala</b> : Ang aming mga rekomendasyon ay layunin lamang na magbigay-kaalaman sa iyo tungkol sa mga potensyal na paraan ng kontrasepsyon batay sa iyong ibinigay na impormasyon. Ang pagsusulit na ito ay ginawa sa pamamagitan ng gabay ng isang kwalipikadong tagapagkalinga ng kalusugan para sa personalisadong gabay sa pagpili ng kontrasepsyon. Gayunpaman, hindi ito pumapalit sa propesyonal na payo medikal. Ikaw ang huling magdedesisyon kung alin sa tingin mo ang pinakatamang paraan para sa iyo. Ikaw ang responsable sa kahusayan ng impormasyong ibinigay. Hindi kami mananagot para sa anumang pinsala o kawalan dulot ng paggamit ng website o pagtitiwala sa mga rekomendasyon.
</p>
<div class="swipe p-3  mb-4 ms-2 me-2 rounded-4" style="background: #e9a886;">
<p align="justify" style="font-weight:500; margin:0;">Swipe left to view other recommended methods.</p>
</div>

<?php include('quiz-result-dss.php') ?>

    

        <form id= "back_btn" action="right_for_me_quiz.php" method="post">
            <div class="row mt-2" >
                  <div class="col-auto">
                      <button id="next-3-months" class="btn" style="font-size:20px; color:#1F6CB5; float:right;"><i class="fa-solid fa-circle-chevron-left"></i></button>
                  </div>
                  <div class="col-auto">
                      <p style="margin-top:10px;">Back</p>
                  </div>
              </div>
            <div>
            <!-- <input class="btn" type="submit" value="Back" name="submit_back">-->
        </form>
    </div>

<div id="method_buttons_container">

    <div class="row mt-5 mb-3 flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #915E98;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;
                white-space: nowrap;"></div>
            </div>
        
            <div class="col">
                <h5>Pumili ng contraceptive method batay sa resulta ng iyong pagsusuri.</h5>
                <p>Kung hindi sigurado, maaari kang mag-click ng skip button sa ibaba.</p>
            </div>
    </div>
  <!-- New Save Button -->
  <!-- Note: Removed the inline "display: none" style from the button -->
  <button id="save_method_button" style="display:none;">Save Method Only</button>
</div>

<form id= "skip_btn" action="right_for_me_1.php" method="post">
            <div class="row mt-2" style="justify-content: flex-end;">
                <div class="col-auto">
                          <p style="margin-top:10px;">Skip</p>
                </div>
                <div class="col-auto">
                        <button id="next-3-months" class="btn" style="font-size:20px; color:#1F6CB5; float:right;" onclick="change_first_logged_in()"><i class="fa-solid fa-circle-chevron-right"></i></button>
                </div>
            </div>
</form>

<div id="how_to_use_div" style="display:none;">
    <div class="d-grid p-3 px-3 rounded-4 my-4 mb-5" style="background: #fff;">
        <p class="text-start"><b></b></p>
        <p style="text-align: justify;"></p>
    </div>
</div>

<div id="not_applicable_div" style="display:none;">
  <div class="d-grid  p-3  px-3 rounded-4 my-4 mb-5" style="background: #e9a886;" >
    <p class="text-start" >
    <div style="text-align: center;">
    <i class="fa-solid fa-prescription mb-4" style="font-size:30px;"></i>
    </div>Ang iyong napiling method ay hindi nangangailangan ng SMS reminder sapagkat ito ay ginagamit tuwing kailangan mo ito. Siguruhing sundin ang mga directions kung paano ito gamitin upang mapanatili ang epektibong paggamit nito!</p>
  </div>
        <div class="col mt-3 d-flex justify-content-center">
            <a class="js-link" href="right_for_me_1.php" style=" text-decoration: none; color:black;">
                <button class="btn my-3 px-4 py-2 rounded-3 shadow-sm rounded continue_btn" style="background: #ffff;">Continue</button>
            </a>
        </div>
</div>

<div id="sms_reminder_btn" style="display: none;">
  <div class="row my-4 flex-nowrap" style="align-items: center;">
              <div class="col-auto">
                  <div class="vl" style="width: 10px;
                  background-color: #1F6CB5;
                  border-radius: 99px;
                  height: 75px;
                  display: -webkit-inline-box;"></div>
              </div>
          
              <div class="col mt-3">
                  <h5>SMS</h5>
                  <p>Contraceptive method sa pamamagitan ng SMS</p>
                  
              </div>
  </div>
      <div class="row ms-3 flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 20px;
                background-color: #CAA4D0;
                border-radius: 99px;
                height: 20px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col mt-2">
                <div class="row">
                    <div class="col-auto"><p style="color:#5A5A5A;">Nais mo bang tumanggap ng SMS reminders sa paggamit ng iyong napiling contraceptive method ayon sa rekomendasyon?</p></div>
                </div>
            </div>
        </div>
  <!-- Move the "Remind Me!" button inside the form -->
  <div class="center-container" style="text-align: center;position: relative;">
    <div class="circle shadow-sm" id="circle1" style="background-color: #F2C1A7; position: absolute; width: 3.1em; height: 3.1em;
    left: 48.7%; transform: translate(-47%, -6%); z-index: -2;"></div>

    <div class="circle shadow-sm" id="circle2" style="background-color: #CAA4D0; position: absolute; width: 3.1em; height: 3.1em; left: 51%;
    transform: translate(-55%, 5%); z-index: -1;"></div>
  </div>

  <form class="circle shadow-sm" id="sms_reminder_form" action="#" method="post" class="m-5">
    <input type="submit" value="Remind Me!" name="submit_remind" id="remind_me_btn" class="btn" style="font-weight: 600; margin-top: 10%;">
  </form>


  <div class="col mt-3 d-flex justify-content-center">
            <a class="js-link" href="right_for_me_1.php" style=" text-decoration: none; color:black;">
                <button class="btn my-3 px-4 py-2 continue_btn" id="no-tnx-btn" style="background: transparent;">No Thanks</button>
            </a>
        </div>

</div>


<div class="input-container" style=" width: ; display: none;" >
<div class="row ms-3 flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 20px;
                background-color: #4574C4;
                border-radius: 99px;
                height: 20px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col mt-2">
              <p style="color:#5A5A5A;">Ilang beses mo nais gamitin ang method na ito?</p>
            </div>
</div>

<div class="row mx-5">
    <p class="mx-2" style="font-size:12px; color:#5A5A5A;">(Ex.: 2 times, at ang Mini Pill ay ang napiling method. Ikaw ay makakatanggap ng SMS reminders ng 2 buwan dahil ikaw ay kukuha ng <b>2 packs ng pills</b>.) </p>
</div>

<!--niliitan ko lang to kasi parang note lang sya ikaw na po bahala mag adjust -->
  <div class="mx-3">
    <div class="input-container mx-5 my-3 rounded-3 shadow-sm px-4 py-3" style="background-color: white; width: 250px;">
      <label for="usage">Usage </label>
      <span style="width: 4px;
        background-color: #7B7777;
        border-radius: 99px;
        height: 33px;
        display: inline-block;
        margin-left: 7px;"></span>
      <input type="text" style="border:none; padding-left:35px;" id="usage-input" pattern="[0-9]*" maxlength="2" placeholder="00">
      <label for="time" style="color:#1F6CB5;"> time/s</label>
    </div>
  </div>

</div>

<!-- Create a container for the Save button -->
<div id="save_button_container_txt" class="my-4 custom-width-hidden" >
  <div class="d-flex justify-content-end" style="text-align: right;">  
    <p style="font-size:14px; color:#5A5A5A;">Kapag na-save na ang iyong mga input, ikaw ay magsisimulang makatanggap ng SMS reminders para sa pag-inom o paggamit ng iyong napiling contraceptive method.</p>
  </div>
</div>


<script>
  let selectedMethod = ''; // Variable to store the selected contraceptive method
  let dateFilled = false; // Variable to track if the date picker is filled
let usageFilled = false; // Variable to track if the usage input is filled

  const recommendationsJson = '<?php echo addslashes($_POST['recommendations']); ?>';
    const recommendations = JSON.parse(recommendationsJson);

    const container = document.getElementById("method_buttons_container");
    container.style.display = "block";

    recommendations.forEach(function (method) {
      fetchMethodDetails(method, container);
    });
    

    /*document.getElementById("save_method_button").addEventListener("click", function () {
  if (selectedMethod) {
    const saveMethodOnlyButton = document.getElementById("save_method_button");
    saveMethodOnlyButton.style.display = "none";

    const smsReminderForm = document.getElementById("sms_reminder_btn");
    smsReminderForm.style.display = "none";

    const remindMeButton = document.getElementById("remind_me_btn");
    remindMeButton.style.display = "none"; // Hide the "Remind Me!" button when "Save Method Only" is clicked
  }});
  */

document.getElementById("remind_me_btn").addEventListener("click", function (event) {
  event.preventDefault();
  const remindMeButton = document.getElementById("remind_me_btn");
  const remindCon = document.getElementById("sms_reminder_form");
  const cir1 = document.getElementById("circle1");
  const cir2 = document.getElementById("circle2");
  remindMeButton.style.display = "none"; // Hide the "Remind Me!" button when clicked
  remindCon.style.display = "none";
  cir1.style.display = "none";
  cir2.style.display = "none";
  const noThanksBtn = document.getElementById("no-tnx-btn");
  noThanksBtn.style.display = "none";

  showDatePicker();
});

function fetchMethodDetails(method, container) {

    

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const methodDetails = JSON.parse(xhr.responseText);
          const button = document.createElement("button");
                button.classList.add("method_btn", "btn", "mx-3","my-3", "btn-light", "shadow-sm");

                // Set the width and height of the button
                button.style.width = "150px"; // Adjust the width as needed
                button.style.minHeight = "190px"; // Adjust the height as needed

                button.classList.add("hover");

                const methodNameDiv = document.createElement("div");
                methodNameDiv.textContent = methodDetails.birth_control_name;
                methodNameDiv.classList.add("method_name");
                methodNameDiv.style.minHeight="50px";
                methodNameDiv.style.display="flex";
                methodNameDiv.style.justifyContent="center";
                methodNameDiv.style.alignItems="center";
                button.appendChild(methodNameDiv);

                const imgDiv = document.createElement("div");
                imgDiv.classList.add("img_container", "rounded-3", "shadow-sm"); // Add this class for styling
                imgDiv.style.height="94px";

                const img = document.createElement("img");
                img.src = methodDetails.birth_control_img;
                img.alt = methodDetails.birth_control_name;
                img.style.width = "auto";
                img.style.maxHeight = "100%";
                img.style.objectFit = "contain"; // Make the image fit within the container
                imgDiv.appendChild(img);

                button.appendChild(imgDiv);

                button.setAttribute("data-selected", "false");
                container.appendChild(button);

          // Add an event listener to handle button selection
          button.addEventListener("click", function () {
            selectedMethod = methodDetails.birth_control_name; // Store the selected method
            const isSelected = button.getAttribute("data-selected") === "true";
            
            const skipbutton = document.getElementById("skip_btn");

            // If the button is already selected, remove it from the view
            if (isSelected) {
              button.style.display = "none";
            } else {
              const methodButtons = container.querySelectorAll(".method_btn");
              methodButtons.forEach(function (otherButton) {
                if (otherButton !== button) {
                  otherButton.style.display = "none";
              skipbutton.style.display = "none";
                }
              });

               // Change the button color when selected
                button.style.backgroundColor = "#D2E0F8"; 


               // Make the AJAX request to save the selected contraceptive method
   const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            change_first_logged_in();
            showHowToUse(selectedMethod);
            alert("Contraceptive method successfully saved!\n\n[Reminder]:\nYou should stick with your chosen contraceptive method until the end of its cycle.\n\nIf you ever plan to change methods, it is advisable to wait for a year if the previous method is a hormonal type. Thank you!");
          } else {
            alert("Error saving contraceptive method. Please try again.");
          }
        } else {
          alert("Error saving contraceptive method. Please try again.");
        }
      }
    };

    xhr.open("POST", "save_method_only.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const user_id = '<?php echo $_SESSION['USER']['user_id']; ?>';
    xhr.send(
      "user_id=" + encodeURIComponent(user_id) + "&selected_method=" + encodeURIComponent(selectedMethod)
    );
            // Check if the selected method is one of the listed methods
    const notApplicableSMSMethod =
          ["condom", "diaphragm", "spermicide", "withdrawal method", "calendar method", "temperature method", "emergency contraception", "vasectomy", "tubal ligation"].includes(
            methodDetails.birth_control_name.toLowerCase()
          );
              // Show the reminder button only if it's not a special method
            if (!notApplicableSMSMethod) {
              showReminderButton();
            }
            else{
              const notApplicable = document.getElementById("not_applicable_div");
              notApplicable.style.display = "block";
            }
            }
          });
        } else {
          console.error("Error fetching method details");
        }
      }
    };

    xhr.open("GET", `get_method_details.php?method_name=${encodeURIComponent(method)}`, true);
    xhr.send();
}

function showHowToUse(selectedMethod) {
    // Set the selected method in the HTML content
    const methodTitle = document.querySelector("#how_to_use_div b");
    methodTitle.innerHTML = `<i class="fa-solid fa-lightbulb fa-bounce"></i> Narito ang tamang paggamit o proseso ng ${selectedMethod}:`;

    // Fetch the how_to_use information for the selected method
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const howToUse = xhr.responseText;
                // Set the how_to_use content in the HTML
                const howToUseContent = document.querySelector("#how_to_use_div p[style='text-align: justify;']");
                //howToUseContent.textContent = howToUse;
                // Use innerHTML to process newline characters as HTML line breaks
                howToUseContent.innerHTML = howToUse.replace(/\n/g, '<br>');
                // Add a line height to the content
                howToUseContent.style.lineHeight = '1.5';
                // Show the how_to_use_div
                const howToUseDiv = document.getElementById("how_to_use_div");
                howToUseDiv.style.display = "block";
            } else {
                console.error("Error fetching how_to_use information");
            }
        }
    };

    xhr.open("GET", `get_how_to_use.php?method_name=${encodeURIComponent(selectedMethod)}`, true);
    xhr.send();
}

  function showReminderButton() {
  const smsReminderBtn = document.getElementById("sms_reminder_btn");
  smsReminderBtn.style.display = "block";
}


function showDatePicker() {
  const datePickerContainer = document.createElement("div");
  datePickerContainer.id = "date_picker_container";
  datePickerContainer.classList.add("m-4");

  const datePickerLabel = document.createElement("label");
  datePickerLabel.textContent = "Pumili ng petsa kung kailan mo nais simulan ang iyong contraceptive method: ";

   // Create and append the provided HTML content
   const additionalContent = document.createElement("div");
  additionalContent.innerHTML = `
    <div class="row mb-4 flex-nowrap" style="align-items: center; padding-left:7px;">
      <div class="col-auto">
        <div class="vl" style="width: 20px; background-color: #e9a886; border-radius: 99px; height: 20px; display: -webkit-inline-box;"></div>
      </div>
      <div class="col mt-2">
        <p style="color:#5A5A5A;">Pumili ng petsa kung kailan mo nais simulan ang iyong contraceptive method: </p>
      </div>
    </div>
  `;
  datePickerContainer.appendChild(additionalContent);

  const datePickerInput = document.createElement("input");
  datePickerInput.type = "text";
  datePickerInput.id = "start_date_picker";
  datePickerInput.setAttribute("placeholder", "Select a date...");

 // datePickerContainer.appendChild(datePickerLabel);
  datePickerContainer.appendChild(datePickerInput);

  const inputContainer = document.querySelector(".input-container");
  inputContainer.style.display = "block"; // Show the usage input container

  // Append the date picker container after the "Remind Me!" button div
  document.getElementById("sms_reminder_btn").insertAdjacentElement('afterend', datePickerContainer);

  // Create a flatpickr instance for the date picker input
  flatpickr(datePickerInput, {
    dateFormat: "Y-m-d",
    enableTime: false,
    minDate: "today",
    inline: true, // Display the calendar without a need to click on the input
    onChange: function(selectedDates, dateStr, instance) {
      // This function is triggered when a date is selected
    dateFilled = !!datePickerInput.value; // Convert to boolean, true if filled, false if empty
    checkShowSaveButton();
    }
  });

  // Event listener for usage input
  const usageInput = document.getElementById("usage-input");
  usageInput.addEventListener("input", function () {
    // Remove any non-numeric characters from the input
    this.value = this.value.replace(/\D/g, '');
    usageFilled = !!usageInput.value; // Convert to boolean, true if filled, false if empty
    checkShowSaveButton();
  });

  // Create and append the "Save" button
  const saveButton = document.createElement("button");
  saveButton.id = "save_date_button";
  saveButton.textContent = "Save";
  saveButton.style.display = "none"; // Hide the save button initially
  saveButton.disabled = true;
  saveButton.classList.add("btn","px-4", "shadow-sm");
  saveButton.style.background ="#C5A6C9";
  saveButton.style.color ="white";


  saveButton.addEventListener("click", function () {
    const selectedDate = datePickerInput.value;
    const formattedDate = selectedDate.split("T")[0];
    updateStartDate(formattedDate);
  });

  // Create a div to contain the "Save" button
  const saveButtonDiv = document.createElement("div");
  saveButtonDiv.classList.add("d-flex", "justify-content-end", "mt-4"); // Bootstrap classes for flex and alignment
  saveButtonDiv.id = "save_button_container"; // You can add an id to the div if needed
  saveButtonDiv.appendChild(saveButton);


  // Get the usage input container
  const usageInputContainer = document.querySelector(".input-container");

  // Append the "Save" button after the usage input container
  usageInputContainer.insertAdjacentElement('afterend', saveButtonDiv);


  // Remove the input field from the container pangalis ng input para rekta calendar nalang 
  datePickerContainer.removeChild(datePickerInput);
}


// Add event listener for the date picker to check if it's filled
document.getElementById("start_date_picker").addEventListener("change", function () {
  dateFilled = !!this.value; // Convert to boolean, true if filled, false if empty
  checkShowSaveButton();
});

// Add event listener for the usage input to check if it's filled
document.getElementById("usage-input").addEventListener("input", function () {
  usageFilled = !!this.value; // Convert to boolean, true if filled, false if empty
  checkShowSaveButton();
});

// Function to check whether to show the save button or not
function checkShowSaveButton() {
  const saveButton = document.getElementById("save_date_button");
  const saveButtonContainer = document.getElementById("save_button_container_txt");
  const usageValue = parseInt(usageInput.value, 10); // Parse the usage input value as an integer
  
  if (dateFilled && usageFilled && usageValue !== 0) {
    saveButton.style.display = "block";
    saveButtonContainer.style.display = "block";
    saveButton.disabled = false;
  } else {
    saveButton.disabled = true;
  }
}

  function updateStartDate(formattedDate) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          alert("Selected contraceptive method, start date, and usage saved to the database. Please check the SMS we sent you for more details about your SMS reminders. Thank you!");

          // Redirect to right_for_me_1.php
          window.location.href = 'right_for_me_1.php';

        } else {
          alert("Error updating selected contraceptive method and start date in the database.");
        }
      }
    };

    xhr.open("POST", "save_method_and_start_date.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const user_id = '<?php echo $_SESSION['USER']['user_id']; ?>';
    const usageValue = parseInt(usageInput.value, 10); // Parse the usage input value as an integer
    xhr.send(
      "user_id=" + encodeURIComponent(user_id) + "&selected_method=" + encodeURIComponent(selectedMethod) + "&selected_date=" + encodeURIComponent(formattedDate) + "&birth_control_usage=" + encodeURIComponent(usageValue)
    );
  }

  function change_first_logged_in(){

    let form = new FormData();

    form.append('data_type', 'change_first_logged_in');

    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange',function(){

        if(ajax.readyState == 4)
        {
            if(ajax.status == 200){

                //console.log(ajax.responseText);return;
                let obj = JSON.parse(ajax.responseText);

                if(obj.success){
                    console.log('first logged changed');
                }
            }
        }
        });

    ajax.open('post','ajax.php', true);
    ajax.send(form);
  }
</script>









<!-- footer -->




<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  const usageInput = document.getElementById('usage-input');
  const durationDropdown = document.getElementById('duration-dropdown');

  durationDropdown.addEventListener('change', () => {
    const selectedValue = durationDropdown.value;
    switch (selectedValue) {
      case 'day':
        usageInput.maxLength = 1;
        usageInput.placeholder = '6 days';
        break;
      case 'month':
        usageInput.maxLength = 2;
       usageInput.placeholder = '11 months';
        break;
      case 'year':
        usageInput.maxLength = 2;
        usageInput.placeholder = '10 years';
        break;
      default:
        usageInput.maxLength = 2;
        usageInput.placeholder = '';
    }
  });
</script>


<br><br><br>
<?php include('footer.php') ?>

</body>


</html>
