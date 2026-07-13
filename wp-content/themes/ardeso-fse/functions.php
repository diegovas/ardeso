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
		add_theme_support( 'customize-selective-refresh-widgets' );
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

function ardeso_fse_asset_url( $path ) {
	return esc_url( get_theme_file_uri( ltrim( $path, '/' ) ) );
}

function ardeso_fse_theme_mod_text( $setting, $default ) {
	$value = get_theme_mod( $setting, $default );

	return '' !== trim( (string) $value ) ? $value : $default;
}

function ardeso_fse_theme_mod_bool( $setting, $default = false ) {
	return (bool) get_theme_mod( $setting, $default ? 1 : 0 );
}

function ardeso_fse_theme_mod_image( $setting, $default ) {
	$value = get_theme_mod( $setting, $default );

	return $value ? esc_url( $value ) : esc_url( $default );
}

function ardeso_fse_theme_mod_url( $setting, $default = '' ) {
	$value = get_theme_mod( $setting, $default );
	$value = is_string( $value ) ? trim( $value ) : '';

	return '' !== $value ? esc_url( $value ) : esc_url( $default );
}

function ardeso_fse_sanitize_checkbox( $checked ) {
	return ! empty( $checked ) ? 1 : 0;
}

function ardeso_fse_sanitize_count( $value ) {
	return max( 0, min( 12, absint( $value ) ) );
}

function ardeso_fse_visible_items( $items ) {
	return array_values( array_filter(
		(array) $items,
		static function ( $item ) {
			return ! isset( $item['enabled'] ) || ! empty( $item['enabled'] );
		}
	) );
}

