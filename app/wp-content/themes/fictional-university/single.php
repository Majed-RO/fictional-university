<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php university_page_banner(); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Created by <?php the_author_posts_link(); ?> On <?php the_time('n.j.Y'); ?> in <?php echo get_the_category_list(', '); ?> </span></p>
        </div>

        <div class="generic-content">
            <p><?php the_content(); ?></p>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>