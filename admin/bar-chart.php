<?php 
    defined('APP') or die('direct script access denied!');
?>

<section id="bar-chart-printable-area">
    <div>
        <h4 class="bar-chart-data-title mt-2 mb-3">Registerd Contraceptive Clients of (<?=$facility_name ?>) per Barangay</h4>

        <div class ="sipa-logo-container-bar-chart" style="display:none;">
            <img class="sipa-logo" src="logo.png" alt="SiPa" width="55" height="55" >
            <center><h5><?=$facility_name ?> Contraceptive Clients per Barangay</h5><center>
        </div>

        <canvas id="barChart"></canvas>
        <div class ="printBtnContainer-bar-chart">
            <button onclick="barangay_data.print_bar_chart()" class="btn px-5 my-3" style="background-color: #e9a886; color:#ffff;"> Print Result </button>
        </div>
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

        print_bar_chart: function(){
            barangay_data.add_BarChart_PrintStyles();

            // Create a new style element
            let style = document.createElement('style');

            // Add a CSS rule to set the page size to landscape when printing
            style.textContent = '@media print { @page { size: landscape; } }';

            // Append the style element to the head of the document
            document.head.appendChild(style);

            window.print();

            // Remove the style element after printing
            document.head.removeChild(style);

            barangay_data.removePrintStyles();
        },

        print_pie_chart: function(){
            barangay_data.add_PieChart_PrintStyles();
            window.print();
            barangay_data.removePrintStyles();
        },

        add_PieChart_PrintStyles: function(){
            // Create a new style element
            let style = document.createElement('style');

            // Add CSS rules to the style element
            style.textContent = `
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    #printableArea, #printableArea * {
                        visibility: visible;
                    }
                    #printableArea {
                        position: absolute;
                        left: 0;
                        top: 0;
                        right:0;
                        width: 100%;
                        height: 100%;
                        justify-content: center;
                        align-items: center;
                    }
                    .printBtnContainer {
                        display: none;
                    }
                    .topbar, .dash, .todays-appointment-section, .table-not-included{
                        display: none !important;
                    }
                    .sipa-logo-container{
                        display: block !important;
                    }
                    #buttons, #genderFilter{
                        display: none !important;
                    }
                    #current-date-appointment
                    {
                        display: none !important;
                    }
                }
            `;

            // Append the style element to the head of the document
            //document.head.appendChild(style);
            // Get the div element
            let section = document.getElementById('print-style-element-container');

            // Append the style element to the div
            section.appendChild(style);
        },

        add_BarChart_PrintStyles: function(){
            // Create a new style element
            var style = document.createElement('style');

            // Add CSS rules to the style element
            style.textContent = `
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    #bar-chart-printable-area, #bar-chart-printable-area * {
                        visibility: visible;
                    }
                    #bar-chart-printable-area {
                        position: absolute;
                        left: 0;
                        top: 0;
                        right:0;
                        width: 100%;
                        height: 100%;
                        justify-content: center;
                        align-items: center;
                    }
                    .printBtnContainer-bar-chart {
                        display: none;
                    }
                    .bar-chart-data-title {
                        display: none;
                    }
                    .sipa-logo-container-bar-chart{
                        display: block !important;
                    }
                    /*.topbar, .dash, .todays-appointment-section, .table-not-included{
                        display: none !important;
                    }
                    #buttons, #genderFilter{
                        display: none !important;
                    }
                    #current-date-appointment
                    {
                        display: none !important;
                    }*/
                }
            `;

            // Append the style element to the head of the document
            //document.head.appendChild(style);
            // Get the div element
            let section = document.getElementById('print-style-element-container');

            // Append the style element to the div
            section.appendChild(style);
        },

        removePrintStyles: function(){
            // Get the style elements
            /*var styles = document.getElementsByTagName('style');

            // Loop through the style elements
            for (var i = styles.length - 1; i >= 0; i--) {
                var style = styles[i];
                
                // Remove the style element if it contains the print styles
                if (style.textContent.includes('@media print')) {
                    style.parentNode.removeChild(style);
                }
            }*/
            // Get the div element
            let section = document.getElementById('print-style-element-container');

            // Remove the last child (the style element)
            section.removeChild(section.lastChild);
        },
    };

    barangay_data.bar_chart();
    
</script>