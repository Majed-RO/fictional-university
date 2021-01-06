import $, { error } from 'jquery';

class Like {

    constructor() {
        this.events();
    }

    events() {

        $(".like-box").on("click", this.clickBtnDispatcher.bind(this));
    }

    // methods go here
    clickBtnDispatcher (e) {
        var currentLikeBox = $(e.target).closest(".like-box");
        //console.log(currentLikeBox.data("exists"));

        if (currentLikeBox.attr("data-exists") == "yes") {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox); 
        }
    }

    createLike(currentLikeBox) {
        var professorId = currentLikeBox.attr("data-professor");
        
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-NONCE', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLikes',
            type: 'POST',
            data: { 'professor_id': professorId },
            success: (response) => {
                // to make heart icon red
                currentLikeBox.attr("data-exists", "yes");
                currentLikeBox.attr("data-like", response);
                // to increase the number of likes by one
                var  likesCountObject = currentLikeBox.find(".like-count");
                var likedCount = parseInt(likesCountObject.html(), 10);
                likedCount++;
                likesCountObject.html(likedCount);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

    deleteLike(currentLikeBox) {
        var likeId = currentLikeBox.attr("data-like");

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-NONCE', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLikes',
            type: 'DELETE',
            data: { 'like_id': likeId },
            success: (response) => {
                // to make heart icon white
                currentLikeBox.attr("data-exists", "no");
                currentLikeBox.attr("data-like", 0);
                // to decrease the number of likes by one
                var likesCountObject = currentLikeBox.find(".like-count");
                var likedCount = parseInt(likesCountObject.html(), 10);
                likedCount--;
                likesCountObject.html(likedCount);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

}

export default Like;