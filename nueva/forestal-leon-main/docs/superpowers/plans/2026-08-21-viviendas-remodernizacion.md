# Viviendas — remodernización de la página — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Reconstruir la página Viviendas como espejo de `binderholz.com/es/soluciones-de-construccion/vivienda-unifamiliar/`, según la especificación aprobada en `docs/superpowers/specs/2026-08-21-viviendas-remodernizacion-design.md`.

**Architecture:** Dos artefactos independientes que comparten el mismo contenido y el mismo sistema de diseño (`theme.json` tokens): una vista previa HTML autónoma para validar en navegador, y el JSON de Elementor regenerado con un script Node que construye el árbol de contenedores con funciones factoría (evita repetir 900 líneas de JSON a mano). Ningún archivo del tema (`forestal-leon/patterns/*.php`) se toca.

**Tech Stack:** HTML/CSS estático (sin build), Node.js (script de generación, ya presente en el sistema — `node v24.16.0`), JSON (formato Elementor 0.4).

---

## Contexto que un ingeniero nuevo necesita

- El repo no es un repositorio git (`git status` falla con "not a git repository"). No hay commits que hacer en esta tarea.
- La página vive en dos formas: `forestal-leon/patterns/tipologia-viviendas.php` (patrón del tema, **no tocar**, ver `ELEMENTOR.md` § 5) y `elementor/viviendas.json` (lo que de verdad se ve, servido por Elementor).
- El precedente inmediato es `preview-madera-material-construccion.html` + `elementor/madera-material-construccion.json`, remodernizados el 21 de agosto de 2026. Ese JSON usa una convención de portada (fondo blanco clásico, `boxed_width: 1312`, tarjetas con `box_shadow_box_shadow_type`) más nueva que la que tiene hoy `viviendas.json` (fondo verde oscuro `#1C3829`, sin box-shadow). Esta tarea adopta la convención nueva.
- No hay fotografías reales de viviendas ejecutadas en el repo. `fotos-web/` solo tiene fotos industriales (naves, cerchas, uniones). Los tres títulos de obra actuales en `viviendas.json` («Vivienda unifamiliar, Los Ríos», etc.) son inventados y no se pueden reutilizar: la spec § 6 lo prohíbe explícitamente.
- Servir la vista previa: `python -m http.server 4322` desde la raíz del repo, luego abrir `http://localhost:4322/preview-viviendas.html`. (`python` no está en PATH en esta máquina — usar `py -m http.server 4322` o `python3 -m http.server 4322`, verificado en la Tarea 3.)

## File Structure

| Archivo | Acción | Responsabilidad |
|---|---|---|
| `preview-viviendas.html` | Crear | Vista previa estática autocontenida, para validar visualmente los 5 módulos |
| `elementor/viviendas.json` | Sobrescribir | El único artefacto que llega a producción |
| `scripts/build-viviendas-json.js` | Crear (temporal, puede borrarse tras usarlo) | Genera `elementor/viviendas.json` desde funciones factoría, evita 900 líneas de JSON copiadas a mano |

---

## Task 1: Vista previa HTML

**Files:**
- Create: `preview-viviendas.html`

- [ ] **Step 1: Escribir el archivo completo**

