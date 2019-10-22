<?php

/*
	Template Name: Home Page
*/


if( is_user_logged_in() ){
	get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<!-- https://codepen.io/jeffglenn/pen/KNYoKa/ -->
		<section id="timeline">

			<?php
				$args = array(
					'posts_per_page' => 4,
					'start_date' => 'now',
				);
				$events = tribe_get_events($args);
				foreach( $events as $event ){ ?>
					<div class="tl-item">
						<div class="tl-bg" style="background-image: url(<?php echo get_the_post_thumbnail_url($event->ID); ?>)"></div>
						<a href="<?php echo $event->guid; ?>">
							<div class="tl-year">
								<h2><?php echo $event->post_title; ?></h2>
								<p class="f2 heading--sanSerif"><?php echo date( "M  d  Y", strtotime($event->event_date) ); ?></p>
							</div>
							<div class="tl-content">
								<p><?php echo $event->post_excerpt; ?></p>
							</div>
						</a>
					</div>
				<?php } ?>

		</section>
		<?php
			if (have_posts()){
				while (have_posts()){

					the_post();
					the_content();

				}
			}
		?>

<?php }else{ ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">
		<style>
			* {
				background-color: darkgrey;
			}
			body {
				display: flex;
				flex-direction: column;
				justify-content: space-around;
				text-align: center;
				padding-top: 20%;
			}
			.place-hold {
				display: flex;
				flex-direction: column;
				margin: auto auto;
			}
		</style>
		<div class="place-hold">
			<h1>Currently Under Construction</h1>
			<h4>Please Log in to view website</h4>
		</div>
<?php } ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>