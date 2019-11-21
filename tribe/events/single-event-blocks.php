<?php
/**
 * Single Event Template
 *
 * A single event complete template, divided in smaller template parts.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/single-event-blocks.php
 *
 * See more documentation about our Blocks Editor templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 4.7
 *
 */

$event_id = $this->get( 'post_id' );

$tags = get_the_tags($event_id);
$post_tags = array();
foreach( $tags as $tag ){
	$post_tags[] = $tag->slug;
}

$is_recurring = '';

if ( ! empty( $event_id ) && function_exists( 'tribe_is_recurring_event' ) ) {
	$is_recurring = tribe_is_recurring_event( $event_id );
}
?>

<style>
	.tribe-block__organizer__details a,
	.tribe-block__organizer__details a p,
	.tribe-block__venue a,
	.tribe-block__venue__phone {
		color: #009fd4 !important;
	}
</style>
<?php if( is_user_logged_in() || in_array('demo', $post_tags) ){ ?>

	<div id="tribe-events-content" class="tribe-events-single tribe-blocks-editor">
		<?php $this->template( 'single-event/back-link' ); ?>
		<?php $this->template( 'single-event/notices' ); ?>
		<?php $this->template( 'single-event/title' ); ?>
		<?php if ( $is_recurring ) { ?>
			<?php $this->template( 'single-event/recurring-description' ); ?>
		<?php } ?>
		<?php $this->template( 'single-event/content' ); ?>
		<?php $this->template( 'single-event/comments' ); ?>
		<?php $this->template( 'single-event/footer' ); ?>
	</div>

<?php }else{ ?>
	<script>
		jQuery().ready(function(){
			window.location.href='/events/';
		});
	</script>
<?php } ?>

<?php edit_post_link(); ?>

<script>

	const comment_input = document.querySelector("#comment");
	comment_input.placeholder = "Leave a comment";
	comment_input.rows = 3;

	const org_phone = document.querySelector(".tribe-block__organizer__phone");
	if( org_phone ){
		const o_phone = document.createElement('a');
		o_phone.href = 'tel:'+org_phone.innerText;
		wrap(org_phone, o_phone);
	}

	const org_email = document.querySelector(".tribe-block__organizer__email");
	if( org_email ){
		const o_email = document.createElement('a');
		o_email.href = 'mailto:'+org_email.innerText;
		wrap(org_email, o_email);
	}

	const venu_phone = document.querySelector(".tribe-block__venue__phone");
	if( venu_phone ){
		const v_phone = document.createElement('a');
		v_phone.href = 'tel:'+venu_phone.innerText;
		wrap(venu_phone, v_phone);
	}

	jQuery("<hr class='sperate-comment-string' />").insertAfter("li.parent");

</script>
