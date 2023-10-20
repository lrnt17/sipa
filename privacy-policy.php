<?php 
    defined('APP') or die('direct script access denied!');
?>

<style>
    .cbox{
        width:auto;
    }

    .modal2 {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 80px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* The close-privacy-policies Button */
    .close-privacy-policies {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

        .close-privacy-policies:hover,
        .close-privacy-policies:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
.content-modal {
    background-color: #fefefe;
    margin: auto;
    width: 60%;
    max-height: 80vh;
    overflow-y: auto;
    border-radius: 40px;
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    padding: 4%;
    padding-right: 4%;
    position: relative; /* Ensure the close button is positioned relative to this div */
    overflow-y: auto;
}

@media (max-width: 768px) {
    .content-modal{
        width:90%;
    }
}

p {
    white-space: initial;
}
</style>

<section id="myModal2" class="modal2">
    <!-- Modal content -->
    <div class="content-modal">
        <span class="close-privacy-policies">&times;</span>
        <div class="scrollable-content">
        <h2>Privacy Policy for [SiPa]</h2>
        <p>Last Updated: [9/23/2023]</p>

        <h3>1. Introduction</h3>
        <p>Welcome to SiPa (Siguradong Pagpapaplano). We are committed to protecting your <br>
        privacy and ensuring the security of your personal information. This Privacy Policy  <br>
        outlines the types of information we collect, how we use it, and how we safeguard your  <br>
        data when you visit our Website.</p>


        <h3>2. Information We Collect</h3>
        <p>2.1. Personal Information: We may collect personal information that you voluntarily  <br>
        provide to us when you use our Website. This may include your name, email address,  <br>
        contact number, and any other information you choose to share with us.</p>
        
        <h3>3. Privacy Policy</h3>
        <p>Please review our Privacy Policy to understand how we collect, use, and protect your  <br>
        personal information when you use this Website. By using the Website, you agree to the  <br>
        terms outlined in the Privacy Policy.</p>
        
        <h3>4. User Conduct</h3>
        <p>a. You agree to use the Website in compliance with all applicable laws and regulations.</p>
        <p>b. You will not engage in any illegal, harmful, or abusive conduct on the Website.</p>
        <p>c. You will not attempt to gain unauthorized access to the Website or any <br>
            related systems.</p>
        
        <h3>5. Intellectual Property</h3>
        <p>a. All content and materials on this Website, including text, graphics, logos, and images, <br>
        are the property of the Company and are protected by intellectual property laws.</p> 
        <p>b. You may not reproduce, distribute, or modify any content from this Website without <br>
        prior written consent from the Company.</p>
        
        <h3>6. Third-Party Links</h3>
        <p>This Website may contain links to third-party websites. These links are provided for <br>
            convenience only, and the Company does not endorse or take responsibility for the <br>
            content or practices of these third-party websites.</p>
        
        <h3>7. Disclaimer of Warranties</h3>
        <p>a. This Website is provided "as is," without any warranties, express or implied, including <br>
        but not limited to the accuracy, reliability, or availability of the content.</p>
        <p>b. The Company disclaims all liability for any errors, omissions, or inaccuracies in the <br>
        content or for any loss or damage resulting from the use of this Website.</p>
        
        <h3>8. Limitation of Liability</h3>
        <p>The Company and its affiliates shall not be liable for any direct, indirect, incidental, <br>
            consequential, or punitive damages arising from your use or inability to use this Website.</p>
        
        <h3>9. Changes to Terms</h3>
        <p>The Company reserves the right to modify these Terms at any time. It is your  <br>
        responsibility to review these Terms periodically for updates. Your continued use of the  <br>
        Website after any modifications signifies your acceptance of the revised Terms.</p>

        <p>By using our Website, you consent to the terms outlined in this Privacy Policy.</p>
    </div>
</section>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("myModal2");
    var btn = document.getElementById("myBtn2");
    var policy = document.getElementById("policy");
    var span = document.getElementsByClassName("close-privacy-policies")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
    modal.style.display = "block";
    }

    policy.onclick = function() {
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
});
</script>