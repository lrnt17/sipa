<?php 
    defined('APP') or die('direct script access denied!');
?>

<style>
    .cbox{
        width:auto;
    }
    .modal3 {
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

        .content-modal3 {
    background-color: #fefefe;
    margin: auto;
    width: 60%; /* Reduce the width of the modal */
    max-height: 80vh; /* Set maximum height for the modal */
    overflow-y: auto; /* Enable vertical scrollbar if content exceeds the height */
    border-radius: 40px;
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    padding: 4%;
    padding-right: 4%; /* Add padding to the right side */
    overflow-y: auto;
        }

    .close-terms-con {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-terms-con:hover,
    .close-terms-con:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

        /* The close-terms-con Button */
        .close-terms-con {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close-terms-con:hover,
        .close-terms-con:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }
</style>

<section id="myModal3" class="modal3">
    <!-- Modal content -->
    <div class="content-modal3">
        <span class="close-terms-con">&times;</span>
        <div class="scrollable-content">
        <h2> <p>Terms and Conditions for SiPa</p> </h2>

       <p> Effective Date: [September 23, 2023] </p>

       <p>These terms and conditions govern your use of SiPa (Siguradong Pagpapaplano).<br>
By accessing or using the Website, you agree to abide by these Terms. If you do not <br>
agree with these Terms, please refrain from using the Website.</p>

<h3>1. Information Disclaimer</h3>

<p>The content provided on this Website is for informational purposes only and should not <br>
be considered as medical advice. It is not a substitute for professional medical  <br>
consultation.  Consult with a qualified healthcare provider before making any decisions <br>
related to contraception or sexual health.</p> 

<h3>2. User Age Requirement</h3>

<p>Users must be at least 18 years old to access and use this Website. By using the <br>
Website, you confirm that you meet this age requirement.</p> 

<h3>3. Privacy Policy</h3>

<p>Please review our Privacy Policy to understand how we collect, use, and protect your <br>
   personal information when you use this Website. By using the Website, you agree to the <br>
   terms outlined in the Privacy Policy.</p> 

<h3>4. User Conduct</h3>

<p>a. You agree to use the Website in compliance with all applicable laws and regulations.</p>
<p>b. You will not engage in any illegal, harmful, or abusive conduct on the Website.</p>
<p>c. You will not attempt to gain unauthorized access to the Website or any <br> 
related systems. </p> 

<h3>5. Intellectual Property</h3>

<p>a. All content and materials on this Website, including text, graphics, logos, and images,<br>
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

<p>The Company and its affiliates shall not be liable for any direct, indirect, <br>
incidental, consequential, or punitive damages arising from your use or inability to use <br>
this Website. </p> 

<h3>9. Changes to Terms</h3>

<p>The Company reserves the right to modify these Terms at any time. It is your <br>
responsibility to review these Terms periodically for updates. Your continued use of the  <br>
Website after any modifications signifies your acceptance of the revised Terms.</p> 

<h3>10. Termination</h3>

<p>The Company may terminate or suspend your access to the Website without notice  <br>
if you violate these Terms or engage in any conduct that the Company deems harmful <br>
or inappropriate.</p> 

<h3>11. Governing Law</h3>

<p>These Terms are governed by the laws of Philippines. Any disputes arising from  <br>
or related to these Terms shall be subject to the exclusive jurisdiction of the courts </br>
in Philippines. </p> 

<p>By using this Website, you acknowledge that you have read, understood, and agreed to  <br>
these Terms and the Privacy Policy. If you have any questions or concerns, <br>
please contact us at +63 912 345 6789.</p> 

<p>Please consult with a legal professional to ensure that these terms and conditions are  <br>
appropriate for your specific website and jurisdiction.</p>

    </div>

</section>

<script>
    var modal3 = document.getElementById("myModal3");
    var btn = document.getElementById("myBtn3");
    var span = document.getElementsByClassName("close-terms-con")[0];


    // Get the button that opens the modal
    var btn = document.getElementById("myBtn3");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-terms-con")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
    modal3.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal3.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal3.style.display = "none";
    }
    }
</script>
    </div>

</section>

<script>
    var modal3 = document.getElementById("myModal3");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn3");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-terms-con")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
    modal3.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal3.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal3.style.display = "none";
    }
    }
</script>