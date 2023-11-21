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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>


    <title><?=$facility_name?> Administrator | SiPa</title>
</head>
<section id="print-style-element-container"></section>
<style>
    body {
        font-family: var(--bs-body-font-family) !important;
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
    /*@media print {
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
    }*/

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
                <div class="col-auto">
                    <a href="appointment-list.php" style="text-decoration: none;">
                        <div class=" py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                            <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                <span class="title">Appointment List</span>
                        </div>
                    </a>
                </div>
                <?php if(check_admin($user_role)):?>
                    <!--<div class="col-auto">
                        <a href="appointment-list.php" style="text-decoration: none;">
                            <div class=" py-4 mt-3 rounded-4 shadow-sm dashboard" style="background: white; width: 200px;text-align: center;">
                                <i class="fa-solid fa-clipboard-list mb-3" style="font-size: 30px;"></i></br>
                                    <span class="title">Appointment List</span>
                            </div>
                        </a>
                    </div>-->

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
        
        <?php if(check_admin($user_role)):?>
        <?php include('current-date-appointments.php') ?>
        <?php endif;?>

        <div class ="sipa-logo-container" style="display:none;">
            <img class="sipa-logo" src="logo.png" alt="SiPa" width="55" height="55" >
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
                        <div class ="printBtnContainer" >
                            <button onclick="barangay_data.print_pie_chart()" class="btn px-4 my-4" style="background-color: #e9a886; color:#ffff;"> Print Result </button>
                            <button id="saveToPDFBtn" class="btn px-4 my-4" style="background-color: #e9a886; color:#ffff;"> Save to PDF </button>
                        </div>
                    </div>
                    <div id="result2" class="p-3 rounded-4 shadow-sm" style="background-color:#D2E0F8; display:none;"></div>

                    <div class="table-not-included mt-5">
                    <hr style="color: #002C5F; background-color: #002C5F; height: 2px; border: none;">
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <h4 class="mb-4" style="font-weight: 500;">SiPa Users' Selected Method Table</h4>
                                </div>
                            </div>
                        </div>
                        <?php include('tables.php') ?>
                    </div>

                    <div class="table-not-included mt-5">
                        <hr style="color: #002C5F; background-color: #002C5F; height: 2px; border: none;">
                        <?php include('bar-chart.php') ?>
                    </div>
                </div>
            </div>
            
        </div>
        <?php include('pie-chart.php') ?>

        <!--<div class="table-not-included"><?php include('bar-chart.php') ?></div>-->
    </section>
    

</body>

<script>
document.getElementById('saveToPDFBtn').addEventListener('click', function () {
    var result2 = document.getElementById('result2');
    var pdf = new jsPDF();

    // Extract data from the HTML table
    var table = result2.querySelector('table.resultTable');
    var tableRows = [];

    // Extract column headers
    var columnHeaders = [];
    for (var i = 0; i < table.rows[0].cells.length; i++) {
        columnHeaders.push(table.rows[0].cells[i].textContent.trim());
    }

    // Extract data rows
    for (var i = 1; i < table.rows.length; i++) {
        var rowData = [];
        for (var j = 0; j < table.rows[i].cells.length; j++) {
            rowData.push(table.rows[i].cells[j].textContent.trim());
        }
        tableRows.push(rowData);
    }
    var resultText1 = result2.querySelector('h5').textContent.trim();

    // Set column widths
    var columnWidths = [60, 60, 60]; // Set your desired widths

    // Set row heights
    var rowHeight = 15; // Set your desired height

    // Set border styling
    var borderStyles = { lineWidth: 0.1, lineColor: [0, 0, 0] }; // Set line width and color

    // Set left and right margin
    var marginLeft = 15;

    // Add logo to the PDF (adjust image path and dimensions)
    var logoImagePath = '<?php echo 'data:image/png;base64,' . base64_encode(file_get_contents('logo.png')); ?>';
    var logoWidth = 10;
    var logoHeight = 10;
    pdf.addImage(logoImagePath, 'PNG', marginLeft, 10, logoWidth, logoHeight);

    // Add the table title
    pdf.setFontSize(16);
    pdf.setFontStyle('bold');
    pdf.text('SiPa Users Selected Contraceptive Method Report', pdf.internal.pageSize.getWidth() / 2, 20, null, null, 'center');
    pdf.setFontStyle('normal');

    // Add resultText1
    pdf.setFontSize(11);
    pdf.text(marginLeft, 30, resultText1);

    // Add the table to the PDF
    pdf.setFontSize(12);

    // Add headers first
    for (var j = 0; j < columnHeaders.length; j++) {
        pdf.rect(marginLeft + j * columnWidths[j], 40, columnWidths[j], rowHeight, 'S');
        pdf.setFontStyle('bold'); // Set font style to bold
        pdf.text(marginLeft + j * columnWidths[j] + columnWidths[j] / 2, 48, columnHeaders[j], null, null, 'center');
        pdf.setFontStyle('normal'); // Reset font style to normal
    }

    // Add data rows
    for (var i = 0; i < tableRows.length; i++) {
        for (var j = 0; j < tableRows[i].length; j++) {
            // Add borders to each cell
            pdf.rect(marginLeft + j * columnWidths[j], (i + 1) * rowHeight + 40, columnWidths[j], rowHeight, 'S');

            // Add text inside the cell with center alignment
            pdf.text(
                marginLeft + j * columnWidths[j] + columnWidths[j] / 2,
                (i + 1) * rowHeight + 48 + rowHeight / 7, // Adjust the vertical position for centering
                tableRows[i][j],
                null,
                null,
                'center'
            );
        }
    }

    // Save or download the PDF
    pdf.save('Users-Selected-Method-Report.pdf');
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