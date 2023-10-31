<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<style>
    table{
        border:none;
    }

    .lines{
    width: 95%;
    height: 28px;
    position: relative;
    left: 28px;
    }

    .lines::after, .lines::before{
        content: '';
        position: absolute;
        height: 2.5px;
        margin: auto;
        background: #1F6CB5;
        width: 42%;
        top: 45%;
    }

    .lines::after{
        left: 0;
    }

    .lines::before{
        right: 0;
    }
    .table-con {
  width: 100%; /* Set the width of the container as needed */
  overflow-x: auto; /* Enable horizontal scrolling */
}

table {
  width: 100%; /* Make the table fill the container width */
  /* Additional styling for your table if needed */
}
</style>
<section>

    <div class="container table-con">
        <table cellspacing="0" cellpadding="10" id="top_three_table" border="0" class="p-2 rounded-4 shadow-sm"style="background-color:white;">
            <thead> </thead>
            <tbody> </tbody>
        </table>
    </div>
</section>

<template id="top-three-thead-template">
    <th>
    <div style="text-align: center; position: relative;" class="container mb-4 mt-3">
        <h3 class="js-birth-control-rank" style="display: inline-block; vertical-align: middle; position: absolute; margin-left: 28px; margin-top: 21px;">1</h3>
        <i class="fa-solid fa-award" style="font-size: 100px; display: inline-block; vertical-align: middle;"></i>
    </div>
        <div class="container rounded-4 justify-content-center shadow-sm" style="text-align: center; background: white; width: 300px; max-height: 200px; position: relative; overflow: hidden; padding: 0;">
            <img src="assets/images/user.jpg" class="js-birth-control-image" style="width: 100%; height: auto; object-fit: cover;" >
        </div>
        <center><p class="js-birth-control-name mt-4" style="font-weight: 500;"></p></center>
    </th>
</template>

<template id="top-three-tbody-template-column-name">
    <tr class="js-column-name-row">
        <td colspan="3" style="text-align: center;">
            <div class="lines ">
               <h5 class="js-column-name" style="font-weight:500;"></h5>
            </div>
        </td>
    </tr>
</template>

<template id="top-three-tbody-template-column-data-row">
    <tr class="js-column-data-row"></tr>
</template>

<template id="top-three-tbody-template-column-data-cell">
    <td class="p-5" style="vertical-align: top;">
        <p class="js-column-data"></p>
        <div class="row" style="align-items:center;">
            <div class="col-auto">
                <div class="js-column-data-rating"></div>
            </div>
            <div class="col-1 mt-3">
                <p>
                    &mdash;
                </p>
            </div>
            <div class="col-auto">
                <h6 class="js-column-data-range" style="margin: 0;"></h6>
            </div>
        </div>
    </td>
</template>

<template class="js-rrl-template" id="rrl-template">
    <div class="js-rrl-item pb-4">
        <p class="js-rrl-title" style="margin-bottom:0px; font-weight:600;">Literature 1</p>
        <p class="js-rrl-content" style="margin-bottom:0px; display:inline;">Content of literature 2...</p>
        <a class="js-rrl-link" href="#" target="_blank" style="text-decoration:none;"></a>
    </div>
</template>

