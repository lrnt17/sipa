<?php 
    require('../connect.php');
    require('../functions.php');
    require('fetch_user_and_partner_info.php');
    
    
    // Assuming you already have the connection set up
    $query = "SELECT IFNULL(birth_control_name, 'No method selected yet') as birth_control_name, 
                 user_sex, 
                 COUNT(*) as count 
            FROM users 
            WHERE user_role = 'user' 
            GROUP BY birth_control_name, user_sex";
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
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <title><?=$facility_name?> Administrator | SiPa</title>
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
            right:0;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }
        .printBtnContainer {
            display: none;
        }

        .topbar, .dash, .todays-appointment-section{
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

    .dashboard:hover{
        background: #D2E0F8 !important;
    }

    .select1 {

    /* styling */
    background-color: white;
    border: thin solid #B9B9B9;
    border-radius: 4px;
    display: inline-block;
    font: inherit;
    line-height: 1.5em;
    padding: 0.5em 3.5em 0.5em 1em;
    width: 23%;
    /* reset */

    margin: 0;      
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    }

    .select1.minimal {
    background-image:
        linear-gradient(45deg, transparent 50%, gray 50%),
        linear-gradient(135deg, gray 50%, transparent 50%),
        linear-gradient(to right, #ccc, #ccc);
    background-position:
        calc(100% - 20px) calc(1em + 2px),
        calc(100% - 15px) calc(1em + 2px),
        calc(100% - 2.5em) 0.5em;
    background-size:
        5px 5px,
        5px 5px,
        1px 1.5em;
    background-repeat: no-repeat;
    }

    select.minimal:focus {
    background-image:
        linear-gradient(45deg, blue 50%, transparent 50%),
        linear-gradient(135deg, transparent 50%, blue 50%),
        linear-gradient(to right, #ccc, #ccc);
    background-position:
        calc(100% - 15px) 1em,
        calc(100% - 20px) 1em,
        calc(100% - 2.5em) 0.5em;
    background-size:
        5px 5px,
        5px 5px,
        1px 1.5em;
    background-repeat: no-repeat;
    border-color: blue;
    outline: 0;
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

        <div class="container" id="buttons" style="display: flex;">
            <div class="row">
                <div class="col-auto">
                <a href="my-videos.php" style="text-decoration: none;">
                    <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                            <i class="fa-solid fa-film mb-3" style="font-size: 30px;"></i></br>
                            <span class="title">Videos</span>
                    </div>
                </a>
                </div>
                <?php if(check_admin($user_role)):?>
                    <div class="col-auto">
                        <a href="appointment-list.php" style="text-decoration: none;">
                            <div class=" py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Appointment List</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="schedule-settings.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                    <i class="fa-solid fa-calendar-day mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Schedule Settings</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto" <?php if ($currentPage === 'local-admins.php') echo 'class="active-link"';  ?>>
                        <a href="local-admins.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                    <i class="fa-solid fa-user-group mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Admin List (<?=$facility_name?>)</span>
                            </div>
                        </a>
                    </div>
                <?php endif;?>
                <?php if(check_head_admin($user_role)):?>
                    <div class="col-auto">
                        <a href="#" style="text-decoration: none;">
                            <div class=" py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Head Administrators</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="manage-admins.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                    <i class="fa-solid fa-calendar-day mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Administrators</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="partner-facilities.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                    <i class="fa-solid fa-user-group mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Partner Facilities</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="#" style="text-decoration: none;">
                            <div class=" py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Contraceptive Methods</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="contraceptive-details.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-circle-info mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Contraceptive Details</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="contraceptive-chart.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-chart-column mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Contraceptive Chart</span>
                            </div>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="contraceptive-sidebyside.php" style="text-decoration: none;">
                            <div class="py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-table-columns mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Contraceptive Side by Side</span>
                            </div>
                        </a>
                    </div>
                <?php endif;?>
            </div>

        </div>
            
        <?php include('current-date-appointments.php') ?>

        <div class ="sipa-logo-container" style="display:none;">
            <img class="rounded-circle" src="logo-colored.png" alt="SiPa" width="55" height="55" >
            <center><h5>SiPa Users' Selected Contraceptive Method Report</h5><center>
        </div>

        <div class="container">
            <!-- <div id="chartTitle" style="text-align: left; font-weight: bold;">Selected Method of Users Chart</div> -->
            <div class="row">
                <div class="row p-3 rounded-4 shadow-sm" style="background: white; align-items: center;">
                    <div class="col-auto">
                        <div class="p-3 " style="width: 600px;height: 500px;">
                                <select id="genderFilter" class="select1 minimal">
                                    <option value="All">All</option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                            </select>
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
    data.sort(function (a, b) {
        return b.count - a.count;
    });

    var ctx = document.getElementById('pieChart').getContext('2d');
    var labels = data.map(function (e) {
        return e.birth_control_name;
    });
    var count = data.map(function (e) {
        return Number(e.count);
    });

    Chart.register(ChartDataLabels);
    Chart.defaults.font.size = 14;

    // Create the initial chart
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [
                {
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
                    borderWidth: 1,
                },
            ],
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
                    display: true,
                    text: 'Users\' Selected Method Chart',
                    font: {
                        family: "'Lato', sans-serif"
                    },
                    position: 'top',
                    align: 'center',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            var total = count.reduce(function (a, b) {
                                return a + b;
                            }, 0);
                            var value = count[tooltipItem.dataIndex];
                            var percentage = ((value / total) * 100).toFixed(2);
                            return labels[tooltipItem.dataIndex] + ': ' + percentage + '%';
                        }
                    }
                },
                datalabels: {
                    display: true,
                        formatter: function (value) {
                            var total = count.reduce(function (a, b) {
                                return a + b;
                            }, 0);
                            var percentage = ((value / total) * 100).toFixed(2);
                            return percentage + '%';
                        },
                        color: 'black'
                    }
                }
            },
        });


    // Add an event listener to the gender filter dropdown
    document.getElementById("genderFilter").addEventListener("change", function () {
        var selectedGender = this.value;
        var filteredData = data.filter(function (item) {
            if (selectedGender === "All") {
                return true; // Show all data
            } else if (selectedGender === "Female" && isFemaleMethod(item.birth_control_name, item.user_sex)) {
                return true;
            } else if (selectedGender === "Male" && isMaleMethod(item.birth_control_name, item.user_sex)) {
                return true;
            }
            return false; // Hide the rest
        });

        // Update the chart data and redraw it
        updateChart(filteredData);
    });

    // Function to check if a method is female-specific and matches the user's sex
    function isFemaleMethod(method, sex) {
        var femaleMethods = ["Hormonal IUD", "Copper IUD", "Implant", "Injection", "Hormonal Vaginal Ring", "Hormonal Patch", "Mini Pill", "Combined Pill", "Spermicide", "Diaphragm", "Calendar Method", "Temperature Method", "Tubal Ligation", "No method selected yet"];
        return femaleMethods.includes(method) && sex === 'Female';
    }

    // Function to check if a method is male-specific and matches the user's sex
    function isMaleMethod(method, sex) {
        var maleMethods = ["Withdrawal Method", "Condom", "Vasectomy", "No method selected yet"];
        return maleMethods.includes(method) && sex === 'Male';
    }


        // Function to update the chart data and redraw it
