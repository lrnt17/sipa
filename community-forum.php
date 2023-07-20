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
</style>

<div>
    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-3"><p style="font-size: 3.5rem;">Community</p></div>
            <div class="col-3"><p style="font-size: 3.5rem; font-weight:bolder;" >Forum</p></div>
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
        <div class="row" style="width:15%;">
            <div class="col">
            <a href="community-topics.php" class="js-link nav-link active" ><i class="fa-regular fa-comments" style="display:inline;"></i>&nbsp; Community Topics</a>
            </div>
        </div>
        <div class="row" style="width:15%;">
            <div class="col">
                <a href="my-topics.php" class="js-link nav-link"><i class="fa-solid fa-question" style="display:inline;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Topics</a>
            </div>
            
        </div>
    </div>
    
    
</div>