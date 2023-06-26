<?php include("connect.php"); session_start(); ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
   </style>
   

</head>
<body>
    <!-- navigation bar with logo -->
    <div class="navigation-bar" id="navigation-container">
        <img src="#">
        <ul>
            <li><a href="home_1_with_user.php">Home</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Dropdown<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            </li>
            <li><a href="#">Sign in</a></li>
            <div class="profile_pic">
                <a href="profile.php" id="avatar_name" href="#name">
                    <img id="avatar" src="<?php //echo $_SESSION["image"]; ?>" alt="avatar">
                </a>
            </div>
        </ul>
    </div>

    <div class="title-quiz" id="title-quiz">
    <h1>Take the quiz</h1>
    </div>

    <h3>User Experiences</h3>
    <p>Identify what methods you have past experience with.<span style="color: red;">*</span></p>
    
    <form id= "quiz_form" action="right_for_me_quiz_result.php" method="post" onsubmit="validateForm(event)">
    <div class="user-experience-container" id="user-experience-container">
        <table>
            <tr>
                <th>Contraceptive Method</th>
                <th>How was your Experience?</th>
                <th>Would you consider using this again?</th>
            </tr>
            <tr>
                <td><input type="checkbox" name="user-exp-chckbx" id="hormonalIUD" onchange="toggleRadioButtons('hormonalIUD')"> <label for="hormonalIUD">Hormonal IUD</label></td>
                <td>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDExperience" name="hormonalIUDExperience" value="good"disabled required> Good</label>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDExperience" name="hormonalIUDExperience" value="neutral"disabled required> Neutral</label>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDExperience" name="hormonalIUDExperience" value="bad"disabled required> Bad</label>
                </td>
                <td>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDConsider" name="hormonalIUDConsider" value="yes"disabled required> Yes</label>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDConsider" name="hormonalIUDConsider" value="no"disabled required> No</label>
                    <label><input type="radio" class="user-exp-radio" id="hormonalIUDConsider" name="hormonalIUDConsider" value="dontKnow" disabled required> I don't know</label>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" name="user-exp-chckbx" id="copperIUD" onchange="toggleRadioButtons('copperIUD')"> <label for="copperIUD">Copper IUD</label></td>
                <td>
                    <label><input type="radio" class="user-exp-radio" id="copperIUDExperience" name="copperIUDExperience" value="good"disabled required> Good</label>
                    <label><input type="radio" class="user-exp-radio" id="copperIUDExperience" name="copperIUDExperience" value="neutral" disabled required> Neutral</label>
                    <label><input type="radio" class="user-exp-radio" id="copperIUDExperience" name="copperIUDExperience" value="bad" disabled required> Bad</label>
                </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="copperIUDConsider" name="copperIUDConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="copperIUDConsider" name="copperIUDConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="copperIUDConsider" name="copperIUDConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="implant" onchange="toggleRadioButtons('implant')"> <label for="implant">Implant</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="implantExperience" name="implantExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="implantExperience" name="implantExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="implantExperience" name="implantExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="implantConsider" name="implantConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="implantConsider" name="implantConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="implantConsider" name="implantConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="injection"  onchange="toggleRadioButtons('injection')"> <label for="injection">Injection/DMPA</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="injectionExperience" name="injectionExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="injectionExperience" name="injectionExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="injectionExperience" name="injectionExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="injectionConsider" name="injectionConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="injectionConsider" name="injectionConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="injectionConsider" name="injectionConsider" value="dontKnow"disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="hormonalVaginalRing"  onchange="toggleRadioButtons('hormonalVaginalRing')"> <label for="hormonalVaginalRing">Hormonal Vaginal Ring</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingExperience" name="hormonalVaginalRingExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingExperience" name="hormonalVaginalRingExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingExperience" name="hormonalVaginalRingExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingConsider" name="hormonalVaginalRingConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingConsider" name="hormonalVaginalRingConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalVaginalRingConsider" name="hormonalVaginalRingConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="hormonalPatch"  onchange="toggleRadioButtons('hormonalPatch')"> <label for="hormonalPatch">Hormonal Patch</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchExperience" name="hormonalPatchExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchExperience" name="hormonalPatchExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchExperience" name="hormonalPatchExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchConsider" name="hormonalPatchConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchConsider" name="hormonalPatchConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="hormonalPatchConsider" name="hormonalPatchConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="pills" onchange="toggleRadioButtons('pills')"> <label for="pills">Pills</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="pillsExperience" name="pillsExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="pillsExperience" name="pillsExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="pillsExperience" name="pillsExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="pillsConsider" name="pillsConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="pillsConsider" name="pillsConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="pillsConsider" name="pillsConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="condom" onchange="toggleRadioButtons('condom')"> <label for="condom">Condom</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="condomExperience" name="condomExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="condomExperience" name="condomExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="condomExperience" name="condomExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="condomConsider" name="condomConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="condomConsider" name="condomConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="condomConsider" name="condomConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="diaphragm" onchange="toggleRadioButtons('diaphragm')"> <label for="diaphragm">Diaphragm</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="diaphragmExperience" name="diaphragmExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="diaphragmExperience" name="diaphragmExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="diaphragmExperience" name="diaphragmExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="diaphragmConsider" name="diaphragmConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="diaphragmConsider" name="diaphragmConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="diaphragmConsider" name="diaphragmConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="spermicide" onchange="toggleRadioButtons('spermicide')"> <label for="spermicide">Spermicide</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="spermicideExperience" name="spermicideExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="spermicideExperience" name="spermicideExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="spermicideExperience" name="spermicideExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="spermicideConsider" name="spermicideConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="spermicideConsider" name="spermicideConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="spermicideConsider" name="spermicideConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="withdrawal" onchange="toggleRadioButtons('withdrawal')"> <label for="withdrawal">Withdrawal Method</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="withdrawalExperience" name="withdrawalExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="withdrawalExperience" name="withdrawalExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="withdrawalExperience" name="withdrawalExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="withdrawalConsider" name="withdrawalConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="withdrawalConsider" name="withdrawalConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="withdrawalConsider" name="withdrawalConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="calendarMethod" onchange="toggleRadioButtons('calendarMethod')"> <label for="calendarMethod">Calendar Method</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodExperience" name="calendarMethodExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodExperience" name="calendarMethodExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodExperience" name="calendarMethodExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodConsider" name="calendarMethodConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodConsider" name="calendarMethodConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="calendarMethodConsider" name="calendarMethodConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="tempMethod" onchange="toggleRadioButtons('tempMethod')"> <label for="tempMethod">Temperature Method</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="tempMethodExperience" name="tempMethodExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="tempMethodExperience" name="tempMethodExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="tempMethodExperience" name="tempMethodExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="tempMethodConsider" name="tempMethodConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="tempMethodConsider" name="tempMethodConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="tempMethodConsider" name="tempMethodConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="emergencyContraception" onchange="toggleRadioButtons('emergencyContraception')"> <label for="emergencyContraception">Emergency Contraception</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionExperience" name="emergencyContraceptionExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionExperience" name="emergencyContraceptionExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionExperience" name="emergencyContraceptionExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionConsider" name="emergencyContraceptionConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionConsider" name="emergencyContraceptionConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="emergencyContraceptionConsider" name="emergencyContraceptionConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="vasectomy" onchange="toggleRadioButtons('vasectomy')"> <label for="vasectomy">Vasectomy</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="vasectomyExperience" name="vasectomyExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="vasectomyExperience" name="vasectomyExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="vasectomyExperience" name="vasectomyExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="vasectomyConsider1" name="vasectomyConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="vasectomyConsider2" name="vasectomyConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="vasectomyConsider3" name="vasectomyConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="tubalLigation" onchange="toggleRadioButtons('tubalLigation')"> <label for="tubalLigation">Tubal Ligation</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationExperience" name="tubalLigationExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationExperience" name="tubalLigationExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationExperience" name="tubalLigationExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationConsider" name="tubalLigationConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationConsider" name="tubalLigationConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="tubalLigationConsider" name="tubalLigationConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
        </table>
        <br>
        <input type="checkbox" id="user-experience-checkbox-none"> <label for="user-experience-checkbox-none">I have not used any of these methods</label>

    </div>
    
    <br>

    <h3>Personal Preferences</h3>
    <p>Let us know which of the following factors is for you.<span style="color: red;">*</span></p>

    <div class ="personal-preferences-container" id="personal-preferences-container">

                <span><b>Cost effectiveness</b></span>
                <br>
                <input type="radio" name="costEffectiveness" value="veryImportant"> <label>Very Important</label>
                <input type="radio" name="costEffectiveness" value="important"> <label>Important</label>
                <input type="radio" name="costEffectiveness" value="neutral"> <label>Neutral</label>
                <input type="radio" name="costEffectiveness" value="unimportant"> <label>Unimportant</label>
                <input type="radio" name="costEffectiveness" value="veryUnimportant"> <label>Very Unimportant</label>
                <br><br>
                <span><b>Helps with managing periods and side effects</b></span>
                <br>
                <input type="radio" name="managingPeriods" value="veryImportant"> <label>Very Important</label>
                <input type="radio" name="managingPeriods" value="important"> <label>Important</label>
                <input type="radio" name="managingPeriods" value="neutral"> <label>Neutral</label>
                <input type="radio" name="managingPeriods" value="unimportant"> <label>Unimportant</label>
                <input type="radio" name="managingPeriods" value="veryUnimportant"> <label>Very Unimportant</label>
                <br><br>
                <span><b>Effective at preventing pregnancy</b></span>
                <br>
                <input type="radio" name="preventingPregnancy" value="veryImportant"> <label>Very Important</label>
                <input type="radio" name="preventingPregnancy" value="important"> <label>Important</label>
                <input type="radio" name="preventingPregnancy" value="neutral"> <label>Neutral</label>
                <input type="radio" name="preventingPregnancy" value="unimportant"> <label>Unimportant</label>
                <input type="radio" name="preventingPregnancy" value="veryUnimportant"> <label>Very Unimportant</label>
                <br><br>
                <span><b>Low possibility of gaining weight</b></span>
                <br>
                <input type="radio" name="gainingWeight" value="veryImportant"> <label>Very Important</label>
                <input type="radio" name="gainingWeight" value="important"> <label>Important</label>
                <input type="radio" name="gainingWeight" value="neutral"> <label>Neutral</label>
                <input type="radio" name="gainingWeight" value="unimportant"> <label>Unimportant</label>
                <input type="radio" name="gainingWeight" value="veryUnimportant"> <label>Very Unimportant</label>
                <br><br>

    </div>

    <br>

    <h3>Medical History</h3>
    <div class ="medical-history-container" id="medical-history-container">
        <p><b>Do you have a concern about any of the following conditions? (choose all that apply)<span style="color: red;">*</span></b></p>
        <input type="checkbox" name="med-hist-chckbx" id="depression"> <label for="depression">Depression or anxiety</label><br>
        <input type="checkbox" name="med-hist-chckbx" id="acne"> <label for="acne">Acne and breakouts</label><br>
        <input type="checkbox" name="med-hist-chckbx" id="blood-clotting-disorder"> <label for="blood-clotting-disorder">Blood clotting disorder</label><br>
        <input type="checkbox" name="med-hist-chckbx" id="pcos"> <label for="pcos">Polycystic Ovary Syndrome (PCOS) or Endometriosis</label><br>
        <input type="checkbox" name="med-hist-chckbx" id="hypertension"> <label for="hypertension">Hypertension or highblood pressure</label><br>
        <input type="checkbox" name="med-hist-chckbx" id="treatment-for-sti"> <label for="treatment-for-sti">Treatment for Sexual Transmitted Infection (STIs)</label><br><br>
        <input type="checkbox"  id="none-of-the-above"> <label for="none-of-the-above"><b>None of the above</b></n></label>
        
    </div>

    <br>

    <h3>Additional Factors</h3>
    <div class ="additional-factors-container" id="additional-factors-container">
        <div class = "number-1-additional-factor" id="number-1-additional-factor">
            <p><b>1. How do you feel about the insertion of a foreign object into your vagina?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" id="very-comfortable" name="answer1">Very Comfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" id="comfortable" name="answer1">Comfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" id="neutral" name="answer1">Neutral</label><br>
            <label><input type="radio" class="additional-factors-radio" id="uncomfortable" name="answer1">Uncomfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" id="very-uncomfortable" name="answer1">Very Uncomfortable</label>
        </div>
        <br>
        <div class = "number-2-additional-factor" id="number-2-additional-factor">
            <p><b>2. At what hormone level do you feel most comfortable?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" id="no-hormones" name="answer2">No hormones</label><br>
            <label><input type="radio" class="additional-factors-radio" id="one-hormone" name="answer2">One hormone (progestin only methods)</label><br>
            <label><input type="radio" class="additional-factors-radio" id="two-hormones" name="answer2">Two hormones (progestin and estrogen methods)</label><br>
            <label><input type="radio" class="additional-factors-radio" id="dontknow" name="answer2">I don't know/ no preference</label>
        </div>
        <br>
        <div class = "number-3-additional-factor" id="number-3-additional-factor">
            <p><b>3. How often do you want to use your contraceptive method?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" id="daily" name="answer3">Daily</label><br>
            <label><input type="radio" class="additional-factors-radio" id="weekly" name="answer3">Weekly</label><br>
            <label><input type="radio" class="additional-factors-radio" id="monthly" name="answer3">Monthly</label><br>
            <label><input type="radio" class="additional-factors-radio" id="yearly" name="answer3">Yearly</label><br>
            <label><input type="radio" class="additional-factors-radio" id="dontknow2" name="answer3">I don't know/ no preference</label>
        </div>
        <br>
        <div class = "number-4-additional-factor" id="number-4-additional-factor">
        <p><b>4. Do you want to permanently stop having children?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" id="yes" name="answer4">Yes</label><br>
            <label><input type="radio" class="additional-factors-radio" id="no" name="answer4">No</label><br>
            <label><input type="radio" class="additional-factors-radio" id="dontknow3" name="answer4">I don't know/ no preference</label>
        </div>
        <br>
    </div>
    <input type="submit" value="Get Result" name="submit">
    </form>

    
    
    <br><br><br><br>

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

    <script>
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
        var radioGroups = document.querySelectorAll('input[type="radio"][name^="costEffectiveness"], input[type="radio"][name^="managingPeriods"], input[type="radio"][name^="preventingPregnancy"], input[type="radio"][name^="gainingWeight"], input[type="radio"][name^="answer1"], input[type="radio"][name^="answer2"], input[type="radio"][name^="answer3"], input[type="radio"][name^="answer4"]');
        var checkboxesMedHist = document.querySelectorAll('input[type="checkbox"][name="med-hist-chckbx"]');
        var checkboxesUserExp = document.querySelectorAll('input[type="checkbox"][name="user-exp-chckbx"]');
        var noneOfTheAboveCheckbox = document.getElementById('none-of-the-above');
        var noneOfTheAboveCheckboxUserExp = document.getElementById('user-experience-checkbox-none');

        var radioChecked = false;
            for (var i = 0; i < radioGroups.length; i++) {
                if (radioGroups[i].checked) {
                    radioChecked = true;
                    break;
                }
            }

        var medHistCheckboxChecked = false;
            for (var k = 0; k < checkboxesMedHist.length; k++) {
                if (checkboxesMedHist[k].checked) {
                    medHistCheckboxChecked = true;
                    break;
                }
            }

        var userExpCheckboxChecked = false;
            for (var l = 0; l < checkboxesUserExp.length; l++) {
                if (checkboxesUserExp[l].checked) {
                    userExpCheckboxChecked = true;
                    break;
                }
            }

            if ((!radioChecked || (!noneOfTheAboveCheckbox.checked && !medHistCheckboxChecked) || (!noneOfTheAboveCheckboxUserExp.checked && !userExpCheckboxChecked))) {
                alert('Please select an option for each question or check at least one option on the checkboxes.');
                event.preventDefault();
            } else {
                // Form validation succeeded, allow the form to submit
                // The form will automatically navigate to right_for_me_quiz_result.php
            }
        }













        //scoring logic for the quiz

        //array list of contraceptive methods
        var contraceptives = [
        { method: "hormonal_IUD", score: 0 },
        { method: "copper_IUD", score: 0 },
        { method: "the_implant", score: 0 },
        { method: "the_shot", score: 0 },
        { method: "HVR", score: 0 },
        { method: "pill", score: 0 },
        { method: "condom", score: 0 },
        { method: "diaphragm", score: 0 },
        { method: "spermicide", score: 0 },
        { method: "withdrawl_method", score: 0 },
        { method: "calendar_method", score: 0 },
        { method: "temperature_method", score: 0 },
        { method: "emergency_contraception", score: 0 },
        { method: "vasectomy", score: 0 },
        { method: "tubal_ligation", score: 0 }
        ];

        // Increment the score for a particular contraceptive method
        function incrementScore(method) {
        var contraceptive = contraceptives.find(c => c.method === method);
        if (contraceptive) {
            contraceptive.score++;
        }
        }
        

        // Example usage: Increment the score for the "pill" method
        incrementScore("pill");

        contraceptives.sort((a, b) => b.score - a.score);

        var topThree = contraceptives.slice(0, 3);

    </script>


</body>
</html>

<?php



?>
