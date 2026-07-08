<?php
/**
 * Title: Página de inicio
 * Slug: ardeso-fse/home-page
 * Categories: ardeso-pages
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","className":"ardeso-section ardeso-no-line","layout":{"type":"constrained"}} -->
<section class="wp-block-group ardeso-section ardeso-no-line">
	<!-- wp:heading {"level":1,"className":"ardeso-display"} -->
	<h1 class="wp-block-heading ardeso-display"><strong>Somos Ardeso:</strong><br><span class="ardeso-blue">Una agencia creativa<br>de marketing &amp; publicidad</span></h1>
	<!-- /wp:heading -->
	<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-video.svg' ) ); ?>","alt":"Producción audiovisual en estudio","dimRatio":0,"isUserOverlayColor":true,"minHeight":540,"minHeightUnit":"px","className":"ardeso-hero-media","layout":{"type":"constrained"}} -->
	<div class="wp-block-cover ardeso-hero-media" style="min-height:540px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background" alt="Producción audiovisual en estudio" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-video.svg' ) ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons"><!-- wp:button {"className":"ardeso-play-button"} -->
		<div class="wp-block-button ardeso-play-button"><a class="wp-block-button__link wp-element-button" href="#">▶</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons -->
	</div></div>
	<!-- /wp:cover -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"ardeso-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group ardeso-section">
	<!-- wp:heading {"className":"ardeso-section-title"} -->
	<h2 class="wp-block-heading ardeso-section-title">CONOCE NUESTRO TRABAJO</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"className":"ardeso-label"} -->
	<p class="ardeso-label">Branding</p>
	<!-- /wp:paragraph -->
	<!-- wp:group {"className":"ardeso-work-grid","layout":{"type":"default"}} -->
	<div class="wp-block-group ardeso-work-grid">
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-camera.svg' ) ); ?>" alt="Proyecto de marca 1"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 1</h3><!-- /wp:heading --></div><!-- /wp:group -->
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-video.svg' ) ); ?>" alt="Proyecto de marca 2"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 2</h3><!-- /wp:heading --></div><!-- /wp:group -->
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-branding.svg' ) ); ?>" alt="Proyecto de marca 3"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 3</h3><!-- /wp:heading --></div><!-- /wp:group -->
	</div>
	<!-- /wp:group -->
	<!-- wp:paragraph {"className":"ardeso-label"} -->
	<p class="ardeso-label">Producciones de vídeo</p>
	<!-- /wp:paragraph -->
	<!-- wp:group {"className":"ardeso-work-grid","layout":{"type":"default"}} -->
	<div class="wp-block-group ardeso-work-grid">
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-video.svg' ) ); ?>" alt="Producción 1"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 4</h3><!-- /wp:heading --></div><!-- /wp:group -->
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-camera.svg' ) ); ?>" alt="Producción 2"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 5</h3><!-- /wp:heading --></div><!-- /wp:group -->
		<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ardeso-card-image"} --><figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-social.svg' ) ); ?>" alt="Producción 3"/></figure><!-- /wp:image --><!-- wp:heading {"level":3,"className":"ardeso-card-title"} --><h3 class="wp-block-heading ardeso-card-title">Marca 6</h3><!-- /wp:heading --></div><!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"ardeso-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group ardeso-section">
	<!-- wp:heading {"className":"ardeso-section-title"} -->
	<h2 class="wp-block-heading ardeso-section-title">NUESTROS CLIENTES</h2>
	<!-- /wp:heading -->
	<!-- wp:group {"className":"ardeso-slider-row","layout":{"type":"default"}} -->
	<div class="wp-block-group ardeso-slider-row">
		<!-- wp:paragraph {"className":"ardeso-arrow"} --><p class="ardeso-arrow">‹</p><!-- /wp:paragraph -->
		<!-- wp:group {"className":"ardeso-logo-grid","layout":{"type":"default"}} -->
		<div class="wp-block-group ardeso-logo-grid">
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 1" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 1</p><!-- /wp:paragraph --></div><!-- /wp:group -->
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 2" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 2</p><!-- /wp:paragraph --></div><!-- /wp:group -->
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 3" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 3</p><!-- /wp:paragraph --></div><!-- /wp:group -->
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 4" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 4</p><!-- /wp:paragraph --></div><!-- /wp:group -->
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 5" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 5</p><!-- /wp:paragraph --></div><!-- /wp:group -->
			<!-- wp:group {"className":"ardeso-logo-tile","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} --><div class="wp-block-group ardeso-logo-tile"><!-- wp:image {"width":"120px","sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mark-ardeso.svg' ) ); ?>" alt="Cliente 6" style="width:120px"/></figure><!-- /wp:image --><!-- wp:paragraph --><p>Cliente 6</p><!-- /wp:paragraph --></div><!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<!-- wp:paragraph {"className":"ardeso-arrow"} --><p class="ardeso-arrow">›</p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<!-- wp:paragraph {"className":"ardeso-dots"} --><p class="ardeso-dots">•••</p><!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"ardeso-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group ardeso-section">
	<!-- wp:heading {"className":"ardeso-section-title"} -->
	<h2 class="wp-block-heading ardeso-section-title">NUESTROS SERVICIOS</h2>
	<!-- /wp:heading -->
	<!-- wp:media-text {"mediaPosition":"left","mediaUrl":"<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-branding.svg' ) ); ?>","mediaType":"image","mediaAlt":"Collage de piezas creativas","className":"ardeso-services-split"} -->
	<div class="wp-block-media-text is-stacked-on-mobile ardeso-services-split"><figure class="wp-block-media-text__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/photo-branding.svg' ) ); ?>" alt="Collage de piezas creativas"/></figure><div class="wp-block-media-text__content">
		<!-- wp:details {"showContent":true,"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail" open><summary>Branding</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Estrategia, identidad visual y mensajes para que tu marca sea reconocible y consistente.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
		<!-- wp:details {"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail"><summary>Diseño gráfico</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Piezas digitales e impresas listas para campañas, lanzamientos y comunicación diaria.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
		<!-- wp:details {"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail"><summary>Estrategia de Redes Sociales</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Planificación de contenido, narrativa y pauta para crecer con intención.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
		<!-- wp:details {"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail"><summary>Producción de contenido</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Fotografía, video y recursos creativos alineados a tus objetivos comerciales.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
		<!-- wp:details {"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail"><summary>Planificación estratégica</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Rutas de trabajo claras para campañas, posicionamiento y crecimiento.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
		<!-- wp:details {"className":"ardeso-service-detail"} --><details class="wp-block-details ardeso-service-detail"><summary>Diseño de sitios web</summary><!-- wp:paragraph {"className":"ardeso-text"} --><p class="ardeso-text">Experiencias web editables, rápidas y pensadas para convertir.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
	</div></div>
	<!-- /wp:media-text -->
</section>
<!-- /wp:group -->
