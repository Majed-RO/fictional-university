<?php

add_action('rest_api_init', 'university_like_route');

function university_like_route() {
    register_rest_route('university/v1', 'manageLikes', array(
        'methods'   => 'POST',
        'callback'  => 'university_create_like'
    ));

    register_rest_route('university/v1', 'manageLikes', array(
        'methods'   => 'DELETE',
        'callback'  => 'university_delete_like'
    ));
}

function university_create_like($data) {
   $likedProfessorID = sanitize_text_field($data['professor_id']);

    if (is_user_logged_in()) {

        $currentUserLikes = new WP_Query(array(
            'author'        => get_current_user_id(),
            'post_type'     => 'like',
            'meta_query'    => array(
                array(
                    'key'       => 'liked_professor_id',
                    'compare'   => '=',
                    'value'     => $likedProfessorID
                )
            ),
        ));

        $likedBefore = $currentUserLikes->found_posts;
        $newLikeTitle = wp_get_current_user()->display_name . ' liked ' . get_the_title($likedProfessorID);

        if (!$likedBefore && get_post_type($likedProfessorID) == 'professor') {
            return wp_insert_post(array(
                'post_type'     => 'like',
                'post_title'    => $newLikeTitle,
                'post_status'   => 'publish',
                'meta_input'      => array(
                    'liked_professor_id'    => $likedProfessorID
                )
            ));
            
        } else {
            die("Invalid Professor ID! ");
        }
    } else {
        die("User is not logged in! ");
    }
    
  
    
}

function university_delete_like($data)
{
    $likeId = sanitize_text_field($data['like_id']);

    if (get_current_user_id() == get_post_field('post_author', $likeId) && get_post_type($likeId) == 'like') {

         wp_delete_post($likeId, true);
         return "Congrats, like deleted!";

    } else {
        die("You don't have permission to delete this like!");
    }
}