```html
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vista previa — Viviendas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet">
<style>
:root{
  --base:#ffffff; --base-alt:#fafaf7; --cream:#f4efe4; --section-grey:#ECEBE6;
  --primary:#01735a; --primary-dark:#015644;
  --forest-deep:#1c3829; --forest-mid:#2e5940; --forest-light:#4a7c5f;
  --sage:#7a9e7e; --sage-pale:#c5d9c6;
  --wood:#c4832a; --wood-text:#a16b22; --wood-pale:#e8c48a; --bark:#3d2b1f;
  --contrast:#3c3c38; --ink:#1a1a17; --contrast-mid:#6b6b64;
  --stone:#8a8679; --border:#d4d0c8;
  --s10:.5rem; --s20:1rem; --s30:1.5rem; --s40:2rem; --s50:3rem;
  --s60:clamp(3rem,6vw,5rem); --s70:clamp(4rem,8vw,6rem);
  --t-fast:.128s ease-out; --t-base:.256s ease-out;
  --sombra-sutil:0 1px 2px rgba(26,26,23,.06);
  --sombra-media:0 4px 16px rgba(26,26,23,.08);
  --sombra-alta:0 12px 40px rgba(26,26,23,.12);
  --font:"Open Sans",-apple-system,"Segoe UI",Helvetica,Arial,sans-serif;
}

.reveal{opacity:0;transform:translateY(20px);
  transition:opacity .55s ease-out var(--d,0s),transform .55s ease-out var(--d,0s)}
.reveal.visible{opacity:1;transform:none}
@media(prefers-reduced-motion:reduce){
  .reveal,.reveal.visible{opacity:1;transform:none;transition:none}
  *{transition:none!important;animation:none!important}
}
*{box-sizing:border-box}
body{margin:0;background:var(--base);color:var(--contrast);font-family:var(--font);font-size:16px;line-height:1.75}
.wrap{max-width:1360px;margin-inline:auto;padding:0 clamp(1rem,2vw,1.5rem)}
p{margin:0}
a{color:var(--primary);text-decoration:underline;transition:color var(--t-fast)}
a:hover{color:var(--primary-dark)}
h1,h2,h3,h4{font-family:var(--font);font-weight:400;line-height:1.15;margin:0;color:var(--ink)}

.hdr{padding:var(--s30) 0;border-bottom:1px solid var(--border);background:#fff;
  box-shadow:var(--sombra-sutil);position:relative;z-index:5}
.hdr .wrap{display:flex;align-items:center;justify-content:space-between;gap:var(--s30);flex-wrap:wrap}
.hdr img{height:44px;width:auto;display:block}
.hdr nav ul{display:flex;gap:var(--s30);align-items:center;flex-wrap:wrap;list-style:none;margin:0;padding:0}
.hdr nav a{font-size:.9375rem;font-weight:700;text-transform:uppercase;color:var(--primary);text-decoration:none}
.hdr nav a:hover{color:var(--primary-dark)}
.hdr .cotizar{background:var(--primary);color:#fff!important;padding:.7rem 1.1rem}

.aviso{background:var(--ink);color:#fff;font-size:.8125rem;text-align:center;padding:.6rem 1rem;line-height:1.6}
.aviso strong{color:var(--sage-pale)}
.aviso code{background:rgba(255,255,255,.12);padding:.1rem .35rem}

/* ---- 1. portada clara, con texto primero (binderholz) ---- */
.hero{padding:clamp(3rem,7vw,4.5rem) 0 clamp(2rem,5vw,3rem);
  background:linear-gradient(180deg,var(--base) 0%,var(--base-alt) 100%)}
.hero .lbl{color:var(--primary);font-size:.9375rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:var(--s10)}
.hero h1{color:var(--primary);font-size:clamp(2rem,5.5vw,3.875rem);text-transform:uppercase;line-height:1.1}
.hero h2{color:var(--contrast);font-weight:400;font-size:clamp(1.5rem,3.4vw,2.5rem);line-height:1.25;margin-top:.25rem}
.hero .entradilla{margin-top:var(--s30);font-size:1.125rem;line-height:1.75;color:var(--contrast);max-width:62ch}

.banda-seccion{padding-bottom:var(--s60);background:var(--base-alt)}
.banda-foto{aspect-ratio:16/9;box-shadow:var(--sombra-alta);overflow:hidden}
.banda-foto img{width:100%;height:100%;display:block;object-fit:cover}

/* ---- 2. tarjeta destacada — sustituye el descargable de binderholz ---- */
.destacada-seccion{padding:0 0 var(--s70);background:var(--base-alt)}
.destacada{background:var(--cream);border-top:4px solid var(--primary);padding:var(--s40);
  box-shadow:var(--sombra-media);transition:box-shadow var(--t-base);
  display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1.5rem 2rem}
.destacada:hover{box-shadow:var(--sombra-alta)}
.destacada__texto{flex:1 1 420px}
.destacada h3{font-size:1.375rem;font-weight:700;color:var(--ink)}
.destacada p{margin-top:.5rem;font-size:1rem;line-height:1.75;color:var(--contrast);max-width:52ch}
.btn{display:inline-block;margin-top:1.25rem;padding:.85rem 1.5rem;border:1px solid var(--primary);
  color:var(--primary);font-size:.9375rem;font-weight:700;text-decoration:none;text-transform:uppercase;
  letter-spacing:.02em;transition:background var(--t-base),color var(--t-base)}
.btn:hover{background:var(--primary);color:#fff}
.destacada__texto .btn{flex:0 0 auto}

/* ---- 3. texto de soluciones constructivas — oficial, sin resumir ---- */
.texto-seccion{padding:var(--s70) 0;background:var(--base)}
.texto-seccion .medida{max-width:62ch}
.texto-seccion p{font-size:1rem;line-height:1.75;color:var(--contrast)}
.texto-seccion p+p{margin-top:1.1rem}
.texto-seccion strong{color:var(--ink)}

/* ---- 4. parrilla de referencias — el módulo que sostiene la página ---- */
.referencias{padding:var(--s70) 0;background:var(--section-grey)}
.referencias > .wrap > h2{color:var(--primary);text-transform:uppercase;font-size:clamp(1.625rem,3.4vw,2.875rem)}
.referencias .nota-estado{margin-top:.5rem;font-size:.9375rem;color:var(--contrast-mid);max-width:52ch}
.ref-grid{display:flex;flex-wrap:wrap;gap:2rem;margin-top:var(--s60)}
/* 3 columnas si hay 6 obras o más; con menos, --2up fuerza 2 columnas grandes
   para que la última fila no quede con huecos vacíos (spec, módulo 4) */
.ref-grid .ref-card{flex:1 1 360px;max-width:400px}
.ref-grid.ref-grid--2up .ref-card{flex-basis:460px;max-width:560px}
.ref-card__foto{position:relative;aspect-ratio:4/3;overflow:hidden;box-shadow:var(--sombra-media);
  transition:box-shadow var(--t-base)}
.ref-card__foto:hover{box-shadow:var(--sombra-alta)}
.ref-card__foto img{width:100%;height:100%;display:block;object-fit:cover;transition:transform .5s ease-out}
.ref-card__foto:hover img{transform:scale(1.04)}
.ref-card__badge{position:absolute;top:.75rem;left:.75rem;background:rgba(26,26,23,.82);color:#fff;
  font-size:.6875rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .6rem}
.ref-card__pie{margin-top:.75rem;font-size:.9375rem;line-height:1.6;color:var(--contrast-mid)}

/* ---- 5. contacto — cuatro puertas, igual en las 16 páginas, sin tocar ---- */
.contacto{padding:var(--s70) 0;background:var(--base)}
.contacto h2{color:var(--primary);text-transform:uppercase;font-size:clamp(1.875rem,4.5vw,4.75rem);line-height:1.1}
.tiles{display:flex;flex-wrap:wrap;gap:var(--s30);margin-top:var(--s30)}
.tile{flex:1 1 260px;border:1px solid var(--border);padding:var(--s40);box-shadow:var(--sombra-sutil)}
.tile h4{font-size:1.125rem;font-weight:700;color:var(--ink)}
.tile p{margin-top:.5rem;font-size:1rem;line-height:1.75;color:var(--contrast)}
.tile .btn{margin-top:1rem;padding:.65rem 0;border:0;text-transform:none;letter-spacing:0;font-weight:700}
.tile .btn:hover{background:none;color:var(--primary-dark)}

footer{background:var(--forest-deep);color:#fff;padding:var(--s50) 0}
footer p{font-size:.8125rem;color:var(--sage-pale);text-align:center}
</style>
</head>
<body>

<div class="aviso">Vista previa estática — no interactiva — de la propuesta para <strong>«Viviendas»</strong>, espejo de binderholz. Las tres tarjetas de Referencias usan fotos de planta de <code>fotos-web/</code> como marcador visible: aún no hay fotografía de obra ejecutada, y por eso no llevan nombre de proyecto inventado. Genera el JSON real en <code>elementor/viviendas.json</code>.</div>

<div class="hdr"><div class="wrap">
  <img src="forestal-leon/assets/images/logo-forestal-leon.png" alt="Forestal León">
  <nav aria-label="Navegación principal"><ul>
    <li><a href="#">Inicio</a></li>
    <li><a href="#">Construcción en madera</a></li>
    <li><a href="#">Productos</a></li>
    <li><a href="#">Quiénes Somos</a></li>
    <li><a href="#">Servicio</a></li>
    <li><a href="#" class="cotizar">Cotizar</a></li>
  </ul></nav>
</div></div>

<!-- 1. PORTADA — el párrafo del bienestar sube a entradilla (binderholz abre con el bienestar, no con la técnica) -->
<section class="hero"><div class="wrap">
  <p class="lbl reveal">Construcción en madera</p>
  <h1 class="reveal" style="--d:.08s">Viviendas</h1>
  <h2 class="reveal" style="--d:.16s">Construcción de viviendas unifamiliares en madera</h2>
  <p class="entradilla reveal" style="--d:.24s">Una vivienda en madera es sinónimo de bienestar y confort. Las superficies de madera y sus propiedades naturales para retener el calor y regular la humedad crean un clima interior equilibrado, convirtiendo cada espacio en un ambiente cálido y agradable para vivir.</p>
</div></section>

<div class="banda-seccion"><div class="wrap">
  <div class="banda-foto reveal"><img src="forestal-leon/assets/images/tipologia-viviendas.jpg" alt="Estructura de vivienda en madera laminada"></div>
</div></div>

<!-- 2. TARJETA DESTACADA — sustituye el PDF de binderholz, que Forestal León no tiene. Mismo lugar, mismo peso: botón que solicita, no descarga -->
<section class="destacada-seccion"><div class="wrap">
  <div class="destacada reveal">
    <div class="destacada__texto">
      <h3>Ficha técnica del sistema Timber Frame</h3>
      <p>Escuadrías, conectores estructurales y el detalle completo de los componentes que fabricamos en planta para tu proyecto de vivienda.</p>
    </div>
    <a class="btn" href="#construccion-e-ingenieria">Solicitar ficha técnica</a>
  </div>
</div></section>

<!-- 3. TEXTO OFICIAL — sin resumir, con un párrafo nuevo que separa qué sale de planta y qué se hace en obra -->
<section class="texto-seccion"><div class="wrap">
  <div class="medida reveal">
    <p>La construcción de viviendas unifamiliares en madera con sistema <strong>Timber Frame</strong> es hoy una de las alternativas más eficientes y competitivas del mercado chileno. En Forestal León fabricamos todos los componentes estructurales en planta, con vigas laminadas, pilares y conectores estructurales metálicos listos para montar en obra, tanto para construcciones nuevas como para ampliaciones de viviendas existentes.</p>
    <p>La estructura se complementa con panelería liviana no estructural, ya sea tabiquería de madera, perfilería metálica, paneles aislantes o vidrio, permitiendo adaptar cada vivienda a los requerimientos funcionales, climáticos y estéticos del proyecto. El resultado es una estructura precisa, durable y adaptable a cualquier estilo arquitectónico, ya sea tradicional o moderno, con el toque personal que cada proyecto merece.</p>
    <p>Lo que fabricamos en planta y lo que se ejecuta en obra queda definido desde el primer contacto: Forestal León entrega el kit estructural —vigas laminadas, pilares y conectores metálicos— listo para montar; el montaje, la panelería de cierre y las terminaciones corren por cuenta del equipo de construcción del proyecto.</p>
  </div>
</div></section>

<!-- 4. PARRILLA DE REFERENCIAS — el módulo que sostiene la página en binderholz.
     Sin fotos ni nombres de obra reales todavía (spec § 6): marcador honesto, nunca un título inventado. -->
<section class="referencias"><div class="wrap">
  <h2 class="reveal">Referencias</h2>
  <p class="nota-estado reveal">Próximamente — obras de vivienda ejecutadas con este sistema.</p>

  <div class="ref-grid reveal">
    <div class="ref-card">
      <div class="ref-card__foto">
        <span class="ref-card__badge">Pendiente</span>
        <img src="fotos-web/construccion-01-nave.jpg" alt="Fabricación de estructura en planta — imagen provisional">
      </div>
      <p class="ref-card__pie">Referencia de obra — foto y datos pendientes</p>
    </div>
    <div class="ref-card">
      <div class="ref-card__foto">
        <span class="ref-card__badge">Pendiente</span>
        <img src="fotos-web/construccion-03-cercha.jpg" alt="Montaje de cercha laminada — imagen provisional">
      </div>
      <p class="ref-card__pie">Referencia de obra — foto y datos pendientes</p>
    </div>
    <div class="ref-card">
      <div class="ref-card__foto">
        <span class="ref-card__badge">Pendiente</span>
        <img src="fotos-web/construccion-05-cercha.jpg" alt="Ensamblaje de cercha laminada — imagen provisional">
      </div>
      <p class="ref-card__pie">Referencia de obra — foto y datos pendientes</p>
    </div>
  </div>
</div></section>

<!-- 5. CONTACTO — las cuatro puertas, idénticas en las 16 páginas. Se renderiza completa porque esta
     vista previa representa la página entera de punta a punta, no solo lo que cambió. -->
<section class="contacto"><div class="wrap">
  <h2 class="reveal">Contacto</h2>
  <div class="tiles reveal">
    <div class="tile">
      <h4>Compra de productos</h4>
      <p>Cotiza madera aserrada, estructural o laminados.</p>
      <a class="btn" href="#compra-de-productos">Solicitar cotización</a>
    </div>
    <div class="tile">
      <h4>Construcción e ingeniería</h4>
      <p>Desarrolla tu proyecto en madera con nosotros.</p>
      <a class="btn" href="#construccion-e-ingenieria">Desarrollar un proyecto</a>
    </div>
    <div class="tile">
      <h4>Reclamos y MPD</h4>
      <p>Canal formal de reclamos y prevención de delitos.</p>
      <a class="btn" href="#reclamos">Presentar un caso</a>
    </div>
    <div class="tile">
      <h4>Contacto general</h4>
      <p>Prensa, alianzas y cualquier otra consulta.</p>
      <a class="btn" href="#contacto-general">Escríbenos</a>
    </div>
  </div>
</div></section>

<footer><div class="wrap"><p>— pie de página global del tema (parts/footer.html), sin cambios —</p></div></footer>

<script>
(function () {
  var objetivos = document.querySelectorAll('.reveal');
  var menosMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function mostrarTodo() {
    Array.prototype.forEach.call(objetivos, function (el) { el.classList.add('visible'); });
  }
  if (menosMovimiento || !('IntersectionObserver' in window)) { mostrarTodo(); return; }

  var observador = new IntersectionObserver(function (entradas) {
    entradas.forEach(function (entrada) {
      if (!entrada.isIntersecting) return;
      entrada.target.classList.add('visible');
      observador.unobserve(entrada.target);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

  Array.prototype.forEach.call(objetivos, function (el) { observador.observe(el); });
}());
</script>

</body>
</html>
```

