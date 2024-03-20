<?php
//Nav layout for activity options


if(is_shop() || is_product_category() || is_product_tag()) {
?>

<div class="activity-banner">	
<div class="container">
					<div class="row">
								<div class="col-12 my-2">
                  <p class="text-center">Filter by Activity Type</p>
                  <nav class="main-menu activity navbar navbar-expand-md navbar-light d-block text-center" role="navigation">
                    <?php

                  wp_nav_menu( array(
                    'theme_location'    => 'go_explore_activity_menu',
                    'depth'             => 1,
                    'container'         => 'div',
                    'container_class'   => '',
                    'container_id'      => 'bs-example-navbar-collapse-1',
                    'menu_class'        => 'activity-menu'
                  ) );
                  ?>		
                  </nav>	
              </div>
          </div>
  </div>
  </div>
 <?php }
