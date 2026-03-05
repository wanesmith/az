<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing divs of the main content and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.3.8
 */
?>
</div><!-- .content-wrapper -->

</div><!-- .content-inner -->

<?php

/**

 * Hook to add content block

 * slikk_after_content

 */

do_action( 'slikk_before_footer_block' );

?>

</div><!-- .site-content -->

</div><!-- #main -->

</div><!-- #page-content -->

<div class="clear"></div>

<?php

/**

 * Before footer hook

 */

do_action( 'slikk_footer_before' );



if ( 'hidden' !== slikk_get_inherit_mod( 'footer_type' ) && is_active_sidebar( 'sidebar-footer' ) ) :

    ?>

    <footer id="colophon" class="<?php echo apply_filters( 'slikk_site_footer_class', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?> site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

        <div class="footer-inner clearfix">

            <?php get_sidebar( 'footer' ); ?>

        </div><!-- .footer-inner -->

    </footer><!-- footer#colophon .site-footer -->

<?php endif; ?>

<?php



/**

 * Fires the Slikk bottom bar

 */

do_action( 'slikk_bottom_bar' );

?>

</div><!-- #page .hfeed .site -->

</div><!-- .site-container -->

<?php

/**

 * Fires the Slikk bottom bar

 */

do_action( 'slikk_body_end' );

?>

<?php wp_footer(); ?>



<script>

    jQuery( document ).ready(function() {

        jQuery(".rpbt_shortcode a").removeAttr("data-fancybox");

    });

</script>
</body>
</html>
