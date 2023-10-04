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

<!--<template id="top-three-thead-template">
    <th class="js-birth-control-details">
        <h2 class="js-birth-control-name"></h2>
        <img src="assets/images/user.jpg" class="js-birth-control-image" width="50" height="50">
    </th>
</template>

<template id="top-three-tbody-template">
    <tr colspan="3">
        <td class="js-column-name"></td>
    </tr>
    <tr>
        <td class="js-column-data"></td>
    </tr>
</template>-->
<template id="top-three-thead-template">
    <th>
        <h2 class="js-birth-control-name"></h2>
        <img src="assets/images/user.jpg" class="js-birth-control-image" width="50" height="50">
    </th>
</template>

<template id="top-three-tbody-template-column-name">
    <tr class="js-column-name-row">
        <td colspan="3" class="js-column-name" style="text-align: center;"></td>
    </tr>
</template>

<!--<template id="top-three-tbody-template-column-data">
    <tr class="js-column-data-row">
        <td class="js-column-data"></td>
    </tr>
</template>-->
<template id="top-three-tbody-template-column-data-row">
    <tr class="js-column-data-row"></tr>
</template>

<template id="top-three-tbody-template-column-data-cell">
    <td class="js-column-data"></td>
</template>


<script>
    //let top_three_methods = JSON.parse('<?php //echo $recommendationsJson; ?>');
    //console.log(top_three_methods);

    var top_three_dss = {

        load_top_three_results: function(){

            let top_three_methods = JSON.parse('<?php echo $top_three_method_ids; ?>');
            //console.log(top_three_methods);

            let form = new FormData();

            form.append('method_ids', JSON.stringify(top_three_methods));
            form.append('data_type', 'load_top_three_results');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        console.log(ajax.responseText);
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
                            
                            // Iterate over each method_id in obj.rows
                           /*for (let method_id in obj.rows) {
                                console.log(obj.rows[method_id].length);

                                // Generate table rows for each row of the current method_id
                                for (let i = 0; i < obj.rows[method_id].length; i++) {
                                    let row = document.importNode(theadTemplate.content, true);
                                    row.querySelector(".js-birth-control-image").src = obj.rows[method_id][i].birth_control_img;
                                    row.querySelector(".js-birth-control-name").textContent = obj.rows[method_id][i].birth_control_name;

                                    theadTable.appendChild(row);

                                    console.log(obj.rows[method_id][i].sidebyside_data);
                                    let sidebyside_data = obj.rows[method_id][i].sidebyside_data;

                                    for (let column_name in sidebyside_data) {
                                        let row = document.importNode(tbodyTemplate.content, true);
                                        row.querySelector(".js-column-name").textContent = column_name;
                                        row.querySelector(".js-column-data").textContent = sidebyside_data[column_name];
                                        tbodyTable.appendChild(row);
                                    }
                                }
                            }*/
                            
                            // Create table headers
                            let headerRow = document.createElement('tr');
                            for (let method_id in obj.rows) {
                                let header = document.importNode(theadTemplate.content, true);
                                header.querySelector(".js-birth-control-image").src = obj.rows[method_id][0].birth_control_img;
                                header.querySelector(".js-birth-control-name").textContent = obj.rows[method_id][0].birth_control_name;
                                headerRow.appendChild(header);
                            }
                            theadTable.appendChild(headerRow);

                            // Create table rows for each column of sidebyside_data
                            /*let sidebyside_data = obj.rows[Object.keys(obj.rows)[0]][0].sidebyside_data; // get sidebyside_data of the first method
                            for (let column_name in sidebyside_data) {
                                //let columnNameRow = document.importNode(tbodyTemplate.content, true);
                                let columnNameRow = document.importNode(tbodyTemplateColumnName.content, true);
                                columnNameRow.querySelector(".js-column-name").textContent = column_name;
                                tbodyTable.appendChild(columnNameRow.querySelector(".js-column-name-row"));

                                let columnDataRow = document.importNode(tbodyTemplate.content, true);
                                for (let method_id in obj.rows) {
                                    //let columnDataCell = document.importNode(tbodyTemplate.content, true);
                                    let columnDataCell = document.importNode(tbodyTemplateColumnData.content, true);
                                    columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
                                    columnDataRow.querySelector(".js-column-data-row").appendChild(columnDataCell.querySelector(".js-column-data"));
                                }
                                tbodyTable.appendChild(columnDataRow.querySelector(".js-column-data-row"));
                            }*/
                            // Create table rows for each column of sidebyside_data
                            let sidebyside_data = obj.rows[Object.keys(obj.rows)[0]][0].sidebyside_data; // get sidebyside_data of the first method
                            for (let column_name in sidebyside_data) {
                                let columnNameRow = document.importNode(tbodyTemplateColumnName.content, true);
                                columnNameRow.querySelector(".js-column-name").textContent = column_name;
                                tbodyTable.appendChild(columnNameRow.querySelector(".js-column-name-row"));

                                /*let columnDataRow = document.importNode(tbodyTemplateColumnData.content, true);
                                for (let method_id in obj.rows) {
                                    let columnDataCell = document.importNode(tbodyTemplateColumnData.content, true);
                                    columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
                                    columnDataRow.querySelector(".js-column-data-row").appendChild(columnDataCell.querySelector(".js-column-data"));
                                }
                                tbodyTable.appendChild(columnDataRow.querySelector(".js-column-data-row"));*/
                                let columnDataRow = document.importNode(tbodyTemplateColumnDataRow.content, true);
                                for (let method_id in obj.rows) {
                                    let columnDataCell = document.importNode(tbodyTemplateColumnDataCell.content, true);
                                    columnDataCell.querySelector(".js-column-data").textContent = obj.rows[method_id][0].sidebyside_data[column_name];
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