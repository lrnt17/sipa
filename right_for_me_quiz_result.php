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

   </style>
   

</head>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 2%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Contraception Method</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Result</p></div>
        </div>
    </div>
    <br><br>
    <div class="container mt-3">
        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col mt-3">
                <h5>Your recommendation</h5>
                <p > Based on your answers, these are the methods to consider.</p>
            </div>
        </div>

    
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recommendations from the POST data
    $recommendationsJson = $_POST['recommendations'];
  
    // Convert the JSON string back to a PHP array
    $recommendations = json_decode($recommendationsJson, true);

     // Start a flex container to display items horizontally
     //try lang to sa css para makita yung pagdisplay ng pahorizontal..pwede mo pa iedit hehe 
  echo '<div class="container d-flex justify-content-center">';
  echo '<div class="row" style="justify-content: space-evenly;">';
  
    // Now, you can use the $recommendations array as needed
    // For example, you can loop through the recommended contraceptive methods:
    // Loop through the recommendations and fetch the corresponding contraceptive method information
  foreach ($recommendations as $method) {

    $methodSafe = mysqli_real_escape_string($conn, $method);

    // Remove spaces from the method name and convert to lowercase
    $methodSafeFormatted = strtolower(str_replace(' ', '', $methodSafe));

    // Query the database to fetch the contraceptive method information
    $query = "SELECT * FROM birth_controls WHERE LOWER(REPLACE(birth_control_name, ' ', '')) = '$methodSafeFormatted'";
    $result = mysqli_query($conn, $query);

    // Check if the method exists in the birth_controls table
    if (mysqli_num_rows($result) > 0) {

        // Fetch all rows corresponding to the contraceptive method (in case there are multiple matches)
      while ($row = mysqli_fetch_assoc($result)) {
        // Display the contraceptive method information

            //paalis nalang tong css na i2 if gagawan mo na pu ng css
            ?>

          <div class="col-sm-12 col-lg-4">
              <div class="container d-flex justify-content-center">
                  <div class="card mx-1 my-5 rounded-4" style="width: 80%; background-color:#BDD8F0;">
                  <div class="container rounded-4 justify-content-center" style="text-align: center; background: white; width: 100%; max-height: 200px; position: relative; overflow: hidden; padding: 0;">
                          <img src="<?php echo $row["birth_control_img"]; ?>" class="card-img-top"style="width: 100%; height: auto; object-fit: cover;"alt="...">
                  </div>
                          <div class="card-body" style=" min-height:14rem;">
                          <h5 class="card-title" style="text-align:center; color:#3B3B3B;"><?php echo $row["birth_control_name"]; ?></h5>
                          <p class="card-text mt-3">What it is?</p>
                          <p class="card-text" style="margin-top: -3%;"><?php echo $row["birth_control_desc"]; ?></p>
                      </div>
                  </div>
              </div>
          </div>
        <?php 
      }
    } else {
      // Handle the case where the method name is not found in the birth_controls table
      echo "<p>Contraceptive method '$method' not found.</p>";
    }
  }echo "</div>";
  echo "</div>";
};

?>



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
                <h5>Select a contraceptive method based on the result of your assessment.</h5>
            </div>
    </div>
  <!-- New Save Button -->
  <!-- Note: Removed the inline "display: none" style from the button -->
  <button id="save_method_button" style="display:none;">Save Method Only</button>
</div>

<div id="not_applicable_div" style="display:none;">
  <div class="d-grid  p-3  px-3 rounded-4 my-4 mb-5" style="background: #F2C1A7;" >
    <p class="text-start" >
    <div style="text-align: center;">
    <i class="fa-solid fa-prescription mb-4" style="font-size:30px;"></i>
    </div>Your selected method does not need SMS reminder as it is used every time you need it. Make sure to follow the directions on how to use it to ensure its effectiveness!</p>
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
                  <p >Contraceptive method reminder via</p>
                  
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
                    <div class="col-auto"><p style="color:#5A5A5A;">Would you like to receive SMS reminders to take your selected contraceptive method as recommended?</p></div>
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
    <input type="submit" value="Remind Me!" name="submit_remind" id="remind_me_btn" class="btn" style="font-weight: 600;">
  </form>

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
              <p style="color:#5A5A5A;">How many times would you like to use this  method?</p>
            </div>
</div>

<div class="row mx-5">
    <p class="mx-2" style="font-size:12px; color:#5A5A5A;">(Ex.: 2 times, and Mini Pill is the selected method.  You will opt to receive SMS reminders for 2 months because you will take <b>2 packs of pills</b>.) </p>
</div>

<!--niliitan ko lang to kasi parang note lang sya ikaw na po bahala mag adjust -->
  <div class="mx-3">
    <div class="input-container mx-5 my-3 rounded-3 shadow-sm px-4 py-3" style="background-color: white; width: 250px;">
      <label for="usage">Usage </label>
      <!-- etong separator guide lang hahaha palitan mo nalangg -->
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
    <p style="font-size:14px; color:#5A5A5A;">Once your inputs have been saved, you will start receiving SMS reminders for taking your selected contraceptive method.</p>
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
                button.style.height = "150px"; // Adjust the height as needed

                button.classList.add("hover");

                const methodNameDiv = document.createElement("div");
                methodNameDiv.textContent = methodDetails.birth_control_name;
                methodNameDiv.classList.add("method_name");
                button.appendChild(methodNameDiv);

                const imgDiv = document.createElement("div");
                imgDiv.classList.add("img_container", "rounded-3", "shadow-sm"); // Add this class for styling

                const img = document.createElement("img");
                img.src = methodDetails.birth_control_img;
                img.alt = methodDetails.birth_control_name;
                img.style.maxWidth = "100%";
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

            // If the button is already selected, remove it from the view
            if (isSelected) {
              button.style.display = "none";
            } else {
              const methodButtons = container.querySelectorAll(".method_btn");
              methodButtons.forEach(function (otherButton) {
                if (otherButton !== button) {
                  otherButton.style.display = "none";
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
            alert("Contraceptive method successfully saved!");
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



  function showReminderButton() {
  const smsReminderBtn = document.getElementById("sms_reminder_btn");
  smsReminderBtn.style.display = "block";
}


function showDatePicker() {
  const datePickerContainer = document.createElement("div");
  datePickerContainer.id = "date_picker_container";
  datePickerContainer.classList.add("m-4");

  const datePickerLabel = document.createElement("label");
  datePickerLabel.textContent = "Select the start date for the contraceptive method: ";

   // Create and append the provided HTML content
   const additionalContent = document.createElement("div");
  additionalContent.innerHTML = `
    <div class="row mb-4 flex-nowrap" style="align-items: center; padding-left:7px;">
      <div class="col-auto">
        <div class="vl" style="width: 20px; background-color: #F2C1A7; border-radius: 99px; height: 20px; display: -webkit-inline-box;"></div>
      </div>
      <div class="col mt-2">
        <p style="color:#5A5A5A;">Select the start date for the contraceptive method: </p>
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
          alert("Selected contraceptive method, start date, and usage saved to the database.");

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





</body>


</html>