function ardeso_fse_customize_add_text_control( $wp_customize, $setting, $section, $label, $default, $type = 'text', $priority = 10 ) {
	$wp_customize->add_setting( $setting, array(
		'default'           => $default,
		'sanitize_callback' => 'textarea' === $type ? 'sanitize_textarea_field' : 'sanitize_text_field',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( $setting, array(
		'label'    => $label,
		'section'  => $section,
		'type'     => $type,
		'priority' => $priority,
	) );
}

function ardeso_fse_customize_add_checkbox_control( $wp_customize, $setting, $section, $label, $default = true, $priority = 10 ) {
	$wp_customize->add_setting( $setting, array(
		'default'           => $default ? 1 : 0,
		'sanitize_callback' => 'ardeso_fse_sanitize_checkbox',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( $setting, array(
		'label'    => $label,
		'section'  => $section,
		'type'     => 'checkbox',
		'priority' => $priority,
	) );
}

function ardeso_fse_customize_add_image_control( $wp_customize, $setting, $section, $label, $default, $priority = 10 ) {
	$wp_customize->add_setting( $setting, array(
		'default'           => $default,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		$setting,
		array(
			'label'    => $label,
			'section'  => $section,
			'settings' => $setting,
			'priority' => $priority,
		)
	) );
}

function ardeso_fse_customize_add_url_control( $wp_customize, $setting, $section, $label, $default, $priority = 10 ) {
	$wp_customize->add_setting( $setting, array(
		'default'           => $default,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( $setting, array(
		'label'    => $label,
		'section'  => $section,
		'type'     => 'url',
		'priority' => $priority,
	) );
}

function ardeso_fse_customize_add_count_control( $wp_customize, $setting, $section, $label, $default, $priority = 10 ) {
	$wp_customize->add_setting( $setting, array(
		'default'           => $default,
		'sanitize_callback' => 'ardeso_fse_sanitize_count',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( $setting, array(
		'input_attrs' => array(
			'max'  => 12,
			'min'  => 0,
			'step' => 1,
		),
		'label'       => $label,
		'section'     => $section,
		'type'        => 'number',
		'priority'    => $priority,
	) );
}

function ardeso_fse_customizer_defaults() {
	return array(
		'home'     => array(
			'hero_enabled'          => true,
			'hero_title'            => 'Somos Ardeso:',
			'hero_title_highlight'  => 'Una agencia creativa de marketing & publicidad',
			'hero_image'            => ardeso_fse_asset_url( 'assets/images/photo-video.svg' ),
			'hero_image_alt'        => 'Producción audiovisual en estudio',
			'hero_button_enabled'   => true,
			'hero_button_label'     => '▶',
			'hero_button_url'       => '#',
			'work_enabled'          => true,
			'work_title'            => 'CONOCE NUESTRO TRABAJO',
			'branding_label'        => 'Branding',
			'branding_count'        => 3,
			'video_label'           => 'Producciones de vídeo',
			'video_count'           => 3,
			'clients_enabled'       => true,
			'clients_title'         => 'NUESTROS CLIENTES',
			'clients_count'         => 6,
			'services_enabled'      => true,
			'services_title'        => 'NUESTROS SERVICIOS',
			'services_image'        => ardeso_fse_asset_url( 'assets/images/photo-branding.svg' ),
			'services_image_alt'    => 'Collage de piezas creativas',
			'services_count'        => 6,
		),
		'about'    => array(
			'gallery_enabled' => true,
			'gallery_count'   => 3,
			'intro_enabled'   => true,
			'intro_title'     => 'SOBRE NOSOTROS',
			'intro_heading'   => 'Movemos marcas hacia lo más alto',
			'intro_text'      => 'Somos una agencia creativa de marketing y publicidad. Acompañamos a marcas que quieren verse mejor, comunicar con intención y convertir ideas en experiencias memorables.',
			'team_enabled'    => true,
			'team_title'      => 'NUESTRO EQUIPO',
			'team_image_count'=> 4,
			'team_item_count' => 5,
			'values_enabled'  => true,
			'values_title'    => 'NUESTROS VALORES',
			'values_count'    => 6,
		),
		'services' => array(
			'page_enabled'    => true,
			'banner_image'    => ardeso_fse_asset_url( 'assets/images/banner-camera.svg' ),
			'banner_alt'      => 'Banner de cámara',
			'banner_title'    => "Nosotros Movemos\ntu marca",
			'heading'         => 'Descubre cuáles son nuestros servicios',
			'cards_count'     => 6,
		),
		'work'     => array(
			'hero_enabled'     => true,
			'hero_title'       => 'Conoce más sobre',
			'hero_highlight'   => 'nuestros proyectos',
			'recent_enabled'   => true,
			'recent_title'     => 'LO MÁS RECIENTE',
			'recent_count'     => 6,
			'industrial_title' => 'MARCAS INDUSTRIALES',
			'industrial_count' => 3,
			'medical_title'    => 'MARCAS MÉDICAS',
			'medical_count'    => 3,
			'clients_enabled'  => true,
			'clients_title'    => 'Algunas marcas que confían en nuestro trabajo',
			'clients_count'    => 12,
		),
		'contact'  => array(
			'page_enabled'  => true,
			'title'         => 'Agendemos una reunión',
			'highlight'     => 'y hablemos sobre tu proyecto',
			'intro'         => 'Queremos conocerte mejor y hablar sobre las necesidades de tu negocio o proyecto, por lo cual te ofrecemos realizar una sesión de 30-40 minutos la cual nos servirá de base para proporcionarte una solución personalizada.',
			'form_enabled'  => true,
			'button_label'  => 'Enviar',
		),
		'footer'   => array(
			'enabled'          => true,
			'title'            => 'CONTÁCTANOS',
			'logo'             => ardeso_fse_asset_url( 'assets/images/logo-ardeso.svg' ),
			'logo_alt'         => 'Ardeso Marketing y Publicidad',
			'text'             => 'Síguenos en nuestras redes sociales y no te pierdas de nuestro más reciente contenido.',
			'social_count'     => 4,
			'whatsapp_label'   => 'Escríbenos en WhatsApp',
			'whatsapp_url'     => 'https://wa.me/50300000000',
			'privacy_label'    => 'POLÍTICA DE PRIVACIDAD',
			'privacy_url'      => '/politica-de-privacidad/',
			'form_enabled'     => true,
			'form_intro'       => 'Solicita más información enviándonos un mensaje:',
			'button_label'     => 'Enviar',
			'copyright'        => '© 2026 by ardeso',
		),
	);
}

function ardeso_fse_default_item( $group, $index ) {
	$items = array(
		'home_branding' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-camera.svg' ), 'alt' => 'Proyecto de marca 1', 'title' => 'Marca 1' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-video.svg' ), 'alt' => 'Proyecto de marca 2', 'title' => 'Marca 2' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-branding.svg' ), 'alt' => 'Proyecto de marca 3', 'title' => 'Marca 3' ),
		),
		'home_video' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-video.svg' ), 'alt' => 'Producción 1', 'title' => 'Marca 4' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-camera.svg' ), 'alt' => 'Producción 2', 'title' => 'Marca 5' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-social.svg' ), 'alt' => 'Producción 3', 'title' => 'Marca 6' ),
		),
		'home_client' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 1', 'title' => 'Cliente 1', 'url' => '' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 2', 'title' => 'Cliente 2', 'url' => '' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 3', 'title' => 'Cliente 3', 'url' => '' ),
			4 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 4', 'title' => 'Cliente 4', 'url' => '' ),
			5 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 5', 'title' => 'Cliente 5', 'url' => '' ),
			6 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/mark-ardeso.svg' ), 'alt' => 'Cliente 6', 'title' => 'Cliente 6', 'url' => '' ),
		),
		'home_service' => array(
			1 => array( 'enabled' => true, 'title' => 'Branding', 'text' => 'Estrategia, identidad visual y mensajes para que tu marca sea reconocible y consistente.' ),
			2 => array( 'enabled' => true, 'title' => 'Diseño gráfico', 'text' => 'Piezas digitales e impresas listas para campañas, lanzamientos y comunicación diaria.' ),
			3 => array( 'enabled' => true, 'title' => 'Estrategia de Redes Sociales', 'text' => 'Planificación de contenido, narrativa y pauta para crecer con intención.' ),
			4 => array( 'enabled' => true, 'title' => 'Producción de contenido', 'text' => 'Fotografía, video y recursos creativos alineados a tus objetivos comerciales.' ),
			5 => array( 'enabled' => true, 'title' => 'Planificación estratégica', 'text' => 'Rutas de trabajo claras para campañas, posicionamiento y crecimiento.' ),
			6 => array( 'enabled' => true, 'title' => 'Diseño de sitios web', 'text' => 'Experiencias web editables, rápidas y pensadas para convertir.' ),
		),
		'about_gallery' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-video.svg' ), 'alt' => 'Equipo de producción audiovisual' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-team.svg' ), 'alt' => 'Equipo creativo de Ardeso' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-camera.svg' ), 'alt' => 'Producción de contenido para marcas' ),
		),
		'about_team_image' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-team.svg' ), 'alt' => 'Equipo de mercadeo' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-social.svg' ), 'alt' => 'Equipo de redes sociales' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-video.svg' ), 'alt' => 'Equipo multimedia' ),
			4 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-design.svg' ), 'alt' => 'Equipo de diseño' ),
		),
		'about_team_item' => array(
			1 => array( 'enabled' => true, 'title' => 'Nuestra pasión arde con fuerza', 'text' => 'Unimos estrategia, producción, diseño y gestión para que cada proyecto avance con claridad.' ),
			2 => array( 'enabled' => true, 'title' => 'Directora de Mercadeo', 'text' => 'Dirección estratégica, investigación y acompañamiento de marca.' ),
			3 => array( 'enabled' => true, 'title' => 'Community Manager', 'text' => 'Gestión de comunidades, contenido diario y conversación con audiencias.' ),
			4 => array( 'enabled' => true, 'title' => 'Diseñador Multimedia', 'text' => 'Producción audiovisual, edición y recursos creativos para campañas.' ),
			5 => array( 'enabled' => true, 'title' => 'Diseñadora Gráfica Publicitaria', 'text' => 'Identidad visual, piezas comerciales y sistemas gráficos.' ),
		),
		'about_value' => array(
			1 => array( 'enabled' => true, 'title' => 'Creatividad' ),
			2 => array( 'enabled' => true, 'title' => 'Responsabilidad' ),
			3 => array( 'enabled' => true, 'title' => 'Adaptabilidad' ),
			4 => array( 'enabled' => true, 'title' => 'Unidad' ),
			5 => array( 'enabled' => true, 'title' => 'Compromiso' ),
			6 => array( 'enabled' => true, 'title' => 'Innovación' ),
		),
		'service_card' => array(
			1 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-team.svg' ), 'alt' => 'Branding', 'title' => 'Branding', 'text' => 'Construimos marcas claras, memorables y consistentes para conectar con la audiencia correcta.' ),
			2 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-design.svg' ), 'alt' => 'Diseño gráfico', 'title' => 'Diseño gráfico', 'text' => 'Diseñamos piezas visuales para campañas, redes sociales, impresos y presentaciones.' ),
			3 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-social.svg' ), 'alt' => 'Redes sociales', 'title' => 'Estrategia de Redes Sociales', 'text' => 'Planificamos mensajes, formatos y calendarios para sostener una presencia digital fuerte.' ),
			4 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-camera.svg' ), 'alt' => 'Producción de contenido', 'title' => 'Producción de contenido', 'text' => 'Producimos fotografía, video y recursos para campañas con alto impacto visual.' ),
			5 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-branding.svg' ), 'alt' => 'Planificación estratégica', 'title' => 'Planificación estratégica', 'text' => 'Ordenamos objetivos, acciones y métricas para que cada campaña tenga dirección.' ),
			6 => array( 'enabled' => true, 'image' => ardeso_fse_asset_url( 'assets/images/photo-design.svg' ), 'alt' => 'Sitios web', 'title' => 'Diseño de sitios web', 'text' => 'Creamos sitios editables, responsivos y alineados a la identidad de cada marca.' ),
		),
	);

	$defaults = isset( $items[ $group ][ $index ] ) ? $items[ $group ][ $index ] : array();

	return wp_parse_args(
		$defaults,
		array(
			'enabled' => true,
			'image'   => ardeso_fse_asset_url( 'assets/images/photo-camera.svg' ),
			'alt'     => '',
			'title'   => '',
			'text'    => '',
			'url'     => '',
		)
	);
}

