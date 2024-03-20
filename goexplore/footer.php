<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Go Explore
 */

?>
<?php 
/**
 * @package Go Explore
 * Template for the <footer>
 */  ?>
<footer class="site-footer pb-5 px-5">
<div class="container footer-widgets">
    <div class="row">
      <div class="col-12 py-1">
        <?php 
        //Social icons
        ?>
        <section class="footer-widget footer-left">
    <div class="social-icons footer-social">
        <a href="https://www.facebook.com/profile.php?id=61555021378776" title="Facebook" target="_blank" rel="noopener">
            <div class="icon-container facebook" id="facebook">
                <img class="icon" src="/wp-content/themes/goexplore/img/Facebook_Logo_Primary.png" alt="Facebook" width="25px" />
            </div>
        </a>
        <a href="https://twitter.com/GoExploreCO" title="Twitter" target="_blank" rel="noopener">
            <div class="icon-container twitter" id="twitter">
                <img class="icon" src="/wp-content/themes/goexplore/img/logo-black.png" alt="Twitter" width="25px" />
            </div>
        </a>
        <a href="https://www.instagram.com/goexploregiftcards/" title="Instagram" target="_blank" rel="noopener">
            <div class="icon-container instagram" id="instagram">
                <img class="icon" src="/wp-content/themes/goexplore/img/Instagram_Glyph_Gradient.png" alt="Instagram" width="25px" />
            </div>
        </a>
        <a href="https://www.linkedin.com/in/go-explore-8501402a7/" title="LinkedIn" target="_blank" rel="noopener">
            <div class="icon-container linkedin" id="linkedin">
                <img class="icon" src="/wp-content/themes/goexplore/img/LI-In-Bug.png" alt="LinkedIn" width="25px" />
            </div>
        </a>
    </div>
</section>
      </div>
      <div class="col-lg-9 col-12">
        <?php 
        //Left Menus
        ?>
        <section class="footer-widget row">
  <div class="col-lg-4 col-md-6 col-12 pl-4 pt-4">
    <?php
    //Left Menu items
    wp_nav_menu(array(
      'theme_location' => 'go_explore_footer_menu',
      'container_class' => 'menu-footer-container',
      'container' => 'nav',
      'fallback_cb' => false
    ));
    ?>
    </div>
 </section>
      </div>
      <div class="col-12 col-lg-3 pt-4 pt-lg-3">
        <p>Go Explore Gift Cards LLC</p>
        <p>Erie, CO</p>
        <!--<p class="pt-6">© <?php echo date("Y")  ?> </p>-->
      </div>
    </div>
  </div>
</footer>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>