<?php

    require("connect.php");
    require('functions.php');

    echo $_SESSION['USER']['user_id'];
?>

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
    <?php include('header.php') ?>

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
            <td><input type="checkbox" name="user-exp-chckbx" id="combinedPill" onchange="toggleRadioButtons('combinedPill')"> <label for="combinedPill">Combined Pill</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="combinedPillExperience" name="combinedPillExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="combinedPillExperience" name="combinedPillExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="combinedPillExperience" name="combinedPillExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="combinedPillConsider" name="combinedPillConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="combinedPillConsider" name="combinedPillConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="combinedPillConsider" name="combinedPillConsider" value="dontKnow" disabled required> I don't know</label>
            </td>
            </tr>
            <tr>
            <td><input type="checkbox" name="user-exp-chckbx" id="miniPill" onchange="toggleRadioButtons('miniPill')"> <label for="miniPill">Mini Pill</label></td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="miniPillExperience" name="miniPillExperience" value="good" disabled required> Good</label>
                <label><input type="radio" class="user-exp-radio" id="miniPillExperience" name="miniPillExperience" value="neutral" disabled required> Neutral</label>
                <label><input type="radio" class="user-exp-radio" id="miniPillExperience" name="miniPillExperience" value="bad" disabled required> Bad</label>
            </td>
            <td>
                <label><input type="radio" class="user-exp-radio" id="miniPillConsider" name="miniPillConsider" value="yes" disabled required> Yes</label>
                <label><input type="radio" class="user-exp-radio" id="miniPillConsider" name="miniPillConsider" value="no" disabled required> No</label>
                <label><input type="radio" class="user-exp-radio" id="miniPillConsider" name="miniPillConsider" value="dontKnow" disabled required> I don't know</label>
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
                <label><input type="radio" name="costEffectiveness" id="costEffectiveness1" value="veryImportant">Very Important</label>
                <label><input type="radio" name="costEffectiveness" id="costEffectiveness2" value="important">Important</label>
                <label><input type="radio" name="costEffectiveness" id="costEffectiveness3" value="neutral">Neutral</label>
                <label><input type="radio" name="costEffectiveness" id="costEffectiveness4" value="unimportant">Unimportant</label>
                <label><input type="radio" name="costEffectiveness" id="costEffectiveness5" value="veryUnimportant">Very Unimportant</label>
                <br><br>
                <span><b>Helps with managing periods and side effects</b></span>
                <br>
                <label><input type="radio" name="managingPeriods" id="managingPeriods1" value="veryImportant">Very Important</label>
                <label><input type="radio" name="managingPeriods" id="managingPeriods2" value="important">Important</label>
                <label><input type="radio" name="managingPeriods" id="managingPeriods3" value="neutral">Neutral</label>
                <label><input type="radio" name="managingPeriods" id="managingPeriods4" value="unimportant">Unimportant</label>
                <label><input type="radio" name="managingPeriods" id="managingPeriods5" value="veryUnimportant">Very Unimportant</label>
                <br><br>
                <span><b>Effective at preventing pregnancy</b></span>
                <br>
                <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy1" value="veryImportant">Very Important</label>
                <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy2" value="important">Important</label>
                <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy3" value="neutral">Neutral</label>
                <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy4" value="unimportant">Unimportant</label>
                <label><input type="radio" name="preventingPregnancy" id="preventingPregnancy5" value="veryUnimportant">Very Unimportant</label>
                <br><br>
                <span><b>Low possibility of gaining weight</b></span>
                <br>
                <label><input type="radio" name="gainingWeight" id="gainingWeight1" value="veryImportant">Very Important</label>
                <label><input type="radio" name="gainingWeight" id="gainingWeight2" value="important">Important</label>
                <label><input type="radio" name="gainingWeight" id="gainingWeight3" value="neutral">Neutral</label>
                <label><input type="radio" name="gainingWeight" id="gainingWeight4" value="unimportant">Unimportant</label>
                <label><input type="radio" name="gainingWeight" id="gainingWeight5" value="veryUnimportant">Very Unimportant</label>
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
            <label><input type="radio" class="additional-factors-radio" value= "veryComfortable" id="very-comfortable" name="answer1">Very Comfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" value= "comfortable" id="comfortable" name="answer1">Comfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" value= "neutral" id="neutral" name="answer1">Neutral</label><br>
            <label><input type="radio" class="additional-factors-radio" value= "uncomfortable" id="uncomfortable" name="answer1">Uncomfortable</label><br>
            <label><input type="radio" class="additional-factors-radio" value= "veryUncomfortable" id="very-uncomfortable" name="answer1">Very Uncomfortable</label>
        </div>
        <br>
        <div class = "number-2-additional-factor" id="number-2-additional-factor">
            <p><b>2. At what hormone level do you feel most comfortable?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" value="no-hormones" id="no-hormones" name="answer2">No hormones</label><br>
            <label><input type="radio" class="additional-factors-radio" value="one-hormone" id="one-hormone" name="answer2">One hormone (progestin only methods)</label><br>
            <label><input type="radio" class="additional-factors-radio" value="two-hormones" id="two-hormones" name="answer2">Two hormones (progestin and estrogen methods)</label><br>
            <label><input type="radio" class="additional-factors-radio" value="dontknow" id="dontknow" name="answer2">I don't know/ no preference</label>
        </div>
        <br>
        <div class = "number-3-additional-factor" id="number-3-additional-factor">
            <p><b>3. How often do you want to use your contraceptive method?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" value="daily" id="daily" name="answer3">Daily</label><br>
            <label><input type="radio" class="additional-factors-radio" value="weeklyl" id="weekly" name="answer3">Weekly</label><br>
            <label><input type="radio" class="additional-factors-radio" value="monthly" id="monthly" name="answer3">Monthly</label><br>
            <label><input type="radio" class="additional-factors-radio" value="yearly" id="yearly" name="answer3">Yearly</label><br>
            <label><input type="radio" class="additional-factors-radio" value="dontknow2" id="dontknow2" name="answer3">I don't know/ no preference</label>
        </div>
        <br>
        <div class = "number-4-additional-factor" id="number-4-additional-factor">
        <p><b>4. Do you want to permanently stop having children?<span style="color: red;">*</span></b></p>
            <label><input type="radio" class="additional-factors-radio" value="yes" id="yes" name="answer4">Yes</label><br>
            <label><input type="radio" class="additional-factors-radio" value="no" id="no" name="answer4">No</label><br>
            <label><input type="radio" class="additional-factors-radio" value="dontknow3" id="dontknow3" name="answer4">I don't know/ no preference</label>
        </div>
        <br>
    </div>
    <input type="hidden" name="recommendations" id="recommendations_input" value="">
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


            //---------------------------FOR SCORING NA ITONG PART NA TO---------------------------------------

            //------------------WORKING SCORING SYSTEM FOR USER EXPERIENCE------------------------
            var form = document.getElementById("quiz_form");
            var selectedMethods = [];
            var scores = {};

            // Define all contraceptive methods
            var contraceptiveMethods = [
            'hormonalIUD',
            'copperIUD',
            'implant',
            'theShot',
            'hormonalVaginalRing',
            'hormonalPatch',
            'combinedPill',
            'miniPill',
            'condom',
            'diaphragm',
            'spermicide',
            'withdrawalMethod',
            'calendarMethod',
            'temperatureMethod',
            'emergencyContraception',
            'vasectomy',
            'tubalLigation'
            ];

            // Define the current scores for each contraceptive method
            var methodScores = {};
            contraceptiveMethods.forEach(function (method) {
            methodScores[method] = 0;
            });

            // Loop through all the checkboxes to find the selected methods
            var checkboxes = form.querySelectorAll('input[type="checkbox"][name="user-exp-chckbx"]:checked');
            checkboxes.forEach(function (checkbox) {
            selectedMethods.push(checkbox.id);
            });

            // Loop through the selected methods and calculate scores based on user answers
            selectedMethods.forEach(function (method) {
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
            });

            //------------------WORKING SCORING SYSTEM FOR PERSONAL PREFERENCE-----------------------------
            // Define the methods associated with each feature
            var costEffectivenessMethods = [
            'condom',
            'combinedPill',
            'miniPill',
            'hormonalPatch',
            'hormonalVaginalRing',
            'diaphragm',
            'withdrawalMethod',
            'calendarMethod',
            'temperatureMethod',
            ];
            var preventingPregnancyMethods = [
            'combinedPill',
            'miniPill',
            'hormonalVaginalRing',
            'hormonalPatch',
            'theShot',
            'implant',
            'copperIUD',
            'hormonalIUD',
            'vasectomy',
            'tubalLigation'
            ];
            var managingPeriodsMethods = [
            'combinedPill',
            'miniPill',
            'hormonalVaginalRing',
            'implant',
            'hormonalIUD',
            'hormonalPatch',
            'theShot'
            ];
            var gainingWeightMethods = [
            'condom',
            'copperIUD'
            ];

            // Loop through all contraceptive methods and calculate scores based on user preferences
            contraceptiveMethods.forEach(function (method) {
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
                methodScores["combinedPill"] += 2;
                methodScores["hormonalPatch"] += 2;
                methodScores["hormonalVaginalRing"] += 2;
            } else if (condition === "depression") {
                delete methodScores["combinedPill"];
                delete methodScores["hormonalPatch"];
                delete methodScores["hormonalVaginalRing"];
            } else if (condition === "blood-clotting-disorder" || condition === "hypertension") {
                delete methodScores["combinedPill"];
                delete methodScores["hormonalPatch"];
                delete methodScores["hormonalVaginalRing"];
            } else if (condition === "treatment-for-sti") {
                delete methodScores["hormonalIUD"];
                delete methodScores["copperIUD"];
            }
            });



            //------------------WORKING SCORING SYSTEM CODE FOR ADDITIONAL FACTORS---------------------------

            // Define the methods associated with each question
            var foreignObjectMethods = ['hormonalIUD', 'copperIUD', 'diaphragm', 'hormonalVaginalRing'];
            var hormoneLevelMethods = ['condom', 'withdrawalMethod', 'temperatureMethod', 'calendarMethod', 'diaphragm', 'spermicide', 'vasectomy', 'tubalLigation', 'copperIUD', 'implant', 'miniPill', 'theShot', 'hormonalIUD', 'patch', 'combinedPill', 'emergencyContraception', 'hormonalVaginalRing'];
            var frequencyMethods = ['condom', 'diaphragm', 'spermicide', 'withdrawalMethod', 'calendarMethod', 'temperatureMethod', 'miniPill', 'combinedPill', 'patch', 'shot', 'implant', 'copperIUD', 'hormonalIUD'];
            var permanentMethods = ['vasectomy', 'tubalLigation'];

            // Define the relevant methods for each hormone level category
            var noHormonesMethods = ['condom', 'withdrawalMethod', 'temperatureMethod', 'calendarMethod', 'diaphragm', 'spermicide', 'vasectomy', 'tubalLigation', 'copperIUD'];
            var oneHormoneMethods = ['implant', 'miniPill', 'theShot', 'hormonalIUD'];
            var twoHormonesMethods = ['patch', 'combinedPill', 'emergencyContraception', 'hormonalVaginalRing'];

            // Get the user's answers for each question
            var answer1Value = form.elements["answer1"].value;
            var answer2Value = form.elements["answer2"].value;
            var answer3Value = form.elements["answer3"].value;
            var answer4Value = form.elements["answer4"].value;

            // Calculate scores based on user answers for each method
            contraceptiveMethods.forEach(function (method) {
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
                        return 2;
                    case "comfortable":
                        return 1;
                    case "neutral":
                        return 0;
                    case "uncomfortable":
                        return -4;
                    case "veryUncomfortable":
                        delete methodScores["copperIUD"];
                        delete methodScores["diaphragm"];
                        delete methodScores["hormonalVaginalRing"];
                        delete methodScores["hormonalIUD"];
                    case "daily":
                        return 2;
                    case "weekly":
                        return 2;
                    case "monthly":
                        return 2;
                    case "yearly":
                        return 2;
                    default:
                        return 0;
                }
            }


            
                



            //---------------PANG SORT NG TOP 3 RECOMMENDED CONTRACEPTIVE METHOD WITH CHECKING------------------------
            // Sort the method scores in descending order
            var sortedMethodScores = Object.entries(methodScores).sort(function (a, b) {
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

<?php



?>
