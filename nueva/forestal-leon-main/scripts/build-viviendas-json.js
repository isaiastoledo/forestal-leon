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
//      nuevo que separa qué sale de planta y qué se hace en obra (spec, módulo 3).
//      La foto (vigas y pilares laminados) es el producto exacto que describe el primer párrafo. ----
const modulo3Texto = section([
  innerRow([
    {
      id: nid(), elType: 'container', isInner: true,
      settings: {
        _title: 'Texto', content_width: 'full', flex_direction: 'column',
        width: { unit: '%', size: 58, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
        flex_gap: { unit: 'px', size: 16, column: '16', row: '16' },
        padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
      },
      elements: [
        text(
          '<p>La construcción de viviendas unifamiliares en madera con sistema <strong>Timber Frame</strong> es hoy una de las alternativas más eficientes y competitivas del mercado chileno. En Forestal León fabricamos todos los componentes estructurales en planta, con vigas laminadas, pilares y conectores estructurales metálicos listos para montar en obra, tanto para construcciones nuevas como para ampliaciones de viviendas existentes.</p>' +
          '<p>La estructura se complementa con panelería liviana no estructural, ya sea tabiquería de madera, perfilería metálica, paneles aislantes o vidrio, permitiendo adaptar cada vivienda a los requerimientos funcionales, climáticos y estéticos del proyecto. El resultado es una estructura precisa, durable y adaptable a cualquier estilo arquitectónico, ya sea tradicional o moderno, con el toque personal que cada proyecto merece.</p>' +
          '<p>Lo que fabricamos en planta y lo que se ejecuta en obra queda definido desde el primer contacto: Forestal León entrega el kit estructural —vigas laminadas, pilares y conectores metálicos— listo para montar; el montaje, la panelería de cierre y las terminaciones corren por cuenta del equipo de construcción del proyecto.</p>'
        )
      ]
    },
    {
      id: nid(), elType: 'container', isInner: true,
      settings: {
        _title: 'Foto', content_width: 'full', flex_direction: 'column',
        width: { unit: '%', size: 38, sizes: [] }, width_mobile: { unit: '%', size: 100, sizes: [] },
        padding: { unit: 'px', top: '0', right: '0', bottom: '0', left: '0', isLinked: false }
      },
      elements: [
        image('/wp-content/themes/forestal-leon/assets/images/producto-vigas-y-pilares-laminados.jpg', 'Vigas y pilares laminados fabricados en planta', { title: 'Foto — producto' })
      ]
    }
  ], { title: 'Texto y foto', gap: 40 })
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