<script>

    var top_three_dss = {

        load_top_three_results: function(){

            let top_three_methods = JSON.parse('<?php echo $top_three_method_ids; ?>');
            console.log(top_three_methods);

            let form = new FormData();

            form.append('method_ids', JSON.stringify(top_three_methods));
            form.append('data_type', 'load_top_three_results');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        //console.log(ajax.responseText);
                        let obj = JSON.parse(ajax.responseText);
                        
                        if(obj.success){

                            // Get table and template elements
                            let theadTable = document.querySelector("#top_three_table thead");
                            let theadTemplate = document.querySelector("#top-three-thead-template");

                            let tbodyTable = document.querySelector("#top_three_table tbody");
                            //let tbodyTemplate = document.querySelector("#top-three-tbody-template");
                            let tbodyTemplateColumnName = document.querySelector("#top-three-tbody-template-column-name");
                            //let tbodyTemplateColumnData = document.querySelector("#top-three-tbody-template-column-data");
                            let tbodyTemplateColumnDataRow = document.querySelector("#top-three-tbody-template-column-data-row");
                            let tbodyTemplateColumnDataCell = document.querySelector("#top-three-tbody-template-column-data-cell");
                            
                            // Create table headers
                            let headerRow = document.createElement('tr');

                            let rank = 1; // Initialize rank counter

                            for (let method_id in obj.rows) {
                                
                                let header = document.importNode(theadTemplate.content, true);
                                header.querySelector(".js-birth-control-image").src = obj.rows[method_id][0].birth_control_img;
                                header.querySelector(".js-birth-control-name").textContent = obj.rows[method_id][0].birth_control_name;
                                header.querySelector(".js-birth-control-rank").textContent = "" + rank; // Set the rank

                                // Set the color of the <i> tag based on rank
                                let iconElement = header.querySelector(".fa-award");
                                if (rank === 1) {
                                    iconElement.style.color = "#ffd700"; // Change color for rank 1
                                } else if (rank === 2) {
                                    iconElement.style.color = "#929292"; // Change color for rank 2
                                } else if (rank === 3) {
                                    iconElement.style.color = "#CD7F32"; // Change color for rank 3
                                }
                                
                                headerRow.appendChild(header);
                                rank++; // Increment the rank counter
                            }
                            
                            document.querySelector(".js-num-of-rank-methods").innerHTML = rank - 1;

                            theadTable.appendChild(headerRow);

                            // Create table rows for each column of sidebyside_data
                            let sidebyside_data = obj.rows[Object.keys(obj.rows)[0]][0].sidebyside_data; // get sidebyside_data of the first method
                            
                            for (let column_name in sidebyside_data) {
                                
                                let columnNameRow = document.importNode(tbodyTemplateColumnName.content, true);
                                //columnNameRow.querySelector(".js-column-name").textContent = column_name;
                                let formattedColumnName = column_name.replace(/_/g, ' '); // replace underscore with space
                                formattedColumnName = formattedColumnName.charAt(0).toUpperCase() + formattedColumnName.slice(1); // uppercase the first letter

                                //columnNameRow.querySelector(".js-column-name").textContent = formattedColumnName;
                                // Only set the text content if column_name is not "Birth control short desc"
                                if (formattedColumnName !== "Birth control short desc") {
                                    columnNameRow.querySelector(".js-column-name").textContent = formattedColumnName;
                                } else {
                                    columnNameRow.querySelector(".js-column-name").textContent = "Description";
                                }

                                tbodyTable.appendChild(columnNameRow.querySelector(".js-column-name-row"));

                                let columnDataRow = document.importNode(tbodyTemplateColumnDataRow.content, true);
                                
                                for (let method_id in obj.rows) {
                                    
                                    let columnDataCell = document.importNode(tbodyTemplateColumnDataCell.content, true);
                                    //columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
                                    if (column_name !== "references") {
                                        columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
                                    } 
                                    //columnDataCell.querySelector(".js-column-data-rating").textContent = obj.rows[method_id][0].chart_data[column_name];
                                    //console.log(column_name);

                                    let ratingDiv = columnDataCell.querySelector(".js-column-data-rating");

                                    if (column_name !== "birth_control_short_desc" && column_name !== "references") {
                                        
                                        // Create the star elements
                                        for (let j = 0; j < 3; j++) {
                                            let starSpan = document.createElement("span");
                                            starSpan.classList.add("star");

                                            let starIcon = document.createElement("i");
                                            starIcon.classList.add("fas", "fa-star");

                                            // Fill up stars based on the value
                                            if (j < +obj.rows[method_id][0].chart_data[column_name]) {
                                                starSpan.classList.add("active");
                                            }

                                            starSpan.appendChild(starIcon);
                                            ratingDiv.appendChild(starSpan);
                                        }

                                        let rangeDiv = columnDataCell.querySelector(".js-column-data-range");
                                        // Set the text for the rating text column
                                        switch (+obj.rows[method_id][0].chart_data[column_name]) {
                                            case 0:
                                                rangeDiv.textContent = "Bad";
                                                break;
                                            case 1:
                                                rangeDiv.textContent = "Good";
                                                break;
                                            case 2:
                                                rangeDiv.textContent = "Better";
                                                break;
                                            case 3:
                                                rangeDiv.textContent = "Best";
                                                break;
                                        }
                                    } else if (column_name === "references") {
                                        // Output the data of the rll table based on your template here
                                        let rrlTemplate = document.getElementById("rrl-template");
                                        let references = obj.rows[method_id][0].sidebyside_data[column_name];
                                        //console.log(references);
                                        for (let i = 0; i < references.length; i++) {
                                            let rrlItem = document.importNode(rrlTemplate.content, true);
                                            rrlItem.querySelector(".js-rrl-title").textContent = references[i].rrl_title;
                                            rrlItem.querySelector(".js-rrl-content").textContent = references[i].rrl_desc;
                                            rrlItem.querySelector(".js-rrl-link").href = references[i].rrl_link;
                                            rrlItem.querySelector(".js-rrl-link").innerHTML = "<i class='fa-solid fa-arrow-up-right-from-square' style='font-size: 12px;'></i>";
                                            
                                            columnDataCell.querySelector(".js-column-data").appendChild(rrlItem);
                                        }
                                    }

                                    columnDataRow.querySelector(".js-column-data-row").appendChild(columnDataCell);
                                }
                                
                                tbodyTable.appendChild(columnDataRow.querySelector(".js-column-data-row"));
                            }
                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },
    };

    top_three_dss.load_top_three_results();
</script>