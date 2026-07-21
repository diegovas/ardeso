<?php
/**
 * Title: Pie de página de contacto
 * Slug: ardeso-fse/contact-footer
 * Categories: ardeso-sections
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"footer","className":"ardeso-footer ardeso-site-shell","layout":{"type":"constrained","wideSize":"1480px"}} -->
<footer class="wp-block-group ardeso-footer ardeso-site-shell">
	<!-- wp:heading {"level":2,"className":"ardeso-section-title"} -->
	<h2 class="wp-block-heading ardeso-section-title">CONTÁCTANOS</h2>
	<!-- /wp:heading -->
	<!-- wp:columns {"className":"ardeso-contact-grid"} -->
	<div class="wp-block-columns ardeso-contact-grid">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"width":"246px","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo-ardeso.svg' ) ); ?>" alt="Ardeso Marketing y Publicidad" style="width:246px"/></figure>
			<!-- /wp:image -->
			<!-- wp:paragraph {"className":"ardeso-text"} -->
			<p class="ardeso-text">Síguenos en nuestras redes sociales y no te pierdas de nuestro más reciente contenido.</p>
			<!-- /wp:paragraph -->
			<!-- wp:group {"className":"ardeso-socials","layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group ardeso-socials">
				<!-- wp:paragraph --><p><a href="#">f</a></p><!-- /wp:paragraph -->
				<!-- wp:paragraph --><p><a href="#">ig</a></p><!-- /wp:paragraph -->
				<!-- wp:paragraph --><p><a href="#">tk</a></p><!-- /wp:paragraph -->
				<!-- wp:paragraph --><p><a href="#">▶</a></p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:paragraph {"className":"ardeso-kicker"} -->
			<p class="ardeso-kicker"><a href="https://wa.me/50300000000">Escríbenos en WhatsApp</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
	<!-- wp:html -->
		<form class="ardeso-form-grid" action="#" method="post">
			<p class="ardeso-kicker ardeso-form-field--full">Solicita más información enviándonos un mensaje:</p>
			<div class="ardeso-form-field"><label for="footer-name">Nombre</label><input id="footer-name" name="name" type="text"></div>
			<div class="ardeso-form-field"><label for="footer-lastname">Apellido</label><input id="footer-lastname" name="lastname" type="text"></div>
			<div class="ardeso-form-field"><label for="footer-email">Email *</label><input id="footer-email" name="email" type="email"></div>
			<div class="ardeso-form-field"><label for="footer-phone">Teléfono</label><input id="footer-phone" name="phone" type="tel" value="+503"></div>
			<div class="ardeso-form-field"><label for="footer-message">Mensaje</label><textarea id="footer-message" name="message"></textarea></div>
			<div class="ardeso-form-field" style="align-self:end;"><button type="submit">Enviar</button></div>
		</form>
	<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- wp:paragraph {"align":"right","className":"ardeso-copyright"} -->
	<p class="has-text-align-right ardeso-copyright">© 2026 by ardeso</p>
	<!-- /wp:paragraph -->
</footer>
<!-- /wp:group -->
