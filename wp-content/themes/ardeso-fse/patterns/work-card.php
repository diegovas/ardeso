<?php
/**
 * Title: Card de trabajo editable
 * Slug: ardeso-fse/work-card
 * Categories: ardeso-components
 * Inserter: true
 */
?>
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
	<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} -->
	<figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-camera.svg' ) ); ?>" alt="Proyecto"/></figure>
	<!-- /wp:image -->
	<!-- wp:heading {"level":3,"className":"ardeso-card-title"} -->
	<h3 class="wp-block-heading ardeso-card-title">Nombre del proyecto</h3>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->
