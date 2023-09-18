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
    <title>SiPa | Cost Calculator</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 

    body{
    top:0!important;
    }

    /* dropdown menu */
    .input-container {
    display: flex;
    align-items: center;
    padding: 10px;
    }

     /*naol may label*/
    label {
    margin-right: 10px;
    }

    .separator {
    color: #888;
    margin: 0 10px;
    }

    #longevity-input, #condom-input {
    padding: 5px;
    width: 50px; /* Adjust this width as needed */
    }

    select {
    padding: 5px;
    color: #1F6CB5;
    }

    /*eto yung sa button pag selected nakahighlight */
   /* Selected style for the buttons */
    .contraceptive-button.selected,
    .condom-brand-button.selected,
    .recommended-brand-button.selected {
        background-color: #D2E0F8;
        color: #1F6CB5;
    }

    /* sa buttons to, sa pagpili ng method */
    .contraceptive-button, .condom-brand-button, .recommended-brand-button {
        display: inline-block;
        width: calc(100% / 7);
        max-width: 120px; /* Maximum width ng button */
        text-align: center;
        margin: 10px;
        vertical-align: top;
    }


    .contraceptive-button span {
        display: block;
        font-size: 12px;
        margin-top: 5px; /* space sa pagitan ng name and image */
    }

    /* Center the text within the button */
    .contraceptive-button p {
        margin: 0;
    }

    /* Add spacing between rows */
    .button-row {
        display: flex;
        justify-content: center;
    }
    /* pang default*/
    select, input, .contraceptive-button,
    .condom-brand-button,
    .recommended-brand-button {
    border: none;
    outline: none;
    background-color:white;
    }

    .contraceptive-button.hover:hover {
      background-color: #D2E0F8;
  }

    .recommended-brand-button.hover:hover {
      background-color: #D2E0F8;
  }

  .condom-brand-button.hover:hover {
      background-color: #D2E0F8;
  }

   </style>
   

</head>

<body style="background: #F2F5FF;">

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Contraceptive Cost</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Calculator</p></div>
        </div>
    </div>

