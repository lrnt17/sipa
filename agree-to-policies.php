<?php 
    defined('APP') or die('direct script access denied!');
?>

<section id="myModal" class="modal">
    <!-- Modal content -->
    <div class="content-modal">
        <span class="close-policies">&times;</span>
        <p>Some text in the Modal..</p>

        <form onsubmit="login.agree_to_policies(event)" method="post">
            <div class="terms_conditions">
                <label for="terms_conditions">I accept the <b>Terms and Conditions</b></label>
                <input type="checkbox" name="terms_conditions" id="terms_conditions" value="I agree" required>
            </div>
            <div class="privacy_policy">
                <label for="privacy_policy">I agree to <b>Privacy Policy</b></label>
                <input type="checkbox" name="privacy_policy" id="privacy_policy" value="I agree" required>
            </div>

            <div class="">
                <button class="">
                    Continue
                </button>
            </div>
        </form>
    </div>

</section>

<script>
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-policies")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
    modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }
</script>