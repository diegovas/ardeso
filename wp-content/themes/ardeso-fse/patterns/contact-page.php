<?php
/**
 * Title: Página de contacto
 * Slug: ardeso-fse/contact-page
 * Categories: ardeso-pages
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","className":"ardeso-section ardeso-no-line","layout":{"type":"constrained"}} -->
<section class="wp-block-group ardeso-section ardeso-no-line">
	<!-- wp:heading {"level":1,"className":"ardeso-display"} -->
	<h1 class="wp-block-heading ardeso-display"><strong>Agendemos una reunión</strong><br><span class="ardeso-blue">y hablemos sobre tu proyecto</span></h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"className":"ardeso-text ardeso-contact-intro"} -->
	<p class="ardeso-text ardeso-contact-intro">Queremos conocerte mejor y hablar sobre las necesidades de tu negocio o proyecto, por lo cual te ofrecemos realizar una sesión de 30-40 minutos la cual nos servirá de base para proporcionarte una solución personalizada.</p>
	<!-- /wp:paragraph -->
	<!-- wp:html -->
	<form class="ardeso-meeting-form" action="#" method="post" style="margin-top:76px;">
		<div class="ardeso-form-field"><label for="meeting-name">Nombre y apellido*</label><input id="meeting-name" name="name" type="text" required></div>
		<div class="ardeso-form-field"><label for="meeting-email">Correo electrónico*</label><input id="meeting-email" name="email" type="email" required></div>
		<div class="ardeso-form-field"><label for="meeting-phone">Número de teléfono</label><input id="meeting-phone" name="phone" type="tel" value="+503"></div>
		<div class="ardeso-form-field"><label for="meeting-service">¿Cuál de nuestros servicios te interesa?*</label><input id="meeting-service" name="service" type="text" required></div>
		<div class="ardeso-form-field"><label for="meeting-place">¿De dónde eres?</label><input id="meeting-place" name="place" type="text"></div>
		<div class="ardeso-form-field"><label for="meeting-source">¿Por cuál medio te enteraste de nosotros?*</label><input id="meeting-source" name="source" type="text" required></div>
		<button class="ardeso-button" type="submit" style="font-size:clamp(1.2rem,1rem + .8vw,1.8rem); margin-top:42px; min-height:58px;">Enviar</button>
	</form>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
