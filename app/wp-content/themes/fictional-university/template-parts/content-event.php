<?php
if (isset($args['postTypeCount']) && $args['postTypeCount']['event'] == 1) {
    echo '<h1 class="headline headline--medium">Events</h1>';
    echo '<hr>';
}
?>
<div class="event-summary">
    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
    
        <?php
        //$eventDate = new DateTime(get_field('event_date'));
        // Note: Advanced Custom Fields stores the date in 'Ymd'
        // src: https://stackoverflow.com/questions/59473266/datetimeget-fieldevent-date

        // the following commented lines didn't work if acf return the date in other than the format: 
        // 12/24/2020 9:30 pm == m/d/Y g:i a
        // THUS, the RETURN VALUE in the field options should in that format.
        //$eventDate = DateTime::createFromFormat('Ymd', $ss);
        $eventDate = new DateTime(get_field('event_date'));
        $eventDateMonth = $eventDate->format('M');
        $eventDateDay = $eventDate->format('d');

        ?>
        <span class="event-summary__month"><?php echo $eventDateMonth;
                                            ?></span>
        <span class="event-summary__day"><?php echo $eventDateDay;
                                            ?></span>
    </a>
    <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php echo (has_excerpt()) ? get_the_excerpt() : wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
    </div>
</div>