function updateChart(filteredData) {
    var labels = filteredData.map(function (e) {
        return e.birth_control_name;
    });
    var count = filteredData.map(function (e) {
        return Number(e.count);
    });

    // Check if "All" is selected
    if (document.getElementById("genderFilter").value === "All") {
        var noMethodSelectedIndex = labels.indexOf("No method selected yet");

        // Check if "No method selected yet" is not present and remove it
        if (noMethodSelectedIndex === -1) {
            var noMethodSelectedIndex = labels.indexOf("No method selected yet");
            if (noMethodSelectedIndex !== -1) {
                labels.splice(noMethodSelectedIndex, 1);
                count.splice(noMethodSelectedIndex, 1);
            }
        }
    }

    chart.data.labels = labels;
    chart.data.datasets[0].data = count;
    chart.update();

    var totalUsers = count.reduce(function (a, b) {
        return a + b;
    }, 0);

    // Determine the selected gender for the result text
    var selectedGender = document.getElementById("genderFilter").value.toLowerCase();

    // Display "" if "All" is chosen
    if (selectedGender === "all") {
        selectedGender = "";
    }

    var resultTitle = '<h4>RESULT</h4>';
    var resultText = '<b>Out of ' + totalUsers + ' registered ' + selectedGender + ' users, these are the number of people who chose these methods:</b> ';
    labels.forEach(function (label, index) {
        var value = count[index];
        var percentage = ((value / totalUsers) * 100).toFixed(2);
        resultText += '<br>' + label + ': ' + value + ' (' + percentage + '%)';
    });
    document.getElementById('result').innerHTML = resultTitle + resultText;

    // Update datalabels plugin options
    chart.options.plugins.datalabels.formatter = function (value, context) {
        var dataIndex = context.dataIndex;
        var percentage = ((count[dataIndex] / totalUsers) * 100).toFixed(2);
        return percentage + '%';
    };
    chart.update();
    // Update tooltip
    chart.options.plugins.tooltip.callbacks.label = function (tooltipItem) {
        var dataIndex = tooltipItem.dataIndex;
        var value = count[dataIndex];
        var percentage = ((value / totalUsers) * 100).toFixed(2);
        return labels[dataIndex] + ': ' + value + ' (' + percentage + '%)';
    };
    chart.update();
}

// Call the updateChart function on page load
window.addEventListener('load', function () {
    // Trigger the initial chart update
    updateChart(data);
});




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