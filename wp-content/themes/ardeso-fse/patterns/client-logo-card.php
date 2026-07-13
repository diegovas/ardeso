<?php
/**
 * Title: Logo de cliente editable
 * Slug: ardeso-fse/client-logo-card
 * Categories: ardeso-components
 * Inserter: true
 */
?>
<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group ardeso-logo-tile">
	<!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} -->
	<figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente" style="width:120px"/></figure>
	<!-- /wp:image -->
	<!-- wp:paragraph -->
	<p>Cliente</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
