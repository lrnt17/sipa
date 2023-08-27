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
    .nav-link {
        font-weight: normal; /* Use the default font weight */
    }

    /* Style for active anchor tags (text will be bold) */
    .nav-link.active {
        font-weight: bold;
    }
</style>

<div>
    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Community</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Forum</p></div>
        </div>
    </div>

    <div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="form" style="position: relative; top: -30px;">
                <i class="fa-solid fa-magnifying-glass"></i>
                  <input type="text" name="search" id="search"  class="js-search-input form-control form-input" placeholder="Search for topics..." style="height: 55px;
                    text-indent: 33px;
                    border-radius: 15px;">
                </div>
                
              </div>
            </div>
     </div>


    <!--<input type="text" name="search" id="search" class="js-search-input" placeholder="Search for topics" >
</br></br>-->

    <div class="container">
        <div class="row-auto">
            <div class="col-auto p-1">
                <a href="community-topics.php" class="js-link nav-link active col-2" ><i class="fa-regular fa-comments" style="display:inline;"></i>&nbsp; Community Topics</a>
            </div>
            <div class="col p-1 mb-4">
                <a href="my-topics.php" class="js-link nav-link col-2"><i class="fa-solid fa-question" style="display:inline;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Topics</a>
            </div>
        </div>
        
    </div>
    
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script>