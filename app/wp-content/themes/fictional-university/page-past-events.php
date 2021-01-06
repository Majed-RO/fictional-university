<?php get_header(); ?>

<?php university_page_banner(array(
    'title'     => 'Past Events',
    'subtitle' => 'A Recap of the past events'
)); ?>

<div class="container container--narrow page-section">

    <?php

    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        /* 'posts_per_page'    => 1, */ // for test
        'paged'             => get_query_var('paged', 1),
        'post_type'         => 'event',
        'meta_key'          => 'event_date',
        'orderby'           => 'meta_value', // the instructor tells to use meta_value_num but didn't work!
        'order'             => 'ASC',
        'meta_query'        => array(
            array(
                'key'       =>  'event_date',
                'compare'   =>  '<',
                'value'     =>  $today,
                'type'      =>  'DATETIME'
            )
        )
    ));

    while ($pastEvents->have_posts()) : $pastEvents->the_post(); 

        get_template_part('/template-parts/content', 'event');

    endwhile;
    
    echo paginate_links(array(
        'total'     => $pastEvents->max_num_pages
    ));

    wp_reset_postdata();
    ?>

</div>

<?php get_footer(); ?>