<?php get_header(); ?>

<?php university_page_banner(array(
    'title'     => 'Search Results',
    'subtitle' => 'You are searching for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;'
)); ?>

<div class="container container--narrow page-section">

    <?php 
    if (have_posts()) {
        /* This variable is used to show a headline of all results belong to a post type once.
        when  $postTypeCount == 1, then it should be one result of this type. in this case show the headline, if greater than 1 or less than 1, don't show it. This condition is to show the headline ONCE for each group */
        $postTypeCount = array(
            'post' => 0,
            'page' => 0,
            'professor' => 0,
            'campus' => 0,
            'program' => 0,
            'event' => 0,
        );
        while (have_posts()) : the_post();
            $postTypeCount[get_post_type()]++; // increase by one
            get_template_part('template-parts/content', get_post_type(), array('postTypeCount' => $postTypeCount));

        endwhile;
        
        echo paginate_links();
    } else { ?>
        <h2 class="headline headline--small-plus">There is no results match your search. please try again with other keywords!</h2>
    <?php
        get_search_form();
    }
    
    ?>

</div>

<?php get_footer(); ?>