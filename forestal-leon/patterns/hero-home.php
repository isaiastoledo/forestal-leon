<?php
/**
 * Title: Portada — vídeo a sangre
 * Slug: forestal-leon/hero-home
 * Categories: forestal-leon, banner
 * Description: Franja de apertura con el vídeo institucional a todo el ancho, en bucle y sin sonido. Sin texto encima: el mensaje va en el módulo siguiente.
 *
 * El vídeo es el mismo que abre forestalleon.cl (YouTube U2uNIk43eXc). Para
 * cambiarlo, sustituye las dos apariciones del identificador en el src: va una
 * vez como ruta y otra en el parámetro "playlist", que es lo que hace el bucle.
 *
 * Si prefieres una imagen fija, borra este patrón y usa un bloque Portada
 * normal: pesa mucho menos y no depende de YouTube.
 */
?>
<!-- wp:group {"metadata":{"name":"Portada — vídeo"},"align":"full","className":"fl-hero-video","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull fl-hero-video" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0"><!-- wp:html -->
<iframe
	class="fl-hero-video__iframe"
	src="https://www.youtube-nocookie.com/embed/U2uNIk43eXc?autoplay=1&amp;mute=1&amp;loop=1&amp;playlist=U2uNIk43eXc&amp;controls=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1&amp;disablekb=1"
	title="Forestal León — vídeo institucional"
	loading="eager"
	referrerpolicy="strict-origin-when-cross-origin"
	allow="autoplay; encrypted-media; picture-in-picture"
	frameborder="0"
	aria-hidden="true"
	tabindex="-1"></iframe>
<!-- /wp:html --></div>
<!-- /wp:group -->
