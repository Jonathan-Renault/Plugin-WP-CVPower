<?php get_header(); ?>
    <div class="col-sm-8 blog-main">

        <?php
        if ( have_posts() ) {
            while ( have_posts() ) : the_post();
                ?>
                <div class="blog-post">
                    <?php the_content(); ?>
                </div><!-- /.blog-post -->
            <?php
            endwhile;
        }
        ?>



    </div><!-- /.blog-main -->
<?php get_footer(); ?>