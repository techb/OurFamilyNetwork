<?php

/*
	Template Name: Home Page
*/

get_header();

if( is_user_logged_in() ){
	$args = array(
		'posts_per_page' => 4,
		'start_date' => date('Y-m-d', strtotime("last month")),
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'post_tag',
				'field' => 'id',
				'terms' => [4],
				'operator' => 'NOT IN'
			),
		),
	);
	$events = tribe_get_events($args);
}else{
	$args = array(
		'posts_per_page' => 4,
		'tag' => 'public'
	);
}
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="featured-content">
				<div class="featured-content-img">
					<img class="featured-content-img-single"
						src="<?php echo get_field('featured_content_img') ?>"
					/>
				</div>
				<div class="featured-content-copy">
					<p><?php echo get_field("featured_content_copy"); ?></p>
				</div>
			</div>

			<!-- https://codepen.io/jeffglenn/pen/KNYoKa/ -->
			<section id="timeline" class="desktop">
				<?php
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
									<p><?php echo empty($event->post_excerpt) ? wp_trim_words($event->post_content, 45, '...') : $event->post_excerpt; ?></p>
									<?php //var_dumpp($event); ?>
								</div>
							</a>
						</div>
					<?php } ?>
			</section>

			<section id="mobile-timeline" class="mobile">
				<?php
					$events = tribe_get_events($args);
					foreach( $events as $event ){ ?>
						<a href="<?php echo $event->guid; ?>">
							<div class="mobile-item" style="background-image: url(<?php echo get_the_post_thumbnail_url($event->ID); ?>)">
								<div class="mobile-year">
									<div class="dark-overlay">
										<h2 class="mobile-event-title"><?php echo $event->post_title; ?></h2>
										<p class="f2 heading--sanSerif"><?php echo date( "M  d  Y", strtotime($event->event_date) ); ?></p>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>
			</section>

			<section id="user-content">
				<?php
					if (have_posts()){
						while (have_posts()){
							the_post();
							the_content();
						}
					}
				?>
			</section>

<?php edit_post_link(); get_footer(); ?>