<div class="container">
    <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center; font-size:15px;">
                This birth control calculator was designed to help you compare the costs and effectiveness of different contraceptive options.
                </div>
                
              </div>
            </div>
    

        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-3">
                    <div class="col-auto"><p style="font-size: 2rem;  font-weight:bolder;">Cost <span style="font-weight:normal;">calculator</span></p></div>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <h5 style="color:#383838;">Select a contraceptive method:</h5>
        </div>

    <div class="cost-calculator-container" id="cost-calculator-container">
        <div class="button-row">
            <div class="col" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <?php
                // Fetch contraceptive methods from the database then gagawan ng button, tas di kasali yung condom, calendar, withdrawal, and temp method
                $excluded_methods = array("Condom", "Calendar Method", "Withdrawal Method", "Temperature Method");
                $excluded_methods_query = "'" . implode("','", $excluded_methods) . "'";
                $query = "SELECT birth_control_name, birth_control_img FROM birth_controls WHERE birth_control_name NOT IN ($excluded_methods_query)";
                $result = mysqli_query($conn, $query);
        
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $method_name = $row['birth_control_name'];
                    $method_img = $row['birth_control_img'];
                    echo '<button class="contraceptive-button btn mx-3 my-3 btn-light shadow-sm hover" style="width: 110px;height: 120px;" data-method="' . $method_name . '">';
                    echo '<span>' . $method_name . '</span>';
                    echo '<img src="' . $method_img . '" alt="' . $method_name . '" style="max-width: 100%; max-height: 100%; object-fit: contain;">';
                    echo '</button>';
        
                    //$count++; //counter para 7 lang kada row ang buttons 
                    //if ($count === 7) {
                    //    echo '</div><div class="button-row">';
                    //    $count = 0;
                    //}
                }
            ?>
            </div>
        </div>
    </div>


    <!--Dito yung container ng method na napili-->
    <div class="selected-method-container" id="selected-method-container" style="display:none">
 
        <div class="row mt-3 mb-4" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 60px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-2">
                    <div class="col-auto"><h3 id="selected-method-text"> Contraceptive Name </h3></div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-auto">
                <div class="longevity-input-container mx-5 mb-3 rounded-3 shadow-sm px-4 py-3" id="longevity-input-container" style="background-color: white; max-width: 330px; ">
                <!--longevity ay nakaset na, so pag nagselect sa dropdown makikita kung ilang days, months, or weeks ittake yung selected method-->
                    <label for="longevity">Longevity</label>
                    <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 4px;
                    margin-bottom: -12px;"></span>
                    <!--nakadisable tong input text field kasi system magcompute ng ilang days/weeks/months/years-->
                    <input type="text" id="longevity-input" style="border:none; padding-left:15px; width: 67px;" pattern="[0-9]*" style="width: 70px" disabled>
                    <select id="duration-dropdown" style="color:#1F6CB5;">
                        <!-- Options will be added dynamically using JavaScript -->
                    </select>
                </div>

            </div>

            <div class="col-auto">

                <div class="estimated-price-input-container mx-5 mb-3 rounded-3 shadow-sm px-4 py-3" id="estimated-price-input-container" style="background-color: #EFEFEF; width: 320px; display:none">
                    <label class="pt-2" for="estimatePrice">Estimated Price</label>
                    <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 4px;
                    margin-bottom: -10px;"></span>
                    <input type="text" id="estimated-price-input" style="border:none; padding-left:15px; width: 45%; padding-bottom: 3.07px; background:none;" disabled> <!-- est price maa-add dynamically using JavaScript -->
                </div>

            </div>
        </div>
    

    </div>


    <div class="condom-input-container mx-5 rounded-3 shadow-sm px-4 py-3" id="condom-input-container" style="background-color: white; max-width: 330px; display:none">
        <label for="condom">Do you also buy condoms?</label>
        <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
        <select id="answer-dropdown">
            <option value="no">No</option>
            <option value="yes">Yes</option>
        </select>
    </div>

    <br>


    <!--nakahide muna, pag nagyes lang sa 'Do you also buy condoms?' lalabas -->
    <div class="condom-if-yes-container" id="condom-if-yes-container" style="display:none">

        <div class="amount-needed-input-container  mx-5 rounded-3 shadow-sm px-4 py-3" style="background-color: white; max-width: max-content;">
            <label for="need">How many do you usually need?</label>
            <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
            <!--nakadisable tong input text field coz js na bahala magcompute dine-->
            <input type="text" id="condomAmount-input" pattern="[0-9]*"maxlength="2" placeholder="00" style="width: 50px; padding-left: 15px;">
            <select id="condomAmount-dropdown">
                <option value="condomday">Condom/Day</option>
                <option value="condomweek">Condom/Week</option>
                <option value="condommonth">Condom/Month</option>
                <option value="condomyear">Condom/Year</option>
            </select>
        </div>
        
        <div class="row">
            <div class="col-auto mt-4">
                <div class="amount-package-input-container mx-5 rounded-3 shadow-sm px-4 py-3" style="background-color: #FFFFFF;max-width: 330px; ">
                    <label for="amountPackage">Amount in Package</label>
                    <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
                    <!-- nakadisable, kukunin sa db yung amount in package then malalagay dito-->
                    <input type="text" id="condom-amount-package-input" style="width: 50px; padding-left: 15px;"disabled>
                </div>
            </div>

            <div class="col-auto mt-4 mb-4">
                <div class="estimated-condom-price-input-container mx-5 rounded-3 shadow-sm px-4 py-3" style="background-color: #EFEFEF; width: 380px; ">
                    <label for="estimateCondomPrice">Estimated Price per Package</label>
                    <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
                    <!-- nakadisable, kukunin sa db yung amount in package then malalagay dito-->
                    <input type="text" id="estimated-condom-price-input" style="border:none; padding-left:15px; width: 30%; padding-bottom: 3.07px; background:none;" disabled>
                </div>
            </div>
        </div>
        
        </div>
    </div>


        <div class="container recommended-brand-container" id="recommended-brand-container" style="display:none">
            <div class="selected-method-brand-reco" id="selected-method-brand-reco">
                <div class="row mt-3" style="align-items: center;">
                    <div class="col-auto">
                        <div class="vl" style="width: 10px;
                        background-color: #1F6CB5;
                        border-radius: 99px;
                        height: 60px;
                        display: -webkit-inline-box;"></div>
                    </div>
                
                    <div class="col-auto mt-2">
                            <div class="col-auto"><h3>Recommended Brands</h3></div>
                    </div>
                </div>
                <!--name ng selected method malalagay dine -->
                <h4 class="mt-4 mb-3" style="font-size:20px; color:#383838;"> <span id="selected-method-text-reco"></span></h4>
                <p>Select a brand:</p>

                <div class="method-brands-container" id="method-brands-container">
                    <!--selected method brands malalagay dito na nakabutton -->
                </div>

            </div>

         <!--nakahide muna to, magshow lang if yes sa do you buy condoms-->
            <div class="condom-if-yes-container" id="condom-brand" style="display:none" >
                <h4 class="mt-3 mb-3" style="font-size:20px; color:#383838;">Condom</h4>
                <p>Select condom brand:</p>
                <!-- Generate buttons for condom brands -->
                <?php
                $query2 = "SELECT brand_name, brand_img, brand_price, brand_amount_package FROM birth_control_brand_price WHERE birth_control_id = 8";
                $result2 = mysqli_query($conn, $query2);
                
                $condomBrands = array();
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $condomBrands[] = $row2;
                }
            ?>


                <?php foreach ($condomBrands as $index => $brand):
                    $amountPackage =  $brand['brand_amount_package'];?>
                    
                    <button class="condom-brand-button btn mx-3 my-3 btn-light shadow-sm hover" style="width: 150px; height: 150px;" <?php if ($index === 0) echo 'selected'; ?>">
                        <span><?php echo $brand['brand_name']; ?></span>
                        <img src="<?php echo $brand['brand_img']; ?>" alt="<?php echo $brand['brand_name']; ?>" width="80" height="80">
                        <p>₱<?php echo $brand['brand_price']; ?>.00</p>
                    </button>
                <?php endforeach; ?>

            </div>
        </div>



    <div class="container cost_calculator_result p-5 my-5 rounded-4 shadow-sm " id="cost_calculator_result" style= "background: #D2E0F8; display:none">
        <h3>Result</h3>

        <div class="con mt-4 rounded-3 shadow-sm px-4 py-3" style="background-color: white; max-width: max-content;">
            <label for="cost">How much will you spend over...</label>
                <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
                <input type="text" id="cost-duration-input" pattern="[0-9]*" maxlength="4" placeholder ="0"  style="width: 50px; padding-left: 15px;">
                <select id="cost-duration-dropdown">
                <option value="day">Day/s</option>
                    <option value="week">Week/s</option>
                    <option value="month">Month/s</option>
                    <option value="year">Year/s</option>
                    <option value="time" disabled>Time</option> //pang vasectomy and ligation lang to 
                </select>

        </div>

        <div class="con mt-4 rounded-3 shadow-sm px-4 py-3" style="background-color: white; max-width: max-content;">
            <label for="estimatedTotalPrice">You will spend</label>
            <span style="width: 4px;
                    background-color: #7B7777;
                    border-radius: 99px;
                    height: 33px;
                    display: inline-block;
                    margin-left: 2px;
                    margin-bottom: -10px;"></span>
                <input type="text" id="estimated-total-price-input" style="padding-left: 21px; width: 160px;" disabled>
        </div>


        <br><br>
         <!--mag switch case dito para macheck ano yung selected method tas kuhanin sa db effectivetess rate, check din if nakayes sa condom para lumabas yung youre mixing two types of birth control note. nakaphp echo dat yung method na pinili-->
         <p style="font-size:14px"><b>Your chosen type of birth control is <span id="effectiveness-rate"></span> effective.</b></p>
         <p id ='mixingBirthControl' style ="display:none;">You’re mixing two types of birth control. This makes the efficacy higher that it would’ve been if you weren’t also using condoms.</p> 
         <p id ="selectedMethodReminder"></p>


    </div>


    <script>
    
    const buttons = document.querySelectorAll('.contraceptive-button');
    const selectedMethodContainer = document.getElementById('selected-method-container');
    const estimatePriceInputContainer = document.getElementById('estimated-price-input-container');
    const condomInputContainer = document.getElementById('condom-input-container');
    const recommendedBrandContainer = document.getElementById('recommended-brand-container');
    const costResult = document.getElementById('cost_calculator_result');
    const selectedMethodText = document.getElementById('selected-method-text');
    
    const condomAmountInput = document.getElementById('condomAmount-input');      

    // Get the estimated price input
    const estimatedPriceInput = document.getElementById('estimated-price-input');

    // Get the container for recommended brands list
    const recommendedBrandsList = document.getElementById('method-brands-container');

    // Function to generate the recommended brand buttons
    function generateRecommendedBrands(brandData) {
        console.log(brandData); // pang check ng content ng brandData
        recommendedBrandsList.innerHTML = ''; // Clear previous content

        brandData.forEach((brand, index) => {
            const brandButton = document.createElement('button');
            brandButton.classList.add('recommended-brand-button', "btn", "mx-3","my-3", "btn-light", "shadow-sm");
            brandButton.style.width = "150px"; // Adjust the width as needed
            brandButton.style.maxHeight = "170px"; // Adjust the height as needed

            brandButton.classList.add("hover");
            
            if (index === 0) {
                brandButton.classList.add('selected');
                
            }

            brandButton.innerHTML = `
                <span>${brand.brand_name}</span>
                <img src="${brand.brand_img}" alt="${brand.brand_name}" width="80" height="80">
                <p>₱${brand.brand_price}.00</p>
            `;

            brandButton.addEventListener('click', () => {
                // Remove 'selected' class from all recommended brand buttons, yung selected button nakahighlight na blue para makita if yun current na pinindot
                const allBrandButtons = recommendedBrandsList.querySelectorAll('.recommended-brand-button');
                allBrandButtons.forEach(button => {
                    button.classList.remove('selected');
                });

                // Add 'selected' class to the clicked button
                brandButton.classList.add('selected');

                // Update the estimated price input with the brand_price of the clicked brand
                estimatedPriceInput.value = `₱${brand.brand_price}.00`;
                estimatedPriceInput.style.color = "#1F6CB5"; //ginaya ko lang color sa proto hehe
                updateEstimatedTotalPrice();
            });

            recommendedBrandsList.appendChild(brandButton);
        });
    }


    buttons.forEach(button => {
        button.addEventListener('click', () => {

            // Reset the answer dropdown to "No" sa do you also buy condoms? para pag pumili ulit ng another method, marereset yung nakasulat sa input field 
            answerDropdown.value = 'no';

            condomAmountInput.value = '';


            // Remove 'selected' class from all buttons
            buttons.forEach(btn => {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            button.classList.add('selected');

            const selectedMethod = button.getAttribute('data-method'); //after makaselect ng contraceptive method, madidisplay na mga nakahide na container
            // Make an AJAX request to fetch the effectiveness rate from the server
                    fetch('get_effectiveness_rate.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ selectedMethod }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update the HTML element with the retrieved effectiveness rate
                        const effectivenessRateElement = document.getElementById('effectiveness-rate');
                        effectivenessRateElement.textContent = `${data.effectivenessRate}`;
                    })
                    .catch(error => console.error('Error fetching effectiveness rate:', error));

            console.log('selected method:', selectedMethod);
            selectedMethodContainer.style.display = 'block';
            estimatePriceInputContainer.style.display = 'block';
            //kapag permanent method, ala na yung do you also buy condoms tanong
            if (selectedMethod === 'Vasectomy' || selectedMethod === 'Tubal Ligation') {
                console.log('Selected method is Vasectomy or Tubal Ligationnn');
                condomInputContainer.style.display = 'none';
            } else {
                condomInputContainer.style.display = 'block';
            }
            recommendedBrandContainer.style.display = 'block';
            costResult.style.display = 'block';
            selectedMethodText.textContent = selectedMethod; // Set the selected method name

            // Update the selected method name inside the recommended brands container and dun sa babang div 
            const selectedMethodTextReco = document.getElementById('selected-method-text-reco');
            const selectedMethodReminder = document.getElementById('selectedMethodReminder');
            selectedMethodTextReco.textContent = selectedMethod;
            selectedMethodReminder.textContent = "You’re using " + selectedMethod +". We encourage you to stay informed about it by visiting our about contraceptive page." ;

            // Hide condom-related containers
            condomIfYesContainer.style.display = 'none';
            condomBrandContainer.style.display = 'none';
            document.getElementById('mixingBirthControl').style.display = 'none';

            updateEstimatedTotalPrice();


            fetch('get_recommended_brands.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ selectedMethod }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Check the received data

                // Update the selected method's brand longevity in the longevity input
                const selectedMethod = data[0].method_name;
                const selectedMethodLongevity = data[0].brand_longevity;
                const longevityInput = document.getElementById('longevity-input');
                

                // Split the brand_longevity into numeric value and label
                const [numericValue, label] = selectedMethodLongevity.split(' ');
                console.log(numericValue, label);

                // Display the numeric value in the input field
                longevityInput.value = numericValue;
                // Inside the loop that generates contraceptive buttons
                longevityInput.setAttribute('data-original-value', numericValue); //para macheck yung orig data na numerical value ng longevity sa pagconvert ng years to days,weeks,months, vice versa
                longevityInput.setAttribute('data-units', label); //para macheck later pag niconvert yung orig data na label ng longevity sa if years, days,weeks,months



                // Update the duration dropdown options
                updateDurationDropdown(numericValue, label); // Pass both numeric value and label


            // Update the cost duration input and dropdown values kakadagdag lang
            const longevityInputValue = document.getElementById('longevity-input').value;
            const durationDropdownValue = document.getElementById('duration-dropdown').value;

            const costDurationInput = document.getElementById('cost-duration-input');
            const costDurationDropdown = document.getElementById('cost-duration-dropdown');

            const selectedMethodd = button.getAttribute('data-method');
            console.log('selected methodd:', selectedMethodd);
            
            // Set cost-duration-input and dropdown values for Vasectomy and Tubal Ligation kasi permanent method naman sila 
            if (selectedMethodd === 'Vasectomy' || selectedMethodd === 'Tubal Ligation') {
                console.log('Selected method is Vasectomy or Tubal Ligation');
                costDurationInput.value = '1';
                costDurationDropdown.value = 'time';
                costDurationInput.disabled = true;
                costDurationDropdown.disabled = true;
            } else { //else yung dropdown at input text field is same muna as default sa longevity ng method
                console.log('Selected method is not Vasectomy or Tubal Ligation');
                // Set the values to be the same as longevity and duration
                costDurationInput.value = longevityInputValue;
                costDurationDropdown.value = durationDropdownValue;
                costDurationInput.disabled = false;
                costDurationDropdown.disabled = false;
            }

        

        // Update condomAmount-dropdown based on duration-dropdown value para sync ng longevity and condom per day/week/month/year depending sa longevity
        const condomAmountDropdown = document.getElementById('condomAmount-dropdown');
        switch (durationDropdownValue) {
            case 'day':
                condomAmountDropdown.value = 'condomday';
                break;
            case 'week':
                condomAmountDropdown.value = 'condomweek';
                break;
            case 'month':
                condomAmountDropdown.value = 'condommonth';
                break;
            case 'year':
                condomAmountDropdown.value = 'condomyear';
                break;
        }

        // Disable the condomAmount-dropdown para di mamanipulate kahirap kasi icalculate pag paiba iba
        condomAmountDropdown.disabled = true;

        


                // Process the received data and generate recommended brand buttons
                generateRecommendedBrands(data);
                estimatedPriceInput.value = `₱${data[0].brand_price}.00`; // Update the estimated price input ng selected method
                estimatedPriceInput.style.color = "#1F6CB5"; //kakulay sa proto hehe 
                calculateEstimatedTotalPrice();
            })
            .catch(error => console.error('Error sending/receiving data:', error));

                    });
                });
                

  
    // Function to update the duration dropdown options based on brand longevity, nakadepend so if month/s, day/s, week/s, month/s lang pwede sa dropdown options
    function updateDurationDropdown(numericValue, selectedLabel) {
        console.log('Selected label:', selectedLabel); // Log the selectedLabel
        const durationDropdown = document.getElementById('duration-dropdown');
        durationDropdown.innerHTML = ''; // Clear previous options

        //eto yung madadagdag na options sa dropdown menu depending sa brand longevity galing db
        const options = [
            { value: 'day', label: 'Day/s' },
            { value: 'week', label: 'Week/s' },
            { value: 'month', label: 'Month/s' },
            { value: 'year', label: 'Year/s' },
            { value: 'permanent', label: 'Permanent' }
        ];

        // Remove trailing 's' from the selected label if present para if with s mareread pa rin sya as months/years/etc
        const cleanedSelectedLabel = selectedLabel.endsWith('s') ? selectedLabel.slice(0, -1) : selectedLabel;

        // Find the index of the cleaned selected label in the options array
        const selectedIndex = options.findIndex(option => option.value === cleanedSelectedLabel);

        // Clear the input field
        const longevityInput = document.getElementById('longevity-input');
        longevityInput.value = '';

        // If the numericValue is equal to zero, it's a permanent method kasi ganon sinet ko
        if (numericValue === '0') {
            const optionElement = document.createElement('option');
            optionElement.value = 'permanent';
            optionElement.textContent = 'Permanent';
            optionElement.selected = true;
            durationDropdown.appendChild(optionElement);
        } else {
            // Add the options before the selected label up to 'Day/s' para makita ni user converted longevity depending sa sinelect na option from dropdown 
            for (let i = 0; i <= selectedIndex; i++) {
                const optionElement = document.createElement('option');
                optionElement.value = options[i].value;
                optionElement.textContent = options[i].label;

                if (i === selectedIndex) {
                    // Set this option as selected
                    optionElement.selected = true; //yung default label ng longevity ng method ang naka 'selected' or unang makikita sa dropdown menu 
                    // Display the numeric value in the input field, number lang makikita sa text field
                    longevityInput.value = numericValue;
                }

                durationDropdown.appendChild(optionElement);
            }
        }

        durationDropdown.disabled = false;
    }


    // Declare longevityInput outside of functions para magamit sa iba 
    const longevityInput = document.getElementById('longevity-input');

    // Event listener for the duration dropdown
    const durationDropdown = document.getElementById('duration-dropdown');
    durationDropdown.addEventListener('change', () => {
        const selectedOption = durationDropdown.value;
        const originalLongevity = parseFloat(longevityInput.getAttribute('data-original-value'));
        const units = longevityInput.getAttribute('data-units'); // Get the units attribute

        let calculatedTimeValue;

        //dito na yung conversion depending sa sinelect ni user sa dropdown to get the days/weeks/months from years or vice versa
        //nagconsult ako sa google para sa approximate results na pang formula dito 

        if (units === 'years') {
            const originalDays = originalLongevity * 365.3;
            switch (selectedOption) {
                case 'day':
                    calculatedTimeValue = (originalLongevity * 365.3).toFixed(2);
                    break;
                case 'week':
                    calculatedTimeValue = (originalLongevity * 52.179).toFixed(2);
                    break;
                case 'month':
                    calculatedTimeValue = (originalLongevity * 12).toFixed(2);
                    break;
                case 'year':
                    calculatedTimeValue = originalLongevity.toFixed(2);
                    break;
                default:
                    calculatedTimeValue = '';
                    break;
            }
        } else if (units === 'months'|| units === 'month') {
            const originalMonths = originalLongevity;
            switch (selectedOption) {
                case 'day':
                    calculatedTimeValue = (originalLongevity * 30.417).toFixed(2);
                    break;
                case 'week':
                    calculatedTimeValue = (originalLongevity * 4).toFixed(2);
                    break;
                case 'month':
                    calculatedTimeValue = (originalLongevity * 1).toFixed(2);
                    break;
                default:
                    calculatedTimeValue = '';
                    break;
            }
        } else if (units === 'weeks'|| units === 'week') {
            const originalWeeks = originalLongevity;
            switch (selectedOption) {
                case 'day':
                    calculatedTimeValue = (originalLongevity * 7).toFixed(2);
                    break;
                case 'week':
                    calculatedTimeValue = (originalLongevity * 1).toFixed(2);
                    break;
                default:
                    calculatedTimeValue = '';
                    break;
            }
        }
        //para pag whole number ala na .00 
        if (Number.isInteger(parseFloat(calculatedTimeValue))) {
            calculatedTimeValue = parseInt(calculatedTimeValue);
        }

        longevityInput.value = calculatedTimeValue;
        });


    const answerDropdown = document.getElementById('answer-dropdown');
    const condomIfYesContainer = document.getElementById('condom-if-yes-container');
    const condomBrandContainer = document.getElementById('condom-brand');
        <?php
        $condomBrandsJson = json_encode($condomBrands);
        echo "const condomBrands = " . $condomBrandsJson . ";";
        ?>
        answerDropdown.addEventListener('change', () => {
            if (answerDropdown.value === 'yes') {
                condomIfYesContainer.style.display = 'block';
                condomBrandContainer.style.display = 'block';
                document.getElementById('mixingBirthControl').style.display = 'block';

                const selectedBrandIndex = 0; // Change this index based on user selection
                const selectedBrand = condomBrands[selectedBrandIndex];
                const amountInPackageInput = document.getElementById('condom-amount-package-input');
                amountInPackageInput.value = selectedBrand.brand_amount_package;
                const costDurationDropdown = document.getElementById('cost-duration-dropdown');
                const longevityDropdown = document.getElementById('duration-dropdown');
                costDurationDropdown.value = longevityDropdown.value;
                const longevityInput = document.getElementById('longevity-input');
                const costDurationInput = document.getElementById('cost-duration-input');
                costDurationInput.value = longevityInput.value;

            
            // Trigger a click event on the first condom brand button to update the estimated condom price input
            const firstCondomBrandButton = document.querySelector('.condom-brand-button');
            firstCondomBrandButton.click();

            } else {
                condomIfYesContainer.style.display = 'none';
                condomBrandContainer.style.display = 'none';
                const longevityInput = document.getElementById('longevity-input');
                const costDurationInput = document.getElementById('cost-duration-input');
                costDurationInput.value = longevityInput.value;
                document.getElementById('mixingBirthControl').style.display = 'none';
            }
        });
   
    const methodBrandButtons = document.querySelectorAll('.method-brand-button');

    methodBrandButtons.forEach(button => {
        button.addEventListener('click', () => {
        // Remove 'selected' class from all method brand buttons
        methodBrandButtons.forEach(btn => {
            btn.classList.remove('selected');
        });

        // Add 'selected' class to the clicked button
        button.classList.add('selected');

        updateEstimatedTotalPrice();

        // Get the selected method
        const selectedMethod = button.getAttribute('data-method');

            // Make an AJAX request to send the selected method to PHP
            fetch('get_recommended_brands.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ selectedMethod }),
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server if needed
            })
            .catch(error => console.error('Error sending selected method:', error));
        });
    });


    //pang update ng price ng condom
    // Get the condom brand buttons
    const condomBrandButtons = document.querySelectorAll('.condom-brand-button');

    // Get the estimated condom price input
    const estimatedCondomPriceInput = document.getElementById('estimated-condom-price-input');

    // Trigger a click event on the first condom brand button when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        const firstCondomBrandButton = document.querySelector('.condom-brand-button');
        firstCondomBrandButton.click();
    });

    // Update the estimated price input when a condom brand button is clicked
    condomBrandButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'selected' class from all condom brand buttons
            condomBrandButtons.forEach(btn => {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            button.classList.add('selected');

            
            
            // Update the estimated price input with the selected brand's price
            const selectedBrandPriceText = button.querySelector('p').textContent;
            const selectedBrandPrice = parseFloat(selectedBrandPriceText.replace('₱', '').replace('.00', ''));
            estimatedCondomPriceInput.value = "₱" + selectedBrandPrice.toFixed(2);
            estimatedCondomPriceInput.style.color = "#1F6CB5";

            // Get the index of the selected brand
            const selectedBrandIndex = Array.from(condomBrandButtons).indexOf(button);

            /* Debugging: Log the selected brand's index and amount in package
            console.log('Selected brand index:', selectedBrandIndex);
            console.log('Selected brand amount in package:', condomBrands[selectedBrandIndex].brand_amount_package); */

            // Update the amount in package input with the selected brand's amount
            const selectedBrandAmount = condomBrands[selectedBrandIndex].brand_amount_package;
            const amountInPackageInput = document.getElementById('condom-amount-package-input');
            amountInPackageInput.value = selectedBrandAmount;

            
            updateEstimatedTotalPrice();

            });
        });


    function calculateEstimatedTotalPrice() {
        const answerDropdown = document.getElementById('answer-dropdown');
        const estimatedPriceInput = document.getElementById('estimated-price-input');
        const estimatedCondomPriceInput = document.getElementById('estimated-condom-price-input');
        const condomAmountInput = document.getElementById('condomAmount-input');
        const condomAmountPackageInput = document.getElementById('condom-amount-package-input');
        const costDurationInput = document.getElementById('cost-duration-input');
        const costDurationDropdown = document.getElementById('cost-duration-dropdown');
        const estimatedTotalPriceInput = document.getElementById('estimated-total-price-input');



        // Calculate the estimated total price
        if (answerDropdown.value === 'no') {
            const estimatedPrice = parseFloat(estimatedPriceInput.value.replace('₱', '').replace('.00', ''));
            console.log('estimatedPrice eto:', estimatedPrice);
            estimatedTotalPriceInput.value = `₱${estimatedPrice.toFixed(2)}`;
        } else if (answerDropdown.value === 'yes') {
            const condomPricePerPackage = parseFloat(estimatedCondomPriceInput.value.replace('₱', '').replace('.00', ''));
            const estimatedPrice = parseFloat(estimatedPriceInput.value.replace('₱', '').replace('.00', ''));
            const condomAmount = parseFloat(condomAmountInput.value);
            const amountInPackage = parseFloat(condomAmountPackageInput.value);
            const totalPackagesNeeded = Math.ceil(condomAmount / amountInPackage);
            const totalCondomPrice = condomPricePerPackage * totalPackagesNeeded;

            let totalEstimatedPrice = totalCondomPrice + estimatedPrice;


            estimatedTotalPriceInput.value = `₱${totalEstimatedPrice.toFixed(2)}`;

            }
        }

    const condomAmountPackageInput = document.getElementById('condom-amount-package-input');
    const costDurationInput = document.getElementById('cost-duration-input');
    const costDurationDropdown = document.getElementById('cost-duration-dropdown');
    const estimatedTotalPriceInput = document.getElementById('estimated-total-price-input');
        answerDropdown.addEventListener('change', calculateEstimatedTotalPrice);
        condomAmountPackageInput.addEventListener('input', calculateEstimatedTotalPrice);
        costDurationInput.addEventListener('input', calculateEstimatedTotalPrice);
        costDurationDropdown.addEventListener('change', calculateEstimatedTotalPrice);


        condomAmountInput.addEventListener('input', updateEstimatedTotalPrice);
        costDurationInput.addEventListener('input', updateEstimatedTotalPrice);
        costDurationDropdown.addEventListener('change', updateEstimatedTotalPrice);



    function updateEstimatedTotalPrice() {
        const estimatedPriceInput = document.getElementById('estimated-price-input');
        const estimatedCondomPriceInput = document.getElementById('estimated-condom-price-input');
        const condomAmountInput = document.getElementById('condomAmount-input');
        const costDurationInput = document.getElementById('cost-duration-input');
        const condomAmountPackageInput = document.getElementById('condom-amount-package-input');
        const costDurationDropdown = document.getElementById('cost-duration-dropdown');
        const estimatedTotalPriceInput = document.getElementById('estimated-total-price-input');
        const longevityInput = document.getElementById('longevity-input');
        const longevityDropdown = document.getElementById('duration-dropdown');

        // Parse input values
        const durationValue = parseFloat(costDurationInput.value);
        const longevityValue = parseFloat(longevityInput.value);
        const estimatedPrice = parseFloat(estimatedPriceInput.value.replace('₱', '').replace('.00', ''));
        const condomPricePerPackage = parseFloat(estimatedCondomPriceInput.value.replace('₱', '').replace('.00', ''));
        const condomAmount = parseFloat(condomAmountInput.value);
        const amountInPackage = parseFloat(condomAmountPackageInput.value);
            const totalPackagesNeeded = Math.ceil(condomAmount / amountInPackage);
            console.log("ilan kelangang condom pack", totalPackagesNeeded);
            const condomPrice = condomPricePerPackage * totalPackagesNeeded * longevityValue ;
             

        let newEstimatedTotalPrice;

        if (longevityValue === durationValue && longevityDropdown.value === costDurationDropdown.value){

            if (answerDropdown.value === 'yes'){
                newEstimatedTotalPrice = ((estimatedPrice + condomPrice )).toFixed(2);
            }
            else {
                // Reset to initial default price
                newEstimatedTotalPrice = estimatedPrice.toFixed(2);;
            }
        
        }

        else if (answerDropdown.value === 'yes'){

            if (longevityDropdown.value === 'day') { 
                if (costDurationDropdown.value === 'week') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 7 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'month') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 30 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'year') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 365 * durationValue).toFixed(2);
                } else {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* durationValue).toFixed(2);
                }
            }  
            else if (longevityDropdown.value === 'week') {
                if (costDurationDropdown.value === 'day') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ 7 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'month') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 4 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'year') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 52 / durationValue).toFixed(2);
                } else {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ longevityValue* durationValue).toFixed(2);
                }
            } 
            else if (longevityDropdown.value === 'month') {
                if (costDurationDropdown.value === 'day') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ 30 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'week') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ 4 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'year') {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )* 12 * durationValue).toFixed(2);
                } else {
                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ longevityValue* durationValue).toFixed(2);
                }
            } 
            else if (longevityDropdown.value === 'year') {
                if (costDurationDropdown.value === 'day') {
                    newEstimatedTotalPrice = (((estimatedPrice + condomPrice )/ 365 * durationValue)/longevityValue).toFixed(2);
                } else if (costDurationDropdown.value === 'month') {
                    newEstimatedTotalPrice = (((estimatedPrice + condomPrice )/ 12 * durationValue)/longevityValue).toFixed(2);
                } else if (costDurationDropdown.value === 'week') {
                    newEstimatedTotalPrice = (((estimatedPrice + condomPrice )/ 52 * durationValue)/longevityValue).toFixed(2);
                } else {

                    newEstimatedTotalPrice = ((estimatedPrice + condomPrice )/ longevityValue * durationValue).toFixed(2);
                }
            }
        }


        else { 
            if (longevityDropdown.value === 'day') { 
                if (costDurationDropdown.value === 'week') {
                    newEstimatedTotalPrice = (estimatedPrice* 7 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'month') {
                    newEstimatedTotalPrice = (estimatedPrice* 30 * durationValue).toFixed(2);
                } else if (costDurationDropdown.value === 'year') {
                    newEstimatedTotalPrice = (estimatedPrice* 365 * durationValue).toFixed(2);
                } else {
                    newEstimatedTotalPrice = ((estimatedPrice/ longevityValue)* durationValue).toFixed(2);
                }
            }  
            else if (longevityDropdown.value === 'week') {
                    if (costDurationDropdown.value === 'day') {
                        newEstimatedTotalPrice = (estimatedPrice/ 7 * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'month') {
                        newEstimatedTotalPrice = (estimatedPrice* 4 * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'year') {
                        newEstimatedTotalPrice = (estimatedPrice* 52 / durationValue).toFixed(2);
                    } else {
                        newEstimatedTotalPrice = ((estimatedPrice/ longevityValue)* durationValue).toFixed(2);
                    }
            } 
            else if (longevityDropdown.value === 'month') {
                    if (costDurationDropdown.value === 'day') {
                        newEstimatedTotalPrice = (estimatedPrice/ 30 * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'week') {
                        newEstimatedTotalPrice = (estimatedPrice/ 4 * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'year') {
                        newEstimatedTotalPrice = (estimatedPrice* 12 * durationValue).toFixed(2);
                    } else {
                        newEstimatedTotalPrice = ((estimatedPrice/ longevityValue)* durationValue).toFixed(2);
                    }
            } 
            else if (longevityDropdown.value === 'year') {
                    if (costDurationDropdown.value === 'day') {
                        newEstimatedTotalPrice = (estimatedPrice/ (365* longevityValue) * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'month') {
                        newEstimatedTotalPrice = (estimatedPrice/ (12 * longevityValue) * durationValue).toFixed(2);
                    } else if (costDurationDropdown.value === 'week') {
                        newEstimatedTotalPrice = (estimatedPrice/ (52 * longevityValue)* durationValue).toFixed(2);
                    } else {
                        newEstimatedTotalPrice = ((estimatedPrice/ longevityValue) * durationValue).toFixed(2);
                    }
            }
        }


        // Update the estimated total price input
        estimatedTotalPriceInput.value = `₱${newEstimatedTotalPrice}`;
    }


      

     // Event listener for usage input para di mag accept ng letters, numbers lang
    const condomAmount = document.getElementById("condomAmount-input");
    const costDuration = document.getElementById("cost-duration-input");
            condomAmount.addEventListener("input", function () {
            // Remove any non-numeric characters from the input
            this.value = this.value.replace(/\D/g, '');
            });
            costDuration.addEventListener("input", function () {
            // Remove any non-numeric characters from the input
            this.value = this.value.replace(/\D/g, '');
            });
    
</script>


<!-- footer -->

<br><br>
<?php include('footer.php') ?>

</body>

</html>
