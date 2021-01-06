<?php
if (isset($args['postTypeCount']) && $args['postTypeCount']['professor'] == 1) {
    echo '<h1 class="headline headline--medium">Professors</h1>';
    echo '<hr>';
}
?>
<div class="post-item">

    <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

    <div class="generic-content">

        <li class="professor-card__list-item">
            <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php echo get_the_post_thumbnail_url(NULL, 'professorLandscape'); ?>" alt="">
                <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
        </li>

    </div>
</div>