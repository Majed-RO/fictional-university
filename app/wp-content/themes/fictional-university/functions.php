<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback'      => function() {
            return get_the_author();
        }
    ));
    register_rest_field('note', 'userPostsCount', array(
        'get_callback'      => function () {
            return count_user_posts(get_current_user_id(), 'note');
        }
    ));
}
add_action('rest_api_init', 'university_custom_rest');

function university_files()
{
    wp_enqueue_script('google-map-js', '//maps.googleapis.com/maps/api/js?key=AIzaSyA5wKOF1iM3nDsROzqVOC-uUeMvxAM_eXo', NULL, '1.2', true);

    wp_enqueue_script('main-university-js', get_theme_file_uri('js/scripts-bundled.js'), array('jquery'), microtime(), true);
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university-main-styles', get_stylesheet_uri(), NULL, microtime());

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce'    => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerMenuLocationOne', 'Footer Menu Location One');
    register_nav_menu('footerMenuLocationTwo', 'Footer Menu Location Two');

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBannerImage', 1500, 350, true);
}
add_action('after_setup_theme', 'university_features');


function university_custom_queries($query)
{
    // To adjust the main query in archive-program.php
    // unlimited list of programs ordered by title
    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', '-1');
    }

    // To adjust the main query in archive-event.php
    // To get a list of upcoming events
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key'       =>  'event_date',
                'compare'   =>  '>=',
                'value'     =>  $today,
                'type'      =>  'DATETIME'
            )
        ));
    }

    // To adjust the main query in archive-campus.php
    // unlimited list of campuses - to show all pins of all locations on the map
    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
        $query->set('posts_per_page', '-1');
    }
}
add_action('pre_get_posts', 'university_custom_queries');

function university_page_banner($args = NULL)
{
    // if there is no args passed
  //  if (!$args) { $args = array( 'title'); }
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle'])) {
        $pageBannerSubtitle = get_field('page_banner_subtitle');
        if ($pageBannerSubtitle) {
            $args['subtitle'] = $pageBannerSubtitle; 
        } else {
            $args['subtitle'] = ' '; }
    }

    if (!isset($args['photo'])) {
        $pageBannerImage = get_field('page_banner_image');
        if($pageBannerImage) {
            $args['photo'] = $pageBannerImage['sizes']['pageBannerImage'];
        } else {
            $args['photo'] = get_theme_file_uri('images/ocean.jpg');
        }
        
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>  );"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>

<?php
}

/* 
src: https://www.advancedcustomfields.com/resources/google-map/#:~:text=The%20Google%20Map%20field%20provides,location%20data%20in%20version%205.8.
 The Google Maps field requires the following APIs; Maps JavaScript API, Geocoding API and Places API.
*/
function university_map_key($api) {
    $api['key'] = 'AIzaSyA5wKOF1iM3nDsROzqVOC-uUeMvxAM_eXo';
    return $api;
}
add_filter('acf/fields/google_map/api', 'university_map_key');

// redirect subscriber user to the front page when access admin page
function university_subscriber_redirect() {
    $currentUser = wp_get_current_user();
    if ( count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}
add_action('admin_init', 'university_subscriber_redirect');

// hide admin bar for subscriber
function university_hide_admin_bar() {
    $currentUser = wp_get_current_user();
    if ( count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}
add_action('wp_loaded', 'university_hide_admin_bar');

// Customize Login Screen
function university_header_url()
{
    return esc_url(site_url('/'));
}
add_filter('login_headerurl', 'university_header_url');


function university_login_CSS()
{
    wp_enqueue_style('university-main-styles', get_stylesheet_uri());
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
add_action('login_enqueue_scripts', 'university_login_CSS');


function university_login_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'university_login_title');

// make any note private
function university_make_note_private($data, $postarr) {

    // to be sure there is no harm data could be inserted in the note content
    if ($data['post_type'] == 'note') {
        // means the user cannot add new note if he has 4 notes or greater
        if (count_user_posts(get_current_user_id(), 'note') > 3 && !$postarr['ID']) {
            die("exceed_limit");
        }
        
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if ($data['post_type'] == 'note' && $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }
    return $data;
}
add_filter('wp_insert_post_data','university_make_note_private', 10, 2);