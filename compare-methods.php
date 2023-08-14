<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>
    <!--<p><b>Compare</b> contraception methods</p>
    <div onclick="compare_method.show_chart()" style="cursor:pointer;">Comparison Chart</div>
    <div onclick="compare_method.show_sidebyside()" style="cursor:pointer;">Side-by-side Comparison</div>-->
    <?//php include('comparison-chart.php'); ?>
    <?//php include('comparison-sidebyside.php'); ?>
    <a href="comparison-chart.php">Comparison Chart</a>
    <a href="comparison-sidebyside.php">Side-by-side Comparison</a>
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
