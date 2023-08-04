<?php

    require("connect.php");
    require('functions.php');
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
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
    width: 300px; /* You can adjust this value to your preferred width */
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


   </style>
   

</head>
<body>
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="title-quiz-result" id="title-quiz-result">
        <h1>Contraception Method Result</h1>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recommendations from the POST data
    $recommendationsJson = $_POST['recommendations'];
  
    // Convert the JSON string back to a PHP array
    $recommendations = json_decode($recommendationsJson, true);

     // Start a flex container to display items horizontally
     //try lang to sa css para makita yung pagdisplay ng pahorizontal..pwede mo pa iedit hehe 
  echo '<div style="display: flex; flex-wrap: wrap;">';
  
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
        echo '<div style="flex: 0 0 300px; margin: 10px; border: 1px solid #ccc; padding: 10px;">';
        echo "<h2>{$row['birth_control_name']}</h2>";
        echo "<img src='{$row['birth_control_img']}' alt='{$row['birth_control_name']}' style='width: 100px; height: 100px;'><br>";
        echo "<p>{$row['birth_control_desc']}</p>";
        echo "</div>";
      }
    } else {
      // Handle the case where the method name is not found in the birth_controls table
      echo "<p>Contraceptive method '$method' not found.</p>";
    }
  }echo "</div>";
};

?>

    <div>
        <form id= "back_btn" action="right_for_me_quiz.php" method="post">
            <input type="submit" value="Back" name="submit_back">
        </form>
    </div>

    <div id="method_buttons_container">
  <p>Select a contraceptive method based on the result of your assessment.</p>
  <!-- New Save Button -->
  <!-- Note: Removed the inline "display: none" style from the button -->
  <button id="save_method_button" style="display:none;">Save Method Only</button>
</div>

<div id="not_applicable_div" style="display:none;">
  <p>Your selected method does not need SMS reminder as it is used every time you need it. Make sure to follow the directions on how to use it to ensure its effectiveness!</p>
</div>

<div id="sms_reminder_btn" style="display: none;">
  <div>
    <p>Contraceptive method reminder via</p>
    <h3>SMS</h3>
  </div>
  <p>Would you like to receive SMS reminders to take your selected contraceptive method as recommended?</p>
  <!-- Move the "Remind Me!" button inside the form -->
  <form id="sms_reminder_form" action="#" method="post">
    <input type="submit" value="Remind Me!" name="submit_remind" id="remind_me_btn">
  </form>
</div>


<div class="input-container" style=" width: 400px; display: none;" >
<p>How many times would you like to use this  method?</p>

<!--niliitan ko lang to kasi parang note lang sya ikaw na po bahala mag adjust -->
<p style="font-size:12px">(Ex.: 2 times, and Mini Pill is the selected method.  You will opt to receive SMS reminders for 2 months because you will take <b>2 packs of pills</b>.) </p>
<div class="input-container" style="background-color: #EDEDED; width: 250px;">
  <label for="usage">Usage</label>
  <!-- etong separator guide lang hahaha palitan mo nalangg -->
  <span class="separator">|</span>
  <input type="text" id="usage-input" pattern="[0-9]*" maxlength="2" placeholder="00">
  <label for="time">time/s</label>
</div>
</div>

<!-- Create a container for the Save button -->
<div id="save_button_container" style="display: none;">
  <p style="font-size:15px">Once your inputs have been saved, you will start receiving SMS reminders for taking your selected contraceptive method.</p>
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
  remindMeButton.style.display = "none"; // Hide the "Remind Me!" button when clicked

  showDatePicker();
});

  function fetchMethodDetails(method, container) {

    

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const methodDetails = JSON.parse(xhr.responseText);
          const button = document.createElement("button");
          button.classList.add("method_btn");
          button.textContent = methodDetails.birth_control_name;
          button.setAttribute("data-selected", "false");

          const img = document.createElement("img");
          img.src = methodDetails.birth_control_img;
          img.alt = methodDetails.birth_control_name;
          img.width = 50;
          img.height = 50;

          button.appendChild(img);
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

  const datePickerLabel = document.createElement("label");
  datePickerLabel.textContent = "Select the start date for the contraceptive method: ";

  const datePickerInput = document.createElement("input");
  datePickerInput.type = "text";
  datePickerInput.id = "start_date_picker";
  datePickerInput.setAttribute("placeholder", "Select a date...");

  datePickerContainer.appendChild(datePickerLabel);
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

  saveButton.addEventListener("click", function () {
    const selectedDate = datePickerInput.value;
    const formattedDate = selectedDate.split("T")[0];
    updateStartDate(formattedDate);
  });

// Get the usage input container
const usageInputContainer = document.querySelector(".input-container");

// Append the "Save" button after the usage input container
usageInputContainer.insertAdjacentElement('afterend', saveButton);


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
  const saveButtonContainer = document.getElementById("save_button_container");
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

          // Schedule the SMS reminders based on the selected method
          //scheduleSMS(selectedMethod);

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


<footer>
        <div>
            
            <img src="" alt="">

            <a href="#">Home</a>
            <a href="#">FAQs</a>
            <a href="#">Services</a>
            <a href="#">Contraceptive Method</a>
            <a href="#">Videos</a>
            <a href="#">Period Calculator</a>
            <a href="#">Community Forum</a>
            <a href="#">About STDs</a>

            <p>Our Partner</p>
            <img src="" alt="">

            <h3>+63 912 345 6789</h3>
            <!-- icon -->
            <!-- icon -->
        </div>
        
        <div>
            <!-- Translation Code here -->
            <span>
                <div class="translate" id="google_translate_element"></div>

                   <script type="text/javascript">
                        function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,tl',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                            autoDisplay: false,
                            multilanguagePage: true
                        }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>


            <!-- Translation Code End here -->
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
</footer>
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
