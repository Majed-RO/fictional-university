<?php
if (isset($args['postTypeCount']) && $args['postTypeCount']['campus'] == 1) {
    echo '<h1 class="headline headline--medium">Campuses</h1>';
    echo '<hr>';
}
?>
<div class="post-item">

    <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

    <div class="generic-content">
        <p>
            <a class="btn btn--blue" href="<?php the_permalink(); ?>">View Campus..</a>
        </p>
    </div>
</div>