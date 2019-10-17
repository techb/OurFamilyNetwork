<?php

/*
	Template Name: Home Page
*/


if( is_user_logged_in() ){
	get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
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
			/* header, footer {
				display: none;
			} */
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