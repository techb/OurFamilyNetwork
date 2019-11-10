
<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<style>
	.hide-me {
		display: none;
	}
</style>

<div id="tribe-events-content" class="tribe-events-single">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

	<div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Items people are bringing -->
			<?php
				$items = json_decode(get_field('bring_it'), true);
				if( !empty($_POST["user_id"]) ){
					if( !isset( $items['all_items'] ) ){
						$items = array('all_items' => array());
					}
					array_pop($_POST);
					$items['all_items'][] = $_POST;
				}
				update_field('bring_it', json_encode($items));
				$user = wp_get_current_user();
				$allowed_roles = array('editor', 'administrator', 'author', 'subscriber');
				if( array_intersect($allowed_roles, $user->roles ) ){ ?>
					<div class="add-a-dish"><i class="fa fa-plus-square"></i><p>Add a dish!</p></div>
					<div class="bring-it">
						<div class="bring-it-content">
						</div>

						<div class="bring-it-add">
							<form id="bring-it-form" class="bring-it-form hide-me"  method="post" action="">
								<ul class="input-container">
									<li id="categroy-container" >
										<label class="description" for="categroy">Category </label>
										<span>
											<input id="element_3_1" name="categroy" class="element radio" type="radio" value="appetizers" />
											<label class="choice" for="element_3_1">Appetizers</label>
											<input id="element_3_2" name="categroy" class="element radio" type="radio" value="main_dish" />
											<label class="choice" for="element_3_2">Main Dishes</label>
											<input id="element_3_3" name="categroy" class="element radio" type="radio" value="desserts" />
											<label class="choice" for="element_3_3">Desserts</label>
											<input id="element_3_4" name="categroy" class="element radio" type="radio" value="beverages" />
											<label class="choice" for="element_3_4">Beverages</label>
										</span>
									</li>

									<ul class="name-desc">
										<li id="dish-name" >
											<label class="description" for="dish_name">Dish Name </label>
											<div>
												<input id="dish_name" name="dish_name" class="element text medium" type="text" maxlength="255" value=""/>
											</div>
										</li>
										<li id="dish-desc" >
											<label class="description" for="short_desc">Short Description </label>
											<div>
												<textarea id="short_desc" name="short_desc" class="element textarea small"></textarea>
											</div>
										</li>
									</ul>

									<ul class="last-section">
										<li id="vegan-section" >
											<label class="description" for="vegan"> </label>
											<span>
												<input id="vegan" name="vegan" class="element checkbox" type="checkbox" value="1" />
												<label class="choice" for="vegan">Vegan</label>
											</span>
										</li>

										<li class="buttons">
											<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
											<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
										</li>
									</ul>
								</ul>
							</form>
						</div>
					</div>
				<?php }
			?>
			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<script>

		window.onload = function(){
			const comment_area = document.querySelector(".comments .comment-respond .comment-form .comment-form-comment textarea");
			comment_area.placeholder = "Leave a reply";

			const add_dish = document.querySelector(".add-a-dish");
			add_dish.addEventListener("click", function(){
				document.querySelector(".bring-it-form").classList.toggle("hide-me");
				document.querySelector(".bring-it-form").classList.toggle("fadeIn");
			});

			// TO-Do: add collapsing comments

		}

	</script>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->