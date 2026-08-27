<?php
/**
 * Title: Ficha de proyecto — estructura
 * Slug: forestal-leon/ficha-proyecto-estructura
 * Categories: forestal-leon
 * Description: Cuerpo de la ficha de referencia (carrusel, datos del proyecto, tres fotos a ancho completo, texto y collage final), calcado en estructura a las páginas de obra de binderholz.com. Solo estructura: los textos y las imágenes son marcadores de posición para reemplazar por el contenido real de cada obra.
 *
 * Se inserta como contenido de una entrada de «Proyecto» (Proyectos › Añadir
 * proyecto). El antetítulo «Referencias», el título, la entradilla (el texto
 * introductorio) ya los pone la plantilla single-proyecto.html; este patrón
 * es lo que va DEBAJO, en el cuerpo editable.
 *
 * OJO — el carrusel: WordPress sin Elementor Pro ni plugins no trae un bloque
 * de carrusel. Lo de abajo es solo el hueco marcado con varias imágenes; para
 * que se mueva solo (autoplay) hace falta un plugin de carrusel/slider
 * gratuito (por ejemplo el bloque «Slideshow» de Jetpack) que sustituya este
 * bloque de galería por el suyo.
 */
?>
<!-- wp:group {"metadata":{"name":"Carrusel — pendiente plugin"},"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-antetitulo","align":"center","fontSize":"x-small"} -->
<p class="is-style-antetitulo has-text-align-center has-x-small-font-size">Carrusel de imágenes — pendiente instalar un plugin de carrusel con autoplay</p>
<!-- /wp:paragraph -->

<!-- wp:gallery {"columns":1,"linkTo":"none"} -->
<figure class="wp-block-gallery has-nested-images columns-1 is-cropped"></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Datos del proyecto"},"className":"is-style-filete-verde","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-filete-verde"><!-- wp:heading {"level":2,"fontSize":"heading-s"} -->
<h2 class="wp-block-heading has-heading-s-font-size">Datos del proyecto</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><strong>Proyecto</strong> Nombre del proyecto</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Localidad</strong> Ciudad, país</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Fecha de inicio</strong> Mes y año</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Fecha de término</strong> Mes y año</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Duración de ejecución</strong> Cifra de meses o semanas</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Superficie</strong> Cifra m²</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Volumen</strong> Cifra m³ de madera</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Arquitectura</strong> Oficina de arquitectura (opcional, borrar si no aplica)</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Cálculo estructural</strong> Oficina de cálculo (opcional, borrar si no aplica)</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Ejecución</strong> Empresa ejecutora</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:gallery {"columns":3,"linkTo":"none","align":"full"} -->
<figure class="wp-block-gallery alignfull has-nested-images columns-3 is-cropped"></figure>
<!-- /wp:gallery -->

<!-- wp:paragraph -->
<p>Bloque de texto: el relato de la obra, el desafío técnico o el proceso constructivo. Reemplazar por el texto real.</p>
<!-- /wp:paragraph -->

<!-- wp:gallery {"columns":4,"linkTo":"none","align":"full"} -->
<figure class="wp-block-gallery alignfull has-nested-images columns-4 is-cropped"></figure>
<!-- /wp:gallery -->
