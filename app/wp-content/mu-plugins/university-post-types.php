<?php

function university_post_types () {
    // register a new post type: event
    register_post_type('event', array(
        'capability_type' => 'event',
        'map_meta_cap'      =>  true,
        'supports'    => array('title', 'editor', 'excerpt'),
        'rewrite'     => array('slug' => 'events'),
        'has_archive' => true,
        'public'      => true,
        'labels'      => array(
            'name'              => 'Events',
            'add_new_item'      => 'Add New Event',
            'edit_item'         => 'Edit Event',
            'all_items'         => 'All Events',
            'singular_event'    => 'Event'
        ),
        'menu_icon'    => 'dashicons-calendar'
        ));

     // register a new post type: program
    register_post_type('program', array(
        // we exclude editor to fix search in the content
        'supports'    => array('title'),
        'rewrite'     => array('slug' => 'programs'),
        'has_archive' => true,
        'public'      => true,
        'labels'      => array(
            'name'              => 'Programs',
            'add_new_item'      => 'Add New Program',
            'edit_item'         => 'Edit Program',
            'all_items'         => 'All Programs',
            'singular_event'    => 'Program'
        ),
        'menu_icon'    => 'dashicons-awards'
    ));

    // register a new post type: professor
    register_post_type('professor', array(
        'supports'    => array('title', 'editor', 'thumbnail'),
        /* 'rewrite'     => array('slug' => 'professors'),
        'has_archive' => true, */
        'public'      => true,
        'labels'      => array(
            'name'              => 'Professors',
            'add_new_item'      => 'Add New Professor',
            'edit_item'         => 'Edit Professor',
            'all_items'         => 'All Professors',
            'singular_event'    => 'Professor'
        ),
        'menu_icon'    => 'dashicons-welcome-learn-more'
    ));

    // register a new post type: campus
    register_post_type('campus', array(
        'capability_type' => 'campus',
        'map_meta_cap'      =>  true,
        'supports'    => array('title', 'editor', 'thumbnail'),
        'rewrite'     => array('slug' => 'campuses'),
        'has_archive' => true,
        'public'      => true,
        'labels'      => array(
            'name'              => 'Campus',
            'add_new_item'      => 'Add New Campus',
            'edit_item'         => 'Edit Campus',
            'view_item'         => 'View Campus',
            'all_items'         => 'All Campuses',
            'singular_event'    => 'Campus'
        ),
        'menu_icon'    => 'dashicons-location-alt'
    ));

    // register a new post type: note
    register_post_type('note', array(
        'show_in_rest'      => true,
        'supports'          => array('title', 'editor'),
        'capability_type'   => 'note',
        'map_meta_cap'      =>  true,
        'public'            => false,
        'show_ui'           => true,
        'labels'            => array(
            'name'              => 'Note',
            'add_new_item'      => 'Add New Note',
            'edit_item'         => 'Edit Note',
            'view_item'         => 'View Note',
            'all_items'         => 'All Notes',
            'singular_event'    => 'Note'
        ),
        'menu_icon'    => 'dashicons-welcome-write-blog'
    ));

    // register a new post type: like
    register_post_type('like', array(
        'supports'          => array('title'),
        'public'            => false,
        'show_ui'           => true,
        'labels'            => array(
            'name'              => 'Like',
            'add_new_item'      => 'Add New Like',
            'edit_item'         => 'Edit Like',
            'view_item'         => 'View Like',
            'all_items'         => 'All Likes',
            'singular_event'    => 'Like'
        ),
        'menu_icon'    => 'dashicons-heart'
    ));
    // NOTE: This new post type, to be recognized in the url, you should go to settings > permalinks > save. This will restructure the urls which wordpress can understand
}

add_action('init', 'university_post_types');