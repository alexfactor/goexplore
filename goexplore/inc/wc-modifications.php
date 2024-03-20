<?php
/**
 * Template Overrides for WooCommerce pages
 * 
 * @link https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/#section-3
 * 
 * @package Go Explore
 */


function go_explore_wc_modify(){
/** Archive Product */
add_action( 'woocommerce_before_main_content', 'go_explore_open_container_row', 5);
 function go_explore_open_container_row(){
  echo '<div class="shop-background"><div class="container shop-content"><div class="row">';
 }
 add_action('woocommerce_after_main_content', 'go_explore_close_container_row', 5);
 function go_explore_close_container_row(){
  echo '</div></div></div>';
 }

 /**add_action( 'woocommerce_before_shop_loop_item', 'go_explore_open_container_row', 5);
 function go_explore_open_shop_item(){
  echo '<div class="shop-item">';
 }
 add_action('woocommerce_after_shop_loop_item', 'go_explore_close_container_row', 5);
 function go_explore_close_shop_item(){
  echo '</div>';
 }**/

 remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar');

if( is_product() ){

/*add_action('woocommerce_single_product_summary', 'the_excerpt', 6);*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6);

}

add_action( 'woocommerce_before_main_content', 'go_explore_add_shop_tags', 9);
function go_explore_add_shop_tags() {
  if(is_shop() || is_product_category() || is_product_tag()) {
  echo '<div class="col-12">';
  echo do_shortcode('[searchandfilter id="primary_product_filter"]');
} else {
  echo '<div class="col">';
}
}
add_action( 'woocommerce_after_main_content', 'go_explore_close_shop_tags', 4);
function go_explore_close_shop_tags() {
  echo '</div>';
}
if(is_shop() || is_product_category() || is_product_tag() || is_product()) {
add_action( 'woocommerce_after_shop_loop_item_title', 'go_explore_add_location', 1);
function go_explore_add_location() {
  $location = esc_html( get_field('experience_city_state') );
  echo '<p class="location">' . $location . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'go_explore_add_location_product', 5);
function go_explore_add_location_product() {
  $address_product = esc_html( get_field('experience_address') );
  $city_state_product = esc_html( get_field('experience_city_state') );
  $zip_product = esc_html( get_field('experience_zip_code') );
  echo '<p class="location">' . $address_product . '<br>' . $city_state_product . ' ' . $zip_product . '</p>';
}
}
if(is_shop() || is_product_category() || is_product_tag()) {
  add_action( 'woocommerce_after_main_content', 'go_explore_more_experiences_coming', 5);
  function go_explore_more_experiences_coming() {
    echo '<span class="col"><h3 class="text-center">Check back frequently as we are always adding new experiences!</h3></span>';
  }
  }
// Enforce single parent category items in cart at a time based on first item in cart
function get_product_top_level_category ( $product_id ) {

  $product_terms            =  get_the_terms ( $product_id, 'product_cat' );
  $product_category_term    =  $product_terms[0];
  $product_category_parent  =  $product_terms[0]->parent;

  while ( $product_category_parent  !=  0 ) {
          $product_category_term    =  get_term($product_category_parent, 'product_cat' );
          $product_category_parent  =  $product_category_term->parent;
  }

  return $product_category_term;

}

add_filter ( 'woocommerce_before_cart', 'restrict_cart_to_single_category' );
function restrict_cart_to_single_category() {
      global $woocommerce;
      $cart_contents    =  $woocommerce->cart->get_cart( );
      $cart_item_keys   =  array_keys ( $cart_contents );
      $cart_item_count  =  count ( $cart_item_keys );

      // Do nothing if the cart is empty
      // Do nothing if the cart only has one item
      if ( ! $cart_contents || $cart_item_count == 1 ) {
              return null;
      }

      // Multiple Items in cart
      $first_item                    =  $cart_item_keys[0];
      $first_item_id                 =  $cart_contents[$first_item]['product_id'];
      $first_item_top_category       =  get_product_top_level_category ( $first_item_id );
      $first_item_top_category_term  =  get_term ( $first_item_top_category, 'product_cat' );
      $first_item_top_category_name  =  $first_item_top_category_term->name;

      // Now we check each subsequent items top-level parent category
      foreach ( $cart_item_keys as $key ) {
              if ( $key  ==  $first_item ) {
                      continue;
              }
              else {
                      $product_id            =  $cart_contents[$key]['product_id'];
                      $product_top_category  =  get_product_top_level_category( $product_id );

                      if ( $product_top_category  !=  $first_item_top_category ) {
                              $woocommerce->cart->set_quantity ( $key, 0, true );
                              $mismatched_categories  =  1;
                      }
              }
      }

      // we really only want to display this message once for anyone, including those that have carts already prefilled
      if ( isset ( $mismatched_categories ) ) {
              echo '<p class="woocommerce-error">Only one category allowed in cart at a time.<br />You are currently allowed only <strong>'.$first_item_top_category_name.'</strong> items in your cart.<br />To order a different category empty your cart first.</p>';
      }
}

}
add_action('wp', 'go_explore_wc_modify');