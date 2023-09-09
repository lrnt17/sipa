<?php 
    require("connect.php");
    require('functions.php');

    echo $_SESSION['USER']['user_id']."<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Side-by-side | SiPa</title>
</head>
<style>
    @keyframes appear {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    li, .js-options{
        animation: appear 1s ease-in-out; /* Apply the 'appear' animation with a duration of 1 second and ease-in-out timing function */
    }






    ul {
        list-style-type: none;
    }

    .clearfix:after {
        content: '';
        height: 0;
        width: 0;
    }
    /** ========================
    * Contenedor
    ============================*/
    .pricing-wrapper {
        width: 960px;
        margin: 40px auto 0;
    }

    .pricing-table {
        text-align: center;
        float: left;
        width: 300px;
    }

    .table-list li:nth-child(2n) {
        background: #F0F0F0;
    }

    .table-buy {
        background: #FFF;
        text-align: left;
        overflow: hidden;
    }


    .table-buy .pricing-action:hover {
        background: #cf4f3e;
    }

    .recommended .table-buy .pricing-action:hover {
        background: #228799;	
    }

    .js-table{
        float: left;
        border: 1px solid red;
    }

    ul {
      list-style: none;
      margin: 0;
      padding: 0;
      float:left;
    }
    li {
      border: 1px solid black;
      padding: 10px;
      width: 100px;
    }
</style>
<body>
    <section class="js-comparison-sidebyside hide">
        <?php include('compare-methods.php') ?>
        
        <div id="side_by_side">
            <div class="js-table js-column-labels">
                <ul class="js-list1">
                    
                </ul>
            </div>
            <div class="js-table js-select_1">
                
            </div>
            <div class="js-table js-select_2">

            </div>
        </div>
    </section>    
</body>
<script>
    //var secondDiv = document.querySelector('.js-select_2');
    // disable the click event on the second div element by default
    //secondDiv.style.pointerEvents = 'none';

    var compare_sidebyside = {

        secondDiv: document.querySelector('.js-select_2'),
        birth_control_id: null,
        correspondingDiv: null,

        load_column_labels: function(){

            let column_labels = document.querySelector('.js-column-labels ul');
            
            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                    
                        if(obj.success){

                            let li = document.createElement('li');
                            li.innerHTML = 'blankdiv';
                            column_labels.appendChild(li);

                            for (let column in obj.columns) {
                                let li = document.createElement('li');
                                li.textContent = obj.columns[column].replace(/_/g, ' ');
                                column_labels.appendChild(li);
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

        load_contraceptive_options_1: function(){
            
            let select_method_holder = document.querySelector('.js-select_1');

            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){

                            let div = document.createElement('div');
                            div.classList = 'js-options-title';
                            div.innerHTML = 'Select Method #1';
                            select_method_holder.appendChild(div);

                            let br = document.createElement('br');
                            select_method_holder.appendChild(br);

                            for (let i = 0; i < obj.rows.length; i++) {
                                let birthControlName = obj.rows[i].birth_control_name;
                                let div = document.createElement('div');
                                div.classList = 'js-options';
                                div.style = "cursor:pointer;";
                                div.setAttribute('onclick',`compare_sidebyside.selected_contraceptive_1('${obj.rows[i].birth_control_id}')`);
                                
                                // Create a h3 element
                                let h4 = document.createElement('h4');
                                h4.textContent = birthControlName;
                                
                                // Create an img element
                                let img = document.createElement('img');
                                img.src = obj.rows[i].birth_control_icon; // Set the source of the image
                                img.alt = obj.rows[i].birth_control_name; // Set the alt text of the image
                                // Set the width and height of the image
                                img.width = 25;
                                img.height = 25;
                                
                                // Append the img element to the div element
                                div.appendChild(img);
                                div.appendChild(h4);
                                select_method_holder.appendChild(div);
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

        load_contraceptive_options_2: function(){

            let select_method_holder = document.querySelector('.js-select_2');

            let form = new FormData();
            form.append('birth_control_id', null);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);

                        if(obj.success){

                            let div = document.createElement('div');
                            div.classList = 'js-options-title';
                            div.innerHTML = 'Select Method #2';
                            select_method_holder.appendChild(div);

                            let br = document.createElement('br');
                            select_method_holder.appendChild(br);

                            for (let i = 0; i < obj.rows.length; i++) {
                                let birthControlName = obj.rows[i].birth_control_name;
                                let div = document.createElement('div');
                                div.classList = 'js-options';
                                div.style = "cursor:pointer;";

                                // Create a h3 element
                                let h4 = document.createElement('h4');
                                h4.textContent = birthControlName;
                                
                                // Create an img element
                                let img = document.createElement('img');
                                img.src = obj.rows[i].birth_control_icon; // Set the source of the image
                                img.alt = obj.rows[i].birth_control_name; // Set the alt text of the image
                                // Set the width and height of the image
                                img.width = 25;
                                img.height = 25;
                                
                                // Append the img element to the div element
                                div.appendChild(img);
                                div.appendChild(h4);
                                div.setAttribute('onclick',`compare_sidebyside.selected_contraceptive_2('${obj.rows[i].birth_control_id}')`);
                                
                                
                                select_method_holder.appendChild(div);
                            }
                        }
                        compare_sidebyside.add_pointer_event(compare_sidebyside.birth_control_id);
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);
        },

        enable_second_div_click: function(){
            compare_sidebyside.secondDiv.style = "";
            compare_sidebyside.secondDiv.style.pointerEvents = 'auto';
        },

        disable_second_div_click: function(){
            compare_sidebyside.secondDiv.style = "";
            compare_sidebyside.secondDiv.style.pointerEvents = 'none';
        },

        selected_contraceptive_1: function(birth_control_id){
            
            compare_sidebyside.enable_second_div_click();

            // Make the corresponding div element unclickable
            compare_sidebyside.birth_control_id = birth_control_id;
            compare_sidebyside.add_pointer_event(compare_sidebyside.birth_control_id);

            let select_method_holder = document.querySelector('.js-select_1');
            select_method_holder.innerHTML = "";

            let form = new FormData();
            form.append('birth_control_id', birth_control_id);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        
                        let excludedColumns = ["sidebyside_id", "birth_control_id"];
                        let ul = document.createElement("ul");
                        ul.classList = 'js-list2';

                        if(obj.success){
                            
                            let div = document.createElement("div");
                            div.classList = 'js-close-selected1';
                            div.style = "float:right;cursor:pointer;";
                            div.setAttribute('onclick',`compare_sidebyside.close_selected_contraceptive(this)`);
                            div.innerHTML = 'X';
                            select_method_holder.appendChild(div);

                            for (let i = 0; i < obj.rows.length; i++) {
                                
                                let row = obj.rows[i];
                                let li = document.createElement('li');

                                // Create a div element
                                let div = document.createElement('div');

                                // Create a p element and set its text content to the value of birth_control_name
                                let p = document.createElement('p');
                                p.textContent = row['birth_control_name'];
                                div.appendChild(p);

                                // Create an img element and set its source to the value of birth_control_image
                                let img = document.createElement('img');
                                img.src = row['birth_control_icon'];
                                img.width = 25;
                                img.height = 25;
                                div.appendChild(img);

                                // Append the div element to the li element
                                li.appendChild(div);
                                ul.appendChild(li);

                                for (let key in row) {

                                    if (!excludedColumns.includes(key) && key !== 'birth_control_name' && key !== 'birth_control_icon') {
                                        //console.log(key);
                                        let value = row[key];

                                        let li = document.createElement('li');
                                        li.textContent = value;

                                        ul.appendChild(li);
                                    }
                                }
                            }
                            select_method_holder.appendChild(ul);
                            compare_sidebyside.list_height_adjust();

                        }
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },

        selected_contraceptive_2: function(birth_control_id){
            
            let select_method_holder = document.querySelector('.js-select_2');
            select_method_holder.innerHTML = "";

            let form = new FormData();
            form.append('birth_control_id', birth_control_id);
            form.append('data_type', 'load_sidebyside_data');

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange',function(){

                if(ajax.readyState == 4)
                {
                    if(ajax.status == 200){

                        let obj = JSON.parse(ajax.responseText);
                        
                        let excludedColumns = ["sidebyside_id", "birth_control_id"];
                        let ul = document.createElement("ul");
                        ul.classList = 'js-list3';

                        if(obj.success){
                            
                            let div = document.createElement("div");
                            div.classList = 'js-close-selected2';
                            div.style = "float:right;cursor:pointer;pointer-events: auto;";
                            div.setAttribute('onclick',`compare_sidebyside.close_selected_contraceptive(this)`);
                            div.innerHTML = 'X';
                            select_method_holder.appendChild(div);

                            for (let i = 0; i < obj.rows.length; i++) {
                                
                                let row = obj.rows[i];
                                let li = document.createElement('li');

                                // Create a div element
                                let div = document.createElement('div');

                                // Create a p element and set its text content to the value of birth_control_name
                                let p = document.createElement('p');
                                p.textContent = row['birth_control_name'];
                                div.appendChild(p);

                                // Create an img element and set its source to the value of birth_control_image
                                let img = document.createElement('img');
                                img.src = row['birth_control_icon'];
                                img.width = 25;
                                img.height = 25;
                                div.appendChild(img);

                                // Append the div element to the li element
                                li.appendChild(div);
                                ul.appendChild(li);

                                for (let key in row) {

                                    if (!excludedColumns.includes(key) && key !== 'birth_control_name' && key !== 'birth_control_icon') {
                                        
                                        let value = row[key];

                                        let li = document.createElement('li');
                                        li.textContent = value;
                                        
                                        ul.appendChild(li);
                                    }
                                }
                            }
                            select_method_holder.appendChild(ul);
                            compare_sidebyside.list_height_adjust();
                        }
                        
                    }else{
                        alert("Please check your internet connection");
                    }
                }
            });

            ajax.open('post','ajax.php', true);
            ajax.send(form);

        },

        list_height_adjust: function() {
            /*
            // Get the first and second list elements
            let list1 = document.querySelector(".js-list1");
            let list2 = document.querySelector(".js-list2");
            let list3 = document.querySelector(".js-list3");

            // Get the list items from each list
            let items1 = list1.getElementsByTagName("li");
            let items2 = list2.getElementsByTagName("li");
            let items3 = list3 ? list3.getElementsByTagName("li") : null;

            // Loop over the list items
            for (let i = 0; i < items1.length; i++) {

                // Get the current list item from each list
                let item1 = items1[i];
                let item2 = items2[i];
                let item3 = items3 ? items3[i] : null;

                // Get the computed height of each item
                let item1Height = window.getComputedStyle(item1).getPropertyValue("height");
                let item2Height = window.getComputedStyle(item2).getPropertyValue("height");
                let item3Height = item3 ? window.getComputedStyle(item3).getPropertyValue("height") : "0px";

                // Set the height of both items to the maximum height
                let maxHeight = Math.max(parseInt(item1Height), parseInt(item2Height), parseInt(item3Height));
                item1.style.height = maxHeight + "px";
                item2.style.height = maxHeight + "px";
                if (item3) {
                    item3.style.height = maxHeight + "px";
                }
            }
            */
            let list1 = document.querySelector(".js-list1");
            let list2 = document.querySelector(".js-list2");
            let list3 = document.querySelector(".js-list3");

            // Get the list items from each list
            let items1 = list1.getElementsByTagName("li");
            let items2 = list2 ? list2.getElementsByTagName("li") : null;
            let items3 = list3 ? list3.getElementsByTagName("li") : null;

            // Get the number of list items in each list
            let numItems1 = items1.length;
            let numItems2 = items2 ? items2.length : 0;
            let numItems3 = items3 ? items3.length : 0;

            // Get the maximum number of list items
            let maxNumItems = Math.max(numItems1, numItems2, numItems3);

            // Loop over the list items
            for (let i = 0; i < maxNumItems; i++) {
                // Get the current list item from each list
                let item1 = i < numItems1 ? items1[i] : null;
                let item2 = i < numItems2 ? items2[i] : null;
                let item3 = i < numItems3 ? items3[i] : null;

                // Remove the style attribute from each item
                if (item1) {
                    item1.removeAttribute("style");
                }
                if (item2) {
                    item2.removeAttribute("style");
                }
                if (item3) {
                    item3.removeAttribute("style");
                }

                // Get the computed height of each item
                let item1Height = item1 ? window.getComputedStyle(item1).getPropertyValue("height") : "0px";
                let item2Height = item2 ? window.getComputedStyle(item2).getPropertyValue("height") : "0px";
                let item3Height = item3 ? window.getComputedStyle(item3).getPropertyValue("height") : "0px";

                // Set the height of all items to the maximum height
                let maxHeight = Math.max(parseInt(item1Height), parseInt(item2Height), parseInt(item3Height));
                if (item1) {
                    item1.style.height = maxHeight + "px";
                }
                if (item2) {
                    item2.style.height = maxHeight + "px";
                }
                if (item3) {
                    item3.style.height = maxHeight + "px";
                }
            }
        },

        close_selected_contraceptive: function(clickedElement) {

            // Now you can access properties of the clickedElement to determine which div was clicked.
            if (clickedElement.className.includes('js-close-selected1')) {
                
                // This was the first div element
                document.querySelector('.js-select_1').innerHTML = "";
                compare_sidebyside.list_height_adjust();
                compare_sidebyside.remove_pointer_event(compare_sidebyside.birth_control_id);
                compare_sidebyside.disable_second_div_click();
                compare_sidebyside.load_contraceptive_options_1();
                
            } else if (clickedElement.className.includes('js-close-selected2')) {

                // This was another div element
                document.querySelector('.js-select_2').innerHTML = "";
                compare_sidebyside.list_height_adjust();
                compare_sidebyside.load_contraceptive_options_2();
            }
        },

        add_pointer_event: function(birth_control_id){
            // Find the corresponding div element in the second set
            let secondSet = document.querySelectorAll('.js-select_2 .js-options');

            compare_sidebyside.correspondingDiv = Array.from(secondSet).find(function(div) {
                return div.getAttribute('onclick').includes(`selected_contraceptive_2('${birth_control_id}')`);
            });

            if (compare_sidebyside.correspondingDiv) {
                compare_sidebyside.correspondingDiv.style.pointerEvents = 'none';
            }
        },

        remove_pointer_event: function(birth_control_id){
            // Find the corresponding div element in the second set
            let secondSet = document.querySelectorAll('.js-select_2 .js-options');

            if (secondSet.length === 0) {
                
                compare_sidebyside.birth_control_id = null;
                compare_sidebyside.correspondingDiv = null;

                return;
            } 

            compare_sidebyside.correspondingDiv = Array.from(secondSet).find(function(div) {
                return div.getAttribute('onclick').includes(`selected_contraceptive_2('${birth_control_id}')`);
            });

            if (compare_sidebyside.correspondingDiv) {
                compare_sidebyside.correspondingDiv.style.pointerEvents = '';
            }
        },
    };
    
    compare_sidebyside.load_column_labels();
    compare_sidebyside.load_contraceptive_options_1();
    compare_sidebyside.load_contraceptive_options_2();
    window.onload = function() {
        compare_sidebyside.disable_second_div_click();
    };

</script>
</html>


