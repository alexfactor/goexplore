<?php

/**
 * Go Explore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Go Explore
 */

// Register Custom Navigation Walker
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

require_once get_template_directory() . '/inc/customizer.php';

/**
* Enqueue scripts and styles.
*/
function go_explore_scripts(){
	//Bootstrap javascript and CSS files
 	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/inc/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
 	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/inc/bootstrap.min.css', array(), '4.3.1', 'all' );

 	// Theme's main stylesheet
 	wp_enqueue_style( 'go-explore-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );

 	// Google Fonts
 	// wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Rajdhani:400,500,600,700|https://fonts.googleapis.com/css?family=Seaweed+Script' );

 	// Flexslider Javascript and CSS files
	wp_enqueue_script( 'flexslider-min-js', get_template_directory_uri() . '/inc/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/inc/flexslider/flexslider.css', array(), '', 'all' );
	wp_enqueue_script( 'flexslider-js', get_template_directory_uri() . '/inc/flexslider/flexslider.js', array( 'jquery' ), '', true );

 }
 add_action( 'wp_enqueue_scripts', 'go_explore_scripts' );

/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which
* runs before the init hook. The init hook is too late for some features, such
* as indicating support for post thumbnails.
*/
function go_explore_config(){

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'go_explore_main_menu' 	=> 'Go Explore Main Menu',
				'go_explore_main_menu_right' 	=> 'Go Explore Main Menu Right',
				'go_explore_footer_menu' => 'Go Explore Footer Menu',
				'go_explore_activity_menu' => 'Go Explore Activity Menu'
			)
		);

		// This theme is WooCommerce compatible, so we're adding support to WooCommerce
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width' => 255,
			'single_image_width'	=> 255,
			'product_grid' 			=> array(
	            'default_rows'    => 10,
	            'min_rows'        => 5,
	            'max_rows'        => 10,
	            'default_columns' => 3,
	            'min_columns'     => 1,
	            'max_columns'     => 4,				
			)
		) );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

        /**
        * Add support for core custom logo.
        *
        * @link https://codex.wordpress.org/Theme_Logo
        */
		add_theme_support( 'custom-logo', array(
			'height' 		=> 310,
			'width'			=> 433,
			'flex_height'	=> true,
			'flex_width'	=> true,
		) );

		add_image_size( 'go-explore-slider', 1920, 800, array( 'center', 'center' ) );

		if ( ! isset( $content_width ) ) {
			$content_width = 600;
		}				
}
add_action( 'after_setup_theme', 'go_explore_config', 0 );

/**
 * If WooCommerce is active, we want to enqueue a file
 * with a couple of template overrides
 */
if( class_exists( 'WooCommerce' )){
	require get_template_directory() . '/inc/wc-modifications.php';
}

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'go_explore_woocommerce_header_add_to_cart_fragment' );

function go_explore_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<span class="items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['span.items'] = ob_get_clean();
	return $fragments;
}

//Allow different file type uploads
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter('upload_mimes', 'cc_mime_types');


// Add filter to specific menus 
add_filter('wp_nav_menu_args', 'add_filter_to_menus');
function add_filter_to_menus($args) {

    // You can test agasint things like $args['menu'], $args['menu_id'] or $args['theme_location']
    if( $args['theme_location'] == 'go_explore_activity_menu') {
        add_filter( 'wp_setup_nav_menu_item', 'filter_menu_items' );
    }

    return $args;
}
// Filter menu
function filter_menu_items($item) {

    if( $item->type == 'taxonomy') {

        // Get category and image ID
        $slug = pathinfo( $item->url, PATHINFO_BASENAME );
        $cat = get_term_by( 'slug', $slug, 'category' );
        // If there is no standard category try getting product category
        if( !$cat ) {
            $cat = get_term_by( 'slug', $slug, 'product_cat' );
        }
        $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);

    } else {
        // Get post and image ID
        $post_id = url_to_postid( $item->url );
        $thumb_id = get_post_thumbnail_id( $post_id );
    }

    if( !empty($thumb_id) ) {
        // Make the title just be the featured image.
        //$item->title = wp_get_attachment_image( $thumb_id, 'poster');

        // Display image + title example
         $item->title = wp_get_attachment_image( $thumb_id, 'poster'). '<br>' . $item->title;
    }
    return $item;
}
// Remove filters
add_filter('wp_nav_menu_items','remove_filter_from_menus', 10, 2);
function remove_filter_from_menus( $nav, $args ) {
    remove_filter( 'wp_setup_nav_menu_item', 'filter_menu_items' );
    return $nav;
}
  
add_filter( 'woocommerce_available_payment_gateways', 'go_explore_unset_gateway_by_category' );
  
function go_explore_unset_gateway_by_category( $available_gateways ) {
    if ( is_admin() ) return $available_gateways;
    if ( ! is_checkout() ) return $available_gateways;
    $unset = false;
    $category_id = 21; // TARGET CATEGORY
    foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
        $terms = get_the_terms( $values['product_id'], 'product_cat' );    
        foreach ( $terms as $term ) {        
            if ( $term->term_id == $category_id ) {
                $unset = true; // CATEGORY IS IN THE CART
                break;
            }
        }
    }
    if ( $unset == true ) unset( $available_gateways['woocommerce_payments'] ); // DISABLE COD IF CATEGORY IS IN THE CART
    return $available_gateways;
}

add_action( 'woocommerce_order_status_processing', 'custom_autocomplete_order' );
function custom_autocomplete_order( $order_id ) {
if ( ! $order_id ) {
return;
}
$order = wc_get_order( $order_id );
$order->update_status( 'completed' );
}

//shortcodes
//homepage header image randomizer
function go_explore_random_img_func() {
	ob_start(); ?>
	<script>
	(function(){
	const imgArray = ["<?php the_field('header_image_one'); ?>", "<?php the_field('header_image_two'); ?>", "<?php the_field('header_image_three'); ?>"];
	const siteBannerElement = document.querySelector("#randomImg");
	const randomImgValue = Math.floor(Math.random() * imgArray.length);
	const randomImgSrc = siteBannerElement.src = imgArray[randomImgValue];
	})();
	</script>
	<?php 
	return ob_get_clean();
	}
	
	add_shortcode('go_explore_random_img', 'go_explore_random_img_func');