<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php university_page_banner(); ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">

                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <?php
                $likesCount = new WP_Query(array(
                    'post_type'     => 'like',
                    'meta_query'    => array(
                        array(
                            'key'       => 'liked_professor_id',
                            'compare'   => '=',
                            'value'     => get_the_ID()
                        )
                    )
                ));

                $heartStatus = 'no';
                $likeId = 0;
                if (is_user_logged_in()) {
                    $currentUserLikes = new WP_Query(array(
                        'author'        => get_current_user_id(),
                        'post_type'     => 'like',
                        'meta_query'    => array(
                            array(
                                'key'       => 'liked_professor_id',
                                'compare'   => '=',
                                'value'     => get_the_ID()
                            )
                        ),
                    ));

                    if ($currentUserLikes->found_posts) {
                        $heartStatus = 'yes';
                        $likeId = $currentUserLikes->posts[0]->ID;
                    }
                }
                //print_r($currentUserLikes);
                ?>
                <div class="two-thirds">

                    <span class="like-box" data-like="<?php  echo $likeId;  ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $heartStatus; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likesCount->found_posts; ?></span>
                    </span>

                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php
        $relatedPrograms = get_field('related_programs');

        if ($relatedPrograms) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
            echo '<ul class="link-list min-list">';

            foreach ($relatedPrograms as $program) { ?>

                <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>

        <?php }
            echo '</ul>';
        }
        ?>
    </div>


<?php endwhile; ?>

<?php get_footer(); ?>