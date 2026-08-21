<?php
/**
 * Title: Actualidad — últimas noticias
 * Slug: forestal-leon/actualidad
 * Categories: forestal-leon, posts
 * Description: Las cuatro noticias más recientes en tarjetas con fecha, titular y extracto, y el botón Más al final.
 */
?>
<!-- wp:group {"metadata":{"name":"Actualidad"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-alt-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"level":2,"className":"is-style-titulo-seccion"} -->
<h2 class="wp-block-heading is-style-titulo-seccion">Actualidad</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":0,"query":{"perPage":4,"pages":1,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":4}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|20"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:post-date {"format":"d.m.Y","fontSize":"x-small","textColor":"contrast-mid"} /-->

<!-- wp:post-title {"isLink":true,"fontSize":"large"} /-->

<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"fontSize":"small","showMoreOnNewLine":true,"moreText":"más información"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Publica artículos en Entradas y aparecerán aquí automáticamente.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/noticias">Más</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
