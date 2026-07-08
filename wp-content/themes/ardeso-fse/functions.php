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
}
add_action( 'init', 'ardeso_fse_register_pattern_categories' );

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
