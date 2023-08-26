var allvideos = {

    start: (typeof start == 'undefined') ? 0 : start,
    limit: (typeof limit == 'undefined') ? 4 : limit,

    open_upload_video: function(){

        let form = document.querySelector('.js-upload-video');

        if (form.classList.contains('hide')) {
            form.classList.remove('hide');
            allvideos.display_video_to_upload();
            allvideos.load_contraceptive_list();
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
                        
                        // Reset allvideos.start and call allvideos.loadMorevideos with clearExisting set to true
                        allvideos.start = 0;
                        allvideos.loadMoreVideos(null, true);
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

    view_video_comments: function(id){
        sessionStorage.setItem('scrollPosition', window.pageYOffset);
        sessionStorage.setItem('numVideos', allvideos.start);
        window.location.href = "video.php?id="+id;
    },

    loadMoreVideos: function(callback, clearExisting = false) {
        
        let form = new FormData();
        form.append('start', allvideos.start);
        form.append('limit', allvideos.limit);
        form.append('data_type', 'load_videos');
        var ajax = new XMLHttpRequest();
    
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {

                    console.log(ajax.responseText);
                    
                    let obj = JSON.parse(ajax.responseText);
                    if (obj.success) {

                        if (!obj.hasMore) {
                            document.getElementById("loadMoreBtn").style.display = "none";
                        } else {
                            // Reset the display property of the "View More" button
                            document.getElementById("loadMoreBtn").style.display = "";
                        }

                        allvideos.displayVideos(obj.rows, clearExisting);
                        allvideos.start += obj.rows.length;
                        //console.log(allvideos.start);

                        // Call callback function
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                }
            }
        });
    
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    displayVideos: function(videos, clearExisting = false) {
        let videoContainer = document.getElementById("videoContainer");
        let videoCardTemplate = document.getElementById("videoCardTemplate");
        let loadMoreBtn = document.getElementById("loadMoreBtn");

         // Clear existing videos if clearExisting is true
        if (clearExisting) {
            videoContainer.innerHTML = "";
            videoContainer.appendChild(loadMoreBtn);
        }

        // Display message if there are no videos
        if (videos.length === 0) {
            let messageElement = document.createElement('p');
            messageElement.textContent = "No discussions found";
            videoContainer.insertBefore(messageElement, loadMoreBtn);
            return;
        }

        // Get the user's search query
        let searchQuery = document.querySelector('.js-search-videos').value;

        // Split the search query into individual words
        let searchWords = searchQuery.split(' ');

        for (var i = 0; i < videos.length; i++) {
            let videoCard = videoCardTemplate.content.cloneNode(true);

            /*if(typeof videos[i].user == 'object'){
                videoCard.querySelector(".js-image").src = videos[i].user.image;
            }*/
            videoCard.querySelector(".js-image").src = videos[i].user_img;
            videoCard.querySelector(".js-username").textContent = videos[i].user_fname;
            //videoCard.querySelector(".js-date").textContent = videos[i].date;
            //videoCard.querySelector(".js-title").textContent = videos[i].video_title;
            // Highlight matching words in the post title
            let videoTitle = videos[i].video_title;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                videoTitle = videoTitle.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }
            videoCard.querySelector(".js-video-title").innerHTML = videoTitle;
            videoCard.querySelector(".js-video-display").src = videos[i].video;
            videoCard.querySelector(".js-video-category").innerHTML = videos[i].birth_control.name;
            //videoCard.querySelector(".js-post").textContent = videos[i].forum_desc;
            // Highlight matching words in the post text WAG ISAMA
            /*let videoDesc = videos[i].forum_desc;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                videoDesc = videoDesc.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }
            videoCard.querySelector(".js-post").innerHTML = videoDesc;*/

            videoCard.querySelector(".js-video-link").setAttribute('onclick',`allvideos.view_video_comments(${videos[i].video_id})`);
            //videoCard.querySelector(".js-like-button").setAttribute('video_id', videos[i].video_id);
            //videoCard.querySelector(".js-num-likes").setAttribute('video_id', videos[i].video_id);

            //videoCard.querySelector(".js-delete-button").setAttribute('onclick',`allvideos.delete_post(${videos[i].video_id})`);
            //videoCard.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_post.show_me(${videos[i].video_id})`);
            //videoCard.querySelector(".js-edit-button").setAttribute('onclick',`allvideos.editPost(${videos[i].video_id})`);

            //counting the number of comments
            if(videos[i].view_count > 0){
                videoCard.querySelector(".js-views-count").innerHTML = `${videos[i].view_count} view${videos[i].view_count > 1 ? 's' : ''}`;
            }else{
                videoCard.querySelector(".js-views-count").innerHTML = `No views`;
            }
            
            //counting the number of likes VIEW COUNT
            /*if (videos[i].getlikes['count(*)'] == 0) {
                videoCard.querySelector(".js-views-count").innerHTML = "";
            } else {
                videoCard.querySelector(".js-views-count").innerHTML = `${videos[i].getlikes['count(*)']} view${videos[i].getlikes['count(*)'] > 1 ? 's' : ''}`;
            }*/

            //---------------------------------------------------------------------------------------
            //copying the content of videoCard
            let clone = videoCard.cloneNode(true);

            // Get root element of cloned template
            let rootElement = clone.querySelector(':first-child');

            //para mag iba iba kulay nung like button
            //red kapaga nilike na, blue kpaag hindi pa
            /*let likeButton = clone.querySelector(".js-like-button");
            like_rating.userLiked(videos[i].video_id, (function(likeButton) {
                return function(userlikes) {
                    //console.log(userlikes);
                    if (userlikes) {
                        likeButton.classList.add('btn_selected');
                    } else {
                        likeButton.classList.add('btn');
                    }
                };
            })(likeButton));*/

            //for pressing like button
            /*clone.querySelector('.js-like-button').addEventListener('click', function(event) {
                // Call the allvideos.like function and pass a reference to the clicked button element
                like_rating.like(event.target, false);
            });*/

            rootElement.setAttribute('id','video_'+videos[i].video_id);
            let row_data = JSON.stringify(videos[i]);
            row_data = row_data.replaceAll('"','\\"');
            rootElement.setAttribute('row',row_data);

            /*let action_buttons = clone.querySelector(".js-modification-buttons");
            if(!videos[i].user_owns){
                action_buttons.remove();
            }*/
			// Update the timestamp dynamically
            let timestampElement = clone.querySelector('.js-date');
            time.updateTimestamps(timestampElement, videos[i].date);

            videoContainer.insertBefore(clone, loadMoreBtn);
        }
    },

    blank: function(){

        
    },
    
    blank: function(){

        
    },
};

if (typeof all_videos_page != 'undefined') {
    // Check if number of videos is saved
    if (sessionStorage.getItem('numVideos') !== null) {
        // Calculate number of times to call loadMoreVideos
        let numCalls = Math.ceil((sessionStorage.getItem('numVideos') - allvideos.start) / allvideos.limit);
        // Define recursive function to call loadMoreVideos
        let loadMore = function(i) {
            if (i > 0) {
                allvideos.loadMoreVideos(function() {
                    loadMore(i - 1);
                });
            } else {
                // Restore scroll position
                if (sessionStorage.getItem('scrollPosition') !== null) {
                    window.scrollTo(0, sessionStorage.getItem('scrollPosition'));
                    sessionStorage.removeItem('scrollPosition');
                }
                // Remove saved number of videos
                sessionStorage.removeItem('numVideos');
            }
        };
        // Call loadMoreVideos
        loadMore(numCalls);
    } else {
        allvideos.loadMoreVideos();
    }
}