- [ ] **Step 2: Verificar que el HTML no tiene errores evidentes de anidamiento**

Run: `node -e "const h=require('fs').readFileSync('preview-viviendas.html','utf8'); const open=(h.match(/<section/g)||[]).length; const close=(h.match(/<\/section>/g)||[]).length; console.log('section open/close:', open, close); if(open!==close) process.exit(1);"`
Expected: `section open/close: 5 5` (portada, tarjeta destacada, texto, referencias, contacto — la banda de imagen no es `<section>`, es `<div class="banda-seccion">`)

- [ ] **Step 3: Confirmar que no hay ningún nombre de obra inventado**

Run: `grep -inE "Los Ríos|Ñuble \||Biobío \|" preview-viviendas.html`
Expected: sin coincidencias (exit code 1). Si aparece algo, es un título de obra inventado que la spec § 6 prohíbe — hay que quitarlo antes de seguir.

---

## Task 2: Generador del JSON de Elementor

**Files:**
- Create: `scripts/build-viviendas-json.js`
- Overwrite (al ejecutar el script): `elementor/viviendas.json`

El script usa funciones factoría para los patrones repetidos (contenedor boxed, heading, texto, imagen, botón) en vez de escribir 900 líneas de JSON a mano — evita duplicación y hace visibles los valores que cambian entre widgets.

