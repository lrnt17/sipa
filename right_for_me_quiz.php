<?php  
    require("connect.php");
    require("functions.php");
    //session_start(); 

    $methodsForMale = [
        "Condom",
        "Withdrawal Method",
        "Vasectomy",
    ];
    
    $methodsForFemale = [
        "Hormonal IUD",
        "Copper IUD",
        "Implant",
        "Injection",
        "Mini Pill",
        "Combination Pill",
        "Diaphragm",
        "Spermicide",
        "Calendar Method",
        "Temperature Method",
        "Tubal Ligation",
    ];

// Assuming you have already established a database connection ($conn)
$user_id = $_SESSION['USER']['user_id'];
$sql = "SELECT user_sex FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userSex = $row['user_sex']; // User's sex (e.g., 'Male' or 'Female')
}
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    @media (max-width: 450px) {
            .table-hover{
                font-size: 13px !important;
            }
            .table-container{
                padding:30px !important;
            }
            
        }
   </style>
   

</head>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
    <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
        <div class="col-auto"><p style="font-size: 3.5rem;">Take the</p></div>
        <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Test</p></div>
    </div>
</div>
<div class="row height d-flex justify-content-center align-items-center">

          <div class="col-md-6">

            <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center;">
            Kumpletuhin ang pagsusulit sa pamamagitan ng pagbibigay ng iyong mga nakaraang preferences, preferences, medical history, at iba pang factor na mga kadahilanan upang matukoy ang iyong top 3 na inirerekomendang paraan ng kontrasepsyon.
                </div>

            </div>
        </div>
    
    <div class="container mt-3">
    <p align="justify" class="mb-5" style="font-weight:300;"> 
    <b>Paalala</b> : Ang aming mga rekomendasyon ay layunin lamang na magbigay-kaalaman sa iyo tungkol sa mga potensyal na paraan ng kontrasepsyon batay sa iyong ibinigay na impormasyon. Ang pagsusulit na ito ay ginawa sa pamamagitan ng gabay ng isang kwalipikadong tagapagkalinga ng kalusugan para sa personalisadong gabay sa pagpili ng kontrasepsyon. Gayunpaman, hindi ito pumapalit sa propesyonal na payo medikal. Ikaw ang huling magdedesisyon kung alin sa tingin mo ang pinakatamang paraan para sa iyo. Ikaw ang responsable sa kahusayan ng impormasyong ibinigay. Hindi kami mananagot para sa anumang pinsala o kawalan dulot ng paggamit ng website o pagtitiwala sa mga rekomendasyon.
    </p>
        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #F2C1A7;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            
            <div class="col mt-3">
                <h5>User Experiences</h5>
                <p>Piliin ang paraang contraceptive na mayroon kang dating karanasan.<span style="color: red;"> *</span></p>
            </div>
        </div>
    
        <br>
    
    <form id= "quiz_form" action="right_for_me_quiz_result.php" method="post" onsubmit="validateForm(event)">

    <div class="container rounded-2 shadow-sm rounded table-container" style="background:white; padding: 3rem">
        <div class="user-experience-container" id="user-experience-container">
            <table class="table table-hover">
                <tr>
                    <th>Contraceptive Method</th>
                    <th>Ano ang karanasan mo?</th>
                    <th>Ikukunsidera mo bang gamitin ito ulit?</th>
                </tr>
                <?php
        $methods = ($userSex === "Male") ? $methodsForMale : $methodsForFemale;

        foreach ($methods as $method) {
            // Generate HTML for each contraceptive method
            echo '<tr>';
            echo '<td><input type="checkbox" name="user-exp-chckbx" id="' . strtolower(str_replace(' ', '', $method)) . '" onchange="toggleRadioButtons(\'' . strtolower(str_replace(' ', '', $method)) . '\')"> <label style="display: inline !important;" for="' . strtolower(str_replace(' ', '', $method)) . '">' . $method . '</label></td>';
            echo '<td>';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Experience" name="' . strtolower(str_replace(' ', '', $method)) . 'Experience" value="good" disabled required> Good </label> ';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Experience" name="' . strtolower(str_replace(' ', '', $method)) . 'Experience" value="neutral" disabled required> Neutral </label> ';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Experience" name="' . strtolower(str_replace(' ', '', $method)) . 'Experience" value="bad" disabled required> Bad </label> ';
            echo '</td>';
            echo '<td>';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Consider" name="' . strtolower(str_replace(' ', '', $method)) . 'Consider" value="yes" disabled required> Yes </label> ';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Consider" name="' . strtolower(str_replace(' ', '', $method)) . 'Consider" value="no" disabled required> No </label> ';
            echo '<label><input type="radio" class="user-exp-radio" id="' . strtolower(str_replace(' ', '', $method)) . 'Consider" name="' . strtolower(str_replace(' ', '', $method)) . 'Consider" value="dontKnow" disabled required> I don\'t know </label> ';
            echo '</td>';
            echo '</tr>';
        }
        ?>
            </table>
            <br>
            <input type="checkbox" id="user-experience-checkbox-none"> <label for="user-experience-checkbox-none"> Hindi ko pa ginamit ang alinman sa mga method na ito</label>

        </div>
    </div>

    
    <br><br><br>
        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #915E98;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-3">
                <h5>Personal Preferences</h5>
                <p>Alin sa mga sumusunod na kadahilanan ang mas mahalaga sa iyo.<span style="color: red;"> *</span></p>
            </div>
        </div>

        <br>

    <div class="container p-5 rounded-2 shadow-sm rounded" style="background:white;">
        <div class ="personal-preferences-container" id="personal-preferences-container">

                <span><b>Epektibo ng gastos</b></span>
                <br>
                <div class="row m-3">
                    <div class="col-md">
                        <label><input type="radio" name="costEffectiveness" id="costEffectiveness1" value="veryImportant"> Very Important</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="costEffectiveness" id="costEffectiveness2" value="important"> Important</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="costEffectiveness" id="costEffectiveness3" value="neutral"> Neutral</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="costEffectiveness" id="costEffectiveness4" value="unimportant"> Unimportant</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="costEffectiveness" id="costEffectiveness5" value="veryUnimportant"> Very Unimportant</label>
                    </div>
                </div>
                <br>
                <div name="female-specific-section">
                    <span><b>Tumutulong sa pag-manage ng regla at mga epekto</b></span>
                    <br>
                    <div class="row m-3">
                        <div class="col-md">
                            <label><input type="radio" name="managingPeriods" id="managingPeriods1" value="veryImportant"> Very Important</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="managingPeriods" id="managingPeriods2" value="important"> Important</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="managingPeriods" id="managingPeriods3" value="neutral"> Neutral</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="managingPeriods" id="managingPeriods4" value="unimportant"> Unimportant</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="managingPeriods" id="managingPeriods5" value="veryUnimportant"> Very Unimportant</label>
                        </div>
                    </div>
                </div>
                <br>
                <span><b>Epektibo sa pagpigil ng pagbubuntis</b></span>
                <br>
                <div class="row m-3">
                    <div class="col-md">
                        <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy1" value="veryImportant"> Very Important</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy2" value="important"> Important</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy3" value="neutral"> Neutral</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy4" value="unimportant"> Unimportant</label>
                    </div>
                    <div class="col-md">
                        <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy5" value="veryUnimportant"> Very Unimportant</label>
                    </div>
                </div>

                <br>
                <div name="female-specific-section">
                    <span><b>Mababang posibilidad ng pagtaba</b></span>
                    <br>

                    <div class="row m-3">
                        <div class="col-md">
                            <label><input type="radio" name="gainingWeight" id="gainingWeight1" value="veryImportant"> Very Important</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="gainingWeight" id="gainingWeight2" value="important"> Important</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="gainingWeight" id="gainingWeight3" value="neutral"> Neutral</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="gainingWeight" id="gainingWeight4" value="unimportant"> Unimportant</label>
                        </div>
                        <div class="col-md">
                            <label><input type="radio" name="gainingWeight" id="gainingWeight5" value="veryUnimportant"> Very Unimportant</label>
                        </div>
                    </div>
                </div>

        </div>

    </div>



    <br><br><br>

        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto">
                <h5>Medical History</h5>
                
            </div>
        </div>

        <br>

    <div class="cont p-5 rounded-2 shadow-sm rounded" style="background:white;">
        <div class ="medical-history-container" id="medical-history-container">
            <p><b>Mayroon ka bang concern tungkol sa alinman sa mga sumusunod na kondisyon? (Pumili ng lahat na naaangkop)<span style="color: red;"> *</span></b></p>
            <input type="checkbox" name="med-hist-chckbx" id="depression"> <label style="display: inline !important;" for="depression"> Depression or anxiety</label><br>
            <input type="checkbox" name="med-hist-chckbx" id="acne"> <label style="display: inline !important;" for="acne"> Acne and breakouts</label><br>
            <input type="checkbox" name="med-hist-chckbx" id="blood-clotting-disorder"> <label style="display: inline !important;" for="blood-clotting-disorder"> Blood clotting disorder</label><br>
            <div id="pcosSection"><input type="checkbox" name="med-hist-chckbx" id="pcos"> <label style="display: inline !important;" for="pcos"> Polycystic Ovary Syndrome (PCOS) or Endometriosis</label><br></div>
            <input type="checkbox" name="med-hist-chckbx" id="hypertension"> <label style="display: inline !important;" for="hypertension"> Hypertension or highblood pressure</label><br>
            <input type="checkbox" name="med-hist-chckbx" id="treatment-for-sti"> <label style="display: inline !important;" for="treatment-for-sti"> Treatment for Sexual Transmitted Infection (STIs)</label><br><br>
            <input type="checkbox"  id="none-of-the-above"> <label style="display: inline !important;" for="none-of-the-above"><b> Wala sa mga nabanggit</b></n></label>
            
        </div>
    </div>

    

    <br><br><br>

        <div class="row flex-nowrap" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #B6CCF5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto">
                <h5>Additional Factors</h5>
            </div>
        </div>
        
        <br>
    <div class="cont p-5 rounded-2 shadow-sm rounded" style="background:white;">
    <div class ="additional-factors-container" id="additional-factors-container-female">
            <div class = "number-1-additional-factor" id="number-1-additional-factor">
                <p><b>1. Ano ang nararamdaman mo tungkol sa pagpapasok ng isang bagay sa iyong ari o vagina?<span style="color: red;"> *</span></b></p>
                <label><input type="radio" class="additional-factors-radio" value= "veryComfortable" id="very-comfortable" name="answer1"> Very Comfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "comfortable" id="comfortable" name="answer1"> Comfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "neutral" id="neutral" name="answer1"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "uncomfortable" id="uncomfortable" name="answer1"> Uncomfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "veryUncomfortable" id="very-uncomfortable" name="answer1"> Very Uncomfortable</label>
            </div>
            <br>
            <div class = "number-2-additional-factor" id="number-2-additional-factor">
                <p><b>2. Sa anong hormone level ka pinakakumportable?<span style="color: red;"> *</span></b></p>
                <label><input type="radio" class="additional-factors-radio" value="no-hormones" id="no-hormones" name="answer2"> No hormones</label><br>
                <label><input type="radio" class="additional-factors-radio" value="one-hormone" id="one-hormone" name="answer2"> One hormone (progestin only methods)</label><br>
                <label><input type="radio" class="additional-factors-radio" value="two-hormones" id="two-hormones" name="answer2"> Two hormones (progestin and estrogen methods)</label><br>
                <label><input type="radio" class="additional-factors-radio" value="dontknow" id="dontknow" name="answer2"> I don't know/ no preference</label>
            </div>
            <br>
            <div class = "number-3-additional-factor" id="number-3-additional-factor">
                <p><b>3. Gaano kadalas mo gustong gamitin ang iyong contraceptive method?<span style="color: red;"> *</span></b></p>
                <label><input type="radio" class="additional-factors-radio" value="daily" id="daily" name="answer3"> Daily</label><br>
                <label><input type="radio" class="additional-factors-radio" value="weeklyl" id="weekly" name="answer3"> Weekly</label><br>
                <label><input type="radio" class="additional-factors-radio" value="monthly" id="monthly" name="answer3"> Monthly</label><br>
                <label><input type="radio" class="additional-factors-radio" value="yearly" id="yearly" name="answer3"> Yearly</label><br>
                <label><input type="radio" class="additional-factors-radio" value="dontknow2" id="dontknow2" name="answer3"> I don't know/ no preference</label>
            </div>
            <br>
            <div class = "number-4-additional-factor" id="number-4-additional-factor">
            <p><b>4. Ikukunsidera mo ba ang permanenteng contraceptive method tulad ng tubal ligation?<span style="color: red;"> *</span></b></p>
                <label><input type="radio" class="additional-factors-radio" value="yes" id="yes" name="answer4"> Yes</label><br>
                <label><input type="radio" class="additional-factors-radio" value="no" id="no" name="answer4"> No</label><br>
                <label><input type="radio" class="additional-factors-radio" value="dontknow3" id="dontknow3" name="answer4"> I don't know/ no preference</label>
            </div>
            <br>
            <div class = "number-5-additional-factor" id="number-5-additional-factor">
                <p><b>5. Gaano ka kumportable sa mga paraang nangangailangan lamang ng fertility awareness?<span style="color: red;"> *</span></b></p>
                <label><input type="radio" class="additional-factors-radio" value= "veryComfortable" id="very-comfortable" name="answer5"> Very Comfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "comfortable" id="comfortable" name="answer5"> Comfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "neutral" id="neutral" name="answer5"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "uncomfortable" id="uncomfortable" name="answer5"> Uncomfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value= "veryUncomfortable" id="very-uncomfortable" name="answer5"> Very Uncomfortable</label>
            </div>
        </div>

        <div class="additional-factors-container" id="additional-factors-container-male" style="display:none;">
            <div class="number-1-additional-factor-male" id="number-1-additional-factor-male">
                <p><b>1. Gaano kahalaga para sa iyo ang pagiging hindi planado sa pagpili ng iyong birth control?</b><span style="color: red;"> *</span></p>
                <label><input type="radio" class="additional-factors-radio" value="veryImportant" name="maleAnswer1"> Very Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="important" name="maleAnswer1"> Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="neutral" name="maleAnswer1"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value="unimportant" name="maleAnswer1"> Unimportant</label><br>
                <label><input type="radio" class="additional-factors-radio" value="veryUnimportant" name="maleAnswer1"> Very Unimportant</label>
            </div>
            <br>
            <div class="number-2-additional-factor-male" id="number-2-additional-factor-male">
                <p><b>2. Gaano kahalaga ang kadalian ng paggamit para sa iyo?</b><span style="color: red;"> *</span></p>
                <label><input type="radio" class="additional-factors-radio" value="veryImportant" name="maleAnswer2"> Very Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="important" name="maleAnswer2"> Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="neutral" name="maleAnswer2"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value="unimportant" name="maleAnswer2"> Unimportant</label><br>
                <label><input type="radio" class="additional-factors-radio" value="veryUnimportant" name="maleAnswer2"> Very Unimportant</label>
            </div>
            <br>
            <div class="number-3-additional-factor-male" id="number-3-additional-factor-male">
                <p><b>3. Gaano kahalaga sa iyo ang pag-iwas sa sexually transmitted infections (STIs)?</b><span style="color: red;"> *</span></p>
                <label><input type="radio" class="additional-factors-radio" value="veryImportant" name="maleAnswer3"> Very Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="important" name="maleAnswer3"> Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="neutral" name="maleAnswer3"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value="unimportant" name="maleAnswer3"> Unimportant</label><br>
                <label><input type="radio" class="additional-factors-radio" value="veryUnimportant" name="maleAnswer3"> Very Unimportant</label>
            </div>
        <br>
        <div class="number-4-additional-factor-male" id="number-4-additional-factor-male">
                <p><b>4. Gaano kahalaga sa iyo ang pangmatagalan na contraception?</b><span style="color: red;"> *</span></p>
                <label><input type="radio" class="additional-factors-radio" value="veryImportant" name="maleAnswer4"> Very Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="important" name="maleAnswer4"> Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="neutral" name="maleAnswer4"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value="unimportant" name="maleAnswer4"> Unimportant</label><br>
                <label><input type="radio" class="additional-factors-radio" value="veryUnimportant" name="maleAnswer4"> Very Unimportant</label>
            </div>
            <br>
        <div class="number-5-additional-factor-male" id="number-5-additional-factor-male">
                <p><b>5. Gaano ka kumportable sa ideya ng isang permanenteng contraceptive method?</b><span style="color: red;"> *</span></p>
                <label><input type="radio" class="additional-factors-radio" value="veryComfortable" name="maleAnswer5"> Very Comfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value="comfortable" name="maleAnswer5"> Important</label><br>
                <label><input type="radio" class="additional-factors-radio" value="neutral" name="maleAnswer5"> Neutral</label><br>
                <label><input type="radio" class="additional-factors-radio" value="uncomfortable" name="maleAnswer5"> Uncomfortable</label><br>
                <label><input type="radio" class="additional-factors-radio" value="veryUncomfortable" name="maleAnswer5"> Very Uncomfortable</label>
            </div>
            <br>
        </div>

    </div>
    
    <input type="hidden" name="recommendations" id="recommendations_input" value="">
    <input type="submit" value="Get Result" name="submit" class="btn my-4 px-5 py-3" style="background: #D2E0F8; float:right;">
    </form>

    </div>
    
    
    <br><br><br><br>

    
    <br><br>
    <!-- check kung first time logged in, pag oo, wala muna footer -->
    <?php
    
    $checkLoginQuery = "SELECT first_logged_in FROM users WHERE user_id = $user_id";
    $checkLoginResult = mysqli_query($conn, $checkLoginQuery);

    if (mysqli_num_rows($checkLoginResult) > 0) {
        $row = mysqli_fetch_assoc($checkLoginResult);
        $loggedin = $row['first_logged_in']; // Logged_in (1 if no, 0 if yes)
    }
    
    if ($loggedin == 1){
        include('footer.php');
    }
    
    ?>

    <script>

        var loggedin = "<?php echo $loggedin; ?>";
        console.log(loggedin);

        var userSex = "<?php echo $userSex; ?>";
        console.log(userSex);

        // Get a collection of elements with the name "female-specific-section"
        const femaleSpecificSections = document.getElementsByName('female-specific-section');

        // Loop through the collection and hide/show each element based on the user's sex
        for (let i = 0; i < femaleSpecificSections.length; i++) {
            if (userSex === 'Male') {
                // If the user is male, hide the female-specific section
                femaleSpecificSections[i].style.display = 'none';
            } else {
                // If the user is female, show the female-specific section
                femaleSpecificSections[i].style.display = 'block';
            }
        }
        if (userSex === 'Male') {
            const pcosSection = document.getElementById('pcosSection');
            pcosSection.style.display = 'none';
            const additionalFactorsMale = document.getElementById('additional-factors-container-male');
            const additionalFactorsFemale = document.getElementById('additional-factors-container-female');
            additionalFactorsMale.style.display = 'block';
            additionalFactorsFemale.style.display = 'none';

            }
        else{

        }

        //if the user ticked the None of the Above or the I have not used any of these methods
        const noneCheckbox = document.getElementById('none-of-the-above');
        const noneCheckbox2 = document.getElementById('user-experience-checkbox-none');
        const checkboxes = document.getElementsByName('med-hist-chckbx');
        const checkboxes2 = document.getElementsByName('user-exp-chckbx');
        const radiobuttons = document.getElementsByClassName('user-exp-radio');

        //for medical history checkboxes
        noneCheckbox.addEventListener('change', function() {
            if (this.checked) {
            // Disable other checkboxes and uncheck them
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].disabled = true;
                checkboxes[i].checked = false;
                
            }
            
            } else {
            // Enable other checkboxes
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].disabled = false;
            }
            }
        })

        //for user experience checkboxes
        noneCheckbox2.addEventListener('change', function() {
            if (this.checked) {
            // Disable other checkboxes2 and uncheck them
            for (let i = 0; i < checkboxes2.length; i++) {
                checkboxes2[i].disabled = true;
                checkboxes2[i].checked = false;
            }
            for (let i = 0; i < radiobuttons.length; i++) {
                radiobuttons[i].disabled = true;
                radiobuttons[i].checked = false;
            }

            } else {
            // Enable other checkboxes
            for (let i = 0; i < checkboxes2.length; i++) {
                checkboxes2[i].disabled = false;
            }
            }
        });

        // Get all radio button elements
        const radioButtons = document.querySelectorAll('.additional-factors-radio');

        // Attach event listener to each radio button
        radioButtons.forEach(radioButton => {
        radioButton.addEventListener('change', handleRadioButtonChange);
        });

        function handleRadioButtonChange(event) {
        const selectedRadioButton = event.target;
        const radioGroupName = selectedRadioButton.name;

        // Reset styles for all radio buttons in the same group
        radioButtons.forEach(radioButton => {
            if (radioButton.name === radioGroupName) {
            radioButton.parentElement.style.fontWeight = 'normal';
            radioButton.parentElement.style.color = 'lightgray';
            }
        });

        // Apply styles to the selected radio button
        selectedRadioButton.parentElement.style.fontWeight = 'bold';
        selectedRadioButton.parentElement.style.color = 'black';
        }

        //enable the radiobuttons when a checkbox is selected
        
        function toggleRadioButtons(method) {
        var checkbox = document.getElementById(method);
        var experienceRadios = document.getElementsByName(method + "Experience");
        var considerRadios = document.getElementsByName(method + "Consider");

        if (checkbox.checked) {
            for (var i = 0; i < experienceRadios.length; i++) {
            experienceRadios[i].disabled = false;
            }
            for (var j = 0; j < considerRadios.length; j++) {
            considerRadios[j].disabled = false;
            }
        } else {
            for (var i = 0; i < experienceRadios.length; i++) {
            experienceRadios[i].disabled = true;
            experienceRadios[i].checked = false;
            }
            for (var j = 0; j < considerRadios.length; j++) {
            considerRadios[j].disabled = true;
            considerRadios[j].checked = false;
            }
        }
        }

        //validate the radiobuttons before submitting
        
        function validateForm(event) {
        var radioGroupsPersonalPrefFemale = ["costEffectiveness", "managingPeriods", "preventingPregnancy", "gainingWeight"];
        var radioGroupsPersonalPrefMale =["costEffectiveness", "preventingPregnancy"];
        var checkboxesMedHist = document.querySelectorAll('input[type="checkbox"][name="med-hist-chckbx"]');
        var checkboxesUserExp = document.querySelectorAll('input[type="checkbox"][name="user-exp-chckbx"]');
        var noneOfTheAboveCheckbox = document.getElementById('none-of-the-above');
        var noneOfTheAboveCheckboxUserExp = document.getElementById('user-experience-checkbox-none');
        var radioGroupsAddFactorsFemale =["answer1", "answer2", "answer3", "answer4", "answer5"];
        var radioGroupsAddFactorsMale = ["maleAnswer1", "maleAnswer2", "maleAnswer3", "maleAnswer4", "maleAnswer5"];
        
        
        var radioChecked = false;
        //pang validate sa radiobuttons for additionalFactors Female
        if (userSex =="Female"){

            for (var i = 0; i < radioGroupsAddFactorsFemale.length; i++) {
                var groupName = radioGroupsAddFactorsFemale[i];
                var radioGroup = document.querySelectorAll('input[type="radio"][name^="' + groupName + '"]');
                
                // Check if at least one radio button in the group is checked
                var groupChecked = false;
                for (var j = 0; j < radioGroup.length; j++) {
                    if (radioGroup[j].checked) {
                        groupChecked = true;
                        break;
                    }
                }
                
                // If any group is not checked, set radioChecked to false and break
                if (!groupChecked) {
                    radioChecked = false;
                    break;
                }
                
                // Set radioChecked to true only if all groups are checked
                radioChecked = true;
            }
        }
        //pang validate sa radiobuttons for additionalFactors Male
        else if (userSex =="Male"){
            for (var i = 0; i < radioGroupsAddFactorsMale.length; i++) {
                var groupName = radioGroupsAddFactorsMale[i];
                var radioGroup = document.querySelectorAll('input[type="radio"][name^="' + groupName + '"]');
                
                // Check if at least one radio button in the group is checked
                var groupChecked = false;
                for (var j = 0; j < radioGroup.length; j++) {
                    if (radioGroup[j].checked) {
                        groupChecked = true;
                        break;
                    }
                }
                
                // If any group is not checked, set radioChecked to false and break
                if (!groupChecked) {
                    radioChecked = false;
                    break;
                }
                
                // Set radioChecked to true only if all groups are checked
                radioChecked = true;
            }
        }

        
        var radioPersonalPrefChecked = false;
        //pang validate sa radiobuttons for Personal Preferences Female
        if (userSex =="Female"){

            for (var i = 0; i < radioGroupsPersonalPrefFemale.length; i++) {
                var groupName = radioGroupsPersonalPrefFemale[i];
                var radioGroup = document.querySelectorAll('input[type="radio"][name^="' + groupName + '"]');
                
                // Check if at least one radio button in the group is checked
                var groupChecked = false;
                for (var j = 0; j < radioGroup.length; j++) {
                    if (radioGroup[j].checked) {
                        groupChecked = true;
                        break;
                    }
                }
                
                // If any group is not checked, set radioPersonalPrefChecked to false and break
                if (!groupChecked) {
                    radioPersonalPrefChecked = false;
                    break;
                }
                
                // Set radioPersonalPrefChecked to true only if all groups are checked
                radioPersonalPrefChecked = true;
            }
        }
        //pang validate sa radiobuttons for Personal Preferences Male
        else if (userSex =="Male"){
            for (var i = 0; i < radioGroupsPersonalPrefMale.length; i++) {
                var groupName = radioGroupsPersonalPrefMale[i];
                var radioGroup = document.querySelectorAll('input[type="radio"][name^="' + groupName + '"]');
                
                // Check if at least one radio button in the group is checked
                var groupChecked = false;
                for (var j = 0; j < radioGroup.length; j++) {
                    if (radioGroup[j].checked) {
                        groupChecked = true;
                        break;
                    }
                }
                
                // If any group is not checked, set radioPersonalPrefChecked to false and break
                if (!groupChecked) {
                    radioPersonalPrefChecked = false;
                    break;
                }
                
                // Set radioPersonalPrefChecked to true only if all groups are checked
                radioPersonalPrefChecked = true;
            }
        }
            
        //pang check sa med history checkbox
        var medHistCheckboxChecked = false;
            for (var k = 0; k < checkboxesMedHist.length; k++) {
                if (checkboxesMedHist[k].checked) {
                    medHistCheckboxChecked = true;
                    break;
                }
            }
        //pang check sa user experience checkbox
        var userExpCheckboxChecked = false;
            for (var l = 0; l < checkboxesUserExp.length; l++) {
                if (checkboxesUserExp[l].checked) {
                    userExpCheckboxChecked = true;
                    break;
                }
            }


            if ((!radioChecked || !radioPersonalPrefChecked || (!noneOfTheAboveCheckbox.checked && !medHistCheckboxChecked) || (!noneOfTheAboveCheckboxUserExp.checked && !userExpCheckboxChecked))) {
                alert('Please select an option for each question or check at least one option on the checkboxes.');
                event.preventDefault();
            } else {
                // Form validation succeeded, allow the form to submit
                // The form will automatically navigate to right_for_me_quiz_result.php


            //---------------------------FOR SCORING NA ITONG PART NA TO---------------------------------------

            //------------------WORKING SCORING SYSTEM FOR USER EXPERIENCE------------------------
            var form = document.getElementById("quiz_form");
            var selectedMethods = [];
            var scores = {};

    
            // Define contraceptive methods for males
            var maleContraceptiveMethods = [
                'condom',
                'withdrawalmethod',
                'vasectomy'
            ];

            // Define contraceptive methods for females
            var femaleContraceptiveMethods = [
                'hormonaliud',
                'copperiud',
                'implant',
                'injection',
                'combinedpill',
                'minipill',
                'diaphragm',
                'spermicide',
                'calendarmethod',
                'temperaturemethod',
                'tuballigation'
            ];


            // Define the current scores for each contraceptive method
            var methodScores = {};
            // Filter contraceptive methods based on the user's sex
            var applicableMethods = (userSex === 'Male') ? maleContraceptiveMethods : femaleContraceptiveMethods;
            console.log('Applicable Methods:', applicableMethods);
            applicableMethods.forEach(function (method) {
            methodScores[method] = 0;
            });

            // Loop through all the checkboxes to find the selected methods
            var checkboxes = form.querySelectorAll('input[type="checkbox"][name="user-exp-chckbx"]:checked');
            checkboxes.forEach(function (checkbox) {
            selectedMethods.push(checkbox.id);
            });

            // Loop through the selected methods and calculate scores based on user answers
            selectedMethods.forEach(function (method) {
            // Check if the method is applicable to the user's sex
            if (applicableMethods.includes(method)) {
                var experienceValue = form.elements[method + "Experience"].value;
                var considerValue = form.elements[method + "Consider"].value;

                if (experienceValue === "good") {
                    methodScores[method] += 8;
                } else if (experienceValue === "bad") {
                    methodScores[method] -= 8;
                }

                if (considerValue === "yes") {
                    methodScores[method] += 2;
                } else if (considerValue === "no") {
                    delete methodScores[method];
                }
            }
        });
            //------------------WORKING SCORING SYSTEM FOR PERSONAL PREFERENCE-----------------------------
            // Define the methods associated with each feature
            var costEffectivenessMethods = [
            'condom',
            'combinedpill',
            'minipill',
            'diaphragm',
            'withdrawalmethod',
            'calendarmethod',
            'temperaturemethod',
            ];
            var preventingPregnancyMethods = [
            'combinedpill',
            'minipill',
            'injection',
            'implant',
            'copperiud',
            'hormonaliud',
            'vasectomy',
            'tuballigation'
            ];
            var managingPeriodsMethods = [
            'combinedpill',
            'minipill',
            'implant',
            'hormonaliud',
            'injection'
            ];
            var gainingWeightMethods = [
            'condom',
            'copperiud'
            ];

            // Loop through all contraceptive methods and calculate scores based on user preferences
            applicableMethods.forEach(function (method) {
            // Get the user's preference for each feature
            var costEffectivenessValue = form.elements["costEffectiveness"].value;
            var preventingPregnancyValue = form.elements["preventingPregnancy"].value;
            var managingPeriodsValue = form.elements["managingPeriods"].value;
            var gainingWeightValue = form.elements["gainingWeight"].value;

            // Calculate scores based on user preferences for each method
            if (costEffectivenessMethods.includes(method)) {
                methodScores[method] += getScore(costEffectivenessValue);
            }

            if (preventingPregnancyMethods.includes(method)) {
                methodScores[method] += getScore(preventingPregnancyValue);
            }

            if (managingPeriodsMethods.includes(method)) {
                methodScores[method] += getScore(managingPeriodsValue);
            }

            if (gainingWeightMethods.includes(method)) {
                methodScores[method] += getScore(gainingWeightValue);
            }
            });

            // Function to get the score based on the user's preference value
            function getScore(value) {
            switch (value) {
                case "veryImportant":
                return 2;
                case "important":
                return 1;
                case "neutral":
                return 0;
                case "unimportant":
                return -1;
                case "veryUnimportant":
                return -2;
                default:
                return 0;
            }
            }

            //------------------SCORING SYSTEM CODE FOR MEDICAL HISTORY NAMAN DITO ------------------------------

            // Get the user's answers for the medical history questions
            var medHistCheckboxes = form.querySelectorAll('input[type="checkbox"][name="med-hist-chckbx"]:checked');
            var medHistConditions = [];
            medHistCheckboxes.forEach(function (checkbox) {
            medHistConditions.push(checkbox.id);
            });

            // Update scores based on medical history conditions
            medHistConditions.forEach(function (condition) {
            if (condition === "acne" || condition === "pcos") {
                methodScores["combinedpill"] += 2;
            } else if (condition === "depression") {
                delete methodScores["combinedpill"];
                delete methodScores["hormonaliud"];
                delete methodScores["injection"];
            } else if (condition === "blood-clotting-disorder" || condition === "hypertension") {
                delete methodScores["combinedpill"];
                delete methodScores["tuballigation"];
                delete methodScores["vasectomy"];
            } else if (condition === "treatment-for-sti") {
                delete methodScores["hormonaliud"];
                delete methodScores["copperiud"];
                methodScores["condom"] += 2;
            }
            });



            //------------------WORKING SCORING SYSTEM CODE FOR ADDITIONAL FACTORS---------------------------

            // Define the methods associated with each question
            var foreignObjectMethods = ['hormonaliud', 'copperiud', 'diaphragm'];
            var hormoneLevelMethods = ['condom', 'withdrawalmethod', 'temperaturemethod', 'calendarmethod', 'diaphragm', 'spermicide', 'tuballigation', 'copperiud', 'implant', 'minipill', 'injection', 'hormonaliud', 'combinedpill'];
            var frequencyMethods = ['condom', 'diaphragm', 'spermicide', 'withdrawalmethod', 'calendarmethod', 'temperaturemethod', 'minipill', 'combinedpill', 'injection', 'implant', 'copperiud', 'hormonaliud'];
            var permanentMethods = [ 'tuballigation'];

            // Define the relevant methods for each hormone level category
            var noHormonesMethods = ['condom', 'withdrawalmethod', 'temperaturemethod', 'calendarmethod', 'diaphragm', 'spermicide', 'tuballigation', 'copperiud'];
            var oneHormoneMethods = ['implant', 'minipill', 'injection', 'hormonaliud'];
            var twoHormonesMethods = [ 'combinedpill'];

            var fertilityAwarenessMethods = ['temperaturemethod', 'calendarmethod'];

             // Define the methods associated with each male-specific question
            var question1Methods = ['withdrawalmethod', 'condom']; // Add the contraceptive methods relevant to question 1
            var question2Methods = ['withdrawalmethod', 'condom', 'vasectomy']; // Add the contraceptive methods relevant to question 2
            var question3Methods = ['condom']; // Add the contraceptive methods relevant to question 3
            var question4Methods = ['vasectomy']; // Add the contraceptive methods relevant to question 4
            var question5Methods = ['vasectomy']; // Add the contraceptive methods relevant to question 5

            // Get the user's answers for each question for female
            var answer1Value = form.elements["answer1"].value;
            var answer2Value = form.elements["answer2"].value;
            var answer3Value = form.elements["answer3"].value;
            var answer4Value = form.elements["answer4"].value;
            var answer5Value = form.elements["answer5"].value;

            // Get the user's answers for each question for male
            var maleAnswer1Value = form.elements["maleAnswer1"].value;
            var maleAnswer2Value = form.elements["maleAnswer2"].value;
            var maleAnswer3Value = form.elements["maleAnswer3"].value;
            var maleAnswer4Value = form.elements["maleAnswer4"].value;
            var maleAnswer5Value = form.elements["maleAnswer5"].value;

            // Calculate scores based on user answers for each method
            applicableMethods.forEach(function (method) {
                //FOR FEMALE QUESTIONS
                // Question 1: How do you feel about the insertion of a foreign object into your vagina?
                if (foreignObjectMethods.includes(method)) {
                    methodScores[method] += getScoreAF(answer1Value);
                }

                // Question 2: At what hormone level do you feel most comfortable?
                if (hormoneLevelMethods.includes(method)) {
                    methodScores[method] += getScoreHormoneLevel(method, answer2Value);
                }

                // Question 3: How often do you want to use your contraceptive method?
                if (frequencyMethods.includes(method)) {
                    methodScores[method] += getScoreAF(answer3Value);
                }

                // Question 4: Do you want to permanently stop having children?
                if (permanentMethods.includes(method)) {
                    if (answer4Value === "yes") {
                        methodScores[method] += 15;
                    } else if (answer4Value === "dontknow3") {
                        methodScores[method] += 0;
                    } else {
                        delete methodScores[method];
                    }
                }
                // Question 5: How comfortable are you with methods that only requires fertility awareness?
                if (fertilityAwarenessMethods.includes(method)) {
                    methodScores[method] += getScoreAF(answer5Value);
                }
                //FOR MALE QUESTIONS
                 // Question 1: 1. How much does being unplanned matter in your choice of birth control?
                 if (question1Methods.includes(method)) {
                    methodScores[method] += getScoreAF(maleAnswer1Value);
                }

                // Question 2: How important is ease of use for you?
                if (question2Methods.includes(method)) {
                    methodScores[method] += getScoreAF(maleAnswer2Value);
                }

                // Question 3: How important is preventing STIs for you?
                if (question3Methods.includes(method)) {
                    methodScores[method] += getScoreAF(maleAnswer3Value);
                }

                // Question 4: How important is long-term contraception for you?
                if (question4Methods.includes(method)) {
                    methodScores[method] += getScoreAF(maleAnswer4Value);
                }

                // Question 5: How comfortable are you with permanent contraception?
                if (question5Methods.includes(method)) {
                    methodScores[method] += getScoreAF(maleAnswer5Value);
                }
            });


            // Function to get the score based on the user's answer value for hormone level
            function getScoreHormoneLevel(method, value) {
                if (noHormonesMethods.includes(method) && value === "no-hormones") {
                    return 5;
                } 
                else if (oneHormoneMethods.includes(method) && value === "one-hormone") {
                    return 5;
                }
                else if (twoHormonesMethods.includes(method) && value === "two-hormones") {
                    return 5;
                }
                return 0;
            }

            // Function to get the score based on the user's answer value for other questions
            function getScoreAF(value) {
                switch (value) {
                    case "veryComfortable":
                        return 3;
                    case "comfortable":
                        return 1;
                    case "neutral":
                        return 0;
                    case "uncomfortable":
                        return -4;
                    case "veryUncomfortable":
                        delete methodScores["copperiud"];
                        delete methodScores["diaphragm"];
                        delete methodScores["hormonalvaginalring"];
                        delete methodScores["hormonaliud"];
                    case "daily":
                        return 2;
                    case "weekly":
                        return 2;
                    case "monthly":
                        return 2;
                    case "yearly":
                        return 2;

                    //for males
                    case "veryImportant":
                        return 2;
                    case "important":
                        return 1;
                    case "neutral":
                        return 0;
                    case "unimportant":
                        return -1;
                    case "veryUnimportant":
                        return -2;
                        default:
                        return 0;
                }
            }


            
                



            //---------------PANG SORT NG TOP 3 RECOMMENDED CONTRACEPTIVE METHOD WITH CHECKING------------------------
            // Sort the method scores in descending order
            var sortedMethodScores = Object.entries(methodScores)
                .filter(entry => !isNaN(entry[1])) // Filter out methods with NaN scores
                .sort(function (a, b) {
                    return b[1] - a[1];
                });

            // Get the top 3 methods with the highest scores
            var recommendations = sortedMethodScores.slice(0, 3).map(function (entry) {
            return entry[0];
            });

            // Set the value of the hidden input field to the recommendations
            var recommendationsInput = document.getElementById("recommendations_input");
            recommendationsInput.value = JSON.stringify(recommendations);

            // Submit the form
            // Since you're using onsubmit, you don't need to explicitly submit the form
            // The form will be submitted automatically after this function finishes.

            // Concatenate all contraceptive methods with their scores | para makita scores ng ibang methods
            var allMethodsScores = Object.entries(methodScores).map(function (entry) {
            return entry[0] + " (Score: " + entry[1] + ")";
            });
            
            // Debugging output for method scores
            //console.log('Method Scores:', methodScores);

            // Debugging output for sorted method scores
            //console.log('Sorted Method Scores:', sortedMethodScores);

            // Debugging output for recommendations
            //console.log('Recommendations:', recommendations);

            // Add this code to check the score of "vasectomy" and its conditions
            //console.log('Vasectomy Score:', methodScores['vasectomy']);


            // Show all contraceptive methods with their scores in the alert | para macheck if working
            //alert("Recommendations: " + recommendations + "\n\nAll Methods with Scores: \n" + allMethodsScores.join("\n"));

            // Set the value of the hidden input field to the recommendations
            var recommendationsInput = document.getElementById("recommendations_input");
            recommendationsInput.value = JSON.stringify(recommendations);
            
                
                }
        };


    </script>

    <div id="recommendation">
        

    </div>

</body>
</html>