function ardeso_fse_customize_register_collection( $wp_customize, $section, $prefix, $group, $count_default, $fields, &$priority ) {
	ardeso_fse_customize_add_count_control( $wp_customize, "{$prefix}_count", $section, __( 'Cantidad de elementos visibles', 'ardeso-fse' ), $count_default, $priority++ );

	for ( $index = 1; $index <= 12; $index++ ) {
		$item = ardeso_fse_default_item( $group, $index );
		ardeso_fse_customize_add_checkbox_control( $wp_customize, "{$prefix}_{$index}_enabled", $section, sprintf( __( 'Mostrar elemento %d', 'ardeso-fse' ), $index ), $item['enabled'], $priority++ );

		foreach ( $fields as $field => $label ) {
			$setting = "{$prefix}_{$index}_{$field}";
			$default = isset( $item[ $field ] ) ? $item[ $field ] : '';

			if ( 'image' === $field ) {
				ardeso_fse_customize_add_image_control( $wp_customize, $setting, $section, sprintf( $label, $index ), $default, $priority++ );
			} elseif ( 'url' === $field ) {
				ardeso_fse_customize_add_url_control( $wp_customize, $setting, $section, sprintf( $label, $index ), $default, $priority++ );
			} else {
				$type = 'text' === $field || 'alt' === $field || 'title' === $field ? 'text' : 'textarea';
				ardeso_fse_customize_add_text_control( $wp_customize, $setting, $section, sprintf( $label, $index ), $default, $type, $priority++ );
			}
		}
	}
}

