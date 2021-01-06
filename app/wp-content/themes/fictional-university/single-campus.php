<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php university_page_banner(); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></p>
        </div>

        <div class="generic-content">
            <p><?php the_content(); ?></p>
        </div>

        <div class="acf-map">
            <?php $mapLocation = get_field('location_map');?>

                <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
                    <h3><?php the_title(); ?></h3>
                    <?php echo $mapLocation['address']; ?>
                </div>
                
        </div>

         <?php

        $relatedPrograms = new WP_Query(array(
            'posts_per_page'    => -1,
            'post_type'         => 'program',
            'orderby'           => 'title', // the instructor tells to use meta_value_num but didn't work!
            'order'             => 'ASC',
            'meta_query'        => array(
                array(
                    'key'       =>  'related_campuses',
                    'compare'   =>  'LIKE',
                    'value'     =>  '"' . get_the_ID() . '"' // mandatory to get the right id where the db stores values in a serialized way
                )
            )
        ));

        if ($relatedPrograms->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">This Campus contains the following programs</h2>';

            echo '<ul class="link-list min-list">';
            while ($relatedPrograms->have_posts()) :
                    $relatedPrograms->the_post(); ?>

                <li>
                    <a href="<?php the_permalink(); ?>">
                       <?php the_title(); ?>
                    </a>
                </li>

            <?php endwhile;
            echo '</ul>';
        }

        wp_reset_postdata();
        ?>

    </div>

<?php endwhile; ?>

<?php get_footer(); ?>