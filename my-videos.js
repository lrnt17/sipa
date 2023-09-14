var manage_my_videos = {

    edit_id: '',

    load_my_videos: function(){

        let form = new FormData();
        form.append('data_type', 'load_my_videos');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let data = JSON.parse(ajax.responseText);

                    let table = document.querySelector("#video_table tbody");

                    if(data.success){
                        // Get table and template elements
                        let template = document.querySelector("#row-template");

                        // Generate table rows
                        for (let i = 0; i < data.rows.length; i++) {
                            let row = document.importNode(template.content, true);
                            row.querySelector(".js-select-video").setAttribute('video_id', data.rows[i].video_id);
                            row.querySelector(".js-video-display").src = data.rows[i].video;
                            //row.querySelector(".js-admin-fullname").textContent = data.rows[i].user_fname + ' ' + data.rows[i].user_lname;
                            row.querySelector(".js-video-title").textContent = data.rows[i].video_title;
                            row.querySelector(".js-video-desc").textContent = data.rows[i].video_desc;
                            row.querySelector(".js-video-date").textContent = data.rows[i].date;
                            //row.querySelector(".js-video-views").textContent = data.rows[i].view_count;
                            if(data.rows[i].view_count > 0){
                                row.querySelector(".js-video-views").textContent = `${data.rows[i].view_count}`;
                            }else{
                                row.querySelector(".js-video-views").textContent = `0`;
                            }
                            //row.querySelector(".js-video-comments").textContent = data.rows[i].video_title;
                            if(data.rows[i].comment_count > 0){
                                row.querySelector(".js-video-comments").textContent = `${data.rows[i].comment_count}`;
                            }else{
                                row.querySelector(".js-video-comments").textContent = `0`;
                            }
                            //row.querySelector(".js-video-likes").textContent = data.rows[i].user_pnum;
                            if (data.rows[i].getlikes['count(*)'] == 0) {
                                row.querySelector(".js-video-likes").textContent = "0";
                            } else {
                                row.querySelector(".js-video-likes").textContent = `${data.rows[i].getlikes['count(*)']} `; // like${posts[i].getlikes['count(*)'] > 1 ? 's' : ''}
                            }
                            row.querySelector(".js-video-category").textContent = data.rows[i].birth_control.name;
                            row.querySelector(".js-video-edit-btn").setAttribute('onclick',`manage_my_videos.edit_my_video('${data.rows[i].video_id}')`);
                            
                            //copying the content of postCard
                            let clone = row.cloneNode(true);

                            // Get root element of cloned template
                            let rootElement = clone.querySelector(':first-child');
                            rootElement.setAttribute('id','video_'+data.rows[i].video_id);
                            let row_data = JSON.stringify(data.rows[i]);
                            row_data = row_data.replaceAll('"','\\"');
                            rootElement.setAttribute('row',row_data);

                            table.appendChild(clone);
                        }
                    } else {

                        let row = document.createElement("tr");
                        let cell = document.createElement("td");
                        cell.colSpan = 8;
                        cell.textContent = "No videos found";
                        row.appendChild(cell);
                        table.appendChild(row);
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    select_all_videos: function(source){
        let checkboxes = document.getElementsByName('all_videos[]');
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    },

    open_upload_video: function(){

        let form = document.querySelector('.js-upload-video');

        if (form.classList.contains('hide')) {
            form.classList.remove('hide');
            manage_my_videos.display_video_to_upload();
            manage_my_videos.load_contraceptive_list();
        } else {
            form.classList.add('hide');
        }
    },

    display_video_to_upload: function(){

        let fileInput = document.getElementById('video_to_upload');
        let dropZone = document.getElementById('drop_zone');
        let output = document.querySelector('.js-display-video');
        let fileName = document.getElementById('file-name');

        // Handle file input change
        fileInput.addEventListener('change', function(e) {
            /*loadFile(e.target.files[0]);
            fileName.textContent = ' ' + e.target.files[0].name;*/
            if(e.target.files.length > 0) {
                loadFile(e.target.files[0]);
                fileName.textContent = ' ' + e.target.files[0].name;
            }
        });

        // Prevent default behavior (Prevent file from being opened)
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();

            /*if(e.dataTransfer.files) {
                loadFile(e.dataTransfer.files[0]);
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = ' ' + e.dataTransfer.files[0].name;
            }*/
            if(e.dataTransfer.files.length > 0) {
                loadFile(e.dataTransfer.files[0]);
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = ' ' + e.dataTransfer.files[0].name;
            }
        });

        function loadFile(file) {
            output.src = URL.createObjectURL(file);
            output.style.display = 'block';
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    },

    upload_video: function(e){

        e.preventDefault();
        let video_title_input = document.querySelector(".js-video-title").value.trim();
        let video_desc_input = document.querySelector(".js-video-desc").value.trim();
        let anonymous = document.querySelector(".js-anonymous-video").checked;

        let select_method = document.getElementById('select_contraceptive');
        let selected_method = select_method.options[select_method.selectedIndex].value;

        let fileInput = document.getElementById('video_to_upload');
        let file = fileInput.files[0];

        let form = new FormData();

        form.append('video_title_input', video_title_input);
        form.append('video_desc_input', video_desc_input);
        form.append('selected_method', selected_method);
        form.append('anonymous', anonymous);
        form.append('user_video', file);
        form.append('data_type', 'add_video');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){

                        document.querySelector(".js-video-title").value = "";
                        document.querySelector(".js-video-desc").value = "";
                        document.getElementById("video_to_upload").value = null;
                        select_method.selectedIndex = 0;
                        document.querySelector(".js-anonymous-video").checked = false;

                        let videoElement = document.querySelector(".js-display-video");
                        videoElement.removeAttribute("src");
                        videoElement.classList.add('hide');
                        videoElement.style.display = '';
                        videoElement.load();
                        
                        // Reset manage_my_videos.start and call manage_my_videos.loadMorevideos with clearExisting set to true
                        //manage_my_videos.start = 0;
                        //manage_my_videos.loadMoreVideos(null, true);
                        let table = document.querySelector("#video_table tbody");
                        table.innerHTML = "";
                        manage_my_videos.load_my_videos();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    load_contraceptive_list: function(){

        let form = new FormData();

        form.append('data_type', 'load_all_methods');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        
                        let selectElement = document.querySelector(".js-select-contraceptive");
                        selectElement.innerHTML = "";

                        let blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "Select a Contraceptive";
                        blankOption.disabled = true;
                        blankOption.selected = true;
                        selectElement.appendChild(blankOption);

                        obj.rows.forEach(function(contraceptive) {
                            let option = document.createElement("option");
                            option.value = contraceptive.birth_control_id;
                            option.text = contraceptive.birth_control_name;
                            option.setAttribute("contraceptive-name", contraceptive.birth_control_name);
                            selectElement.appendChild(option);
                        });
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    load_contraceptive_list_for_edit: function(method_id){

        let form = new FormData();

        form.append('data_type', 'load_all_methods');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                    
                        let selectElement = document.querySelector(".js-edit-category");
                        selectElement.innerHTML = "";

                        obj.rows.forEach(function(contraceptive) {
                            let option = document.createElement("option");
                            option.value = contraceptive.birth_control_id;
                            option.text = contraceptive.birth_control_name;
                            option.setAttribute("contraceptive-name", contraceptive.birth_control_name);
                            selectElement.appendChild(option);
                        });
                        selectElement.value = method_id;
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    edit_my_video: function(id){

        document.querySelector(".js-edit-video").classList.remove('hide');
        //manage_my_videos.load_contraceptive_list_for_edit();
        manage_my_videos.edit_id = id;

        let data = document.querySelector("#video_"+id).getAttribute("row");
        data = data.replaceAll('\\"','"');
        data = JSON.parse(data);
        
        if(typeof data == 'object') {

            document.querySelector(".js-edit-title").value = data.video_title;
            document.querySelector(".js-edit-desc").value = data.video_desc;
            //document.querySelector(".js-edit-category").value = data.birth_control_id;
            manage_my_videos.load_contraceptive_list_for_edit(data.birth_control_id);

        } else {
            alert("Invalid data");
        }
    },

    save_edited_details: function(e){

        e.preventDefault();
        let edited_title = document.querySelector(".js-edit-title").value.trim();
        let edited_desc = document.querySelector(".js-edit-desc").value.trim();

        let select_method = document.getElementById('edit_category');
        let selected_method = select_method.options[select_method.selectedIndex].value;
        //console.log(edited_title, edited_desc, selected_method); return;

        let form = new FormData();

        form.append('video_id', manage_my_videos.edit_id);
        form.append('edited_title', edited_title);
        form.append('edited_desc', edited_desc);
        form.append('birth_control_id', selected_method);
        form.append('data_type', 'edit_video_details');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){

                        let table = document.querySelector("#video_table tbody");
                        table.innerHTML = "";
                        
                        let all_videos = document.getElementById("select-all-videos");
                        if (all_videos.checked) {
                            all_videos.checked = false;
                        }

                        manage_my_videos.load_my_videos();
                        manage_my_videos.hide_edit_modal();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    delete_video: function(){

        let selectedRows = document.querySelectorAll("#video_table .js-select-video:checked");
        if (selectedRows.length == 0) {
            alert("Please select at least one row to delete");
            return;
        } else if (!confirm("Are you sure you want to delete this video/s?")) {
            return;
        }

        let ids = [];
        selectedRows.forEach(function(row) {
            let id = row.getAttribute("video_id");
            ids.push(id);
        });

        //console.log(JSON.stringify(ids));return;
        
        let form = new FormData();
        form.append('ids', JSON.stringify(ids));
        form.append('data_type', 'delete_video');

        let ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if (obj.success) {

                        let table = document.querySelector("#video_table tbody");
                        table.innerHTML = "";

                        let all_videos = document.getElementById("select-all-videos");
                        if (all_videos.checked) {
                            all_videos.checked = false;
                        }
                        
                        manage_my_videos.load_my_videos();
                        manage_my_videos.hide_edit_modal();
                    }
                } else {
                    alert("Please check your internet connection");
                }
            }
        });
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    hide_edit_modal: function(){
        document.querySelector(".js-edit-video").classList.add('hide');
    },

    login_alert: function(){
        alert("You must be logged in to upload a videos");
    },
};

manage_my_videos.load_my_videos();