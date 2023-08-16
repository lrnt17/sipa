var allvideos = {

    open_upload_video: function(){

        let form = document.querySelector('.js-upload-video');

        if (form.classList.contains('hide')) {
            form.classList.remove('hide');
        } else {
            form.classList.add('hide');
        }
    },

    display_video_to_upload: function(){

        let fileInput = document.getElementById('video_to_upload');
        let dropZone = document.getElementById('drop_zone');
        let output = document.querySelector('.js-display-video');

        // Handle file input change
        fileInput.addEventListener('change', function(e) {
            loadFile(e.target.files[0]);
        });

        // Prevent default behavior (Prevent file from being opened)
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if(e.dataTransfer.files) {
            loadFile(e.dataTransfer.files[0]);
            fileInput.files = e.dataTransfer.files;
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

        let select_method = document.getElementById('select_contraceptive');
        let selected_method = select_method.options[select_method.selectedIndex].value;

        let fileInput = document.getElementById('video_to_upload');
        let file = fileInput.files[0];

        let form = new FormData();

        form.append('video_title_input', video_title_input);
        form.append('video_desc_input', video_desc_input);
        form.append('selected_method', selected_method);
        form.append('user_video', file);
        form.append('data_type', 'add_video');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){

                        /*let table = document.querySelector("#admin_table tbody");
                        table.innerHTML = "";
                        
                        manage_admins.load_admins();
                        manage_admins.hide();*/
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax-admin.php', true);
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
                        
                        let selectElement = document.getElementById("select_contraceptive");
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

    blank: function(){

        
    },

    blank: function(){

        
    },

    blank: function(){

        
    },
};

allvideos.display_video_to_upload();
allvideos.load_contraceptive_list();