var like_rating = {

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

    like: function(likeButton, isSinglePost){

        let forum_id = likeButton.getAttribute('forum_id');
        
        if (likeButton.classList.contains('btn')) {
            action = 'like';
            //console.log(action);
        } else if (likeButton.classList.contains('btn_selected')) {
            action = 'unlike';
        } else {
            //console.log('The button does not have either class');
            alert('Please log in to like this post and contents');
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
                        //let likesElement = document.querySelector(`.js-num-likes[forum_id="${forum_id}"]`);
                        let likesElement;
                        if (isSinglePost) {
                            likesElement = document.querySelector(`.single-post.js-num-likes[forum_id="${forum_id}"]`);
                        } else {
                            likesElement = document.querySelector(`.js-num-likes[forum_id="${forum_id}"]`);
                        }
                        
                        if (likesCount == 0) {
                            likesElement.innerHTML = '';
                        } else {
                            likesElement.innerHTML = likesCount;
                        }
                        
                        let data = document.querySelector("#post_"+forum_id).getAttribute("row");
                        data = data.replaceAll('\\"','"');
                        data = JSON.parse(data);

                        //allposts.updatePostData(forum_id, data);
                        //myposts.updatePostData(forum_id, data);
                        if (typeof allposts !== 'undefined') {
                            allposts.updatePostData(forum_id, data);
                        }
                        if (typeof myposts !== 'undefined') {
                            myposts.updatePostData(forum_id, data);
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