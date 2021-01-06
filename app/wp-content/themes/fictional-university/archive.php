<?php get_header(); ?>


<?php university_page_banner(array(
    'title'     => get_the_archive_title(),
    'subtitle' => get_the_archive_description()
)); ?>

<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post(); ?>
        <div class="post-item">

            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <div class="metabox">
                <p>Created by <?php the_author_posts_link(); ?> On <?php the_time('n.j.Y'); ?> in <?php echo get_the_category_list(', '); ?> </p>
            </div>
            <div class="generic-content">
                <p><?php the_excerpt(); ?></p>
                <p>
                    <a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading..</a>
                </p>
            </div>
        </div>

    <?php endwhile;
    echo paginate_links();
    ?>

</div>

<?php get_footer(); ?>