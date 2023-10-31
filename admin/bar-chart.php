<?php 
    defined('APP') or die('direct script access denied!');
?>

<section>
    <br><br>
    <div>
        <h1>Registered Male and Female users of Contraceptive in <?=$facility_name ?></h1>
        <canvas id="barChart"></canvas>
    </div>
</section>

<script>

    function bar_chart() {
        
        // setup
        const barChartData = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'Female',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1
            },{
                label: 'Male',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        };

        // config
        const barChartConfig  = {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // render init block
        const barChart = new Chart(
            document.getElementById('barChart'),
            barChartConfig 
        );
    };

    //bar_chart();

    var barangay_data = {

        bar_chart: function(){
            
            let city = "<?=$city?>";
            //console.log(city);return;

            let form = new FormData();
            form.append('city_municipality', city);
            form.append('data_type', 'bar_chart');

            var ajax = new XMLHttpRequest();
            ajax.addEventListener('readystatechange', function() {
                if(ajax.readyState == 4 && ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    if(obj.success) {
                        // Assuming obj.data is an array of objects with properties 'barangay', 'male', and 'female'
                        let labels = obj.rows.map(e => e.barangay);
                        let maleData = obj.rows.map(e => e.male);
                        let femaleData = obj.rows.map(e => e.female);

                        const barChartData = {
                            labels: labels,
                            datasets: [{
                                label: 'Female',
                                data: femaleData,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgb(255, 99, 132)',
                                borderWidth: 1
                            },{
                                label: 'Male',
                                data: maleData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 1
                            }]
                        };

                        const barChartConfig = {
                            type: 'bar',
                            data: barChartData,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };

                        const barChart = new Chart(
                            document.getElementById('barChart'),
                            barChartConfig
                        );
                    }
                }
            });

            ajax.open('post', 'ajax-admin.php', true);
            ajax.send(form);
        },
    };

    barangay_data.bar_chart();
    
</script>