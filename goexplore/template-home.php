<?php 

/*
Template Name: Home Page
*/

get_header(); ?>

		<div class="content-area">
			<main>
				<section class="slider">
					<div class="flexslider">
					  <ul class="slides">
              <?php 
              
              for($i=1; $i < 4; $i++) :
                $slider_page[$i]        = get_theme_mod('set_slider_page' . $i );
                $slider_button_text[$i] = get_theme_mod('set_slider_button_text' . $i);
                $slider_button_url[$i]  = get_theme_mod('set_slider_button_url' . $i);
              endfor;

              $args = array(
                'post_type'       => 'page',
                'posts_per_page'  => 3,
                'post__in'        => $slider_page,
                'orderby'         => 'post__in'
              );

              $slider_loop = new Wp_Query($args);
              $j = 1;

              if($slider_loop->have_posts()):
                while($slider_loop->have_posts()):
                  $slider_loop->the_post();

              ?>
					    <li>
					      <?php the_post_thumbnail('go-explore-slider', array('class' => 'img-fluid slider-1', 'id' => 'randomImg')); ?>
                <div class="container">
                <div class="slider-details-container">
                  <div class="slider-title">
                    <h1><?php the_title(); ?></h1>
                  </div>
                  <div class="slider-description">
                    <div class="subtitle"><?php the_content(); ?></div>
                    <a href="<?php echo $slider_button_url[$j]; ?>" class="link"><?php echo $slider_button_text[$j]; ?></a>
                  </div>
                </div>  
                
                </div>
					    </li> 
              <?php
              $j++;
              endwhile;
              wp_reset_postdata();
            endif;
              ?>
					  </ul>
					</div>
				</section>
        <div class="gift-section pt-4">
        <section class="container pb-4">
          <div class="row">
            <div class="col-12 text-center">
              <h2 class="hw-text"><strong>How it <span class="color-teal">works</span></strong></h2>
              <h3><strong>To give</strong> a gift card:</h3>
            </div>
            <div class="col-lg-4 col-12 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_gift_card_image_1'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>1.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_gift_card_1') ); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_gift_card_image_2'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>2.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_gift_card_2') ); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_gift_card_image_3'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>3.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_gift_card_3') ); ?></p>
                </div>
              </div>
            </div>
            </div>
        </section>
          </div>
        <div class="redeem-section">
            <section class="container py-4">
          <div class="row">
            <div class="col-12 text-center">
              <h3><strong>To redeem</strong> a gift card:</h3>
            </div>
            <div class="col-lg-3 col-6 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_redeem_image_1'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>1.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_redeem_1') ); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_redeem_image_2'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>2.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_redeem_2') ); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_redeem_image_3'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>3.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_redeem_3') ); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6 text-center">
              <div class="row">
                <div class="col-12 py-3 desc-icons">
                  <img src="<?php the_field('how_to_redeem_image_4'); ?>" />
                </div>
                <div class="col-12">
                  <p class="desc-number"><strong>4.</strong></p>
                </div>
                <div class="col-12">
                  <p class="desc-text"><?php  esc_html( the_field('how_to_redeem_4') ); ?></p>
                </div>
              </div>
            </div>
          </div>
        </section>
        </div>
        <div class="about-section">
        <section class="container py-4">
          <div class="row">
              <div class="col-12 col-lg-8 text-center">
              <h2>About us</h2>
              <p><?php  esc_html( the_field('about_us') ); ?></p>
            </div>
                <div class="col-6 col-lg-2 about-img-1">
                  <img src="<?php the_field('about_us_image_1'); ?>" />
                </div>
                <div class="col-6 col-lg-2 about-img-2">
                  <img src="<?php the_field('about_us_image_2'); ?>" />
                </div>
          </div>
        </section>
        </div>
        <section class="container py-4">
          <div class="row">
            <div class="col-12">
            <h2 class="text-center py-3">Go explore <span class="color-teal">near you</span></h2>
              <?php 
              $map = ( get_field('map') );
             echo do_shortcode($map);
           ?>
            </div>
          </div>
        </section>
			</main>
		</div>
<?php get_footer(); ?>