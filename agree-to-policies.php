<?php 
    defined('APP') or die('direct script access denied!');
?>

<style>
    .cbox{
        width:auto;
    }
</style>

<section id="myModal" class="modal">
    <!-- Modal content -->
    <div class="content-modal">
        <span class="close-policies" style="cursor: pointer;">&times;</span>
        <p>Some text in the Modal..</p>

        <form onsubmit="login.agree_to_policies(event)" method="post" >
            <div class="terms_conditions" style="margin: 8px 0px 8px 0px;">
                <input type="checkbox" class="cbox" name="terms_conditions" id="terms_conditions" value="I agree" required>
                <label for="terms_conditions" style="position: unset;
                font-size: 16px;
                color: #575757;
                margin-bottom: 0px; 
                font-weight: 400;">I accept the <b>Terms and Conditions</b></label>
            </div>
            <div class="privacy_policy" style="margin: 8px 0px 8px 0px;">
                <input type="checkbox" class="cbox" name="privacy_policy" id="privacy_policy" value="I agree" required>
                <label for="privacy_policy" style="position: unset;
                font-size: 16px;
                color: #575757;
                margin-bottom: 0px; 
                font-weight: 400;">I agree to <b>Privacy Policy</b></label>
            </div>

            <div class="" style="display: flex; justify-content: flex-end;">
                <button class="" style="
                display: block;
                width: 20%;
                padding: 10px;
                text-align: center;
                border: none;
                background: #F2C1A7;
                outline: none;
                border-radius: 10px;
                font-size: 1.4rem;
                color: #FFF;
                cursor: pointer;
                ">
                    Continue
                </button>
            </div>
        </form>
    </div>

</section>

<script>
    var policies_conditions = document.getElementById("myModal");
    console.log(policies_conditions);
    // Get the button that opens the modal
    //var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var close_policies = document.querySelector(".close-policies");
    console.log(close_policies);
    // When the user clicks the button, open the modal 
    /*btn.onclick = function() {
    modal.style.display = "block";
    }*/

    // When the user clicks on <span> (x), close the modal
    close_policies.onclick = function() {
        console.log(close_policies);
        policies_conditions.style.display = "none";
    }
</script>