<?php 
    defined('APP') or die('direct script access denied!');
?>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <style>
        body{
            font-family: "Lato", sans-serif;
            font-size: 16px;
            margin: 0;
            background: #fff;
            color: #000;
        }
        .table-container {
        width: 100%;
        }
        #table {
        margin: 0 auto; /* Center the table horizontally */
        }
        table.dataTable {
        margin: 20px 0 !important;
        }

         /* Change the PDF button color */
        .dt-buttons .buttons-pdf {
            font-family: "Lato", sans-serif !important;
            background-color: #e9a886 !important; /* Change to your desired background color */
            color: white !important; /* Change to your desired text color */
            padding: 10px 40px!important; /* Adjust padding as needed */
            border-radius: 10px !important;
            border:none !important;
        }

        table.dataTable tbody tr{
            border-bottom: 1px solid black;
            height: 75px !important;
        }

        thead, tbody, tfoot, tr, td, th {
            border-style: outset ;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <table id="table" class="table nowrap pt-4" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Selected Method</th>
                    <th style="text-align: center;">Barangay</th>
                    <th style="text-align: center;">Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Perform a query to fetch data from the 'users' table
                $query = "SELECT CONCAT(user_fname, ' ', user_lname) AS name, IFNULL(birth_control_name, 'No method selected yet') as birth_control_name, user_barangay, user_pnum FROM users WHERE user_role = 'user'";
               $result = mysqli_query($conn, $query);

                // Check if the query was successful
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='padding-top: 2.5%;'>" . $row['name'] . "</td>";
                        echo "<td style='padding-top: 2.5%;'>" . $row['birth_control_name'] . "</td>";
                        echo "<td style='padding-top: 2.5%;'>" . $row['user_barangay'] . "</td>";
                        echo "<td style='padding-top: 2.5%;'>" . $row['user_pnum'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        filename: 'bustos_users_selected_method_report', // Set the PDF filename
                        title: 'SiPa Users\' Selected Contraception Method Report',
                        messageTop: 'Bustos RHU',
                        customize: function(doc) {
                        // Convert the image to a data URL
                        var image = '<?php echo 'data:image/png;base64,' . base64_encode(file_get_contents('logo.png')); ?>';

                        // Add the logo to the PDF
                        doc.content.splice(0, 0, {
                            image: image,
                            width: 35,
                            alignment: 'left'
                        });
                        // Adjust the table styles for the PDF
                        doc.styles.table = {
                            margin: [0, 20, 0, 0], // Left, Top, Right, Bottom
                            fontSize: 12,
                            cellPadding: 10,
                        };
                        // Adjust the messageTop alignment to be left-aligned
                        //yung number sa loob ng .content[n] ay depende dun sa pagkakasunod sunod, so 0 kapag sa header, 1 sa title, 2 sa messageTop, 3 sa table okidoks?
                        doc.content[2].alignment = 'left';

                        doc.defaultStyle.alignment = 'center'; // Center align the content

                        // Adjust the table header styles
                        doc.content[3].table.widths = ['*', '*', '*', '*'];
                        doc.content[3].table.body[0][0].alignment = 'center';

                        // Center align all table cell content
                        for (var i = 2; i < doc.content[3].table.body.length; i++) {
                            for (var j = 0; j < doc.content[3].table.body[i].length; j++) {
                                doc.content[3].table.body[i][j].alignment = 'center';
                            }
                        }
                        // Add a footer with date and time, "Bustos RHU," and the user's full name
                        var now = new Date();
                        var formattedDate = now.toLocaleString();
                        var userFullName = '<?= $_SESSION['USER']['user_fname'] . ' ' . $_SESSION['USER']['user_lname']?>';

                        // Concatenate formattedDate and userFullName
                        var dateTimeAndName = formattedDate + '  - ' + userFullName;

                        doc.footer = function(page, pages) {
                            return {
                                columns: [
                                    {
                                    text: dateTimeAndName, // Concatenated date and name
                                    alignment: 'left',
                                    margin: [10, 0]
                                    },
                                    {
                                        text: 'Page ' + page.toString() + ' of ' + pages.toString(),
                                        alignment: 'right',
                                        margin: [0, 0, 10, 0]
                                    }
                                ]
                            };
                        };

                    }
                }
            ]
        });
    });
</script>