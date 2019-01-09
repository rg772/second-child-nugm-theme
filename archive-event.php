<?php
/**
 * The template for displaying lists of events
 *
 * Queries to do with events will default to this template if a more appropriate template cannot be found
 *
 ***************** NOTICE: *****************
 *  Do not make changes to this file. Any changes made to this file
 * will be overwritten if the plug-in is updated.
 *
 * To overwrite this template with your own, make a copy of it (with the same name)
 * in your theme directory.
 *
 * WordPress will automatically prioritise the template in your theme directory.
 ***************** NOTICE: *****************
 *
 * @package Event Organiser (plug-in)
 * @since 1.0.0
 */

//Call the template header
get_header(); ?>

<main id="main-content" tabindex="-1" class="content socEvent " role="main" >

	<!-- Page header-->
	<div class="page-header">
		<h2 class="page-title">
		<?php
		if ( eo_is_event_archive( 'day' ) ) {
			//Viewing date archive
			echo __( '<span class="performanceHeader">Events</span> ','eventorganiser' ) . ' <br /> ' . eo_get_event_archive_date( 'F j, Y' );
		} elseif ( eo_is_event_archive( 'month' ) ) {
			//Viewing month archive
			echo __( '<span class="performanceHeader">Events</span> ','eventorganiser' ) . ' <br /> ' . eo_get_event_archive_date( 'F Y' );
		} elseif ( eo_is_event_archive( 'year' ) ) {
			//Viewing year archive
			echo __( '<span class="performanceHeader">Events</span> ','eventorganiser' ) . ' <br /> ' . eo_get_event_archive_date( 'Y' );
		} else {
			_e( '<span class="performanceHeader">Events</span> ', 'eventorganiser' );
		}
		?>
		</h2>
	</div>

	<?php eo_get_template_part( 'eo-loop-events' ); //Lists the events ?>

</main><!-- #primary -->

<!-- Call template sidebar and footer -->
<?php get_sidebar(); ?>
<?php get_footer();
