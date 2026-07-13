<?php
/**
 * Ardeso FSE functions.
 *
 * @package ArdesoFSE
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ardeso_fse_setup' ) ) {
	/**
	 * Set up theme defaults.
	 */
	function ardeso_fse_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo', array(
			'height'      => 86,
			'width'       => 246,
			'flex-height' => true,
			'flex-width'  => true,
		) );

		add_editor_style( 'style.css' );
	}
}
add_action( 'after_setup_theme', 'ardeso_fse_setup' );

/**
 * Enqueue front-end styles.
 */
function ardeso_fse_enqueue_styles() {
	wp_enqueue_style(
		'ardeso-fse-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'ardeso-fse-theme',
		get_theme_file_uri( 'assets/js/ardeso-theme.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ardeso_fse_enqueue_styles' );

/**
 * Register block pattern categories.
 */
function ardeso_fse_register_pattern_categories() {
	register_block_pattern_category(
		'ardeso-pages',
		array( 'label' => __( 'Ardeso - Páginas', 'ardeso-fse' ) )
	);

	register_block_pattern_category(
		'ardeso-sections',
		array( 'label' => __( 'Ardeso - Secciones', 'ardeso-fse' ) )
	);

	register_block_pattern_category(
		'ardeso-components',
		array( 'label' => __( 'Ardeso - Componentes editables', 'ardeso-fse' ) )
	);
}
add_action( 'init', 'ardeso_fse_register_pattern_categories' );

/**
 * Register block styles that let editors hide/show content without deleting it.
 */
function ardeso_fse_register_visibility_styles() {
	$blocks = array(
		'core/buttons',
		'core/button',
		'core/column',
		'core/columns',
		'core/cover',
		'core/details',
		'core/group',
		'core/heading',
		'core/html',
		'core/image',
		'core/media-text',
		'core/navigation',
		'core/paragraph',
		'core/site-logo',
	);

	$styles = array(
		'ardeso-hidden'       => __( 'Oculto', 'ardeso-fse' ),
		'ardeso-desktop-only' => __( 'Solo desktop', 'ardeso-fse' ),
		'ardeso-mobile-only'  => __( 'Solo móvil', 'ardeso-fse' ),
	);

	foreach ( $blocks as $block ) {
		foreach ( $styles as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'ardeso_fse_register_visibility_styles' );

/**
 * Map empty editable pages to their original starter pattern on the front end.
 *
 * This keeps the current site from going blank after templates move to
 * post-content, while allowing editors to replace the fallback by saving any
 * content from the page editor.
 *
 * @return array<string,string>
 */
function ardeso_fse_page_pattern_fallbacks() {
	return array(
		'contacto'        => 'ardeso-fse/contact-page',
		'nosotros'        => 'ardeso-fse/about-page',
		'nuestro-trabajo' => 'ardeso-fse/work-page',
		'servicios'       => 'ardeso-fse/services-page',
	);
}

/**
 * Provide starter block content for pages that are still empty.
 *
 * @param string $content Page content.
 * @return string
 */
function ardeso_fse_empty_page_pattern_fallback( $content ) {
	if ( is_admin() || ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$raw_content = get_post_field( 'post_content', get_the_ID() );

	if ( '' !== trim( (string) $raw_content ) ) {
		return $content;
	}

	$pattern_slug = '';

	if ( is_front_page() ) {
		$pattern_slug = 'ardeso-fse/home-page';
	} else {
		$page_slug = get_post_field( 'post_name', get_the_ID() );
		$fallbacks = ardeso_fse_page_pattern_fallbacks();

		if ( isset( $fallbacks[ $page_slug ] ) ) {
			$pattern_slug = $fallbacks[ $page_slug ];
		}
	}

	if ( ! $pattern_slug ) {
		return $content;
	}

	$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( $pattern_slug );

	return isset( $pattern['content'] ) ? $pattern['content'] : $content;
}
add_filter( 'the_content', 'ardeso_fse_empty_page_pattern_fallback', 8 );

/**
 * Seed empty key pages with editable block content once inside wp-admin.
 *
 * Existing edited content is never overwritten. The frontend fallback above
 * covers public rendering until this seed has a chance to run.
 */
function ardeso_fse_seed_editable_page_content() {
	if ( ! is_admin() || ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$seed_version = '1.0.5';

	if ( $seed_version === get_option( 'ardeso_fse_editable_content_seeded_version' ) ) {
		return;
	}

	$page_patterns = array();
	$front_page_id = (int) get_option( 'page_on_front' );

	if ( $front_page_id > 0 ) {
		$page_patterns[ $front_page_id ] = 'ardeso-fse/home-page';
	}

	foreach ( ardeso_fse_page_pattern_fallbacks() as $page_slug => $pattern_slug ) {
		$page = get_page_by_path( $page_slug );

		if ( $page instanceof WP_Post ) {
			$page_patterns[ (int) $page->ID ] = $pattern_slug;
		}
	}

	foreach ( $page_patterns as $page_id => $pattern_slug ) {
		if ( ! current_user_can( 'edit_post', $page_id ) ) {
			continue;
		}

		$current_content = get_post_field( 'post_content', $page_id );

		if ( '' !== trim( (string) $current_content ) ) {
			continue;
		}

		$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( $pattern_slug );

		if ( empty( $pattern['content'] ) ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => $pattern['content'],
			)
		);
	}

	update_option( 'ardeso_fse_editable_content_seeded_version', $seed_version, false );
}
add_action( 'admin_init', 'ardeso_fse_seed_editable_page_content' );

/**
 * Default logo fallback for a fresh installation.
 *
 * @param string $html Logo HTML.
 * @return string
 */
function ardeso_fse_default_logo( $html ) {
	if ( ! empty( $html ) ) {
		return $html;
	}

	return sprintf(
		'<a href="%1$s" class="custom-logo-link" rel="home"><img src="%2$s" class="custom-logo" alt="%3$s" width="246" height="86" /></a>',
		esc_url( home_url( '/' ) ),
		esc_url( get_theme_file_uri( 'assets/images/logo-ardeso.svg' ) ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}
add_filter( 'get_custom_logo', 'ardeso_fse_default_logo' );
