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

    .contraceptive-button,
    .condom-brand-button,
    .recommended-brand-button {
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    border-radius:10px;
    }

   </style>
   

</head>

<body style="background: #F2F5FF;">

    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="title-cost-calculator" id="title-cost-calculator">
        <h1>Contraceptive Cost Calculator</h1>
    </div>

    <div class= "title-description-container" id="title-description-container">
        <p>This birth control calculator was designed to help you compare the costs and effectiveness of different contraceptive options.</p>
    </div>

    <div class="cost-calculator-container" id="cost-calculator-container">
    <h3>Cost Calculator</h3>
    <p>Select a contraceptive method:</p>
        <div class="button-row">
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
                    echo '<button class="contraceptive-button" data-method="' . $method_name . '">';
                    echo '<span>' . $method_name . '</span>';
                    echo '<img src="' . $method_img . '" alt="' . $method_name . '" width="80" height="80">';
                    echo '</button>';
        
                    $count++; //counter para 7 lang kada row ang buttons 
                    if ($count === 7) {
                        echo '</div><div class="button-row">';
                        $count = 0;
                    }
                }
            ?>
        </div>
    </div>


    <!--Dito yung container ng method na napili-->
    <div class="selected-method-container" id="selected-method-container" style="display:none">
    
        <br>
        <!--mapupunta dito yung selected method name na kasing laki ng h3-->
        <h3><span id="selected-method-text"></span></h3>
        <br>
        <div class="longevity-input-container" id="longevity-input-container" style="background-color: #FFFFFF; width: 300px;">
            <!--longevity ay nakaset na, so pag nagselect sa dropdown makikita kung ilang days, months, or weeks ittake yung selected method-->
            <label for="longevity">Longevity</label>
            <span class="separator">|</span>
            <!--nakadisable tong input text field kasi system magcompute ng ilang days/weeks/months/years-->
            <input type="text" id="longevity-input" pattern="[0-9]*" style="width: 70px" disabled>
            <select id="duration-dropdown">
                <!-- Options will be added dynamically using JavaScript -->
            </select>
        </div>
    </div>

    <br>
    
    <div class="estimated-price-input-container" id="estimated-price-input-container" style="background-color: #FFFFFF; width: 320px; display:none">
        <label for="estimatePrice">Estimated Price</label>
        <span class="separator">|</span>
        <input type="text" id="estimated-price-input" disabled> <!-- est price maa-add dynamically using JavaScript -->
    </div>

    <br>

    <div class="condom-input-container" id="condom-input-container" style="background-color: #FFFFFF; width: 300px; display:none">
        <label for="condom">Do you also buy condoms?</label>
        <span class="separator">|</span>
        <select id="answer-dropdown">
            <option value="no">No</option>
            <option value="yes">Yes</option>
        </select>
    </div>

    <br>


    <!--nakahide muna, pag nagyes lang sa 'Do you also buy condoms?' lalabas -->
    <div class="condom-if-yes-container" id="condom-if-yes-container" style="display:none">

        <div class="amount-needed-input-container" style="background-color: #FFFFFF; width: 500px;">
            <label for="need">How many do you usually need?</label>
            <span class="separator">|</span>
            <!--nakadisable tong input text field coz js na bahala magcompute dine-->
            <input type="text" id="condomAmount-input" pattern="[0-9]*" maxlength="2"  style="width: 50px;">
            <select id="condomAmount-dropdown">
                <option value="day">Condom/Day</option>
                <option value="week">Condom/Week</option>
                <option selected="selected" value="month">Condom/Month</option>
                <option value="month">Condom/Year</option>
            </select>
        </div>
        <br>
        
        <div class="amount-package-input-container" style="background-color: #FFFFFF; width: 240px;">
            <label for="amountPackage">Amount in Package</label>
            <span class="separator">|</span>
            <!-- nakadisable, kukunin sa db yung amount in package then malalagay dito-->
            <input type="text" id="condom-amount-package-input" style="width: 50px;"disabled>
        </div>

        <br>

        <div class="estimated-condom-price-input-container" style="background-color: #FFFFFF; width: 420px;">
            <label for="estimateCondomPrice">Estimated Price per Package</label>
            <span class="separator">|</span>
            <!-- nakadisable, kukunin sa db yung amount in package then malalagay dito-->
            <input type="text" id="estimated-condom-price-input" disabled>
            </div>
            <br>
        </div>
    </div>


        <div class="recommended-brand-container" id="recommended-brand-container" style="display:none">
            <div class="selected-method-brand-reco" id="selected-method-brand-reco">
                <h3>Recommended Brands</h3>  
                <!--name ng selected method malalagay dine -->
                <p style="font-size:20px;"> <span id="selected-method-text-reco"></span></p>
                <p>Select a brand:</p>

                <div class="method-brands-container" id="method-brands-container">
                    <!--selected method brands malalagay dito na nakabutton -->
                </div>

            </div>

        <br>
         <!--nakahide muna to, magshow lang if yes sa do you buy condoms-->
            <div class="condom-if-yes-container" id="condom-brand" style="display:none" >
                <p style="font-size:20px">Condom</p>
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
                    
                    <button class="condom-brand-button <?php if ($index === 0) echo 'selected'; ?>">
                        <span><?php echo $brand['brand_name']; ?></span>
                        <img src="<?php echo $brand['brand_img']; ?>" alt="<?php echo $brand['brand_name']; ?>" width="80" height="80">
                        <p>₱<?php echo $brand['brand_price']; ?>.00</p>
                    </button>
                <?php endforeach; ?>

            </div>
    </div>

    <div class="cost_calculator_result" id="cost_calculator_result" style= "background: #D2E0F8; display:none">
    
        <label for="cost">How much will you spend over...</label>
                <span class="separator">|</span>
                <input type="text" id="cost-duration-input" pattern="[0-9]*" maxlength="2"  style="width: 50px;">
                <select id="cost-duration-dropdown">
                    <option value="month">Month/s</option>
                    <option value="year">Year/s</option>
                </select>
        <br>
        <label for="estimatedTotalPrice">You will spend</label>
            <span class="separator">|</span>
            <input type="text" id="estimated-total-price-input"  disabled>
        <br><br>
         <!--mag switch case dito para macheck ano yung selected method tas kuhanin sa db effectivetess rate, check din if nakayes sa condom para lumabas yung youre mixing two types of birth control note. nakaphp echo dat yung method na pinili-->
        <p style="font-size:14px"><b>Your chosen type of birth control is 99.85% effective</b>. You’re mixing two types of birth control. This makes the efficacy higher that it would’ve been if you weren’t also using condoms.<br><br>You’re using hormonal birth control. We encourage you to stay informed about its many possible side effects.</p>


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
            brandButton.classList.add('recommended-brand-button');
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
                calculateEstimatedTotalPrice();
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
            selectedMethodContainer.style.display = 'block';
            estimatePriceInputContainer.style.display = 'block';
            condomInputContainer.style.display = 'block';
            recommendedBrandContainer.style.display = 'block';
            costResult.style.display = 'block';
            selectedMethodText.textContent = selectedMethod; // Set the selected method name

            // Update the selected method name inside the recommended brands container
            const selectedMethodTextReco = document.getElementById('selected-method-text-reco');
            selectedMethodTextReco.textContent = selectedMethod;

            // Hide condom-related containers
            condomIfYesContainer.style.display = 'none';
            condomBrandContainer.style.display = 'none';

            calculateEstimatedTotalPrice();


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

            const selectedBrandIndex = 0; // Change this index based on user selection
            const selectedBrand = condomBrands[selectedBrandIndex];
            const amountInPackageInput = document.getElementById('condom-amount-package-input');
            amountInPackageInput.value = selectedBrand.brand_amount_package;

        
        // Trigger a click event on the first condom brand button to update the estimated condom price input
        const firstCondomBrandButton = document.querySelector('.condom-brand-button');
        firstCondomBrandButton.click();

        } else {
            condomIfYesContainer.style.display = 'none';
            condomBrandContainer.style.display = 'none';
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

            

            calculateEstimatedTotalPrice();

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

    /* pancheck ng values
    console.log('answerDropdown.value:', answerDropdown.value);
    console.log('estimatedPriceInput.value:', estimatedPriceInput.value);
    console.log('estimatedCondomPriceInput.value:', estimatedCondomPriceInput.value);
    console.log('condomAmountInput.value:', condomAmountInput.value);
    console.log('condomAmountPackageInput.value:', condomAmountPackageInput.value);
    console.log('costDurationInput.value:', costDurationInput.value);
    console.log('costDurationDropdown.value:', costDurationDropdown.value);*/

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

        console.log('condomPricePerPackage:', condomPricePerPackage.value);
    console.log('totalPackagesNeeded.value:', totalPackagesNeeded.value);
    console.log('totalCondomPrice.value:', totalCondomPrice.value);
    console.log('totalEstimatedPrice.value:', totalEstimatedPrice.value);
    }
}

    const condomAmountPackageInput = document.getElementById('condom-amount-package-input');
    
    const costDurationInput = document.getElementById('cost-duration-input');
    
    const costDurationDropdown = document.getElementById('cost-duration-dropdown');
    const estimatedTotalPriceInput = document.getElementById('estimated-total-price-input');
answerDropdown.addEventListener('change', calculateEstimatedTotalPrice);
condomAmountInput.addEventListener('input', calculateEstimatedTotalPrice);
condomAmountPackageInput.addEventListener('input', calculateEstimatedTotalPrice);
costDurationInput.addEventListener('input', calculateEstimatedTotalPrice);
costDurationDropdown.addEventListener('change', calculateEstimatedTotalPrice);


    

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

</body>

</html>