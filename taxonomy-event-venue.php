<?php
/**
 * The template for displaying the venue page
 *
 ***************** NOTICE: *****************
 *  Do not make changes to this file. Any changes made to this file
 * will be overwritten if the plug-in is updated.
 *
 * To overwrite this template with your own, make a copy of it (with the same name)
 * in your theme directory. See http://docs.wp-event-organiser.com/theme-integration for more information
 *
 * WordPress will automatically prioritise the template in your theme directory.
 ***************** NOTICE: *****************
 *
 * @package Event Organiser (plug-in)
 * @since 1.0.0
 */

//Call the template header
get_header(); ?>

<main id="main-content" tabindex="-1" class="content socEvent" role="main" >


	<!-- Page header, display venue title-->
	<div class="page-header">
		
		<?php $venue_id = get_queried_object_id(); ?>
		
		<h2 class="page-title">
			<?php printf(  '<span>' . eo_get_venue_name( $venue_id ) . '</span>' );?>
		</h2>
	
		<?php
		if ( $venue_description = eo_get_venue_description( $venue_id ) ) {
			echo '<div class="venue-archive-meta">' . $venue_description . '</div>';
		}
		?>

		
	
	</div>
		



</main><!-- #primary -->

<!-- Call template sidebar and footer -->
<?php get_sidebar(); ?>
<?php get_footer();
