<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');
    
    
    // Assuming you already have the connection set up
    $query = "SELECT IFNULL(birth_control_name, 'No method selected yet') as birth_control_name, COUNT(*) as count FROM users WHERE user_role = 'user' GROUP BY birth_control_name";
    $result = mysqli_query($conn, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <title>SiPa <?=$user_role?></title>
</head>
<style>
    body {
    font-family: "Lato", sans-serif;
    }

    /* Fixed sidenav, full height */
    .sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    padding-top: 20px;
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav a, .dropdown-btn {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 20px;
    color: #818181;
    display: block;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    outline: none;
    }

    /* On mouse-over 
    .sidenav a:hover, .dropdown-btn:hover {
    color: #f1f1f1;
    }*/



    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
    display: none;
    background-color: #262626;
    padding-left: 8px;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
    float: right;
    padding-right: 8px;
    }

    /* Some media queries for responsiveness */
    @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
    }

    /* Styles for the container */
    .container {
            padding: 20px; /* Add padding for spacing */
            display: flex; /* Use flexbox to align items horizontally */
            align-items: center; /* Center vertically */
        }

    #pieChart {
        width: 500px;
        height: 500px;
    }

    /*sa pagprint para macrop */
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
        }
        .printBtnContainer {
            display: none;
        }

        .topbar, .dash{
            display: none !important;
        }


        #buttons{
            display: none !important;
        }
    }

    .dashboard:hover{
        background: #D2E0F8 !important;
    }

</style>
<body style="background: #F2F5FF;">

<?php include('admin-header.php') ?>
    <section class="main" id="printableArea">
        <!--<h1>SiPa <?=$user_role?></h1>
        <h2><?=$user_fname?></h2>-->
        <div class="topbar" style="width:100%;">
                <div class="toggle">
                    <i class="fa-solid fa-bars"></i>
                </div>
        </div>

        <div class="container dash">
        <div class="row flex-nowrap mt-5" style="align-items: center;">
                        <div class="col-auto mt-3">
                            <div class="vl" style="width: 10px;
                            background-color: #1F6CB5;
                            border-radius: 99px;
                            height: 60px;
                            display: -webkit-inline-box;"></div>
                        </div>
                    
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <h2 style="font-weight: 600;">Dashboard</h2>
                                </div>
                            </div>
                        </div>
        </div>
        </div>

        <div class="container" id="buttons" style="display: flex; justify-content: center;">
            <div class="row mt-2">
                <div class="col-auto">
                <a href="my-videos.php" style="text-decoration: none;">
                    <div class="py-4 rounded-4 shadow-sm dashboard" style="background: white; width: 220px;text-align: center;">
                            <i class="fa-solid fa-film mb-3" style="font-size: 30px;"></i></br>
                            <span class="title">Videos</span>
                    </div>
                </a>
                </div>

                <div class="col-auto">
                    <a href="appointment-list.php" style="text-decoration: none;">
                        <div class=" py-4 rounded-4 shadow-sm dashboard" style="background: white; width: 220px;text-align: center;">
                            <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                <span class="title">Appointment List</span>
                        </div>
                    </a>
                </div>

                <div class="col-auto">
                    <a href="schedule-settings.php" style="text-decoration: none;">
                        <div class="py-4 rounded-4 shadow-sm dashboard" style="background: white; width: 220px;text-align: center;">
                                <i class="fa-solid fa-calendar-day mb-3" style="font-size: 30px;"></i></br>
                                <span class="title">Schedule Settings</span>
                        </div>
                    </a>
                </div>

                <div class="col-auto" <?php if ($currentPage === 'local-admins.php') echo 'class="active-link"';  ?>>
                    <a href="local-admins.php" style="text-decoration: none;">
                        <div class="py-4 rounded-4 shadow-sm dashboard" style="background: white; width: 220px;text-align: center;">
                                <i class="fa-solid fa-user-group mb-3" style="font-size: 30px;"></i></br>
                                <span class="title">Admin List (<?=$facility_name?>)</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
            
        <div class="container">
            <!-- <div id="chartTitle" style="text-align: left; font-weight: bold;">Selected Method of Users Chart</div> -->
            <div class="row">
                <div class="row p-3 rounded-4 shadow-sm" style="background: white; align-items: center;">
                    <div class="col-auto">
                        <div class="p-3 " style="width: 400px;height: 400px;">
                            <canvas id="pieChart"><!-- Your canvas for the pie chart --></canvas>
                        </div>
                    </div>
                    <div class="col">
                        <div id="result" class="p-3 rounded-4 shadow-sm" style="background-color:#D2E0F8;"></div>
                        <div class ="printBtnContainer" ><button onclick="window.print()" class="btn px-5 my-3" style="background-color: #F2C1A7; color:#ffff;"> Print Result </button></div>

                    </div>
                </div>
            </div>
            
        </div>
    </section>
    