function ardeso_fse_customize_register( $wp_customize ) {
	$defaults = ardeso_fse_customizer_defaults();

	$wp_customize->add_panel( 'ardeso_content_panel', array(
		'title'       => __( 'Contenido Ardeso', 'ardeso-fse' ),
		'description' => __( 'Edita textos, imágenes, botones y visibilidad de las páginas principales.', 'ardeso-fse' ),
		'priority'    => 30,
	) );

	$wp_customize->add_section( 'ardeso_home_section', array(
		'panel'    => 'ardeso_content_panel',
		'title'    => __( 'Inicio', 'ardeso-fse' ),
		'priority' => 10,
	) );
	$priority = 10;
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_home_hero_enabled', 'ardeso_home_section', __( 'Mostrar hero', 'ardeso-fse' ), $defaults['home']['hero_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_hero_title', 'ardeso_home_section', __( 'Hero: título magenta', 'ardeso-fse' ), $defaults['home']['hero_title'], 'text', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_hero_title_highlight', 'ardeso_home_section', __( 'Hero: título azul', 'ardeso-fse' ), $defaults['home']['hero_title_highlight'], 'textarea', $priority++ );
	ardeso_fse_customize_add_image_control( $wp_customize, 'ardeso_home_hero_image', 'ardeso_home_section', __( 'Hero: imagen/video placeholder', 'ardeso-fse' ), $defaults['home']['hero_image'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_hero_image_alt', 'ardeso_home_section', __( 'Hero: texto alternativo', 'ardeso-fse' ), $defaults['home']['hero_image_alt'], 'text', $priority++ );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_home_hero_button_enabled', 'ardeso_home_section', __( 'Hero: mostrar botón', 'ardeso-fse' ), $defaults['home']['hero_button_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_hero_button_label', 'ardeso_home_section', __( 'Hero: texto del botón', 'ardeso-fse' ), $defaults['home']['hero_button_label'], 'text', $priority++ );
	ardeso_fse_customize_add_url_control( $wp_customize, 'ardeso_home_hero_button_url', 'ardeso_home_section', __( 'Hero: URL del botón', 'ardeso-fse' ), $defaults['home']['hero_button_url'], $priority++ );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_home_work_enabled', 'ardeso_home_section', __( 'Mostrar trabajo destacado', 'ardeso-fse' ), $defaults['home']['work_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_work_title', 'ardeso_home_section', __( 'Trabajo: título', 'ardeso-fse' ), $defaults['home']['work_title'], 'text', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_branding_label', 'ardeso_home_section', __( 'Trabajo: etiqueta branding', 'ardeso-fse' ), $defaults['home']['branding_label'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_home_section', 'ardeso_home_branding', 'home_branding', $defaults['home']['branding_count'], array( 'image' => 'Branding %d: imagen', 'alt' => 'Branding %d: alt', 'title' => 'Branding %d: título' ), $priority );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_video_label', 'ardeso_home_section', __( 'Trabajo: etiqueta video', 'ardeso-fse' ), $defaults['home']['video_label'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_home_section', 'ardeso_home_video', 'home_video', $defaults['home']['video_count'], array( 'image' => 'Video %d: imagen', 'alt' => 'Video %d: alt', 'title' => 'Video %d: título' ), $priority );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_home_clients_enabled', 'ardeso_home_section', __( 'Mostrar clientes', 'ardeso-fse' ), $defaults['home']['clients_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_clients_title', 'ardeso_home_section', __( 'Clientes: título', 'ardeso-fse' ), $defaults['home']['clients_title'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_home_section', 'ardeso_home_client', 'home_client', $defaults['home']['clients_count'], array( 'image' => 'Cliente %d: logo', 'alt' => 'Cliente %d: alt', 'title' => 'Cliente %d: nombre', 'url' => 'Cliente %d: URL' ), $priority );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_home_services_enabled', 'ardeso_home_section', __( 'Mostrar servicios', 'ardeso-fse' ), $defaults['home']['services_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_services_title', 'ardeso_home_section', __( 'Servicios: título', 'ardeso-fse' ), $defaults['home']['services_title'], 'text', $priority++ );
	ardeso_fse_customize_add_image_control( $wp_customize, 'ardeso_home_services_image', 'ardeso_home_section', __( 'Servicios: imagen', 'ardeso-fse' ), $defaults['home']['services_image'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_home_services_image_alt', 'ardeso_home_section', __( 'Servicios: alt de imagen', 'ardeso-fse' ), $defaults['home']['services_image_alt'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_home_section', 'ardeso_home_service', 'home_service', $defaults['home']['services_count'], array( 'title' => 'Servicio home %d: título', 'text' => 'Servicio home %d: texto' ), $priority );

	$wp_customize->add_section( 'ardeso_about_section', array( 'panel' => 'ardeso_content_panel', 'title' => __( 'Nosotros', 'ardeso-fse' ), 'priority' => 20 ) );
	$priority = 10;
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_about_gallery_enabled', 'ardeso_about_section', __( 'Mostrar galería superior', 'ardeso-fse' ), $defaults['about']['gallery_enabled'], $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_about_section', 'ardeso_about_gallery', 'about_gallery', $defaults['about']['gallery_count'], array( 'image' => 'Galería %d: imagen', 'alt' => 'Galería %d: alt' ), $priority );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_about_intro_enabled', 'ardeso_about_section', __( 'Mostrar introducción', 'ardeso-fse' ), $defaults['about']['intro_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_about_intro_title', 'ardeso_about_section', __( 'Intro: título', 'ardeso-fse' ), $defaults['about']['intro_title'], 'text', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_about_intro_heading', 'ardeso_about_section', __( 'Intro: subtítulo', 'ardeso-fse' ), $defaults['about']['intro_heading'], 'text', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_about_intro_text', 'ardeso_about_section', __( 'Intro: texto', 'ardeso-fse' ), $defaults['about']['intro_text'], 'textarea', $priority++ );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_about_team_enabled', 'ardeso_about_section', __( 'Mostrar equipo', 'ardeso-fse' ), $defaults['about']['team_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_about_team_title', 'ardeso_about_section', __( 'Equipo: título', 'ardeso-fse' ), $defaults['about']['team_title'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_about_section', 'ardeso_about_team_image', 'about_team_image', $defaults['about']['team_image_count'], array( 'image' => 'Equipo imagen %d', 'alt' => 'Equipo imagen %d: alt' ), $priority );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_about_section', 'ardeso_about_team_item', 'about_team_item', $defaults['about']['team_item_count'], array( 'title' => 'Equipo texto %d: título', 'text' => 'Equipo texto %d: descripción' ), $priority );
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_about_values_enabled', 'ardeso_about_section', __( 'Mostrar valores', 'ardeso-fse' ), $defaults['about']['values_enabled'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_about_values_title', 'ardeso_about_section', __( 'Valores: título', 'ardeso-fse' ), $defaults['about']['values_title'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_about_section', 'ardeso_about_value', 'about_value', $defaults['about']['values_count'], array( 'title' => 'Valor %d' ), $priority );

	$wp_customize->add_section( 'ardeso_services_section', array( 'panel' => 'ardeso_content_panel', 'title' => __( 'Servicios', 'ardeso-fse' ), 'priority' => 30 ) );
	$priority = 10;
	ardeso_fse_customize_add_checkbox_control( $wp_customize, 'ardeso_services_page_enabled', 'ardeso_services_section', __( 'Mostrar página servicios', 'ardeso-fse' ), $defaults['services']['page_enabled'], $priority++ );
	ardeso_fse_customize_add_image_control( $wp_customize, 'ardeso_services_banner_image', 'ardeso_services_section', __( 'Banner: imagen', 'ardeso-fse' ), $defaults['services']['banner_image'], $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_services_banner_alt', 'ardeso_services_section', __( 'Banner: alt', 'ardeso-fse' ), $defaults['services']['banner_alt'], 'text', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_services_banner_title', 'ardeso_services_section', __( 'Banner: título', 'ardeso-fse' ), $defaults['services']['banner_title'], 'textarea', $priority++ );
	ardeso_fse_customize_add_text_control( $wp_customize, 'ardeso_services_heading', 'ardeso_services_section', __( 'Título principal', 'ardeso-fse' ), $defaults['services']['heading'], 'text', $priority++ );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_services_section', 'ardeso_service_card', 'service_card', $defaults['services']['cards_count'], array( 'image' => 'Servicio %d: imagen', 'alt' => 'Servicio %d: alt', 'title' => 'Servicio %d: título', 'text' => 'Servicio %d: texto' ), $priority );

	$wp_customize->add_section( 'ardeso_work_section', array( 'panel' => 'ardeso_content_panel', 'title' => __( 'Nuestro trabajo', 'ardeso-fse' ), 'priority' => 40 ) );
	$priority = 10;
	foreach ( $defaults['work'] as $key => $default ) {
		if ( false !== strpos( $key, 'count' ) ) {
			continue;
		}

		$setting = "ardeso_work_{$key}";
		if ( is_bool( $default ) ) {
			ardeso_fse_customize_add_checkbox_control( $wp_customize, $setting, 'ardeso_work_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} else {
			ardeso_fse_customize_add_text_control( $wp_customize, $setting, 'ardeso_work_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, 'text', $priority++ );
		}
	}
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_work_section', 'ardeso_work_recent', 'home_video', $defaults['work']['recent_count'], array( 'image' => 'Reciente %d: imagen', 'alt' => 'Reciente %d: alt', 'title' => 'Reciente %d: texto overlay' ), $priority );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_work_section', 'ardeso_work_industrial', 'service_card', $defaults['work']['industrial_count'], array( 'image' => 'Industrial %d: imagen', 'alt' => 'Industrial %d: alt', 'title' => 'Industrial %d: texto overlay' ), $priority );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_work_section', 'ardeso_work_medical', 'about_gallery', $defaults['work']['medical_count'], array( 'image' => 'Médica %d: imagen', 'alt' => 'Médica %d: alt', 'title' => 'Médica %d: texto overlay' ), $priority );
	ardeso_fse_customize_register_collection( $wp_customize, 'ardeso_work_section', 'ardeso_work_client', 'home_client', $defaults['work']['clients_count'], array( 'image' => 'Cliente trabajo %d: logo', 'alt' => 'Cliente trabajo %d: alt', 'url' => 'Cliente trabajo %d: URL' ), $priority );

	$wp_customize->add_section( 'ardeso_contact_section', array( 'panel' => 'ardeso_content_panel', 'title' => __( 'Contacto', 'ardeso-fse' ), 'priority' => 50 ) );
	$priority = 10;
	foreach ( $defaults['contact'] as $key => $default ) {
		$setting = "ardeso_contact_{$key}";
		if ( is_bool( $default ) ) {
			ardeso_fse_customize_add_checkbox_control( $wp_customize, $setting, 'ardeso_contact_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} else {
			$type = 'intro' === $key ? 'textarea' : 'text';
			ardeso_fse_customize_add_text_control( $wp_customize, $setting, 'ardeso_contact_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $type, $priority++ );
		}
	}

	$wp_customize->add_section( 'ardeso_footer_section', array( 'panel' => 'ardeso_content_panel', 'title' => __( 'Footer / contacto global', 'ardeso-fse' ), 'priority' => 60 ) );
	$priority = 10;
	foreach ( $defaults['footer'] as $key => $default ) {
		$setting = "ardeso_footer_{$key}";
		if ( is_bool( $default ) ) {
			ardeso_fse_customize_add_checkbox_control( $wp_customize, $setting, 'ardeso_footer_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} elseif ( 'logo' === $key ) {
			ardeso_fse_customize_add_image_control( $wp_customize, $setting, 'ardeso_footer_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} elseif ( false !== strpos( $key, 'url' ) ) {
			ardeso_fse_customize_add_url_control( $wp_customize, $setting, 'ardeso_footer_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} elseif ( false !== strpos( $key, 'count' ) ) {
			ardeso_fse_customize_add_count_control( $wp_customize, $setting, 'ardeso_footer_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $priority++ );
		} else {
			$type = in_array( $key, array( 'text', 'form_intro' ), true ) ? 'textarea' : 'text';
			ardeso_fse_customize_add_text_control( $wp_customize, $setting, 'ardeso_footer_section', ucfirst( str_replace( '_', ' ', $key ) ), $default, $type, $priority++ );
		}
	}

	for ( $index = 1; $index <= 8; $index++ ) {
		$labels = array( 1 => 'f', 2 => 'ig', 3 => 'tk', 4 => '▶' );
		ardeso_fse_customize_add_checkbox_control( $wp_customize, "ardeso_footer_social_{$index}_enabled", 'ardeso_footer_section', sprintf( __( 'Mostrar red social %d', 'ardeso-fse' ), $index ), $index <= 4, $priority++ );
		ardeso_fse_customize_add_text_control( $wp_customize, "ardeso_footer_social_{$index}_label", 'ardeso_footer_section', sprintf( __( 'Red social %d: etiqueta', 'ardeso-fse' ), $index ), isset( $labels[ $index ] ) ? $labels[ $index ] : '', 'text', $priority++ );
		ardeso_fse_customize_add_url_control( $wp_customize, "ardeso_footer_social_{$index}_url", 'ardeso_footer_section', sprintf( __( 'Red social %d: URL', 'ardeso-fse' ), $index ), '#', $priority++ );
	}
}
add_action( 'customize_register', 'ardeso_fse_customize_register' );

function ardeso_fse_get_collection( $prefix, $group, $default_count, $fields ) {
	$count = ardeso_fse_sanitize_count( get_theme_mod( "{$prefix}_count", $default_count ) );
	$items = array();

	for ( $index = 1; $index <= $count; $index++ ) {
		$default = ardeso_fse_default_item( $group, $index );
		$item    = array(
			'enabled' => ardeso_fse_theme_mod_bool( "{$prefix}_{$index}_enabled", $default['enabled'] ),
		);

		foreach ( $fields as $field ) {
			$setting = "{$prefix}_{$index}_{$field}";
			$fallback = isset( $default[ $field ] ) ? $default[ $field ] : '';

			if ( 'image' === $field ) {
				$item[ $field ] = ardeso_fse_theme_mod_image( $setting, $fallback );
			} elseif ( 'url' === $field ) {
				$item[ $field ] = ardeso_fse_theme_mod_url( $setting, $fallback );
			} else {
				$item[ $field ] = ardeso_fse_theme_mod_text( $setting, $fallback );
			}
		}

		$items[] = $item;
	}

	return ardeso_fse_visible_items( $items );
}

function ardeso_fse_render_slider( $items, $track_class, $item_callback ) {
	if ( empty( $items ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="wp-block-group ardeso-slider-row">
		<p class="ardeso-arrow">‹</p>
		<div class="wp-block-group <?php echo esc_attr( $track_class ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<?php call_user_func( $item_callback, $item ); ?>
			<?php endforeach; ?>
		</div>
		<p class="ardeso-arrow">›</p>
	</div>
	<p class="ardeso-dots">•••</p>
	<?php
	return ob_get_clean();
}

function ardeso_fse_render_work_card( $item ) {
	?>
	<div class="wp-block-group">
		<figure class="wp-block-image size-large ardeso-card-image"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"></figure>
		<?php if ( ! empty( $item['title'] ) ) : ?>
			<h3 class="wp-block-heading ardeso-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
		<?php endif; ?>
	</div>
	<?php
}

function ardeso_fse_render_logo_tile( $item ) {
	$image = sprintf( '<img src="%1$s" alt="%2$s" style="width:120px">', esc_url( $item['image'] ), esc_attr( $item['alt'] ) );
	if ( ! empty( $item['url'] ) ) {
		$image = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $item['url'] ), $image );
	}
	?>
	<div class="wp-block-group ardeso-logo-tile">
		<figure class="wp-block-image size-large is-resized"><?php echo $image; ?></figure>
		<?php if ( ! empty( $item['title'] ) ) : ?>
			<p><?php echo esc_html( $item['title'] ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

function ardeso_fse_render_home_page() {
	$defaults = ardeso_fse_customizer_defaults();
	$home     = $defaults['home'];
	$branding = ardeso_fse_get_collection( 'ardeso_home_branding', 'home_branding', $home['branding_count'], array( 'image', 'alt', 'title' ) );
	$videos   = ardeso_fse_get_collection( 'ardeso_home_video', 'home_video', $home['video_count'], array( 'image', 'alt', 'title' ) );
	$clients  = ardeso_fse_get_collection( 'ardeso_home_client', 'home_client', $home['clients_count'], array( 'image', 'alt', 'title', 'url' ) );
	$services = ardeso_fse_get_collection( 'ardeso_home_service', 'home_service', $home['services_count'], array( 'title', 'text' ) );

	ob_start();
	if ( ardeso_fse_theme_mod_bool( 'ardeso_home_hero_enabled', $home['hero_enabled'] ) ) :
		?>
		<section class="wp-block-group ardeso-section ardeso-no-line">
			<h1 class="wp-block-heading ardeso-display"><strong><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_hero_title', $home['hero_title'] ) ); ?></strong><br><span class="ardeso-blue"><?php echo nl2br( esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_hero_title_highlight', $home['hero_title_highlight'] ) ) ); ?></span></h1>
			<div class="wp-block-cover ardeso-hero-media" style="min-height:540px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background" alt="<?php echo esc_attr( ardeso_fse_theme_mod_text( 'ardeso_home_hero_image_alt', $home['hero_image_alt'] ) ); ?>" src="<?php echo esc_url( ardeso_fse_theme_mod_image( 'ardeso_home_hero_image', $home['hero_image'] ) ); ?>" data-object-fit="cover"><div class="wp-block-cover__inner-container">
				<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_home_hero_button_enabled', $home['hero_button_enabled'] ) ) : ?>
					<div class="wp-block-buttons"><div class="wp-block-button ardeso-play-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( ardeso_fse_theme_mod_url( 'ardeso_home_hero_button_url', $home['hero_button_url'] ) ); ?>"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_hero_button_label', $home['hero_button_label'] ) ); ?></a></div></div>
				<?php endif; ?>
			</div></div>
		</section>
		<?php
	endif;

	if ( ardeso_fse_theme_mod_bool( 'ardeso_home_work_enabled', $home['work_enabled'] ) ) :
		?>
		<section class="wp-block-group ardeso-section">
			<h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_work_title', $home['work_title'] ) ); ?></h2>
			<?php if ( $branding ) : ?>
				<p class="ardeso-label"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_branding_label', $home['branding_label'] ) ); ?></p>
				<div class="wp-block-group ardeso-work-grid"><?php foreach ( $branding as $item ) { ardeso_fse_render_work_card( $item ); } ?></div>
			<?php endif; ?>
			<?php if ( $videos ) : ?>
				<p class="ardeso-label"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_video_label', $home['video_label'] ) ); ?></p>
				<div class="wp-block-group ardeso-work-grid"><?php foreach ( $videos as $item ) { ardeso_fse_render_work_card( $item ); } ?></div>
			<?php endif; ?>
		</section>
		<?php
	endif;

	if ( ardeso_fse_theme_mod_bool( 'ardeso_home_clients_enabled', $home['clients_enabled'] ) && $clients ) :
		?>
		<section class="wp-block-group ardeso-section">
			<h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_clients_title', $home['clients_title'] ) ); ?></h2>
			<?php echo ardeso_fse_render_slider( $clients, 'ardeso-logo-grid', 'ardeso_fse_render_logo_tile' ); ?>
		</section>
		<?php
	endif;

	if ( ardeso_fse_theme_mod_bool( 'ardeso_home_services_enabled', $home['services_enabled'] ) && $services ) :
		?>
		<section class="wp-block-group ardeso-section">
			<h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_home_services_title', $home['services_title'] ) ); ?></h2>
			<div class="wp-block-media-text is-stacked-on-mobile ardeso-services-split">
				<figure class="wp-block-media-text__media"><img src="<?php echo esc_url( ardeso_fse_theme_mod_image( 'ardeso_home_services_image', $home['services_image'] ) ); ?>" alt="<?php echo esc_attr( ardeso_fse_theme_mod_text( 'ardeso_home_services_image_alt', $home['services_image_alt'] ) ); ?>"></figure>
				<div class="wp-block-media-text__content">
					<?php foreach ( $services as $index => $service ) : ?>
						<details class="wp-block-details ardeso-service-detail" <?php echo 0 === $index ? 'open' : ''; ?>><summary><?php echo esc_html( $service['title'] ); ?></summary><p class="ardeso-text"><?php echo esc_html( $service['text'] ); ?></p></details>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	endif;

	return ob_get_clean();
}

function ardeso_fse_render_about_page() {
	$defaults = ardeso_fse_customizer_defaults();
	$about    = $defaults['about'];
	$gallery  = ardeso_fse_get_collection( 'ardeso_about_gallery', 'about_gallery', $about['gallery_count'], array( 'image', 'alt' ) );
	$images   = ardeso_fse_get_collection( 'ardeso_about_team_image', 'about_team_image', $about['team_image_count'], array( 'image', 'alt' ) );
	$items    = ardeso_fse_get_collection( 'ardeso_about_team_item', 'about_team_item', $about['team_item_count'], array( 'title', 'text' ) );
	$values   = ardeso_fse_get_collection( 'ardeso_about_value', 'about_value', $about['values_count'], array( 'title' ) );

	ob_start();
	if ( ardeso_fse_theme_mod_bool( 'ardeso_about_gallery_enabled', $about['gallery_enabled'] ) && $gallery ) : ?>
		<section class="wp-block-group ardeso-section ardeso-no-line"><?php echo ardeso_fse_render_slider( $gallery, 'ardeso-about-hero-track', function ( $item ) { ?><figure class="wp-block-image size-full ardeso-wide-photo"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"></figure><?php } ); ?></section>
	<?php endif; ?>
	<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_about_intro_enabled', $about['intro_enabled'] ) ) : ?>
		<section class="wp-block-group ardeso-section"><h1 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_about_intro_title', $about['intro_title'] ) ); ?></h1><div class="wp-block-columns ardeso-about-grid"><div class="wp-block-column"></div><div class="wp-block-column ardeso-team-copy"><h3 class="wp-block-heading"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_about_intro_heading', $about['intro_heading'] ) ); ?></h3><p><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_about_intro_text', $about['intro_text'] ) ); ?></p></div></div></section>
	<?php endif; ?>
	<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_about_team_enabled', $about['team_enabled'] ) ) : ?>
		<section class="wp-block-group ardeso-section"><h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_about_team_title', $about['team_title'] ) ); ?></h2><div class="wp-block-columns ardeso-team-grid"><div class="wp-block-column ardeso-team-images"><?php foreach ( $images as $image ) : ?><figure class="wp-block-image size-large"><img src="<?php echo esc_url( $image['image'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"></figure><?php endforeach; ?></div><div class="wp-block-column ardeso-team-copy"><?php foreach ( $items as $item ) : ?><h3 class="wp-block-heading"><?php echo esc_html( $item['title'] ); ?></h3><p><?php echo esc_html( $item['text'] ); ?></p><?php endforeach; ?></div></div></section>
	<?php endif; ?>
	<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_about_values_enabled', $about['values_enabled'] ) && $values ) : ?>
		<section class="wp-block-group ardeso-section"><h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_about_values_title', $about['values_title'] ) ); ?></h2><?php echo ardeso_fse_render_slider( $values, 'ardeso-values-grid', function ( $item ) { ?><p class="ardeso-value-tile"><?php echo esc_html( $item['title'] ); ?></p><?php } ); ?></section>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

function ardeso_fse_render_services_page() {
	$defaults = ardeso_fse_customizer_defaults();
	$services = $defaults['services'];
	$cards    = ardeso_fse_get_collection( 'ardeso_service_card', 'service_card', $services['cards_count'], array( 'image', 'alt', 'title', 'text' ) );

	if ( ! ardeso_fse_theme_mod_bool( 'ardeso_services_page_enabled', $services['page_enabled'] ) ) {
		return '';
	}

	ob_start();
	?>
	<section class="wp-block-group ardeso-section ardeso-no-line">
		<div class="wp-block-cover ardeso-banner" style="min-height:250px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-10 has-background-dim"></span><img class="wp-block-cover__image-background" alt="<?php echo esc_attr( ardeso_fse_theme_mod_text( 'ardeso_services_banner_alt', $services['banner_alt'] ) ); ?>" src="<?php echo esc_url( ardeso_fse_theme_mod_image( 'ardeso_services_banner_image', $services['banner_image'] ) ); ?>" data-object-fit="cover"><div class="wp-block-cover__inner-container"><h1 class="wp-block-heading has-text-align-center"><?php echo nl2br( esc_html( ardeso_fse_theme_mod_text( 'ardeso_services_banner_title', $services['banner_title'] ) ) ); ?></h1></div></div>
		<h2 class="wp-block-heading has-text-align-center ardeso-display ardeso-display-medium"><span class="ardeso-blue"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_services_heading', $services['heading'] ) ); ?></span></h2>
		<p class="has-text-align-center ardeso-down">⌄</p>
		<div class="wp-block-group ardeso-service-cards">
			<?php foreach ( $cards as $card ) : ?>
				<div class="wp-block-media-text is-stacked-on-mobile ardeso-service-card" style="grid-template-columns:50% auto"><figure class="wp-block-media-text__media"><img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['alt'] ); ?>"></figure><div class="wp-block-media-text__content"><h3 class="wp-block-heading"><?php echo esc_html( $card['title'] ); ?></h3><p><?php echo esc_html( $card['text'] ); ?></p></div></div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

function ardeso_fse_render_work_page() {
	$defaults   = ardeso_fse_customizer_defaults();
	$work       = $defaults['work'];
	$recent     = ardeso_fse_get_collection( 'ardeso_work_recent', 'home_video', $work['recent_count'], array( 'image', 'alt', 'title' ) );
	$industrial = ardeso_fse_get_collection( 'ardeso_work_industrial', 'service_card', $work['industrial_count'], array( 'image', 'alt', 'title' ) );
	$medical    = ardeso_fse_get_collection( 'ardeso_work_medical', 'about_gallery', $work['medical_count'], array( 'image', 'alt', 'title' ) );
	$clients    = ardeso_fse_get_collection( 'ardeso_work_client', 'home_client', $work['clients_count'], array( 'image', 'alt', 'url' ) );

	ob_start();
	if ( ardeso_fse_theme_mod_bool( 'ardeso_work_hero_enabled', $work['hero_enabled'] ) ) : ?>
		<section class="wp-block-group ardeso-section ardeso-no-line"><h1 class="wp-block-heading ardeso-display"><strong><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_hero_title', $work['hero_title'] ) ); ?></strong><br><span class="ardeso-blue"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_hero_highlight', $work['hero_highlight'] ) ); ?></span></h1></section>
	<?php endif; ?>
	<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_work_recent_enabled', $work['recent_enabled'] ) && $recent ) : ?>
		<section class="wp-block-group"><h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_recent_title', $work['recent_title'] ) ); ?></h2><?php echo ardeso_fse_render_slider( $recent, 'ardeso-portfolio-strip', function ( $item ) { ?><figure class="wp-block-image size-large"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"></figure><?php } ); ?></section>
	<?php endif; ?>
	<section class="wp-block-group ardeso-section">
		<?php if ( $industrial ) : ?><h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_industrial_title', $work['industrial_title'] ) ); ?></h2><div class="wp-block-group ardeso-portfolio-grid"><?php foreach ( $industrial as $item ) : ?><figure class="wp-block-image size-large ardeso-portfolio-item"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"></figure><?php endforeach; ?></div><?php endif; ?>
		<?php if ( $medical ) : ?><h2 class="wp-block-heading ardeso-section-title ardeso-spaced-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_medical_title', $work['medical_title'] ) ); ?></h2><div class="wp-block-group ardeso-portfolio-grid"><?php foreach ( $medical as $item ) : ?><figure class="wp-block-image size-large ardeso-portfolio-item"><img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"></figure><?php endforeach; ?></div><?php endif; ?>
	</section>
	<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_work_clients_enabled', $work['clients_enabled'] ) && $clients ) : ?>
		<section class="wp-block-group ardeso-section"><h2 class="wp-block-heading has-text-align-center ardeso-display ardeso-display-medium"><span class="ardeso-blue"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_work_clients_title', $work['clients_title'] ) ); ?></span></h2><p class="has-text-align-center ardeso-down">⌄</p><div class="wp-block-group ardeso-brand-cloud"><?php foreach ( $clients as $client ) : ?><figure class="wp-block-image size-large"><img src="<?php echo esc_url( $client['image'] ); ?>" alt="<?php echo esc_attr( $client['alt'] ); ?>"></figure><?php endforeach; ?></div></section>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

function ardeso_fse_render_contact_page() {
	$defaults = ardeso_fse_customizer_defaults();
	$contact  = $defaults['contact'];

	if ( ! ardeso_fse_theme_mod_bool( 'ardeso_contact_page_enabled', $contact['page_enabled'] ) ) {
		return '';
	}

	ob_start();
	?>
	<section class="wp-block-group ardeso-section ardeso-no-line">
		<h1 class="wp-block-heading ardeso-display"><strong><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_contact_title', $contact['title'] ) ); ?></strong><br><span class="ardeso-blue"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_contact_highlight', $contact['highlight'] ) ); ?></span></h1>
		<p class="ardeso-text ardeso-contact-intro"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_contact_intro', $contact['intro'] ) ); ?></p>
		<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_contact_form_enabled', $contact['form_enabled'] ) ) : ?>
			<form class="ardeso-meeting-form" action="#" method="post" style="margin-top:76px;">
				<div class="ardeso-form-field"><label for="meeting-name">Nombre y apellido*</label><input id="meeting-name" name="name" type="text" required></div>
				<div class="ardeso-form-field"><label for="meeting-email">Correo electrónico*</label><input id="meeting-email" name="email" type="email" required></div>
				<div class="ardeso-form-field"><label for="meeting-phone">Número de teléfono</label><input id="meeting-phone" name="phone" type="tel" value="+503"></div>
				<div class="ardeso-form-field"><label for="meeting-service">¿Cuál de nuestros servicios te interesa?*</label><input id="meeting-service" name="service" type="text" required></div>
				<div class="ardeso-form-field"><label for="meeting-place">¿De dónde eres?</label><input id="meeting-place" name="place" type="text"></div>
				<div class="ardeso-form-field"><label for="meeting-source">¿Por cuál medio te enteraste de nosotros?*</label><input id="meeting-source" name="source" type="text" required></div>
				<div class="ardeso-meeting-actions"><div style="background:#fafafa; border:1px solid #e8e8e8; color:#333; max-width:390px; padding:24px;"><input type="checkbox" aria-label="No soy un robot"> No soy un robot <span style="float:right; color:#8a8a8a;">reCAPTCHA</span></div><button class="ardeso-button" type="submit" style="font-size:clamp(1.2rem,1rem + .8vw,1.8rem); min-height:58px;"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_contact_button_label', $contact['button_label'] ) ); ?></button></div>
			</form>
		<?php endif; ?>
	</section>
	<?php
	return ob_get_clean();
}

function ardeso_fse_render_customizer_page_content( $content ) {
	if ( is_admin() || ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( is_front_page() ) {
		return ardeso_fse_render_home_page();
	}

	$page_slug = get_post_field( 'post_name', get_the_ID() );
	$renderers = array(
		'nosotros'        => 'ardeso_fse_render_about_page',
		'servicios'       => 'ardeso_fse_render_services_page',
		'nuestro-trabajo' => 'ardeso_fse_render_work_page',
		'contacto'        => 'ardeso_fse_render_contact_page',
	);

	return isset( $renderers[ $page_slug ] ) ? call_user_func( $renderers[ $page_slug ] ) : $content;
}
add_filter( 'the_content', 'ardeso_fse_render_customizer_page_content', 6 );

function ardeso_fse_render_footer_shortcode() {
	$defaults = ardeso_fse_customizer_defaults();
	$footer   = $defaults['footer'];

	if ( ! ardeso_fse_theme_mod_bool( 'ardeso_footer_enabled', $footer['enabled'] ) ) {
		return '';
	}

	$social_count = min( 8, ardeso_fse_sanitize_count( get_theme_mod( 'ardeso_footer_social_count', $footer['social_count'] ) ) );

	ob_start();
	?>
	<footer class="wp-block-group ardeso-footer ardeso-site-shell">
		<h2 class="wp-block-heading ardeso-section-title"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_title', $footer['title'] ) ); ?></h2>
		<div class="wp-block-columns ardeso-contact-grid">
			<div class="wp-block-column">
				<figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url( ardeso_fse_theme_mod_image( 'ardeso_footer_logo', $footer['logo'] ) ); ?>" alt="<?php echo esc_attr( ardeso_fse_theme_mod_text( 'ardeso_footer_logo_alt', $footer['logo_alt'] ) ); ?>" style="width:246px"></figure>
				<p class="ardeso-text"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_text', $footer['text'] ) ); ?></p>
				<div class="wp-block-group ardeso-socials">
					<?php for ( $index = 1; $index <= $social_count; $index++ ) : ?>
						<?php if ( ardeso_fse_theme_mod_bool( "ardeso_footer_social_{$index}_enabled", $index <= 4 ) ) : ?>
							<p><a href="<?php echo esc_url( ardeso_fse_theme_mod_url( "ardeso_footer_social_{$index}_url", '#' ) ); ?>"><?php echo esc_html( ardeso_fse_theme_mod_text( "ardeso_footer_social_{$index}_label", '' ) ); ?></a></p>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
				<p class="ardeso-kicker"><a href="<?php echo esc_url( ardeso_fse_theme_mod_url( 'ardeso_footer_whatsapp_url', $footer['whatsapp_url'] ) ); ?>"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_whatsapp_label', $footer['whatsapp_label'] ) ); ?></a></p>
				<p class="ardeso-privacy-link"><a href="<?php echo esc_url( ardeso_fse_theme_mod_url( 'ardeso_footer_privacy_url', $footer['privacy_url'] ) ); ?>"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_privacy_label', $footer['privacy_label'] ) ); ?></a></p>
			</div>
			<div class="wp-block-column">
				<?php if ( ardeso_fse_theme_mod_bool( 'ardeso_footer_form_enabled', $footer['form_enabled'] ) ) : ?>
					<form class="ardeso-form-grid" action="#" method="post">
						<p class="ardeso-kicker ardeso-form-field--full"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_form_intro', $footer['form_intro'] ) ); ?></p>
						<div class="ardeso-form-field"><label for="footer-name">Nombre</label><input id="footer-name" name="name" type="text"></div>
						<div class="ardeso-form-field"><label for="footer-lastname">Apellido</label><input id="footer-lastname" name="lastname" type="text"></div>
						<div class="ardeso-form-field"><label for="footer-email">Email *</label><input id="footer-email" name="email" type="email"></div>
						<div class="ardeso-form-field"><label for="footer-phone">Teléfono</label><input id="footer-phone" name="phone" type="tel" value="+503"></div>
						<div class="ardeso-form-field"><label for="footer-message">Mensaje</label><textarea id="footer-message" name="message"></textarea></div>
						<div class="ardeso-form-field" style="align-self:end;"><button type="submit"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_button_label', $footer['button_label'] ) ); ?></button></div>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<p class="has-text-align-right ardeso-copyright"><?php echo esc_html( ardeso_fse_theme_mod_text( 'ardeso_footer_copyright', $footer['copyright'] ) ); ?></p>
	</footer>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ardeso_footer', 'ardeso_fse_render_footer_shortcode' );

function ardeso_fse_add_customize_menu() {
	add_theme_page(
		__( 'Personalizar', 'ardeso-fse' ),
		__( 'Personalizar', 'ardeso-fse' ),
		'customize',
		'customize.php'
	);
}
add_action( 'admin_menu', 'ardeso_fse_add_customize_menu' );

function ardeso_fse_admin_customizer_bridge() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen ) {
		return;
	}

	if ( 'customize' === $screen->base ) {
		?>
		<style>
			.ardeso-hide-site-editor-notice {
				display: none !important;
			}
		</style>
		<script>
			document.addEventListener( 'DOMContentLoaded', function () {
				document.querySelectorAll( '.notice.notice-info' ).forEach( function ( notice ) {
					if ( notice.textContent.indexOf( 'edición del sitio con bloques' ) !== -1 || notice.querySelector( 'a[href*="site-editor.php"]' ) ) {
						notice.classList.add( 'ardeso-hide-site-editor-notice' );
					}
				} );
			} );
		</script>
		<?php
		return;
	}

	if ( 'themes' !== $screen->base ) {
		return;
	}
	?>
	<style>
		.theme.active .theme-actions .ardeso-customize-action {
			margin-left: 8px;
		}
	</style>
	<script>
		document.addEventListener( 'DOMContentLoaded', function () {
			var activeActions = document.querySelector( '.theme.active .theme-actions' );

			if ( ! activeActions || activeActions.querySelector( '.ardeso-customize-action' ) ) {
				return;
			}

			var button = document.createElement( 'a' );
			button.className = 'button button-primary ardeso-customize-action';
			button.href = '<?php echo esc_url( admin_url( 'customize.php' ) ); ?>';
			button.textContent = '<?php echo esc_js( __( 'Personalizar', 'ardeso-fse' ) ); ?>';
			activeActions.insertBefore( button, activeActions.firstChild );
		} );
	</script>
	<?php
}
add_action( 'admin_head', 'ardeso_fse_admin_customizer_bridge' );

function ardeso_fse_hide_site_editor_customizer_notice() {
	?>
	<style>
		.notice.notice-info.ardeso-hide-site-editor-notice {
			display: none !important;
		}
	</style>
	<script>
		(function () {
			function hideNotice() {
				document.querySelectorAll( '.notice.notice-info' ).forEach( function ( notice ) {
					if ( notice.textContent.indexOf( 'edición del sitio con bloques' ) !== -1 || notice.querySelector( 'a[href*="site-editor.php"]' ) ) {
						notice.classList.add( 'ardeso-hide-site-editor-notice' );
					}
				} );
			}

			document.addEventListener( 'DOMContentLoaded', hideNotice );
			window.setTimeout( hideNotice, 250 );
			window.setTimeout( hideNotice, 1000 );
		}());
	</script>
	<?php
}
add_action( 'customize_controls_print_styles', 'ardeso_fse_hide_site_editor_customizer_notice' );

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
