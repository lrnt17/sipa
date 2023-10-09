<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>

<style>

    .form .fa-solid{
    position: absolute;
    top:20px;
    left: 20px;
    color: #9ca3af;


    }
    .form-input:focus{
    box-shadow: none;
    border:none;
    }
    /* Default style for anchor tags */
    .links {
        font-weight: normal; /* Use the default font weight */
    }

    /* Style for active anchor tags (text will be bold) */
    .links.active {
        font-weight: bold;
    }

    
</style>


<div>


    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Informative</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Videos</p></div>
        </div>
    </div>

    <div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="form" style="position: relative; top: -30px;">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="video_search" id="video_search" class="js-search-videos form-control form-input" placeholder="Search for videos" style="height: 55px;
                    text-indent: 33px;
                    border-radius: 15px;">
                </div>
                
              </div>
            </div>
    </div>


   


</div>

<script>
        // Wait for the document to be ready
        $(document).ready(function () {
        // Function to set the active class based on the current URL
        function setActiveLink() {
            var url = window.location.href;
            $(".js-link").each(function () {
                if (url.includes($(this).attr("href"))) {
                    $(this).addClass("active");
                } else {
                    $(this).removeClass("active");
                }
            });
        }

        // Attach click event handler to anchor tags with the class "js-link"
        $(".js-link").on("click", function () {
            // Remove the "active" class from all anchor tags
            $(".js-link").removeClass("active");
            // Add the "active" class to the clicked anchor tag
            $(this).addClass("active");
        });

        // Set the active link on page load
        setActiveLink();
    });
</script>