<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php university_page_banner(); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title(); ?> </span></p>
        </div>

        <div class="generic-content">
            <p><?php the_field('main_body_content'); ?></p>
        </div>

        <?php

        $relatedProfessors = new WP_Query(array(
            'posts_per_page'    => -1,
            'post_type'         => 'professor',
            'orderby'           => 'title', // the instructor tells to use meta_value_num but didn't work!
            'order'             => 'ASC',
            'meta_query'        => array(
                array(
                    'key'       =>  'related_programs',
                    'compare'   =>  'LIKE',
                    'value'     =>  '"' . get_the_ID() . '"' // mandatory to get the right id where the db stores values in a serialized way
                )
            )
        ));

        if ($relatedProfessors->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Taught BY</h2>';

            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) :
                $relatedProfessors->the_post(); ?>

                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php echo get_the_post_thumbnail_url(NULL, 'professorLandscape'); ?>" alt="">
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>

            <?php endwhile;
            echo '</ul>';
        }

        wp_reset_postdata();

        $today = date('Ymd');
        $relatedEvents = new WP_Query(array(
            'posts_per_page'    => -1,
            'post_type'         => 'event',
            'meta_key'          => 'event_date',
            'orderby'           => 'meta_value', // the instructor tells to use meta_value_num but didn't work!
            'order'             => 'ASC',
            'meta_query'        => array(
                array(
                    'key'       =>  'event_date',
                    'compare'   =>  '>=',
                    'value'     =>  $today,
                    'type'      =>  'DATETIME'
                ),
                array(
                    'key'       =>  'related_programs',
                    'compare'   =>  'LIKE',
                    'value'     =>  '"' . get_the_ID() . '"' // mandatory to get the right id where the db stores values in a serialized way
                )
            )
        ));

        if ($relatedEvents->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

            while ($relatedEvents->have_posts()) :
                $relatedEvents->the_post(); 

                get_template_part('/template-parts/content', 'event');

            endwhile;
        }
        wp_reset_postdata();

        $relatedCampuses = get_field('related_campuses');

        if ($relatedCampuses) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' is available at these campuses</h2>';
            echo '<ul class="min-list link-list">';
            foreach ($relatedCampuses as $campus) {
                ?>
            
            <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus)?></a></li>

             <?php }
             echo '</ul>';
        } 

        ?>

    </div>

<?php endwhile; ?>

<?php get_footer(); ?>