- [ ] **Step 1: Escribir el script completo**

```js
// scripts/build-viviendas-json.js
// Regenera elementor/viviendas.json según docs/superpowers/specs/2026-08-21-viviendas-remodernizacion-design.md
'use strict';
const fs = require('fs');
const path = require('path');

let n = 0;
const nid = () => (++n).toString(16).padStart(6, '0');

function section(children, { title, bg, padTop = 96, padBottom = 96, boxedWidth, gap = 24 } = {}) {
  const inner = {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: 'Contenido', content_width: 'boxed', flex_direction: 'column',
      width: { unit: '%', size: 100, sizes: [] },
      flex_gap: { unit: 'px', size: gap, column: String(gap), row: String(gap) },
      padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false },
      ...(boxedWidth ? { boxed_width: { unit: 'px', size: boxedWidth, sizes: [] } } : {})
    },
    elements: children
  };
  return {
    id: nid(), elType: 'container', isInner: false,
    settings: {
      _title: title, content_width: 'full', flex_direction: 'column',
      width: { unit: '%', size: 100, sizes: [] },
      padding: { unit: 'px', top: String(padTop), right: '0', bottom: String(padBottom), left: '0', isLinked: false },
      ...(bg ? { background_background: 'classic', background_color: bg } : {})
    },
    elements: [inner]
  };
}

function heading(title, size, color, fontSize, opts = {}) {
  const settings = {
    title, header_size: size, title_color: color,
    typography_typography: 'custom', typography_font_family: 'Open Sans',
    typography_font_size: { unit: 'px', size: fontSize, sizes: [] },
    typography_font_weight: opts.weight || '400',
    typography_line_height: { unit: 'em', size: opts.lineHeight || 1.15, sizes: [] }
  };
  if (opts.fontSizeTablet) settings.typography_font_size_tablet = { unit: 'px', size: opts.fontSizeTablet, sizes: [] };
  if (opts.fontSizeMobile) settings.typography_font_size_mobile = { unit: 'px', size: opts.fontSizeMobile, sizes: [] };
  if (opts.uppercase) settings.typography_text_transform = 'uppercase';
  if (opts.letterSpacing) settings.typography_letter_spacing = { unit: 'px', size: opts.letterSpacing, sizes: [] };
  if (opts.marginBottom != null) {
    settings._margin = { unit: 'px', top: String(opts.marginTop || 0), right: '0', bottom: String(opts.marginBottom), left: '0', isLinked: false };
  }
  return { id: nid(), elType: 'widget', widgetType: 'heading', settings, elements: [] };
}

function text(html, opts = {}) {
  return {
    id: nid(), elType: 'widget', widgetType: 'text-editor',
    settings: {
      editor: html, text_color: opts.color || '#3C3C38',
      typography_typography: 'custom', typography_font_family: 'Open Sans',
      typography_font_size: { unit: 'px', size: opts.fontSize || 17, sizes: [] },
      typography_line_height: { unit: 'em', size: opts.lineHeight || 1.75, sizes: [] }
    },
    elements: []
  };
}

function image(url, alt, opts = {}) {
  return {
    id: nid(), elType: 'widget', widgetType: 'image',
    settings: {
      image: { url, id: '' }, image_size: 'full', alt, _title: opts.title || alt,
      width: { unit: '%', size: 100, sizes: [] }
    },
    elements: []
  };
}

function button(text_, url, opts = {}) {
  return {
    id: nid(), elType: 'widget', widgetType: 'button',
    settings: {
      text: text_, link: { url, is_external: '', nofollow: '' }, button_type: 'link',
      button_text_color: '#01735A',
      text_padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: true },
      typography_typography: 'custom', typography_font_family: 'Open Sans',
      typography_font_size: { unit: 'px', size: 15, sizes: [] },
      background_color: 'rgba(0,0,0,0)', hover_color: '#FFFFFF', button_background_hover_color: '#01735A'
    },
    elements: []
  };
}

function innerRow(children, { title, gap = 24, wrap = true, extraSettings = {} } = {}) {
  return {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: title, content_width: 'full', flex_direction: 'row',
      flex_gap: { unit: 'px', size: gap, column: String(gap), row: String(gap * 2) },
      padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false },
      ...(wrap ? { flex_wrap: 'wrap' } : {}),
      ...extraSettings
    },
    elements: children
  };
}

// ---- Módulo 1 · Portada (convención nueva: fondo blanco, boxed_width 1312 — igual que
//      elementor/madera-material-construccion.json, remodernizado el mismo día) ----
const modulo1Portada = section([
  heading('Construcción en madera', 'p', '#01735A', 15, { weight: '700', uppercase: true, letterSpacing: 1.2, marginBottom: 8 }),
  heading('Viviendas', 'h1', '#01735A', 62, { fontSizeTablet: 43, fontSizeMobile: 31, uppercase: true, lineHeight: 1.1 }),
  heading('Construcción de viviendas unifamiliares en madera', 'h2', '#3C3C38', 40, { fontSizeTablet: 30, fontSizeMobile: 24, lineHeight: 1.25, marginTop: 4, marginBottom: 16 }),
  {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: 'Entradilla', content_width: 'full', flex_direction: 'column',
      width: { unit: '%', size: 100, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
      padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
    },
    elements: [
      text('<p>Una vivienda en madera es sinónimo de bienestar y confort. Las superficies de madera y sus propiedades naturales para retener el calor y regular la humedad crean un clima interior equilibrado, convirtiendo cada espacio en un ambiente cálido y agradable para vivir.</p>', { fontSize: 18 })
    ]
  }
], { title: 'Portada', bg: '#FFFFFF', padTop: 112, padBottom: 64, boxedWidth: 1312, gap: 20 });

// ---- Fotografía — banda ancha bajo el titular ----
const modulo1Foto = section([
  image('/wp-content/themes/forestal-leon/assets/images/tipologia-viviendas.jpg', 'Estructura de vivienda en madera laminada', { title: 'Foto — Viviendas' })
], { title: 'Fotografía', padTop: 0, padBottom: 0 });

// ---- Módulo 2 · Tarjeta destacada — sustituye el PDF de binderholz que Forestal León no tiene.
//      El botón SOLICITA (formulario de Construcción e ingeniería), no descarga nada que no existe. ----
const modulo2Destacada = section([
  {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: 'Ficha técnica del sistema Timber Frame', content_width: 'full', flex_direction: 'row',
      flex_wrap: 'wrap', width: { unit: '%', size: 100, sizes: [] },
      flex_gap: { unit: 'px', size: 32, column: '32', row: '24' },
      padding: { unit: 'px', top: '32', right: '32', bottom: '32', left: '32', isLinked: true },
      background_background: 'classic', background_color: '#F4EFE4',
      border_border: 'solid',
      border_width: { unit: 'px', top: '4', right: '0', bottom: '0', left: '0', isLinked: false },
      border_color: '#01735A',
      box_shadow_box_shadow_type: 'yes',
      box_shadow_box_shadow: { horizontal: 0, vertical: 4, blur: 16, spread: 0, color: 'rgba(26,26,23,0.08)' }
    },
    elements: [
      {
        id: nid(), elType: 'container', isInner: true,
        settings: {
          _title: 'Texto', content_width: 'full', flex_direction: 'column',
          width: { unit: '%', size: 65, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
          flex_gap: { unit: 'px', size: 8, column: '8', row: '8' },
          padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
        },
        elements: [
          heading('Ficha técnica del sistema Timber Frame', 'h3', '#1A1A17', 22, { weight: '700' }),
          text('<p>Escuadrías, conectores estructurales y el detalle completo de los componentes que fabricamos en planta para tu proyecto de vivienda.</p>', { fontSize: 16 })
        ]
      },
      {
        id: nid(), elType: 'container', isInner: true,
        settings: {
          _title: 'Botón', content_width: 'full', flex_direction: 'column',
          width: { unit: '%', size: 30, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
          padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
        },
        elements: [button('Solicitar ficha técnica', '/contacto/#construccion-e-ingenieria')]
      }
    ]
  }
], { title: 'Ficha técnica', bg: '#FAFAF7', padTop: 0, padBottom: 96 });

// ---- Módulo 3 · Texto de soluciones constructivas — oficial, sin resumir + el párrafo
//      nuevo que separa qué sale de planta y qué se hace en obra (spec, módulo 3) ----
const modulo3Texto = section([
  text(
    '<p>La construcción de viviendas unifamiliares en madera con sistema <strong>Timber Frame</strong> es hoy una de las alternativas más eficientes y competitivas del mercado chileno. En Forestal León fabricamos todos los componentes estructurales en planta, con vigas laminadas, pilares y conectores estructurales metálicos listos para montar en obra, tanto para construcciones nuevas como para ampliaciones de viviendas existentes.</p>' +
    '<p>La estructura se complementa con panelería liviana no estructural, ya sea tabiquería de madera, perfilería metálica, paneles aislantes o vidrio, permitiendo adaptar cada vivienda a los requerimientos funcionales, climáticos y estéticos del proyecto. El resultado es una estructura precisa, durable y adaptable a cualquier estilo arquitectónico, ya sea tradicional o moderno, con el toque personal que cada proyecto merece.</p>' +
    '<p>Lo que fabricamos en planta y lo que se ejecuta en obra queda definido desde el primer contacto: Forestal León entrega el kit estructural —vigas laminadas, pilares y conectores metálicos— listo para montar; el montaje, la panelería de cierre y las terminaciones corren por cuenta del equipo de construcción del proyecto.</p>'
  )
], { title: 'Texto', padTop: 96, padBottom: 96 });

// ---- Módulo 4 · Parrilla de referencias — sin fotos ni nombres de obra reales todavía.
//      Marcador honesto (fotos de planta + aviso "pendiente"), NUNCA un título inventado (spec § 6). ----
function refCard(imgUrl, alt) {
  return {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: 'PENDIENTE — sustituir por foto y datos de obra real', content_width: 'full', flex_direction: 'column',
      width: { unit: '%', size: 31, sizes: [] },
      flex_gap: { unit: 'px', size: 14, column: '14', row: '14' },
      padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
    },
    elements: [
      image(imgUrl, alt + ' — imagen provisional', { title: 'Marcador — pendiente de foto real' }),
      text('<p>Referencia de obra — foto y datos pendientes</p>', { color: '#6B6B64', fontSize: 15 })
    ]
  };
}

const modulo4Referencias = section([
  heading('Referencias', 'h2', '#3C3C38', 46, { fontSizeTablet: 34, fontSizeMobile: 26, lineHeight: 1.15, marginTop: 4, marginBottom: 8 }),
  text('<p>Próximamente — obras de vivienda ejecutadas con este sistema.</p>', { color: '#6B6B64', fontSize: 15, lineHeight: 1.6 }),
  innerRow([
    refCard('/wp-content/themes/forestal-leon/assets/images/construccion-01-nave.jpg', 'Fabricación de estructura en planta'),
    refCard('/wp-content/themes/forestal-leon/assets/images/construccion-03-cercha.jpg', 'Montaje de cercha laminada'),
    refCard('/wp-content/themes/forestal-leon/assets/images/construccion-05-cercha.jpg', 'Ensamblaje de cercha laminada')
  ], { title: 'Rejilla de referencias', gap: 32, extraSettings: { css_classes: 'fl-referencias' } })
], { title: 'Referencias', bg: '#ECEBE6', padTop: 96, padBottom: 96 });

// ---- Módulo 5 · Contacto — las cuatro puertas, idénticas en las 16 páginas. Copia textual
//      del bloque ya existente; se añade box_shadow_box_shadow_type para igualar la
//      convención de madera-material-construccion.json (remodernizado el mismo día). ----
function contactTile(title, copy, btnText, anchor) {
  return {
    id: nid(), elType: 'container', isInner: true,
    settings: {
      _title: title, content_width: 'full', flex_direction: 'column',
      padding: { unit: 'px', top: '32', right: '32', bottom: '32', left: '32', isLinked: true },
      border_border: 'solid',
      border_width: { unit: 'px', top: '1', right: '1', bottom: '1', left: '1', isLinked: true },
      border_color: '#D4D0C8',
      width: { unit: '%', size: 23, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
      box_shadow_box_shadow_type: 'yes',
      box_shadow_box_shadow: { horizontal: 0, vertical: 1, blur: 2, spread: 0, color: 'rgba(26,26,23,0.06)' }
    },
    elements: [
      heading(title, 'h4', '#1A1A17', 18, { weight: '700' }),
      text(`<p>${copy}</p>`, { fontSize: 16 }),
      button(btnText, `/contacto/#${anchor}`)
    ]
  };
}

