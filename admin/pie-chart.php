<?php 
    defined('APP') or die('direct script access denied!');
?>

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

    //hide to lilitaw lang pag print
    var resultText1 = '<h5>This table shows the summary of method, number of users, and percentage from ' + totalUsers + ' registered ' + selectedGender + ' users\nof SiPa Website. </h5>';
    var resultTitle2 = '<h4>RESULT</h4>';
    var resultText2 = 'Out of ' + totalUsers + ' registered ' + selectedGender + ' users, these are the number of people who chose these methods: ';

    resultText2 += '<table class="resultTable">';
    resultText2 += '<tr>';
    resultText2 += '<th>Contraceptive Method</th>';
    resultText2 += '<th>Number of Users</th>';
    resultText2 += '<th>Percentage</th>';
    resultText2 += '</tr>';

    labels.forEach(function (label, index) {
        var value = count[index];
        var percentage = ((value / totalUsers) * 100).toFixed(2);

        resultText2 += '<tr>';
        resultText2 += '<td>' + label + '</td>';
        resultText2 += '<td>' + value + '</td>';
        resultText2 += '<td>' + percentage + '%</td>';
        resultText2 += '</tr>';
    });

    resultText2 += '</table>';

    document.getElementById('result2').innerHTML = resultTitle2 + resultText2 + resultText1;





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
