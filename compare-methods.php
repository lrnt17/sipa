<?php 
    defined('APP') or die('direct script access denied!'); 

    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<style>
        .label {
        text-decoration: none;
        color: black;
        font-weight: 400;
    }

    .col-custom {
        display: flex;
        justify-content: center;
        align-items: center;
        background: transparent;
    }

    .col-custom.active {
        background-color: #D2E0F8; /* Set your desired background color here */
    }

    .col-custom.active a {
        font-weight: bold; /* Make the text bold for the active link */
    }
</style>


<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col py-4 rounded-top-4 col-custom <?php echo ($currentPage == 'comparison-chart.php') ? 'active' : ''; ?>" id="chartDiv" style="cursor:pointer;">
                <a href="comparison-chart.php" class="label">Comparison Chart</a>
            </div>
            <div class="col py-4 rounded-top-4 col-custom <?php echo ($currentPage == 'comparison-sidebyside.php') ? 'active' : ''; ?>" id="sidebysideDiv" style="cursor:pointer;">
                <a href="comparison-sidebyside.php" class="label">Side-by-side Comparison</a>
            </div>
        </div>
    </div>
    <!--<p><b>Compare</b> contraception methods</p>
    <div onclick="compare_method.show_chart()" style="cursor:pointer;">Comparison Chart</div>
    <div onclick="compare_method.show_sidebyside()" style="cursor:pointer;">Side-by-side Comparison</div>-->
    <?//php include('comparison-chart.php'); ?>
    <?//php include('comparison-sidebyside.php'); ?>


    <!-- cinomment ko lang [dalawang a tag]-->
    <!--<a href="comparison-chart.php">Comparison Chart</a>
    <a href="comparison-sidebyside.php">Side-by-side Comparison</a>-->
</section>

<!--<script>
    var compare_method = {

        show_chart: function(){
            document.querySelector('.js-comparison-chart').classList.remove('hide');
            document.querySelector('.js-comparison-sidebyside').classList.add('hide');
        },

        show_sidebyside: function(){
            document.querySelector('.js-comparison-sidebyside').classList.remove('hide');
            document.querySelector('.js-comparison-chart').classList.add('hide');
        },
    };
</script>-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to the clickable divs
        const chartDiv = document.getElementById("chartDiv");
        const sidebysideDiv = document.getElementById("sidebysideDiv");

        // Add click event listeners to the divs
        chartDiv.addEventListener("click", function () {
            // Redirect to the link when the div is clicked
            window.location.href = chartDiv.querySelector("a").getAttribute("href");
        });

        sidebysideDiv.addEventListener("click", function () {
            // Redirect to the link when the div is clicked
            window.location.href = sidebysideDiv.querySelector("a").getAttribute("href");
        });
    });
</script>