const modulo5Contacto = section([
  heading('Contacto', 'h2', '#01735A', 76, { fontSizeTablet: 52, fontSizeMobile: 36, uppercase: true, lineHeight: 1.1 }),
  innerRow([
    contactTile('Compra de productos', 'Cotiza madera aserrada, estructural o laminados.', 'Solicitar cotización', 'compra-de-productos'),
    contactTile('Construcción e ingeniería', 'Desarrolla tu proyecto en madera con nosotros.', 'Desarrollar un proyecto', 'construccion-e-ingenieria'),
    contactTile('Reclamos y MPD', 'Canal formal de reclamos y prevención de delitos.', 'Presentar un caso', 'reclamos'),
    contactTile('Contacto general', 'Prensa, alianzas y cualquier otra consulta.', 'Escríbenos', 'contacto-general')
  ], { title: 'Cuatro servicios', gap: 24 })
], { title: 'Contacto', bg: '#FFFFFF', padTop: 96, padBottom: 96, gap: 20 });

const doc = {
  version: '0.4',
  title: 'Viviendas — Forestal León',
  type: 'page',
  content: [modulo1Portada, modulo1Foto, modulo2Destacada, modulo3Texto, modulo4Referencias, modulo5Contacto]
};

const outPath = path.join(__dirname, '..', 'elementor', 'viviendas.json');
fs.writeFileSync(outPath, JSON.stringify(doc, null, 1) + '\n', 'utf8');
console.log('Escrito', outPath, '—', JSON.stringify(doc).length, 'bytes (sin formatear)');
```

- [ ] **Step 2: Ejecutar el generador**

Run: `node scripts/build-viviendas-json.js`
Expected: `Escrito .../elementor/viviendas.json — N bytes (sin formatear)` sin errores de Node.

- [ ] **Step 3: Verificar que el JSON resultante es válido y tiene los 6 contenedores esperados**

Run: `node -e "const d=JSON.parse(require('fs').readFileSync('elementor/viviendas.json','utf8')); console.log('title:', d.title); console.log('secciones:', d.content.length); console.log('titles:', d.content.map(c=>c.settings._title).join(' | '));"`
Expected:
```
title: Viviendas — Forestal León
secciones: 6
titles: Portada | Fotografía | Ficha técnica | Texto | Referencias | Contacto
```

- [ ] **Step 4: Confirmar que no quedó ningún nombre de obra inventado en el JSON**

Run: `grep -inE "Los Ríos|Ñuble \\||Biobío \\|" elementor/viviendas.json`
Expected: sin coincidencias (exit code 1).

---

## Task 3: Verificación visual

**Files:** ninguno (solo lectura/ejecución)

- [ ] **Step 1: Confirmar qué comando de Python hay disponible**

Run: `py --version || python3 --version || python --version`
Expected: alguno de los tres imprime una versión (en esta máquina es `py`, ver investigación previa: `python3` da "Python was not found" pese a listarse en PATH — es el alias de Microsoft Store).

- [ ] **Step 2: Servir el repo y abrir la vista previa**

Run (en segundo plano): `py -m http.server 4322`
Luego abrir en el navegador: `http://localhost:4322/preview-viviendas.html`

