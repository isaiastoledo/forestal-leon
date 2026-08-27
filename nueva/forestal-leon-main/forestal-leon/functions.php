<?php
/**
 * Forestal León — funciones del tema.
 *
 * @package ForestalLeon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FORESTAL_LEON_VERSION', '2.18.0' );

/**
 * Soportes del tema.
 *
 * Un tema de bloques declara muy poco: theme.json se encarga del resto.
 */
function forestal_leon_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	// Sin esto el editor no aplica el CSS del tema y lo que ves al editar no
	// coincide con lo que se publica.
	add_editor_style( 'style.css' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'style', 'script', 'caption', 'gallery' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 612,
		'width'       => 1878,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	load_theme_textdomain( 'forestal-leon', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'forestal_leon_setup' );

/**
 * Hoja de estilo del tema.
 */
function forestal_leon_styles() {
	wp_enqueue_style(
		'forestal-leon',
		get_stylesheet_uri(),
		array(),
		FORESTAL_LEON_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'forestal_leon_styles' );

/**
 * Tipografías.
 *
 * Una sola petición carga la variable Open Sans con los ejes de ancho (wdth)
 * y grosor (wght). El ancho 75 reproduce la antigua "Open Sans Condensed",
 * que Google descontinuó; style.css lo activa con font-stretch.
 *
 * Para alojar las fuentes en el propio servidor, ver DESIGN-SYSTEM.md § 8.
 */
function forestal_leon_fonts() {
	$url = 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap';

	wp_enqueue_style( 'forestal-leon-fonts', $url, array(), null );
}
add_action( 'wp_enqueue_scripts', 'forestal_leon_fonts' );
add_action( 'enqueue_block_editor_assets', 'forestal_leon_fonts' );

/**
 * Precarga de la conexión a Google Fonts (mejora el LCP).
 */
function forestal_leon_font_preconnect( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'forestal_leon_font_preconnect', 10, 2 );

/**
 * Estilos de bloque del sistema de diseño.
 *
 * Aparecen en la barra lateral del editor, pestaña "Estilos". El CSS de cada
 * uno vive en style.css, secciones 5 y 6.
 */
function forestal_leon_block_styles() {
	$estilos = array(
		array( 'core/button',    'solido',          __( 'Sólido (Verde León)', 'forestal-leon' ) ),
		array( 'core/button',    'sobre-oscuro',    __( 'Sobre fondo oscuro', 'forestal-leon' ) ),
		array( 'core/heading',   'titulo-seccion',  __( 'Título de sección (verde)', 'forestal-leon' ) ),
		array( 'core/heading',   'subtitulo-seccion', __( 'Subtítulo de sección', 'forestal-leon' ) ),
		array( 'core/paragraph', 'subtitulo-seccion', __( 'Subtítulo de sección', 'forestal-leon' ) ),
		array( 'core/paragraph', 'antetitulo',      __( 'Antetítulo', 'forestal-leon' ) ),
		array( 'core/paragraph', 'entradilla',      __( 'Entradilla', 'forestal-leon' ) ),
		array( 'core/paragraph', 'etiqueta',        __( 'Etiqueta / tag', 'forestal-leon' ) ),
		array( 'core/paragraph', 'cifra',           __( 'Cifra destacada', 'forestal-leon' ) ),
		array( 'core/heading',   'cifra',           __( 'Cifra destacada', 'forestal-leon' ) ),
		array( 'core/group',     'filete-verde',    __( 'Filete verde superior', 'forestal-leon' ) ),
		array( 'core/group',     'filete-madera',   __( 'Filete madera superior', 'forestal-leon' ) ),
		array( 'core/cover',     'velo-inferior',   __( 'Velo inferior', 'forestal-leon' ) ),
		array( 'core/site-logo', 'logo-blanco',     __( 'Versión blanca', 'forestal-leon' ) ),
		array( 'core/list',      'lista-limpia',    __( 'Sin viñetas', 'forestal-leon' ) ),
	);

	foreach ( $estilos as $estilo ) {
		list( $bloque, $nombre, $etiqueta ) = $estilo;
		register_block_style( $bloque, array(
			'name'  => $nombre,
			'label' => $etiqueta,
		) );
	}
}
add_action( 'init', 'forestal_leon_block_styles' );

/**
 * Categoría propia para los patrones del tema.
 */
function forestal_leon_pattern_category() {
	register_block_pattern_category( 'forestal-leon', array(
		'label'       => __( 'Forestal León', 'forestal-leon' ),
		'description' => __( 'Secciones listas con los contenidos y la marca de Forestal León.', 'forestal-leon' ),
	) );
}
add_action( 'init', 'forestal_leon_pattern_category' );

/**
 * Script de la cabecera.
 *
 * Se carga en todo el sitio: además del cambio de color al hacer scroll —que
 * solo actúa en la portada— gobierna el mega menú de Productos y el menú de
 * móvil, que hacen falta en todas las páginas.
 */
function forestal_leon_script_cabecera() {
	wp_enqueue_script(
		'forestal-leon-cabecera',
		get_template_directory_uri() . '/assets/js/cabecera.js',
		array(),
		FORESTAL_LEON_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
}
add_action( 'wp_enqueue_scripts', 'forestal_leon_script_cabecera' );

/**
 * Marca la portada para que la cabecera se superponga a la imagen del hero.
 *
 * El CSS que lo hace está en style.css § 2 bis. Solo en la portada: en el resto
 * del sitio la cabecera es blanca y sólida, porque no hay imagen debajo.
 */
function forestal_leon_clase_portada( $clases ) {
	if ( is_front_page() && ! is_paged() ) {
		$clases[] = 'fl-hero-superpuesto';
	}

	return $clases;
}
add_filter( 'body_class', 'forestal_leon_clase_portada' );

/**
 * Tipos de contenido propios.
 *
 * La estructura de la web pide dos catálogos con ficha individual:
 *
 *   Productos   → 3 familias (aserrada, estructural, laminado) y 9 productos.
 *                 "Información relevante en cada ventana" = una ficha por producto.
 *   Proyectos   → las referencias de construcción en madera, agrupadas por tipo
 *                 (viviendas, edificios, turismo).
 *
 * Se registran desde el tema para que el ZIP sea autosuficiente. Si más adelante
 * el catálogo crece o se cambia de tema, conviene moverlos a un plugin propio
 * para que el contenido no dependa del tema activo.
 */
function forestal_leon_tipos_de_contenido() {
	register_post_type( 'producto', array(
		'labels'        => array(
			'name'          => __( 'Productos', 'forestal-leon' ),
			'singular_name' => __( 'Producto', 'forestal-leon' ),
			'add_new_item'  => __( 'Añadir producto', 'forestal-leon' ),
			'edit_item'     => __( 'Editar producto', 'forestal-leon' ),
		),
		'public'        => true,
		/*
		 * Sin archivo automático: /productos es una página normal, editable en
		 * Elementor. El archivo de un tipo de contenido solo se puede maquetar
		 * con el Theme Builder de Elementor Pro, y aquí trabajamos con la
		 * versión gratuita. Las fichas siguen respondiendo en
		 * /productos/{slug}, así que los enlaces del menú no cambian.
		 */
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'productos', 'with_front' => false ),
		'menu_icon'     => 'dashicons-archive',
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'show_in_rest'  => true,
		'taxonomies'    => array( 'familia-producto' ),
	) );

	register_taxonomy( 'familia-producto', 'producto', array(
		'labels'            => array(
			'name'          => __( 'Familias de producto', 'forestal-leon' ),
			'singular_name' => __( 'Familia', 'forestal-leon' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'rewrite'           => array( 'slug' => 'familia-producto', 'with_front' => false ),
		'show_in_rest'      => true,
		'show_admin_column' => true,
	) );

	register_post_type( 'proyecto', array(
		'labels'        => array(
			'name'          => __( 'Proyectos', 'forestal-leon' ),
			'singular_name' => __( 'Proyecto', 'forestal-leon' ),
			'add_new_item'  => __( 'Añadir proyecto', 'forestal-leon' ),
			'edit_item'     => __( 'Editar proyecto', 'forestal-leon' ),
		),
		'public'        => true,
		'has_archive'   => false,   // igual que en productos: /proyectos es una página
		'rewrite'       => array( 'slug' => 'proyectos', 'with_front' => false ),
		'menu_icon'     => 'dashicons-building',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'show_in_rest'  => true,
		'taxonomies'    => array( 'tipo-proyecto' ),
	) );

	register_taxonomy( 'tipo-proyecto', 'proyecto', array(
		'labels'            => array(
			'name'          => __( 'Tipos de proyecto', 'forestal-leon' ),
			'singular_name' => __( 'Tipo', 'forestal-leon' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'rewrite'           => array( 'slug' => 'tipo-proyecto', 'with_front' => false ),
		'show_in_rest'      => true,
		'show_admin_column' => true,
	) );
}
add_action( 'init', 'forestal_leon_tipos_de_contenido' );

/**
 * Siembra las familias y los tipos al activar el tema, y refresca las reglas
 * de reescritura para que /productos y /proyectos respondan desde el minuto uno.
 */
function forestal_leon_sembrar_taxonomias() {
	/*
	 * SEGURO: el contenido inicial se crea UNA sola vez en la vida del sitio.
	 *
	 * Sin esto, cada activación del tema volvía a crear las 14 páginas y las 9
	 * fichas. Y como WordPress renombra el slug a «algo__trashed» al mandar una
	 * página a la papelera, la comprobación de «¿ya existe?» no la encontraba y
	 * creaba un duplicado. Resultado: cientos de páginas repetidas.
	 *
	 * Para volver a sembrar a propósito (sitio nuevo, o tras vaciar todo), borra
	 * la opción «forestal_leon_contenido_creado» y reactiva el tema.
	 */
	if ( get_option( 'forestal_leon_contenido_creado' ) === FORESTAL_LEON_VERSION ) {
		// Ya se sembró con esta versión: solo refrescamos las reglas de las URL.
		forestal_leon_tipos_de_contenido();
		flush_rewrite_rules();
		return;
	}

	/*
	 * Las tres familias, con la descripción que sale en su archivo.
	 *
	 * La familia del medio se llama «Plywood», decidido el 18-8-2026. El
	 * documento de estructura la llamaba «Madera estructural»; los textos
	 * oficiales de producto, que describen tableros contrachapados, la
	 * titulaban «Plywood». Manda este último. Si vuelve a cambiar, hay que
	 * tocarlo aquí, en el menú de parts/header.html y en el generador de
	 * plantillas de Elementor.
	 */
	$familias = array(
		'madera-aserrada' => array(
			__( 'Madera aserrada', 'forestal-leon' ),
			__( 'Calidad forestal chilena en cada pieza. Toda nuestra madera aserrada proviene de bosques propios con manejo responsable, certificados FSC™ y PEFC. Aserrado, secado en cámara y cepillado se controlan en la planta de Coelemu, con largo estándar de 3,2 metros.', 'forestal-leon' ),
		),
		'plywood' => array(
			__( 'Plywood', 'forestal-leon' ),
			__( 'Tableros contrachapados de Pino Radiata. Láminas obtenidas por torno y unidas en capas perpendiculares con adhesivo, presión y calor controlados: esa disposición cruzada da rigidez uniforme en ambas direcciones y estabilidad dimensional ante cambios de humedad y temperatura.', 'forestal-leon' ),
		),
		'laminado' => array(
			__( 'Laminado', 'forestal-leon' ),
			__( 'Madera laminada encolada para estructuras, exteriores y proyectos a medida. Grandes luces sin columnas intermedias y estructuras a la vista que se convierten en el elemento central del diseño.', 'forestal-leon' ),
		),
	);

	foreach ( $familias as $slug => $datos ) {
		if ( term_exists( $slug, 'familia-producto' ) ) {
			continue;
		}

		wp_insert_term( $datos[0], 'familia-producto', array(
			'slug'        => $slug,
			'description' => $datos[1],
		) );
	}

	$tipos = array(
		'viviendas' => __( 'Viviendas', 'forestal-leon' ),
		'edificios' => __( 'Edificios', 'forestal-leon' ),
		'turismo'   => __( 'Turismo', 'forestal-leon' ),
	);

	foreach ( $tipos as $slug => $nombre ) {
		if ( ! term_exists( $slug, 'tipo-proyecto' ) ) {
			wp_insert_term( $nombre, 'tipo-proyecto', array( 'slug' => $slug ) );
		}
	}

	forestal_leon_tipos_de_contenido();
	forestal_leon_sembrar_productos();
	forestal_leon_sembrar_proyecto_ejemplo();
	forestal_leon_sembrar_paginas();
	flush_rewrite_rules();

	// Marca que el contenido inicial ya existe: no se vuelve a crear nunca.
	update_option( 'forestal_leon_contenido_creado', FORESTAL_LEON_VERSION );
}
add_action( 'after_switch_theme', 'forestal_leon_sembrar_taxonomias' );

/*
 * Red de seguridad.
 *
 * «after_switch_theme» solo se dispara al CAMBIAR de tema. Si se sube una
 * versión nueva encima del tema ya activo —que es como se va a iterar— no se
 * dispara, y el contenido inicial nunca llegaría a crearse.
 *
 * Esto lo comprueba al entrar al panel: si el tema está activo y la marca no
 * existe, siembra una vez y la deja puesta. Por el seguro de la propia función,
 * no puede repetirse.
 */
function forestal_leon_sembrar_si_falta() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'forestal_leon_contenido_creado' ) === FORESTAL_LEON_VERSION ) {
		return;
	}

	forestal_leon_sembrar_taxonomias();
}
add_action( 'admin_init', 'forestal_leon_sembrar_si_falta' );

/**
 * Crea las nueve fichas de producto al activar el tema.
 *
 * Sin esto, los nueve enlaces del mega menú darían 404 hasta que alguien
 * escribiera las fichas a mano. Se crean como borradores publicados con un
 * esqueleto de contenido: título, entradilla, tabla de características y aviso
 * de lo que falta. Si una ficha ya existe (por slug) no se toca.
 */
function forestal_leon_sembrar_productos() {
	$productos = array(
		'seco-cepillado' => array(
			'titulo'     => __( 'Madera seca cepillada', 'forestal-leon' ),
			'subtitulo'  => __( 'Secada en cámara y cepillada a medida', 'forestal-leon' ),
			'familia'    => 'madera-aserrada',
			'entradilla' => __( 'Pino Radiata secado en cámara y cepillado a medida, con tolerancias precisas y superficie limpia lista para usar.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'El secado controlado en cámara garantiza estabilidad dimensional y reduce al mínimo las deformaciones y contracciones en obra. El cepillado posterior entrega una superficie limpia que no necesita preparación adicional.', 'forestal-leon' ),
			),
			'usos'       => __( 'Revestimientos interiores, cielos, molduras, marcos de puertas y ventanas, y terminaciones en general donde la apariencia y la precisión son determinantes.', 'forestal-leon' ),
		),
		'impregnado' => array(
			'titulo'     => __( 'Madera impregnada', 'forestal-leon' ),
			'subtitulo'  => __( 'Preservación en autoclave para uso a la intemperie', 'forestal-leon' ),
			'familia'    => 'madera-aserrada',
			'entradilla' => __( 'Pino Radiata seco con tratamiento de preservación en autoclave, para uso a la intemperie.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'Garantiza larga duración frente a hongos, insectos y condiciones climáticas adversas. Disponible con dos procesos de impregnación según el requerimiento del proyecto: CCA y cobre micronizado.', 'forestal-leon' ),
				__( 'Ambos se aplican mediante sistema de vacío-presión, que asegura la máxima penetración del preservante en la fibra de la madera.', 'forestal-leon' ),
			),
			'usos'       => __( 'Terrazas, deck, pérgolas, cercos, estructuras en exterior y cualquier aplicación donde la durabilidad frente a la intemperie sea determinante.', 'forestal-leon' ),
		),
		'estructural' => array(
			'titulo'     => __( 'Estructural', 'forestal-leon' ),
			'subtitulo'  => __( 'El tablero más demandado en construcción', 'forestal-leon' ),
			'familia'    => 'plywood',
			'entradilla' => __( 'El tablero más demandado en construcción, con encolado fenólico resistente a la humedad.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'Aporta resistencia a la flexión, al cizalle y a la compresión, y forma parte del sistema de arriostramiento en muros y entrepisos. Su espesor calibrado garantiza uniformidad en toda la superficie, condición crítica en moldaje y revestimiento continuo.', 'forestal-leon' ),
			),
			'usos'       => __( 'Moldajes y encofrados, cubiertas de techo, entrevigado de entrepiso, revestimientos, rigidización de estructuras y estructuración de pisos.', 'forestal-leon' ),
		),
		'muebleria' => array(
			'titulo'     => __( 'Mueblería', 'forestal-leon' ),
			'subtitulo'  => __( 'Cara de apariencia seleccionada, lista para el acabado', 'forestal-leon' ),
			'familia'    => 'plywood',
			'entradilla' => __( 'Tablero con cara de apariencia seleccionada, libre de defectos visibles que interfieran con el acabado.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'La baja presencia de nudos en las capas exteriores y su textura uniforme lo hacen compatible con pinturas, barnices, lacas y laminados sin preparación adicional.', 'forestal-leon' ),
				__( 'Se trabaja con herramientas convencionales y admite tornillos, tarugos, galletas y adhesivos para madera sin problema.', 'forestal-leon' ),
			),
			'usos'       => __( 'Fabricación de muebles y cajonería, paneles decorativos, revestimientos interiores y carpintería de terminación.', 'forestal-leon' ),
		),
		'ranurado' => array(
			'titulo'     => __( 'Ranurado', 'forestal-leon' ),
			'subtitulo'  => __( 'Ranuras longitudinales con solapado lateral', 'forestal-leon' ),
			'familia'    => 'plywood',
			'entradilla' => __( 'Tablero con ranuras longitudinales en cara y solapado lateral que asegura la unión entre piezas.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'El solapado permite una instalación continua y limpia, sin interrupciones visibles entre tableros. Es especialmente valorado en interiorismo y arquitectura por la rapidez de montaje y el acabado resultante.', 'forestal-leon' ),
			),
			'usos'       => __( 'Revestimientos de muros y cielos interiores, fachadas decorativas y panelería en proyectos de arquitectura e interiorismo.', 'forestal-leon' ),
		),
		'impregnado-estructural' => array(
			'titulo'     => __( 'Impregnado', 'forestal-leon' ),
			'subtitulo'  => __( 'Tablero protegido en toda su sección', 'forestal-leon' ),
			'familia'    => 'plywood',
			'entradilla' => __( 'Tablero tratado con cobre micronizado mediante vacío-presión, que protege cada capa del panel.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'Protege frente a hongos, insectos y humedad. A diferencia del tratamiento en madera sólida, aquí el preservante debe penetrar en un tablero ya encolado, lo que exige un proceso más controlado y un secado en cámara posterior para recuperar la estabilidad dimensional.', 'forestal-leon' ),
			),
			'usos'       => __( 'Revestimientos en ambientes de alta humedad, construcciones en exterior, mueblería de uso exterior y proyectos industriales en condiciones adversas.', 'forestal-leon' ),
		),
		'vigas-y-pilares-laminados' => array(
			'titulo'     => __( 'Vigas y pilares laminados', 'forestal-leon' ),
			'subtitulo'  => __( 'Hasta 6 metros por pieza, a la vista o estructurales', 'forestal-leon' ),
			'familia'    => 'laminado',
			'entradilla' => __( 'El elemento estructural de referencia cuando hacen falta resistencia, estética y durabilidad en una sola pieza. Largos de hasta 6 metros.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'Se aplican tanto en estructuras ocultas como expuestas, y son especialmente valorados cuando quedan a la vista por su acabado limpio. Las vigas para techo permiten cubrir grandes espacios sin apoyos intermedios, generando ambientes amplios que no serían posibles con madera maciza convencional.', 'forestal-leon' ),
				__( 'Las cerchas laminadas resuelven techumbres de grandes luces con una eficiencia estructural que convierte la estructura en protagonista del espacio. El pilar laminado completa el sistema. Disponemos de tratamiento de impregnación y revestimientos aplicados en planta para garantizar durabilidad en interior y exterior.', 'forestal-leon' ),
			),
			'usos'       => __( 'Techumbres residenciales y comerciales, vigas decorativas en interiores, cerchas para galpones y gimnasios, pilares estructurales a la vista, lodges, cabañas y proyectos turísticos.', 'forestal-leon' ),
		),
		'deck-y-repisas' => array(
			'titulo'     => __( 'Deck y repisas', 'forestal-leon' ),
			'subtitulo'  => __( 'Piezas estables para exterior, sin pandeo ni torsión', 'forestal-leon' ),
			'familia'    => 'laminado',
			'entradilla' => __( 'La solución de mayor durabilidad para pisos de exterior, con piezas planas y estables que mantienen su geometría.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'A diferencia de la madera maciza, el laminado elimina las tensiones internas que causan pandeo y torsión con el tiempo. El resultado son piezas que aguantan la humedad variable sin deformarse.', 'forestal-leon' ),
				__( 'El deck para piscina es uno de los usos más exigentes: requiere un material que resista el contacto permanente con agua, productos de limpieza y exposición solar sin deteriorarse ni volverse peligroso. La misma lógica aplica a terrazas, repisas exteriores y escalones.', 'forestal-leon' ),
			),
			'usos'       => __( 'Deck para piscinas y terrazas, piso de terraza, escalones de madera en exteriores, repisas, pasarelas y pérgolas.', 'forestal-leon' ),
		),
		'laminado-glulam-cnc' => array(
			'titulo'     => __( 'Laminado Glulam CNC', 'forestal-leon' ),
			'subtitulo'  => __( 'Fabricación a medida con mecanizado de 5 ejes', 'forestal-leon' ),
			'familia'    => 'laminado',
			'entradilla' => __( 'Fabricación a pedido con mecanizado CNC de 5 ejes vinculado a modelado BIM 3D, para piezas fuera de lo estándar.', 'forestal-leon' ),
			'parrafos'   => array(
				__( 'La tecnología permite producir elementos con perforaciones, herrajes y conexiones de acero integradas, fabricados con la precisión necesaria para que cada pieza llegue a obra lista para instalar.', 'forestal-leon' ),
				__( 'Trabajamos a pedido: el cliente entrega el proyecto y nosotros fabricamos cada componente con sus uniones, pernos y conexiones ya incorporados. El resultado es un proceso constructivo más limpio, más rápido y con menos margen de error en terreno.', 'forestal-leon' ),
			),
			'usos'       => __( 'Edificios con estructura de madera, lodges y resorts, galpones de grandes luces, ampliaciones sobre estructuras existentes, pérgolas y cualquier proyecto que requiera piezas a medida con conexiones estructurales incorporadas.', 'forestal-leon' ),
		),
	);

	foreach ( $productos as $slug => $datos ) {
		if ( forestal_leon_buscar_por_slug( $slug, 'producto' ) ) {
			continue;
		}

		$id = wp_insert_post( array(
			'post_type'    => 'producto',
			'post_status'  => 'publish',
			'post_title'   => $datos['titulo'],
			'post_name'    => $slug,
			'post_excerpt' => $datos['entradilla'],
			'post_content' => forestal_leon_contenido_producto( $datos ),
		) );

		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}

		wp_set_object_terms( $id, $datos['familia'], 'familia-producto' );
	}
}

/**
 * Cuerpo de la ficha de proyecto de ejemplo (Galpón Forestal León).
 *
 * A diferencia de las páginas y productos, aquí el contenido ya es real —no
 * un volcado del patrón «forestal-leon/ficha-proyecto-estructura»—, salvo el
 * carrusel, las tres fotos, el bloque de texto y el collage final, que siguen
 * pendientes de las imágenes y del texto que faltan.
 *
 * @return string Marcado de bloques.
 */
function forestal_leon_contenido_ficha_ejemplo() {
	$bloques = array();

	$bloques[] = '<!-- wp:group {"metadata":{"name":"Carrusel — pendiente plugin"},"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->' . "\n"
		. '<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-antetitulo","align":"center","fontSize":"x-small"} -->' . "\n"
		. '<p class="is-style-antetitulo has-text-align-center has-x-small-font-size">' . esc_html__( 'Carrusel de imágenes — pendiente instalar un plugin de carrusel con autoplay. Primera foto: fotos-web/galpon-01-estructura.jpg', 'forestal-leon' ) . '</p>' . "\n"
		. '<!-- /wp:paragraph -->' . "\n\n"
		. '<!-- wp:gallery {"columns":1,"linkTo":"none"} -->' . "\n"
		. '<figure class="wp-block-gallery has-nested-images columns-1 is-cropped"></figure>' . "\n"
		. '<!-- /wp:gallery --></div>' . "\n"
		. '<!-- /wp:group -->';

	$datos = array(
		array( 'Proyecto', 'Galpón de Madera Forestal León' ),
		array( 'Localidad', 'Coelemu' ),
		array( 'Fecha de inicio', 'Febrero 2026' ),
		array( 'Fecha de término', 'Marzo 2026' ),
		array( 'Duración de ejecución', '~1 mes' ),
		array( 'Superficie', '1.020 m²' ),
		array( 'Volumen', 'Pendiente' ),
		array( 'Cálculo estructural', 'JMS Constructores' ),
		array( 'Ejecución', 'Forestal León' ),
	);

	$filas = array();

	foreach ( $datos as $dato ) {
		$filas[] = '<!-- wp:paragraph -->' . "\n"
			. '<p><strong>' . esc_html( $dato[0] ) . '</strong> ' . esc_html( $dato[1] ) . '</p>' . "\n"
			. '<!-- /wp:paragraph -->';
	}

	$bloques[] = '<!-- wp:group {"metadata":{"name":"Datos del proyecto"},"className":"is-style-filete-verde","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->' . "\n"
		. '<div class="wp-block-group is-style-filete-verde"><!-- wp:heading {"level":2,"fontSize":"heading-s"} -->' . "\n"
		. '<h2 class="wp-block-heading has-heading-s-font-size">' . esc_html__( 'Datos del proyecto', 'forestal-leon' ) . '</h2>' . "\n"
		. '<!-- /wp:heading -->' . "\n\n"
		. '<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->' . "\n"
		. '<div class="wp-block-group">' . implode( "\n\n", $filas ) . '</div>' . "\n"
		. '<!-- /wp:group --></div>' . "\n"
		. '<!-- /wp:group -->';

	$bloques[] = '<!-- wp:gallery {"columns":3,"linkTo":"none","align":"full"} -->' . "\n"
		. '<figure class="wp-block-gallery alignfull has-nested-images columns-3 is-cropped"></figure>' . "\n"
		. '<!-- /wp:gallery -->';

	$bloques[] = '<!-- wp:paragraph -->' . "\n"
		. '<p>' . esc_html__( 'Bloque de texto pendiente: el relato de la obra o el desafío técnico. Falta el texto real.', 'forestal-leon' ) . '</p>' . "\n"
		. '<!-- /wp:paragraph -->';

	$bloques[] = '<!-- wp:paragraph {"className":"is-style-antetitulo","align":"center","fontSize":"x-small"} -->' . "\n"
		. '<p class="is-style-antetitulo has-text-align-center has-x-small-font-size">' . esc_html__( 'Collage final — subir a Medios e insertar en este orden: galpon-02-detalle-conector-01.jpg, galpon-03-interior-testero.jpg, galpon-04-interior-nave.jpg, galpon-05-detalle-cercha.jpg, galpon-06-detalle-conector-02.jpg, galpon-07-detalle-conector-03.jpg, galpon-08-interior-luz.jpg, galpon-09-detalle-columna.jpg', 'forestal-leon' ) . '</p>' . "\n"
		. '<!-- /wp:paragraph -->';

	$bloques[] = '<!-- wp:gallery {"columns":4,"linkTo":"none","align":"full"} -->' . "\n"
		. '<figure class="wp-block-gallery alignfull has-nested-images columns-4 is-cropped"></figure>' . "\n"
		. '<!-- /wp:gallery -->';

	return implode( "\n\n", $bloques );
}

/**
 * Crea la ficha de proyecto de ejemplo al activar el tema.
 *
 * Es la que reciben, de momento, las tarjetas de referencia de Inicio,
 * Proyectos, Referencias, Edificios y Turismo cuando se hace clic: todavía no
 * hay una ficha por cada obra, así que todas apuntan aquí. El texto y los
 * datos ya son los reales del Galpón Forestal León; faltan el carrusel, las
 * tres fotos, el bloque de texto y el collage final.
 *
 * Cuando lleguen esas imágenes y el resto de referencias, esta ficha se
 * completa o se reemplaza por una entrada «Proyecto» distinta por cada obra,
 * y las tarjetas de esos cinco archivos de Elementor se actualizan para
 * apuntar cada una a la suya en vez de a «ejemplo-referencia».
 */
function forestal_leon_sembrar_proyecto_ejemplo() {
	$existente = forestal_leon_buscar_por_slug( 'ejemplo-referencia', 'proyecto' );

	if ( $existente ) {
		return;
	}

	$id = wp_insert_post( array(
		'post_type'    => 'proyecto',
		'post_status'  => 'publish',
		'post_title'   => __( 'Galpón Forestal León, Coelemu, Chile', 'forestal-leon' ),
		'post_name'    => 'ejemplo-referencia',
		'post_excerpt' => __( 'El proyecto Galpón Forestal León nació con el fin de demostrar el potencial del sistema BIM aplicado a la construcción en madera, logrando una estructura firme e imponente, capaz de exponerse a cualquier clima. Levantado en Coelemu entre febrero y marzo de 2026, el galpón alcanzó 1.020 m² de superficie en apenas un mes de ejecución, un plazo notablemente menor al que requeriría un galpón convencional de estructura de acero de dimensiones equivalentes. La obra fue construida en su totalidad por equipo propio de Forestal León: cada pieza fue diseñada y numerada previamente, de modo que el montaje en terreno consistió únicamente en unir las vigas de madera mediante conectores de acero diseñados por Forestal León, y la soldadura de cada pilar a los anclajes de fundación.', 'forestal-leon' ),
		'post_content' => forestal_leon_contenido_ficha_ejemplo(),
	) );

	if ( is_wp_error( $id ) || ! $id ) {
		return;
	}

	wp_set_object_terms( $id, 'viviendas', 'tipo-proyecto' );
}

/**
 * Busca una entrada por slug, incluida la papelera.
 *
 * get_page_by_path() no sirve aquí: al mandar algo a la papelera WordPress le
 * añade «__trashed» al slug, así que la búsqueda normal no lo encuentra y se
 * acaba creando un duplicado. Esta versión mira también lo borrado.
 *
 * @param string $slug Slug a buscar.
 * @param string $tipo Tipo de contenido.
 * @return WP_Post|null
 */
function forestal_leon_buscar_por_slug( $slug, $tipo ) {
	$encontrados = get_posts( array(
		'post_type'      => $tipo,
		'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'trash' ),
		'posts_per_page' => 1,
		'no_found_rows'  => true,
		'post_name__in'  => array( $slug, $slug . '__trashed' ),
	) );

	return $encontrados ? $encontrados[0] : null;
}

/**
 * Devuelve el contenido real de un patrón, no una referencia a él.
 *
 * Guardar «<!-- wp:pattern {"slug":"…"} /-->» en una página es cómodo, pero ese
 * contenido lo inyecta el tema al dibujar: la página, por dentro, está vacía.
 * Eso impide editarla bloque a bloque, y los constructores como Elementor la
 * ven en blanco — y la vacían de verdad si alguien pulsa Publicar.
 *
 * Volcando el contenido real, la página queda editable como cualquier otra.
 *
 * @param string $slug Slug del patrón.
 * @return string Marcado de bloques, o la referencia si el patrón no existe.
 */
function forestal_leon_contenido_de_patron( $slug ) {
	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {
		$patron = WP_Block_Patterns_Registry::get_instance()->get_registered( $slug );

		if ( ! empty( $patron['content'] ) ) {
			return $patron['content'];
		}
	}

	// Si aún no estuviera registrado, al menos se verá en la web.
	return '<!-- wp:pattern {"slug":"' . $slug . '"} /-->';
}

/**
 * Permite el iframe del vídeo mientras se crean las páginas.
 *
 * El hero de la portada es un iframe de YouTube. Al guardar el contenido de una
 * página, WordPress lo pasa por un filtro de seguridad que elimina los iframe
 * salvo que quien guarda tenga el permiso «unfiltered_html». Si eso ocurriera,
 * la portada se quedaría sin vídeo y sin ningún aviso.
 *
 * Este permiso solo está activo durante la siembra, y solo para el contenido
 * que genera el propio tema.
 *
 * @param array  $etiquetas Etiquetas permitidas.
 * @param string $contexto  Contexto del filtrado.
 * @return array
 */
function forestal_leon_permitir_iframe( $etiquetas, $contexto ) {
	if ( 'post' === $contexto ) {
		$etiquetas['iframe'] = array(
			'src'             => true,
			'class'           => true,
			'title'           => true,
			'width'           => true,
			'height'          => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'allow'           => true,
			'allowfullscreen' => true,
			'frameborder'     => true,
			'aria-hidden'     => true,
			'tabindex'        => true,
		);
	}

	return $etiquetas;
}

/**
 * Crea las páginas de las secciones al activar el tema.
 *
 * Sin esto, los enlaces «Construcción en madera», «Contacto», «Empresa»,
 * «Noticias» y «Grupo León» de la cabecera darían 404. Cada página se monta
 * a partir de los patrones del tema, así que el contenido se edita después
 * como cualquier otra página. Si ya existe una con ese slug, no se toca.
 */
function forestal_leon_sembrar_paginas() {
	$paginas = array(
		'inicio' => array(
			'titulo'   => __( 'Inicio', 'forestal-leon' ),
			'patrones' => array(
				'forestal-leon/hero-home',
				'forestal-leon/intro-empresa',
				'forestal-leon/video-corporativo',
				'forestal-leon/banda-productos',
				'forestal-leon/referencias-destacadas',
				'forestal-leon/actualidad',
				'forestal-leon/servicio-tiles',
			),
		),
		'construccion-en-madera' => array(
			'titulo'   => __( 'Construcción en madera', 'forestal-leon' ),
			'patrones' => array(
				'forestal-leon/construccion-intro',
				'forestal-leon/cta-proyecto',
			),
		),

		/*
		 * Las cinco subpáginas de Construcción en madera, tal como el cliente
		 * separó la sección en «Comentarios SOLUCIONES DE CONSTRUCCIÓN»:
		 * referencias, la madera como material, vivienda, edificios y turismo.
		 * Cada una con su título, su texto completo y sus imágenes.
		 */
		'referencias' => array(
			'titulo'   => __( 'Referencias', 'forestal-leon' ),
			'padre'    => 'construccion-en-madera',
			'patrones' => array( 'forestal-leon/referencias-destacadas', 'forestal-leon/cta-proyecto' ),
		),
		'madera-material-construccion' => array(
			'titulo'   => __( 'La madera como material de construcción', 'forestal-leon' ),
			'padre'    => 'construccion-en-madera',
			'patrones' => array( 'forestal-leon/ventajas-madera', 'forestal-leon/cta-proyecto' ),
		),
		'viviendas' => array(
			'titulo'   => __( 'Viviendas', 'forestal-leon' ),
			'padre'    => 'construccion-en-madera',
			'patrones' => array( 'forestal-leon/tipologia-viviendas', 'forestal-leon/cta-proyecto' ),
		),
		'edificios' => array(
			'titulo'   => __( 'Edificios', 'forestal-leon' ),
			'padre'    => 'construccion-en-madera',
			'patrones' => array( 'forestal-leon/tipologia-edificios', 'forestal-leon/cta-proyecto' ),
		),
		'turismo' => array(
			'titulo'   => __( 'Turismo', 'forestal-leon' ),
			'padre'    => 'construccion-en-madera',
			'patrones' => array( 'forestal-leon/tipologia-turismo', 'forestal-leon/cta-proyecto' ),
		),
		'contacto' => array(
			'titulo'   => __( 'Contacto', 'forestal-leon' ),
			'patrones' => array(
				'forestal-leon/contacto',
			),
		),
		/*
		 * Quiénes somos, en el orden del documento «Programa forestal león»:
		 * vídeo introductorio, texto introductorio, historia, valores, misión
		 * y visión. empresa-intro monta las tres primeras piezas y
		 * empresa-valores cierra con valores, misión y visión.
		 */
		'empresa' => array(
			'titulo'   => __( 'Quiénes Somos', 'forestal-leon' ),
			'patrones' => array(
				'forestal-leon/empresa-intro',
				'forestal-leon/empresa-historia',
				'forestal-leon/empresa-valores',
				'forestal-leon/cta-cotizar',
			),
		),
		'grupo-leon' => array(
			'titulo'   => __( 'Grupo León', 'forestal-leon' ),
			'patrones' => array(
				'forestal-leon/grupo-leon',
				'forestal-leon/cta-cotizar',
			),
		),
		/*
		 * Catálogo y familias, como páginas y no como archivos.
		 *
		 * Antes /productos, /proyectos y las tres familias los resolvía
		 * WordPress por su cuenta (archivo de tipo de contenido y archivo de
		 * taxonomía). Eso los dejaba fuera del alcance de Elementor gratuito,
		 * que no maqueta archivos. Convertidas en páginas se editan igual que
		 * el resto.
		 *
		 * Las familias van en la raíz —/madera-aserrada— y no colgando de
		 * /productos, porque esa ruta ya la ocupan las fichas de producto
		 * (/productos/seco-cepillado) y una página ahí quedaría eclipsada.
		 */
		'productos' => array(
			'titulo'   => __( 'Productos', 'forestal-leon' ),
			'patrones' => array(),
		),
		'madera-aserrada' => array(
			'titulo'   => __( 'Madera aserrada', 'forestal-leon' ),
			'patrones' => array(),
		),
		'plywood' => array(
			'titulo'   => __( 'Plywood', 'forestal-leon' ),
			'patrones' => array(),
		),
		'laminado' => array(
			'titulo'   => __( 'Laminado', 'forestal-leon' ),
			'patrones' => array(),
		),
		'proyectos' => array(
			'titulo'   => __( 'Proyectos', 'forestal-leon' ),
			'patrones' => array(),
		),
		/*
		 * «Trabaja con nosotros» se retiró el 18-8-2026: el cliente no busca
		 * personal y no quiere ese apartado en la web. Se han quitado también
		 * la banda de la portada, el enlace del pie y el patrón banda-trabaja.
		 */
		'noticias' => array(
			'titulo'   => __( 'Noticias', 'forestal-leon' ),
			'patrones' => array(),   // se asigna como página de entradas más abajo
		),
		'aviso-legal' => array(
			'titulo'   => __( 'Aviso legal', 'forestal-leon' ),
			'patrones' => array(),
			'aviso'    => __( 'Página pendiente: redactar el aviso legal con identificación de la empresa y condiciones de uso.', 'forestal-leon' ),
		),
		'privacidad' => array(
			'titulo'   => __( 'Privacidad', 'forestal-leon' ),
			'patrones' => array(),
			'aviso'    => __( 'Página pendiente: redactar la política de privacidad y el tratamiento de datos de los formularios.', 'forestal-leon' ),
		),
	);

	$creadas = array();

	add_filter( 'wp_kses_allowed_html', 'forestal_leon_permitir_iframe', 10, 2 );

	foreach ( $paginas as $slug => $datos ) {
		$existente = forestal_leon_buscar_por_slug( $slug, 'page' );

		$referencias = '';
		$contenido = '';

		if ( $existente ) {
			$creadas[ $slug ] = $existente->ID;

			/*
			 * Si la página se quedó con las referencias a patrones y nadie la ha
			 * tocado, la rellenamos con el contenido real para que sea editable.
			 * Si ya no coincide, es que alguien la editó: no se toca.
			 */
			/*
			 * No se toca el contenido de una página que ya existe.
			 *
			 * El contenido lo construye Elementor. Si el tema lo rellenara,
			 * machacaría el trabajo hecho en el constructor cada vez que se
			 * sube una versión nueva.
			 */
			continue;
		}

		if ( ! empty( $datos['aviso'] ) ) {
			$contenido .= '<!-- wp:paragraph {"className":"is-style-antetitulo"} -->' . "\n"
				. '<p class="is-style-antetitulo">' . esc_html( $datos['aviso'] ) . '</p>' . "\n"
				. '<!-- /wp:paragraph -->';
		}

		$args = array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $datos['titulo'],
			'post_name'    => $slug,
			'post_content' => trim( $contenido ),
		);

		// Las subpáginas cuelgan de su madre: /construccion-en-madera/viviendas
		if ( ! empty( $datos['padre'] ) && ! empty( $creadas[ $datos['padre'] ] ) ) {
			$args['post_parent'] = $creadas[ $datos['padre'] ];
		}

		$id = wp_insert_post( $args );

		if ( ! is_wp_error( $id ) && $id ) {
			$creadas[ $slug ] = $id;
		}
	}

	remove_filter( 'wp_kses_allowed_html', 'forestal_leon_permitir_iframe', 10 );

	// Portada estática y página de entradas, solo si nadie las ha configurado ya.
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		if ( ! empty( $creadas['inicio'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $creadas['inicio'] );
		}

		if ( ! empty( $creadas['noticias'] ) ) {
			update_option( 'page_for_posts', $creadas['noticias'] );
		}
	}
}

/**
 * Monta el contenido de una ficha de producto.
 *
 * Misma estructura que las páginas de Construcción en madera: subtítulo,
 * fotografía a ancho ampliado, texto corrido, usos y galería de tres.
 * Sin tablas de datos ni tarjetas de especificaciones: el cliente pidió que
 * Productos no fuera un punto de venta y que se concentrara en textos e
 * imágenes.
 */
function forestal_leon_contenido_producto( $datos ) {
	$bloques = array();

	if ( ! empty( $datos['subtitulo'] ) ) {
		$bloques[] = '<!-- wp:paragraph {"className":"is-style-subtitulo-seccion"} -->' . "\n"
			. '<p class="is-style-subtitulo-seccion">' . esc_html( $datos['subtitulo'] ) . "</p>\n"
			. '<!-- /wp:paragraph -->';
	}

	$bloques[] = '<!-- wp:image {"align":"wide","aspectRatio":"16/9","scale":"cover","sizeSlug":"large"} -->' . "\n"
		. '<figure class="wp-block-image alignwide size-large"><img alt="'
		. esc_attr( $datos['titulo'] ) . '" style="aspect-ratio:16/9;object-fit:cover"/></figure>' . "\n"
		. '<!-- /wp:image -->';

	foreach ( $datos['parrafos'] as $parrafo ) {
		$bloques[] = "<!-- wp:paragraph -->\n<p>" . esc_html( $parrafo ) . "</p>\n<!-- /wp:paragraph -->";
	}

	$bloques[] = "<!-- wp:heading {\"level\":2,\"fontSize\":\"heading-s\"} -->\n"
		. '<h2 class="wp-block-heading has-heading-s-font-size">'
		. esc_html__( 'Usos', 'forestal-leon' ) . "</h2>\n<!-- /wp:heading -->";

	$bloques[] = "<!-- wp:paragraph -->\n<p>" . esc_html( $datos['usos'] ) . "</p>\n<!-- /wp:paragraph -->";

	$bloques[] = '<!-- wp:gallery {"columns":3,"linkTo":"none","align":"wide"} -->' . "\n"
		. '<figure class="wp-block-gallery alignwide has-nested-images columns-3 is-cropped"></figure>' . "\n"
		. '<!-- /wp:gallery -->';

	return implode( "\n\n", $bloques );
}

/**
 * Enlace "saltar al contenido" para lectores de pantalla y teclado.
 */
function forestal_leon_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#wp--skip-link--target">'
		. esc_html__( 'Saltar al contenido', 'forestal-leon' )
		. '</a>';
}
add_action( 'wp_body_open', 'forestal_leon_skip_link' );

