<?php 
    defined('APP') or die('direct script access denied!'); 
?>

<section>

    <div>
        <table cellspacing="0" cellpadding="10" id="top_three_table" border="1">
            <thead> </thead>
            <tbody> </tbody>
        </table>
    </div>
</section>

<template id="top-three-thead-template">
    <th>
        <h3 class="js-birth-control-rank"></h3>
        <p class="js-birth-control-name"></p>
        <img src="assets/images/user.jpg" class="js-birth-control-image" width="50" height="50">
    </th>
</template>

<template id="top-three-tbody-template-column-name">
    <tr class="js-column-name-row">
        <td colspan="3" class="js-column-name" style="text-align: center;"></td>
    </tr>
</template>

<template id="top-three-tbody-template-column-data-row">
    <tr class="js-column-data-row"></tr>
</template>

<template id="top-three-tbody-template-column-data-cell">
    <td>
        <p class="js-column-data"></p>
        <div class="js-column-data-rating"></div>
        <h3 class="js-column-data-range"></h3>
    </td>
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
                                header.querySelector(".js-birth-control-rank").textContent = "#" + rank; // Set the rank
                                headerRow.appendChild(header);
                                rank++; // Increment the rank counter
                            }
                            
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
                                }

                                tbodyTable.appendChild(columnNameRow.querySelector(".js-column-name-row"));

                                let columnDataRow = document.importNode(tbodyTemplateColumnDataRow.content, true);
                                
                                for (let method_id in obj.rows) {
                                    
                                    let columnDataCell = document.importNode(tbodyTemplateColumnDataCell.content, true);
                                    columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
                                    //columnDataCell.querySelector(".js-column-data-rating").textContent = obj.rows[method_id][0].chart_data[column_name];
                                    //console.log(column_name);

                                    let ratingDiv = columnDataCell.querySelector(".js-column-data-rating");

                                    if (column_name !== "birth_control_short_desc") {
                                        
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