- [ ] **Step 3: Revisar visualmente los 5 módulos**

Checklist:
- Portada: fondo claro con degradado, antetítulo/H1 en verde, H2 en gris, entradilla legible, imagen 16:9 con sombra
- Tarjeta destacada: fondo crema, filete verde arriba, botón con borde que se rellena al pasar el ratón
- Texto: tres párrafos, el tercero (nuevo) se lee como continuación natural, no como añadido
- Referencias: 3 tarjetas con foto de planta, insignia "PENDIENTE" visible en la esquina, sin ningún nombre de obra
- Contacto: 4 tarjetas en fila, se ajustan a 2 columnas en tablet y 1 en móvil (probar con las herramientas de desarrollo, ancho ~768px y ~400px)
- Reducir animación: activar "reducir movimiento" del sistema operativo y recargar — todo debe aparecer sin animar

- [ ] **Step 4: Detener el servidor**

Terminar el proceso `py -m http.server 4322` iniciado en el Step 2.

---

## Task 4: Limpieza

**Files:**
- Delete (opcional): `scripts/build-viviendas-json.js`

- [ ] **Step 1: Decidir si conservar el script**

El script es reutilizable como base para remodernizar Edificios y Turismo con el mismo molde (decisión tomada en el brainstorming: alcance de esta tarea es solo Viviendas, las otras dos se replican después). Conservarlo en `scripts/` documentado tiene valor; si se prefiere no dejar utilidades sueltas en la raíz del repo, moverlo a un lugar más permanente o borrarlo — es un artefacto de build, no parte del sitio.

