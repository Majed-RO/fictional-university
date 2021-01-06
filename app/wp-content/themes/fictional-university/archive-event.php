<?php get_header(); ?>

<?php university_page_banner(array(
    'title'     => 'Events',
    'subtitle' => 'See what happening in the world!'
)
); ?>

<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post();

        get_template_part('/template-parts/content', 'event');
                
    endwhile;
    
    echo paginate_links();
    ?>

    <hr class="section-break">
    <p>Looking for the events in the past. <a href="<?php echo site_url('/past-events'); ?>">Click here to see the events archive</a>.</p>
</div>

<?php get_footer(); ?>