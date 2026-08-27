<?php
/**
 * Title: Referencias más destacadas
 * Slug: forestal-leon/referencias-destacadas
 * Categories: forestal-leon, featured
 * Description: El par de titulares, un párrafo de contexto y las seis últimas obras en dos columnas, con el botón Más al final.
 */
?>
<!-- wp:group {"metadata":{"name":"Referencias más destacadas"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":2,"className":"is-style-titulo-seccion"} -->
<h2 class="wp-block-heading is-style-titulo-seccion">Referencias más destacadas</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-subtitulo-seccion"} -->
<p class="is-style-subtitulo-seccion">Soluciones constructivas en madera</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>Acompañamos el proyecto de principio a fin: asesoramiento, cálculo, fabricación y montaje. Estas son algunas de las obras en las que hemos participado con soluciones constructivas en madera.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":6,"pages":1,"offset":0,"postType":"proyecto","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|10"}}} -->
<div class="wp-block-group"><!-- wp:post-title {"isLink":true,"fontSize":"small"} /-->

<!-- wp:post-terms {"term":"tipo-proyecto","fontSize":"small","textColor":"contrast-mid"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Publica obras en Proyectos › Añadir proyecto y aparecerán aquí automáticamente, de la más reciente a la más antigua.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/proyectos">Más</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