---

## Self-Review

**1. Cobertura de la spec:**
- Módulo 1 (portada, entradilla promovida, imagen banda) → Task 1 Step 1 + Task 2 `modulo1Portada`/`modulo1Foto` ✓
- Módulo 2 (tarjeta destacada, botón que solicita) → Task 1 Step 1 + Task 2 `modulo2Destacada` ✓
- Módulo 3 (texto oficial + frase nueva planta/obra) → Task 1 Step 1 + Task 2 `modulo3Texto` ✓
- Módulo 4 (parrilla, regla de degradación, sin nombres inventados) → Task 1 Step 1 (`.ref-grid--2up` documentada en CSS) + Task 2 `modulo4Referencias` + Steps de verificación en ambas tareas ✓
- Módulo 5 (contacto sin tocar) → Task 1 Step 1 + Task 2 `modulo5Contacto`, copy idéntico al `viviendas.json` original ✓
- Entregables (§ 5): solo `preview-viviendas.html` y `elementor/viviendas.json`, `tipologia-viviendas.php` no se toca — ningún Task lo modifica ✓
- Riesgo § 6 (nunca títulos inventados): verificado con grep en Task 1 Step 3 y Task 2 Step 4 ✓

**2. Placeholders:** ninguno — todo el código de Task 1 y Task 2 es completo y ejecutable tal cual está escrito.

**3. Consistencia de tipos:** las funciones factoría del Task 2 (`section`, `heading`, `text`, `image`, `button`, `innerRow`, `refCard`, `contactTile`) se usan con la misma firma en todos los módulos donde aparecen; no hay redefiniciones divergentes.