/**
 * Instala el logotipo al activar el tema.
 *
 * Copia el PNG que viaja en /assets/images/ a la biblioteca de medios y lo
 * deja configurado como logotipo del sitio. Así la cabecera no aparece vacía
 * la primera vez. Solo actúa si todavía no hay un logotipo definido: si el
 * cliente ya subió el suyo, no se toca.
 */
function forestal_leon_instalar_logo() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return;
	}

	$origen = get_template_directory() . '/assets/images/logo-forestal-leon.png';

	if ( ! file_exists( $origen ) ) {
		return;
	}

	// ¿Ya se importó en una activación anterior?
	$existente = get_posts( array(
		'post_type'   => 'attachment',
		'post_status' => 'inherit',
		'numberposts' => 1,
		'fields'      => 'ids',
		'meta_key'    => '_forestal_leon_logo',
		'meta_value'  => '1',
	) );

	if ( ! empty( $existente ) ) {
		set_theme_mod( 'custom_logo', (int) $existente[0] );
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$subidas = wp_upload_dir();

	if ( ! empty( $subidas['error'] ) ) {
		return;
	}

	$destino = trailingslashit( $subidas['path'] ) . 'logo-forestal-leon.png';

	if ( ! copy( $origen, $destino ) ) {
		return;
	}

	$adjunto = wp_insert_attachment( array(
		'post_mime_type' => 'image/png',
		'post_title'     => __( 'Logotipo Forestal León', 'forestal-leon' ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	), $destino );

	if ( is_wp_error( $adjunto ) || ! $adjunto ) {
		return;
	}

	wp_update_attachment_metadata( $adjunto, wp_generate_attachment_metadata( $adjunto, $destino ) );
	update_post_meta( $adjunto, '_wp_attachment_image_alt', __( 'Forestal León', 'forestal-leon' ) );
	update_post_meta( $adjunto, '_forestal_leon_logo', '1' );

	set_theme_mod( 'custom_logo', $adjunto );
}
add_action( 'after_switch_theme', 'forestal_leon_instalar_logo' );

/**
 * Rejilla de noticias — shortcode [noticias_forestal].
 *
 * Elementor gratuito no trae widget de entradas: el de «Posts» es de la versión
 * Pro. En vez de comprarla o de meter un pack de complementos solo por esto, el
 * tema publica un shortcode y en Elementor se inserta con el widget «Shortcode»,
 * que sí es gratuito.
 *
 * Atributos:
 *   cantidad   número de tarjetas (3 por defecto; el cliente pidió 3 o 4)
 *   categoria  slug de la categoría; si no existe o está vacía, cae en las
 *              entradas más recientes para que el bloque nunca salga en blanco
 *
 * Sin flechas ni carrusel: es una rejilla estática, tal como se pidió.
 */
function forestal_leon_noticias( $atributos ) {
	$a = shortcode_atts( array(
		'cantidad'  => 3,
		'categoria' => 'noticias',
	), $atributos, 'noticias_forestal' );

	$cantidad = max( 1, min( 4, (int) $a['cantidad'] ) );

	$consulta = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $cantidad,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$categoria = get_category_by_slug( $a['categoria'] );

	if ( $categoria ) {
		$entradas = get_posts( $consulta + array( 'category' => $categoria->term_id ) );
	} else {
		$entradas = array();
	}

	// Sin categoría, o con la categoría vacía: las más recientes de todo el blog.
	if ( ! $entradas ) {
		$entradas = get_posts( $consulta );
	}

	if ( ! $entradas ) {
		return current_user_can( 'edit_posts' )
			? '<p class="fl-noticias__vacio">' . esc_html__( 'Aún no hay entradas publicadas. Publica en Entradas y aparecerán aquí automáticamente.', 'forestal-leon' ) . '</p>'
			: '';
	}

	$html = '<div class="fl-noticias fl-noticias--' . count( $entradas ) . '">';

	foreach ( $entradas as $entrada ) {
		$enlace  = get_permalink( $entrada );
		$imagen  = forestal_leon_imagen_de_entrada( $entrada );
		$extracto = get_the_excerpt( $entrada );

		$html .= '<article class="fl-noticia">';

		if ( $imagen ) {
			$html .= '<a class="fl-noticia__foto" href="' . esc_url( $enlace ) . '" tabindex="-1" aria-hidden="true">' . $imagen . '</a>';
		}

		$html .= '<div class="fl-noticia__cuerpo">';
		$html .= '<p class="fl-noticia__fecha">' . esc_html( get_the_date( 'd.m.Y', $entrada ) ) . '</p>';
		$html .= '<h3 class="fl-noticia__titulo"><a href="' . esc_url( $enlace ) . '">' . esc_html( get_the_title( $entrada ) ) . '</a></h3>';

		if ( $extracto ) {
			$html .= '<p class="fl-noticia__extracto">' . esc_html( wp_trim_words( $extracto, 32, '…' ) ) . '</p>';
		}

		$html .= '<p class="fl-noticia__mas"><a href="' . esc_url( $enlace ) . '">' . esc_html__( 'más información', 'forestal-leon' ) . '</a></p>';
		$html .= '</div></article>';
	}

	return $html . '</div>';
}
add_shortcode( 'noticias_forestal', 'forestal_leon_noticias' );

/**
 * Imagen de una entrada para la tarjeta de noticias.
 *
 * Primero la imagen destacada. Si no la tiene, se coge la primera imagen que
 * haya dentro del propio texto de la entrada: así basta con insertarla en el
 * editor, sin acordarse del panel lateral.
 *
 * Se busca por este orden:
 *   1. Imagen destacada.
 *   2. Primera imagen de la biblioteca dentro del contenido; se reconoce por la
 *      clase «wp-image-123» que WordPress pone al insertarla. Al tener el
 *      identificador, se pide el tamaño «large» en vez de servir el original,
 *      que puede pesar varios megas.
 *
 * Solo valen imágenes de la biblioteca de medios. Las pegadas por URL quedan
 * fuera a propósito: sin identificador no hay tamaños recortados —se serviría
 * el original entero, de varios megas— ni control sobre el archivo, que puede
 * desaparecer si está alojado fuera.
 *
 * @param WP_Post $entrada La entrada.
 * @return string El HTML de la imagen, o cadena vacía si no hay ninguna.
 */
function forestal_leon_imagen_de_entrada( $entrada ) {
	if ( has_post_thumbnail( $entrada ) ) {
		return get_the_post_thumbnail( $entrada, 'large', array( 'loading' => 'lazy', 'alt' => '' ) );
	}

	$contenido = $entrada->post_content;

	if ( preg_match( '/wp-image-(\d+)/', $contenido, $coincidencia ) ) {
		$html = wp_get_attachment_image(
			(int) $coincidencia[1],
			'large',
			false,
			array( 'loading' => 'lazy', 'alt' => '' )
		);

		if ( $html ) {
			return $html;
		}
	}

	return '';
}
