<?php
declare(strict_types=1);

get_header();
?>
<main class="wp-page-content">
    <div class="event-shell">
        <?php
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>
<?php
get_footer();
