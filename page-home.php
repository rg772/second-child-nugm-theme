<?php
/*
 Template Name: Homepage
*/
?>
<?php if(is_front_page()): ?>
	<?php get_header(); ?>

					<main id="main-content" class="m-all t-2of3 d-5of7 cf content-full" role="main">

						<?php get_sidebar('homepage'); ?>

					</main>

<?php endif; ?>



	<?php 
  $page_full_template = file_exists(get_stylesheet_directory() . '/page-full.php') ? get_stylesheet_directory() . '/page-full.php' : get_template_directory() . '/page-full.php';

	include($page_full_template);
  ?>

<?php // get_footer(); ?>

