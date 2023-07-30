
/*const cron = require("node-cron");
const url = 'https://semaphore.co/api/v4/messages';
const apiKey = 'c17f81a2eb07d0ad839118cad67d2c55';
const senderName = 'SEMAPHORE';
const pnum = '09234726098';

function sendMessagePills() {
    
const message = `Hi, this is SiPa!\n\nDon't forget to take your prescribed contraceptive pills today.\n\n For more information about contraceptive methods, please visit our website.\n\nThanks! `;
  
    const parameters = new URLSearchParams({
      apikey: apiKey,
      number: pnum,
      message: message,
      sendername: senderName
    });
  
    fetch(url, {
      method: 'POST',
      body: parameters
    })
      .then(response => response.text())
      .then(output => {
        console.log(output); // Show the server response
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  
  
  // Example usage
  cron.schedule("2 * * * *", sendMessagePills());*/
// DO NOT INCLUDE ALL OF THIS!!!
  var allposts = {

    start: (typeof start == 'undefined') ? 0 : start,
    limit: (typeof limit == 'undefined') ? 5 : limit,

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

                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        document.querySelector(".js-search-input").value = "";
                        document.querySelector(".js-post-input").value = "";
                        document.getElementById("post_title").value = "";
                        document.querySelector(".js-anonymous").checked = false;
                        
                        // Reset allposts.start and call allposts.loadMorePosts with clearExisting set to true
                        allposts.start = 0;
                        allposts.loadMorePosts(null, true);
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
        sessionStorage.setItem('numPosts', allposts.start);
        window.location.href = "post.php?id="+id;
    },

    delete: function(forum_id) {
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
                        //allposts.loadMorePosts();
                        //window.location.reload();

                        // Find and remove the post element from the page
                        let postElement = document.querySelector(`#post_${forum_id}`);
                        postElement.parentNode.removeChild(postElement);
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
        //document.querySelector('.js-start-topic').classList.remove('hide');
        var form = document.querySelector('.js-start-topic');
        //var button = document.querySelector('button');
        if (form.classList.contains('hide')) {
            form.classList.remove('hide');
        } else {
            form.classList.add('hide');
            
        }
    },

    userLiked: function(forum_id, callback) {
        
        //alert(forum_id);
        let form = new FormData();

        form.append('forum_id', forum_id);
        form.append('data_type', 'user_liked');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    if(obj.success){
                        //return true;
                        callback(true);
                    }else{
                        //return false;
                        callback(false);
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    like: function(likeButton){

        let forum_id = likeButton.getAttribute('forum_id');
        
        if (likeButton.classList.contains('btn')) {
            action = 'like';
            //console.log(action);
        } else if (likeButton.classList.contains('btn_selected')) {
            action = 'unlike';
        } else {
            console.log('The button does not have either class');
        }

        let form = new FormData(); //new form within javascript

        form.append('action', action);
        form.append('forum_id', forum_id);
        form.append('data_type', 'add_like');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    //console.log(obj.row.likes['count(*)']);
                    
                    if(obj.success){
                        
                        if (action == 'like') {
                            likeButton.classList.remove('btn');
                            likeButton.classList.add('btn_selected');
                        }else{
                            likeButton.classList.remove('btn_selected');
                            likeButton.classList.add('btn');
                        }

                        //dito nangyayari yung pag add ng number matically
                        let likesCount = obj.row.likes['count(*)'];
                        let likesElement = document.querySelector(`.js-num-likes[forum_id="${forum_id}"]`);
                        if (likesCount == 0) {
                            likesElement.innerHTML = '';
                        } else {
                            likesElement.innerHTML = likesCount;
                        }

                        let data = document.querySelector("#post_"+forum_id).getAttribute("row");
                        data = data.replaceAll('\\"','"');
                        data = JSON.parse(data);
                        console.log(data);

                        //allposts.updateStoredSearchResults(forum_id, data);
                        allposts.updatePostData(forum_id, data);
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    loadMorePosts: function(callback, clearExisting = false) {
        let form = new FormData();
        form.append('start', allposts.start);
        form.append('limit', allposts.limit);
        form.append('data_type', 'load_posts_decoy');
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
                        //allposts.displayPosts(obj.rows);
                        allposts.displayPosts(obj.rows, clearExisting);
                        allposts.start += obj.rows.length;

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
        /*if (posts.length == 0) {
            let messageElement = document.createElement('p');
            messageElement.textContent = "No discussions found";
            postContainer.insertBefore(messageElement, loadMoreBtn);
            return;
        }*/ //its broken
        // Get the user's search query
        let searchQuery = document.querySelector('.js-search-input').value;

        // Split the search query into individual words
        let searchWords = searchQuery.split(' ');

        for (var i = 0; i < posts.length; i++) {
            let postCard = postCardTemplate.content.cloneNode(true);

            if(typeof posts[i].user == 'object'){
                postCard.querySelector(".js-image").src = posts[i].user.image;
            }

            postCard.querySelector(".js-username").textContent = posts[i].user_fname;
            //postCard.querySelector(".js-date").textContent = posts[i].date;xxxxxx
            // Highlight matching words in the post title
            let postTitle = posts[i].forum_title;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                postTitle = postTitle.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }
            postCard.querySelector(".js-title").innerHTML = postTitle;
            //postCard.querySelector(".js-title").textContent = posts[i].forum_title;
            // Highlight matching words in the post text
            let postText = posts[i].forum_desc;
            for (let j = 0; j < searchWords.length; j++) {
                let searchWord = searchWords[j];
                let searchWordRegex = new RegExp(searchWord, 'gi');
                postText = postText.replace(searchWordRegex, '<span class="highlight">$&</span>');
            }
            postCard.querySelector(".js-post").innerHTML = postText;
            //postCard.querySelector(".js-post").textContent = posts[i].forum_desc;
            postCard.querySelector(".js-comment-link").setAttribute('onclick',`allposts.view_comments(${posts[i].forum_id})`);
            postCard.querySelector(".js-like-button").setAttribute('forum_id', posts[i].forum_id);
            postCard.querySelector(".js-num-likes").setAttribute('forum_id', posts[i].forum_id);

            postCard.querySelector(".js-delete-button").setAttribute('onclick',`allposts.delete(${posts[i].forum_id})`);
            //postCard.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_post.show_me(${posts[i].forum_id})`);
            postCard.querySelector(".js-edit-button").setAttribute('onclick',`allposts.editPost(${posts[i].forum_id})`);

            //counting the number of comments
            if(posts[i].comment_count > 0){
                postCard.querySelector(".js-comment-link").innerHTML = `${posts[i].comment_count}+ Comments`;
            }else{
                postCard.querySelector(".js-comment-link").innerHTML = `Comment`;
            }
            
            //counting the number of likes
            if (posts[i].getlikes['count(*)'] == 0) {
                postCard.querySelector(".js-num-likes").innerHTML = "";
            } else {
                postCard.querySelector(".js-num-likes").innerHTML = posts[i].getlikes['count(*)'];
            }

            //---------------------------------------------------------------------------------------
            //copying the content of postCard
            let clone = postCard.cloneNode(true);

            // Get root element of cloned template
            let rootElement = clone.querySelector(':first-child');

            //para mag iba iba kulay nung like button
            //red kapaga nilike na, blue kpaag hindi pa
            let likeButton = clone.querySelector(".js-like-button");
            allposts.userLiked(posts[i].forum_id, (function(likeButton) {
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
                // Call the allposts.like function and pass a reference to the clicked button element
                allposts.like(event.target);
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
            allposts.updateTimestamps(timestampElement, posts[i].date);

            postContainer.insertBefore(clone, loadMoreBtn);
        }
    },

    updateTimestamps: function(element, timestamp) {
        var postTimestamp = new Date(timestamp); // Convert the timestamp to a JavaScript Date object
        var now = new Date();
        var elapsed = Math.floor((now - postTimestamp) / 1000); // Elapsed time in seconds
    
        /*if (elapsed < 60) {
            element.textContent = 'Just now';
        } else if (elapsed < 3600) {
            var minutes = Math.floor(elapsed / 60);
            element.textContent = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
        } else {
            element.textContent = postTimestamp.toLocaleString(); // Display the full timestamp
        }*/

        if (elapsed < 60) {
            element.textContent = 'Just now';
        } else if (elapsed < 3600) {
            var minutes = Math.floor(elapsed / 60);
            element.textContent = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 86400) {
            var hours = Math.floor(elapsed / 3600);
            element.textContent = hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 604800) {
            var days = Math.floor(elapsed / 86400);
            element.textContent = days + ' day' + (days > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 2592000) {
            var weeks = Math.floor(elapsed / 604800);
            element.textContent = weeks + ' week' + (weeks > 1 ? 's' : '') + ' ago';
        } else if (elapsed < 31536000) {
            var months = Math.floor(elapsed / 2592000);
            element.textContent = months + ' month' + (months > 1 ? 's' : '') + ' ago';
        } else {
            var years = Math.floor(elapsed / 31536000);
            element.textContent = years + ' year' + (years > 1 ? 's' : '') + ' ago';
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
        editTitleInput.classList.add('js-title');
        editTitleInput.value = replyTitleText;

        let editInput = document.createElement('input');
        editInput.type = 'text';
        editInput.classList.add('js-post');
        editInput.value = replyText;

        // Replace the reply content with the input field
        replytitleElement.parentNode.replaceChild(editTitleInput, replytitleElement);
        replyElement.parentNode.replaceChild(editInput, replyElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('js-save-button');
        saveButton.innerHTML = 'Save';

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-button');
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', function() {
            // Get the edited title and content from the input fields
            let editedTitle = editTitleInput.value;
            let editedContent = editInput.value;

            // Call a function to save the edited title and content
            allposts.savePost(forum_id, editedTitle, editedContent);
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
                        allposts.updateTimestamps(dateElement, obj.updated_date);

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
        form.append('data_type', 'search_posts');

        var ajax = new XMLHttpRequest();
    
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    //console.log(obj);
                    if (obj.success) {
                        allposts.start = 0;
                        allposts.displayPosts(obj.rows, true);
                        
                        sessionStorage.setItem('searchResults', JSON.stringify(obj.rows));

                    } else {
                        // Display an error message
                        let postContainer = document.getElementById("postContainer");
                        let loadMoreBtn = document.getElementById("loadMoreBtn");
                        postContainer.innerHTML = '<p>No posts found</p>';
                        loadMoreBtn.style.display = "none";
                        postContainer.appendChild(loadMoreBtn);
                        
                        //postContainer.innerHTML = '<p>An error occurred while searching for posts</p>';
                    }
                }
            }
        });
    
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    updatePostData: function(forum_id, data) {
        console.log(forum_id);
        console.log(data);
        // Send a request to the PHP side script to find the post where the like button was clicked
        let form = new FormData();
        form.append('forum_id', forum_id);
        form.append('data_type', 'find_post');
        //form.append('data', data);

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success){
                        let updatedPost = obj.rows[0];
                        console.log(updatedPost);

                        // Call the updateStoredSearchResults function to update the sessionStorage with the updated post data
                        allposts.updateStoredSearchResults(forum_id, updatedPost);
                    }
                }
            }
        });

        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    updateStoredSearchResults: function(postId, updatedPost) {
        console.log(postId);
        console.log(updatedPost);
        // Get the stored search results from sessionStorage
        let storedSearchResults = sessionStorage.getItem('searchResults');
        console.log(storedSearchResults);
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
                console.log(updatedPost);
                // Store the updated search results in sessionStorage
                sessionStorage.setItem('searchResults', JSON.stringify(searchResults));
            }
        }
    },
};


//-----------------------------------------------------------------------------------------------------
if (typeof all_topics_page != 'undefined') {
    // Check if number of posts is saved
    if (sessionStorage.getItem('numPosts') !== null) {
        // Calculate number of times to call loadMorePosts
        let numCalls = Math.ceil((sessionStorage.getItem('numPosts') - allposts.start) / allposts.limit);
        // Define recursive function to call loadMorePosts
        let loadMore = function(i) {
            if (i > 0) {
                allposts.loadMorePosts(function() {
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
        allposts.loadMorePosts();
    }
}



