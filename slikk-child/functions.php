<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css',array(),"1.0.1" );
}


add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
add_filter('show_admin_bar', '__return_false');
remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');
function cvf_remove_wp_core_updates(){
    global $wp_version;
    return(object) array('last_checked' => time(),'version_checked' => $wp_version);
}

// Core Notifications
add_filter('pre_site_transient_update_core','cvf_remove_wp_core_updates');
// Plugin Notifications
add_filter('pre_site_transient_update_plugins','cvf_remove_wp_core_updates');
// Theme Notifications
add_filter('pre_site_transient_update_themes','cvf_remove_wp_core_updates');


/*add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts() {
    wp_enqueue_script( 'parent-js', get_template_directory_uri().'/script.js',array(),"1.0.0" );
}*/

add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts(){
    ?>
    <script>

        jQuery('.logo a').removeClass("logo-link");
        jQuery('.logo a img').removeClass("logo-img logo-light");
        jQuery('.logo a img.logo-dark').remove();

        jQuery("#mobile-menu-panel").prepend('<div class="search-custom search-container"><span title="Search" class="search-item-icon toggle-search"></span></div>');
        jQuery(".menu-container").after('<div class="search-custom search-container"><span title="Search" class="search-item-icon toggle-search"></span></div>');
        jQuery('.post-meta-container .post-meta-separator').last().css("display","none");
        jQuery('.post-meta-container .post-meta-separator').last().css("display","none");
        var searchBlog =jQuery(".search-type-blog");
        jQuery("body").append(searchBlog.clone());
        searchBlog.remove();
        jQuery(window).scroll(function() {
            var isTopbarExist =  jQuery('#tpbr_topbar').length ? true : false;
            jQuery('#mobile-menu-panel .search-custom').removeClass("t-62");
            jQuery('#mobile-menu-panel .search-custom').removeClass("t-55");
            jQuery('#mobile-menu-panel .search-custom').removeClass("t-20");
            jQuery('#mobile-menu-panel .search-custom').removeClass("t-15");
            if (jQuery(this).scrollTop()>12)
            {
                if(isTopbarExist){
                    jQuery('#mobile-menu-panel div.search-custom').addClass("t-55");
                }else{
                    jQuery('#mobile-menu-panel div.search-custom').addClass("t-15");
                }
            }else{
                if(isTopbarExist){
                    jQuery('#mobile-menu-panel .search-custom').addClass("t-62");
                }else{
                    jQuery('#mobile-menu-panel .search-custom').addClass("t-20");
                }
            }
            if (jQuery(this).scrollTop()>1)
            {
                jQuery('.logo').addClass("logo-scroll");
            }else{
                jQuery('.logo').removeClass("logo-scroll");
            }
        });

    </script>
    <?php
}

/**
* Removes or edits the 'Protected:' part from posts titles
*/
add_filter( 'protected_title_format', 'remove_protected_text' );
function remove_protected_text() {
return __('%s');
}

?>