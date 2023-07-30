<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<div class="js-registration-modal hide">
    <h1>Patient Screening Form</h1>
    <form>
        <h2>Personal Information:</h2><!-- Personal Information -->
        <label>Full name:</label>
        <input type="text" name="full_name" required><br>

        <label>Date of birth:</label>
        <input type="date" name="date_of_birth" required><br>

        <label>Phone number:</label>
        <input type="tel" name="phone_number"><br>

        <label>Email address:</label>
        <input type="email" name="email_address"><br>
    
        <h2>Reproductive History:</h2><!-- Reproductive History -->
        <label>Age at menarche (first menstrual period):</label>
        <input type="number" name="age_at_menarche"><br>

        <label>Regularity of menstrual cycles:</label><br>
        <input type="radio" name="menstrual_regularity" value="Regular">Regular<br>
        <input type="radio" name="menstrual_regularity" value="Irregular">Irregular<br>
        <input type="radio" name="menstrual_regularity" value="Unsure">Unsure<br>

        <label>Number of pregnancies:</label>
        <input type="number" name="number_of_pregnancies"><br>

        <label>Number of childbirths:</label>
        <input type="number" name="number_of_childbirths"><br>

        <label>Pregnancy outcomes:</label><br>
        <label>Live births:</label>
        <input type="number" name="live_births"><br>

        <label>Miscarriages:</label>
        <input type="number" name="miscarriages"><br>

        <label>Abortions:</label>
        <input type="number" name="abortions"><br>

        <label>Previous contraceptive methods used (if any):</label><br>
        <input type="text" name="contraceptive_method_1"><br>
        <input type="text" name="contraceptive_method_2"><br>
        <input type="text" name="contraceptive_method_3"><br>
        <input type="radio" name="contraceptive_method_none" value="None">None<br>
    
        <h2>Medical History:</h2><!-- Medical History -->
        <label>Any chronic or pre-existing medical conditions:</label><br>
        <input type="text" name="medical_condition_1"><br>
        <input type="text" name="medical_condition_2"><br>
        <input type="text" name="medical_condition_3"><br>
        <input type="radio" name="medical_condition_none" value="None">None<br>

        <label>Other (please specify):</label>
        <input type="text" name="other_medical_condition"><br>

        <label>Allergies to medications or contraceptive ingredients:</label><br>
        <input type="radio" name="allergies_to_medications" value="Yes">Yes
        <input type="radio" name="allergies_to_medications" value="No">No<br>

        <label>If yes, please specify:</label>
        <input type="text" name="allergies_specify"><br>

        <label>History of blood clotting disorders:</label><br>
        <input type="radio" name="blood_clotting_disorders" value="Yes">Yes
        <input type="radio" name="blood_clotting_disorders" value="No">No<br>

        <label>Any history of sexually transmitted infections (STIs):</label><br>
        <input type="radio" name="sexually_transmitted_infections" value="Yes">Yes
        <input type="radio" name="sexually_transmitted_infections" value="No">No<br>
    
        <h2>Current Medications:</h2><!-- Current Medications -->
        <label>List of medications the patient is currently taking, including over-the-counter drugs and supplements:</label><br>
        <textarea name="current_medications" rows="4" cols="50"></textarea><br>
    
        <h2>Lifestyle and Habits:</h2><!-- Lifestyle and Habits -->
        <label>Smoking habits:</label>
        <input type="radio" name="smoking_habits" value="Never">Never
        <input type="radio" name="smoking_habits" value="Occasionally">Occasionally
        <input type="radio" name="smoking_habits" value="Regularly">Regularly
        <input type="radio" name="smoking_habits" value="Quit">Quit
        <input type="radio" name="smoking_habits" value="Never Smoked">Never Smoked<br>

        <label>Alcohol consumption:</label>
        <input type="radio" name="alcohol_consumption" value="Never">Never
        <input type="radio" name="alcohol_consumption" value="Occasionally">Occasionally
        <input type="radio" name="alcohol_consumption" value="Regularly">Regularly
        <input type="radio" name="alcohol_consumption" value="Quit">Quit
        <input type="radio" name="alcohol_consumption" value="Never Consumed">Never Consumed<br>

        <label>Physical activity level:</label>
        <input type="radio" name="physical_activity_level" value="Sedentary">Sedentary
        <input type="radio" name="physical_activity_level" value="Light activity">Light activity
        <input type="radio" name="physical_activity_level" value="Moderate activity">Moderate activity
        <input type="radio" name="physical_activity_level" value="Vigorous activity">Vigorous activity<br>
    
        <h2>Family Planning Goals:</h2><!-- Family Planning Goals -->
        <label>Desire for future pregnancies:</label>
        <input type="radio" name="future_pregnancies" value="Planning to conceive soon">Planning to conceive soon
        <input type="radio" name="future_pregnancies" value="Not planning to conceive">Not planning to conceive
        <input type="radio" name="future_pregnancies" value="Unsure">Unsure<br>
    
        <h2>Contraceptive Preferences:</h2><!-- Contraceptive Preferences -->
        <label>Preferences for hormonal or non-hormonal methods:</label>
        <input type="radio" name="hormonal_or_non-hormonal" value="Hormonal methods">Hormonal methods
        <input type="radio" name="hormonal_or_non-hormonal" value="Non-hormonal methods">Non-hormonal methods
        <input type="radio" name="hormonal_or_non-hormonal" value="No preference">No preference<br>

        <label>Desire for long-term or temporary contraceptive methods:</label>
        <input type="radio" name="long-term_or_temporary" value="Long-term methods">Long-term methods
        <input type="radio" name="long-term_or_temporary" value="Temporary methods">Temporary methods
        <input type="radio" name="long-term_or_temporary" value="No preference">No preference<br>

        <label>Acceptance of potential side effects:</label>
        <input type="radio" name="acceptance_of_side_effects" value="Very Accepting">Very Accepting
        <input type="radio" name="acceptance_of_side_effects" value="Accepting">Accepting
        <input type="radio" name="acceptance_of_side_effects" value="Neutral">Neutral
        <input type="radio" name="acceptance_of_side_effects" value="Not Accepting">Not Accepting
        <input type="radio" name="acceptance_of_side_effects" value="Very Not Accepting">Very Not Accepting<br>
        
        <h2>Physical Examination (if applicable):</h2><!-- Physical Examination -->
        <label>If certain contraceptive methods require a physical examination or if the patient has specific health concerns, the doctor can include relevant physical examination information here:</label><br>
        <textarea name="physical_examination" rows="4" cols="50"></textarea><br>
    </form>
</div>