</body>

<script type="text/javascript">
    
    // Parse PHP array to JavaScript array
    var data = <?php echo json_encode($data); ?>;

    // Sort the data by count in descending order
    data.sort(function(a, b) {
        return b.count - a.count;
    });

    var ctx = document.getElementById('pieChart').getContext('2d');
    var labels = data.map(function(e) {
    return e.birth_control_name;
    });
    var count = data.map(function(e) {
    return Number(e.count);
    });

Chart.register(ChartDataLabels);
Chart.defaults.font.size = 14;

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            label: 'Demographics',
            data: count,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)', //pwede ibahin ng hex code colors, 17 to kasi 17 yung method 
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 64, 0.2)',
                'rgba(255, 159, 132, 0.2)',
                'rgba(54, 162, 86, 0.2)',
                'rgba(75, 192, 255, 0.2)',
                'rgba(153, 102, 86, 0.2)',
                'rgba(255, 206, 132, 0.2)',
                'rgba(75, 192, 64, 0.2)',
                'rgba(153, 102, 235, 0.2)',
                'rgba(54, 162, 192, 0.2)',
                'rgba(255,99 ,206 ,0.2)',
                'rgba(75 ,192 ,235 ,0.2)'
            ],
            borderColor: [
                'rgba(255 ,99 ,132 ,1)',
                'rgba(54 ,162 ,235 ,1)',
                'rgba(255 ,206 ,86 ,1)',
                'rgba(75 ,192 ,192 ,1)',
                'rgba(153 ,102 ,255 ,1)',
                'rgba(255 ,159 ,64 ,1)',
                'rgba(255 ,99 ,64 ,1)',
                'rgba(255 ,159 ,132 ,1)',
                'rgba(54 ,162 ,86 ,1)',
                'rgba(75 ,192 ,255 ,1)',
                'rgba(153 ,102 ,86 ,1)',
                'rgba(255 ,206 ,132 ,1)',
                'rgba(75 ,192 ,64 ,1)',
                'rgba(153 ,102 ,235 ,1)',
                'rgba(54 ,162 ,192 ,1)',
                'rgba(255 ,99 ,206 ,1)',
                'rgba(75 ,192 ,235 ,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                align: 'center',
                font: {
                    family: "'Lato', sans-serif"
                }
            },
            title: {
                display: true, //comment mo nalang to mika, buong title simula display gang align, tas paayos nalang nung div id na 'chartTitle' na nakacomment pa
                text: 'Users\' Selected Method Chart', //comment mo nalang to mika tas paayos nalang nung div id na 'chartTitle' na nakacomment pa
                font: {
                    family: "'Lato', sans-serif"
                },
                position: 'top',
                align:'center',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        var total = count.reduce(function(a, b) { return a + b;}, 0);
                        var value = count[tooltipItem.dataIndex];
                        var percentage = ((value / total) * 100).toFixed(2);
                        return labels[tooltipItem.dataIndex] + ': ' + percentage + '%';
                    }
                }
            },
            datalabels: {
                display: true,
                formatter: function(value) {
                    var total = count.reduce(function(a,b){ return a + b; },0);
                    var percentage = ((value / total) *100).toFixed(2);
                    return percentage + '%';
                },
                color: 'black'
                
            }
        }
    },
});


    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    };

    var totalUsers = count.reduce(function(a, b) { return a + b;}, 0);
    var resultTitle = '<h4>RESULT</h4>';
    var resultText = '<b>Out of ' + totalUsers + ' registered users, these are the number of people who chose these methods:</b> ';
    labels.forEach(function(label, index) {
        var value = count[index];
        resultText += '<br>' + label + ': ' + value;
    });
    document.getElementById('result').innerHTML = resultTitle + resultText;


</script>


</html>

<script>
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main");

    toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    };
</script>