var myposts = {

    start: (typeof start == 'undefined') ? 0 : start,
    limit: (typeof limit == 'undefined') ? 5 : limit,
    my_topics: (typeof mytopics == 'undefined') ? null : mytopics,
    numDeleted: 0, // variable to keep track of the number of deleted posts

    submit: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-post-input").value.trim();
        let title = document.getElementById("post_title").value;
        let anonymous = document.querySelector(".js-anonymous").checked;
        //console.log(anonymous);
        if(text == "" && title == ""){
            alert("Please type something");
            return;
        }

        let form = new FormData(); //new form within javascript

        form.append('post', text);
        form.append('post_title', title);
        form.append('anonymous', anonymous);
        form.append('data_type', 'add_post');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        document.querySelector(".js-search-my-input").value = "";
                        document.querySelector(".js-post-input").value = "";
                        document.getElementById("post_title").value = "";
                        document.querySelector(".js-anonymous").checked = false;
                        
                        let icon = document.querySelector('.js-toggle-icon');
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                        document.querySelector('.js-start-topic').classList.add('hide');
                        // Reset myposts.start and call myposts.loadMorePosts with clearExisting set to true
                        myposts.start = 0;
                        myposts.loadMorePosts(null, true);
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    view_comments: function(id){
        sessionStorage.setItem('scrollPosition', window.pageYOffset);
        sessionStorage.setItem('numPosts', myposts.start);
        window.location.href = "post.php?id="+id;
    },

    delete_post: function(forum_id) {
        if (!confirm("Are you sure you want to delete this post?")) {
            //alert(forum_id);
            return;
        }
        
        let form = new FormData(); //new form within javascript
        //let comment_part = false;
        console.log(forum_id);
        form.append('id', forum_id);
        //form.append('comment_part', comment_part);
        form.append('data_type', 'delete_post');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){

                        // Find and remove the post element from the page
                        //let postElement = document.querySelector(`#post_${forum_id}`);
                        //postElement.parentNode.removeChild(postElement);
                        window.location.reload();
                        //myposts.numDeleted++; // increment the number of deleted 

                        // check if there are any search results stored in sessionStorage
                        /*let storedSearchResults = sessionStorage.getItem('searchResults');
                        if (storedSearchResults) {
                            console.log(storedSearchResults);
                            // deletion is happening in the search results
                            let searchResults = JSON.parse(storedSearchResults);
                            // remove the deleted post from the search results
                            searchResults = searchResults.filter(function(post) {
                                let forum_id_int = parseInt(forum_id);
                                let forum_id_string = forum_id_int.toString();
                                return post.forum_id !== forum_id_string;
                            });
                            // update the search results stored in sessionStorage
                            sessionStorage.setItem('searchResults', JSON.stringify(searchResults));
                            // display the updated search results
                            myposts.displayPosts(searchResults, true);
                            // check if there are no more search results and display the "No posts found" message
                            if (searchResults.length === 0) {
                                let postContainer = document.getElementById("postContainer");
                                let loadMoreBtn = document.getElementById("loadMoreBtn");
                                postContainer.innerHTML = '<p>No posts found</p>';
                                loadMoreBtn.style.display = "none";
                                postContainer.appendChild(loadMoreBtn);
                            }
                        } else {
                            // deletion is happening in the normal page itself without searching
                            myposts.numDeleted++; // increment the number of deleted posts
                        }*/
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    new_topic: function(){
        
        // Get reference to the form element
        var form = document.querySelector('.js-start-topic');

        var icon = document.querySelector('.js-toggle-icon');

        if (form.classList.contains('hide')) {
            form.classList.remove('hide');

            // Update the icon to minus when the form is visible
            if (icon) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        } else {
            form.classList.add('hide');

            // Update the icon to plus when the form is hidden
        if (icon) {
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        }
             
        }
    },

    loadMorePosts: function(callback, clearExisting = false) {
        
        let form = new FormData();
        //form.append('start', myposts.start - myposts.numDeleted); // adjust the start value to take into account any deleted posts
        //form.append('start', Math.max(0, myposts.start - myposts.numDeleted));
        form.append('start', myposts.start);
        form.append('limit', myposts.limit);
        form.append('data_type', 'load_my_posts');
        var ajax = new XMLHttpRequest();
    
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    if (obj.success) {

                        if (!obj.hasMore) {
                            document.getElementById("loadMoreBtn").style.display = "none";
                        } else {
                            // Reset the display property of the "View More" button
                            document.getElementById("loadMoreBtn").style.display = "";
                        }

                        myposts.displayPosts(obj.rows, clearExisting);
                        myposts.start += obj.rows.length;

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

    displayPosts: function(posts, clearExisting = false) {
        let postContainer = document.getElementById("postContainer");
        let postCardTemplate = document.getElementById("postCardTemplate");
        let loadMoreBtn = document.getElementById("loadMoreBtn");

         // Clear existing posts if clearExisting is true
        if (clearExisting) {
            postContainer.innerHTML = "";
            postContainer.appendChild(loadMoreBtn);
        }

        // Display message if there are no posts
        if (typeof posts === 'undefined') {
            let messageElement = document.createElement('p');
            messageElement.textContent = "No discussions found";
            messageElement.style.textAlign="center";
            postContainer.insertBefore(messageElement, loadMoreBtn);
            return;
        }

        // Get the user's search query
        let searchQuery = document.querySelector('.js-search-my-input').value;

        // Split the search query into individual words
        let searchWords = searchQuery.split(' ');

        for (var i = 0; i < posts.length; i++) {
            /*let post = posts[i];
            // check if a post with the same forum_id as the current post already exists in the list of displayed posts
            let existingPostElement = document.querySelector(`#post_${post.forum_id}`);
            if (existingPostElement) {
                // update the existing post element with the new data
               //existingPostElement.innerHTML = createPostHtml(post);
               existingPostElement.remove();
            } //else {*/
            let postCard = postCardTemplate.content.cloneNode(true);

            /*if(typeof posts[i].user == 'object'){
                postCard.querySelector(".js-image").src = posts[i].user.image;
            }*/
            //postCard.querySelector(".js-image").src = posts[i].user_img;
            if(typeof posts[i].user == 'object'){
                postCard.querySelector(".js-image").src = posts[i].user.image;
            }

            //postCard.querySelector(".js-username").textContent = posts[i].user_fname;
            postCard.querySelector(".js-username").textContent = (typeof posts[i].user == 'object') ? posts[i].user.name : 'User';
            //postCard.querySelector(".js-date").textContent = posts[i].date;
            //postCard.querySelector(".js-title").textContent = posts[i].forum_title;
            // Highlight matching words in the post title
            let postTitle = posts[i].forum_title;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                postTitle = postTitle.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }
            postCard.querySelector(".js-title").innerHTML = postTitle;
            //postCard.querySelector(".js-post").textContent = posts[i].forum_desc;
            // Highlight matching words in the post text
            /*let postText = posts[i].forum_desc;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                postText = postText.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }

            // Create a temporary div element
            let tempDiv = document.createElement('div');
            // Set its innerHTML to the post text
            tempDiv.innerHTML = postText;
            // Get the decoded text
            let decodedText = tempDiv.textContent || tempDiv.innerText || "";

            postCard.querySelector(".js-post").innerHTML = decodedText;*/
            // Create a temporary div element
            let tempDiv = document.createElement('div');
            // Set its innerHTML to the post text
            tempDiv.innerHTML = posts[i].forum_desc;
            // Get the decoded text
            let postText = tempDiv.textContent || tempDiv.innerText || "";

            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                postText = postText.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }

            postCard.querySelector(".js-post").innerHTML = postText;

            postCard.querySelector(".js-comment-link").setAttribute('onclick',`myposts.view_comments(${posts[i].forum_id})`);
            postCard.querySelector(".js-like-button").setAttribute('forum_id', posts[i].forum_id);
            postCard.querySelector(".js-num-likes").setAttribute('forum_id', posts[i].forum_id);

            postCard.querySelector(".js-delete-button").setAttribute('onclick',`myposts.delete_post(${posts[i].forum_id})`);
            //postCard.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_post.show_me(${posts[i].forum_id})`);
            postCard.querySelector(".js-edit-button").setAttribute('onclick',`myposts.editPost(${posts[i].forum_id})`);

            //counting the number of comments
            if(posts[i].comment_count > 0){
                postCard.querySelector(".js-comment-link").innerHTML = ` <i class="fa-solid fa-comments"></i> &nbsp;  ${posts[i].comment_count} +`;
            }else{
                postCard.querySelector(".js-comment-link").innerHTML = `<i class="fa-solid fa-comments"></i>`;
            }
            
            //counting the number of likes
            if (posts[i].getlikes['count(*)'] == 0) {
                postCard.querySelector(".js-num-likes").innerHTML = "";
            } else {
                postCard.querySelector(".js-num-likes").innerHTML = `${posts[i].getlikes['count(*)']} `; // like${posts[i].getlikes['count(*)'] > 1 ? 's' : ''}
            }

            //---------------------------------------------------------------------------------------
            //copying the content of postCard
            let clone = postCard.cloneNode(true);

            // Get root element of cloned template
            let rootElement = clone.querySelector(':first-child');

            //para mag iba iba kulay nung like button
            //red kapaga nilike na, blue kpaag hindi pa
            let likeButton = clone.querySelector(".js-like-button");
            like_rating.userLiked(posts[i].forum_id, (function(likeButton) {
                return function(userlikes) {
                    //console.log(userlikes);
                    if (userlikes) {
                        likeButton.classList.add('btn_selected');
                    } else {
                        likeButton.classList.add('btn');
                    }
                };
            })(likeButton));

            //for pressing like button
            clone.querySelector('.js-like-button').addEventListener('click', function(event) {
                // Call the myposts.like function and pass a reference to the clicked button element
                like_rating.like(event.target, false);
            });

            rootElement.setAttribute('id','post_'+posts[i].forum_id);
            let row_data = JSON.stringify(posts[i]);
            row_data = row_data.replaceAll('"','\\"');
            rootElement.setAttribute('row',row_data);

            let action_buttons = clone.querySelector(".js-modification-buttons");
            if(!posts[i].user_owns){
                action_buttons.remove();
            }
            // Update the timestamp dynamically
            let timestampElement = clone.querySelector('.js-date');
            time.updateTimestamps(timestampElement, posts[i].date);

            postContainer.insertBefore(clone, loadMoreBtn);
            //}
        }
    },

    editPost: function(forum_id) {
        // Find the post element using the forum_id
        let postWrapper = document.querySelector(`#post_${forum_id}`);
        
        // Get the title and content elements of the post
        let replytitleElement = postWrapper.querySelector('.js-title');
        let replyElement = postWrapper.querySelector('.js-post');

        // Get the current text of the title and content elements
        let replyTitleText = replytitleElement.textContent;
        let replyText = replyElement.textContent;
        
        // Create new input elements for the title and content
        let editTitleInput = document.createElement('input');
        editTitleInput.type = 'text';
        editTitleInput.classList.add('form-control', 'fs-3'); // Add Bootstrap class 'form-control' for styling
        editTitleInput.classList.add('js-title');
        editTitleInput.value = replyTitleText;

        // Custom style
        editTitleInput.style.borderBottom = '1px light gray'; 
        editTitleInput.style.borderTop = 'none';
        editTitleInput.style.borderLeft = 'none';
        editTitleInput.style.borderRight = 'none';
        editTitleInput.style.borderRadius ='0px';
        editTitleInput.style.marginBottom ='10px';
        editTitleInput.style.outline = 'none';

        let editInput = document.createElement('textarea');
        //editInput.type = 'text';
        editInput.classList.add('form-control');
        editInput.classList.add('js-post');
        editInput.value = replyText;
        editInput.style.resize = 'none';
        editInput.rows = 5; // Set the number of rows to 5

        // Custom style
        editInput.style.border = 'none';
        editInput.style.borderRadius ='0px';
    

        // Replace the reply content with the input field
        replytitleElement.parentNode.replaceChild(editTitleInput, replytitleElement);
        replyElement.parentNode.replaceChild(editInput, replyElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('js-save-button', 'btn' , 'px-3', 'mr-3');
        saveButton.innerHTML = 'Save';

        saveButton.style.backgroundColor = '#e9a886';
        saveButton.style.color ='#ffff';

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-button', 'btn', 'btn-outline-danger', 'm-3'); // Add the 'row' and 'col-md-6' classes
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', function() {
            // Get the edited title and content from the input fields
            let editedTitle = editTitleInput.value;
            let editedContent = editInput.value;

            // Call a function to save the edited title and content
            myposts.savePost(forum_id, editedTitle, editedContent);
        });

        // Attach event listener to the Cancel button
        cancelButton.addEventListener('click', function() {
            // Create new elements to replace the input fields with
            let newTitleElement = document.createElement('h2');
            newTitleElement.classList.add('js-title');
            newTitleElement.textContent = replyTitleText;

            let newContentElement = document.createElement('div');
            newContentElement.classList.add('js-post');
            newContentElement.textContent = replyText;

            // Replace editInput and saveButton with original replyElement
            editTitleInput.parentNode.replaceChild(newTitleElement, editTitleInput);
            editInput.parentNode.replaceChild(newContentElement, editInput);
            postWrapper.removeChild(saveButton);
            postWrapper.removeChild(cancelButton);
            
            // Show the edit and delete buttons
            postWrapper.querySelector('.js-date').classList.remove('hide');
            postWrapper.querySelector('.js-comment-link-count').classList.remove('hide');
            postWrapper.querySelector('.js-like-button').classList.remove('hide');
            postWrapper.querySelector('.js-num-likes').classList.remove('hide');
            postWrapper.querySelector('.js-modification-buttons').classList.remove('hide');
        });

        // Append the Save button to the replyWrapper element
        postWrapper.appendChild(saveButton);
        // Append the Cancel button to the replyWrapper element
        postWrapper.appendChild(cancelButton);

        // Hide the edit and delete buttons
        postWrapper.querySelector('.js-date').classList.add('hide');
        postWrapper.querySelector('.js-comment-link-count').classList.add('hide');
        postWrapper.querySelector('.js-like-button').classList.add('hide');
        postWrapper.querySelector('.js-num-likes').classList.add('hide');
        postWrapper.querySelector('.js-modification-buttons').classList.add('hide');
    },

    savePost: function(forum_id, editedTitle, editedContent) {

        // Create a FormData object to send the data to the server
        let form = new FormData();
        form.append('forum_id', forum_id);
        form.append('title', editedTitle);
        form.append('content', editedContent);
        form.append('data_type', 'my_edit_post');
        
        // Create a new XMLHttpRequest object
        var ajax = new XMLHttpRequest();

        // Add an event listener to handle the server response
        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //ganto daw iconvert si JSON back to javascript
                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); //nasa ajax.php yung .message

                    if(obj.success){
                        // Find the post element using the forum_id
                        let postElement = document.querySelector(`#post_${forum_id}`);
                        console.log(postElement);

                        // Update the date element with the updated date
                        let dateElement = postElement.querySelector('.js-date');
                        //dateElement.textContent = obj.updated_date;
                        time.updateTimestamps(dateElement, obj.updated_date);

                        // Create new elements to replace the input fields with
                        let newTitleElement = document.createElement('h2');
                        newTitleElement.classList.add('js-title');
                        newTitleElement.textContent = editedTitle;

                        let newContentElement = document.createElement('div');
                        newContentElement.classList.add('js-post');
                        newContentElement.textContent = editedContent;
                        console.log(newTitleElement);
                        console.log(newContentElement);
                        
                        // Replace the input fields with the new elements
                        let titleInput = postElement.querySelector('.js-title');
                        let contentInput = postElement.querySelector('.js-post');
                        /*let titleInput = postElement.getElementsByTagName('input')[0];
                        let contentInput = postElement.getElementsByTagName('input')[1];*/
                        console.log(titleInput);
                        console.log(contentInput);
                        titleInput.parentNode.replaceChild(newTitleElement, titleInput);
                        contentInput.parentNode.replaceChild(newContentElement, contentInput);

                        // Remove the save and cancel buttons
                        let saveButton = postElement.querySelector('.js-save-button');
                        let cancelButton = postElement.querySelector('.js-cancel-button');
                        console.log(saveButton);
                        console.log(cancelButton);
                        postElement.removeChild(saveButton);
                        postElement.removeChild(cancelButton);

                        // Show the other elements
                        postElement.querySelector('.js-date').classList.remove('hide');
                        postElement.querySelector('.js-comment-link-count').classList.remove('hide');
                        postElement.querySelector('.js-like-button').classList.remove('hide');
                        postElement.querySelector('.js-num-likes').classList.remove('hide');
                        postElement.querySelector('.js-modification-buttons').classList.remove('hide');

                        let data = document.querySelector("#post_"+forum_id).getAttribute("row");
                        data = data.replaceAll('\\"','"');
                        data = JSON.parse(data);

                        let forum_id_int = parseInt(forum_id);
                        let forum_id_string = forum_id_int.toString();
                        myposts.updatePostData(forum_id_string, data);
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    search: function(query) {

        let form = new FormData();
        form.append('query', query);
        form.append('my_topics', myposts.my_topics);
        form.append('data_type', 'search_posts');
        console.log(myposts.my_topics);
        var ajax = new XMLHttpRequest();
    
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {

                    let obj = JSON.parse(ajax.responseText);

                    if (obj.success) {

                        myposts.start = 0;
                        myposts.displayPosts(obj.rows, true);
                        
                        sessionStorage.setItem('searchResults', JSON.stringify(obj.rows));
                    } else {

                        // Display an error message
                        let postContainer = document.getElementById("postContainer");
                        let loadMoreBtn = document.getElementById("loadMoreBtn");
                        postContainer.innerHTML = '<p>No posts found</p>';
                        loadMoreBtn.style.display = "none";
                        postContainer.appendChild(loadMoreBtn);
                        
                    }
                }
            }
        });
    
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    updatePostData: function(forum_id, data) {
        // Send a request to the PHP side script to find the post where the like button was clicked
        let form = new FormData();
        form.append('forum_id', forum_id);
        form.append('data_type', 'find_post');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success && obj.hasOwnProperty('rows')){
                        let updatedPost = obj.rows[0];
                        // Call the updateStoredSearchResults function to update the sessionStorage with the updated post data
                        myposts.updateStoredSearchResults(forum_id, updatedPost);
                    }
                }
            }
        });

        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    updateStoredSearchResults: function(postId, updatedPost) {
        // Get the stored search results from sessionStorage
        let storedSearchResults = sessionStorage.getItem('searchResults');
        if (storedSearchResults) {
            // Parse the stored search results
            let searchResults = JSON.parse(storedSearchResults);
            // Find the index of the post with the given ID
            let postIndex = searchResults.findIndex(function(post) {
                return post.forum_id === postId;
            });
            // Check if the post was found
            if (postIndex !== -1) {
                
                // Update the post in the search results
                searchResults[postIndex] = updatedPost;
                // Store the updated search results in sessionStorage
                sessionStorage.setItem('searchResults', JSON.stringify(searchResults));
            }
        }
    },
};


//-----------------------------------------------------------------------------------------------------
if (typeof my_topics_page != 'undefined') {
    // Check if number of posts is saved
    if (sessionStorage.getItem('numPosts') !== null) {
        // Calculate number of times to call loadMorePosts
        let numCalls = Math.ceil((sessionStorage.getItem('numPosts') - myposts.start) / myposts.limit);
        // Define recursive function to call loadMorePosts
        let loadMore = function(i) {
            if (i > 0) {
                myposts.loadMorePosts(function() {
                    loadMore(i - 1);
                });
            } else {
                // Restore scroll position
                if (sessionStorage.getItem('scrollPosition') !== null) {
                    window.scrollTo(0, sessionStorage.getItem('scrollPosition'));
                    sessionStorage.removeItem('scrollPosition');
                }
                // Remove saved number of posts
                sessionStorage.removeItem('numPosts');
            }
        };
        // Call loadMorePosts
        loadMore(numCalls);
    } else {
        myposts.loadMorePosts();
    }
}

