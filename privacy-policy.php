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
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

        /* Modal Content */
        .content-modal {
            background-color: #fefefe;
            margin: auto;
            width: 50%;
            border-radius: 40px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            padding: 4%;
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
</style>

<section id="myModal2" class="modal2">
    <!-- Modal content -->
    <div class="content-modal">
        <span class="close-privacy-policies">&times;</span>
        <p>Privacy Policies</p>

        
    </div>

</section>

<script>
    var modal = document.getElementById("myModal2");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn2");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-privacy-policies")[0];

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