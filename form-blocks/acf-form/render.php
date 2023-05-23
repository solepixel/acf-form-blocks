<?php
/**
 * Form Block: ACF Form
 *
 * @package ACFFormBlocks
 */

$form = get_field( 'form' );

if ( ! $form ) {
	if ( is_admin() ) {
		printf( '<p style="text-align: center;">%s</p>', esc_html__( 'Select a form to see preview.', 'acf-form-blocks' ) );
	}
	return;
}

// TODO: InnerBlocks not rendering in Editor (See README).
?>
<section <?php acf_form_blocks_acf_block_attr( $block ); ?>>
	<?php if ( is_admin() ) : ?>
		<p style="text-align: center;">
			<?php esc_html_e( 'Form:', 'acf-form-blocks' ); ?>
			<?php echo get_the_title( $form->ID ); ?>
		</p>
	<?php else : ?>
		<?php echo apply_filters( 'the_content', $form->post_content ); ?>
	<?php endif; ?>
</section>
