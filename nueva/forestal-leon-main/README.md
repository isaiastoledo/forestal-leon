> ### ¿Vienes a ver o probar el diseño?
> **Maqueta en vivo:** https://isaiastoledo.github.io/forestal-leon/
> **Cómo probar colores y tipografías:** [LEEME.md](LEEME.md)
>
> Lo que sigue es documentación técnica del tema. La web publicada
> (forestalleon.cl) no se modifica desde este repositorio.

# Forestal León — tema de WordPress

Basado en el diseño de `binderholz.com/es/` con el logotipo y los colores corporativos
de Forestal León (Coelemu, Región de Ñuble).

- **Estructura, retícula, tipografía y geometría:** medidas extraídas de binderholz
  (radio 0, condensada, base 8, transiciones de 128/256 ms).
- **Marca:** logotipo original + paleta de `forestal-leon-design-kit` v1.0,
  más el verde muestreado del propio logotipo.

## Estructura

La arquitectura sigue el documento **«Programa forestal león»**: 7 secciones,
productos en 3 familias y proyectos de construcción por tipo.

```
forestal-leon/
├── index.html                   maqueta del home · publicada en GitHub Pages
├── LEEME.md                     guía para probar colores sin saber programar
├── forestal-leon/               ← el tema (esto va a WordPress)
│   ├── theme.json               20 colores, 9 tamaños de texto, 8 espaciados
│   ├── style.css                1.298 líneas
│   ├── functions.php            logo, tipos Productos y Proyectos
│   ├── templates/               12 plantillas
│   ├── parts/                   cabecera · pie
│   ├── patterns/                20 secciones con los textos de la estructura
│   ├── assets/images/           logotipo verde y blanco
│   ├── ESTRUCTURA.md            ← mapa documento → tema, y qué falta
│   ├── DESIGN-SYSTEM.md
│   └── INSTALAR.md
├── elementor/                   las 17 páginas exportadas de Elementor
├── fotos-web/                   18 fotografías optimizadas
└── empaquetar.py                genera forestal-leon.zip
```

El ZIP del tema no está en el repositorio: se genera con `empaquetar.py` y se
publica en [Releases](../../releases). Los originales de fotografía tampoco.

## Cómo conviven el tema y Elementor

No es una cosa o la otra: **el reparto es tema para el armazón, Elementor para el
contenido de las páginas.** Conviene entenderlo antes de tocar nada, porque
desactivar cualquiera de los dos rompe media web.

| Lo da el tema de bloques | Lo da Elementor gratuito |
|---|---|
| Cabecera fija con los desplegables y el selector de idioma | El cuerpo de las 17 páginas |
| Pie verde de cuatro columnas | |
| Colores, tipografías y espaciados (`theme.json`) | |
| Catálogo de productos y sus familias | |
| Plantillas de artículo y de proyecto | |

### Por qué así

La decisión del **9 de agosto de 2026** fue construir un tema de bloques en lugar
de partir del Template Kit de Elementor que hay en `WEB FORESTAL LEON\WEB
PLANTILLA` (Envato, `manifest_version` 1.0.23). El motivo de fondo sigue vigente
y es el que explica el reparto actual:

**La cabecera fija que cambia de color al hacer scroll es una plantilla de
cabecera, y eso vive en el Theme Builder de Elementor, que es de pago.** Aquí
solo hay Elementor gratuito. Por eso la cabecera —y con ella el pie, la paleta y
el catálogo— se quedan en el tema.

Pesaba también que el kit arrastra cuatro plugins (Elementor, ElementsKit Lite,
Gum Elementor Addon, MetForm) y que Elementor genera bastante más HTML y CSS por
página.

El **18 de agosto** se maquetó el contenido de las páginas con Elementor y se
exportaron las 17 plantillas a `elementor/`. El tema no se tocó: siguió dando
todo lo de la columna izquierda. De ahí el híbrido.

### Qué implica en la práctica

- **No desactivar Elementor.** Se vaciaría el contenido de las 17 páginas.
- **No rehacer en Elementor lo que da el tema.** Se duplicaría. La lista está en
  [ELEMENTOR.md](ELEMENTOR.md), apartado 5.
- **Los colores y tipografías se tocan en dos sitios.** En `theme.json` para el
  armazón y en Ajustes del sitio de Elementor para las páginas. Si solo se cambia
  uno, la web queda a dos colores. Los valores están en [ELEMENTOR.md](ELEMENTOR.md).
- Los formularios son **Fluent Forms** insertados con el widget Shortcode; ver
  [FORMULARIOS.md](FORMULARIOS.md).

## Instalar

Apariencia › Temas › Añadir nuevo tema › Subir tema › `forestal-leon.zip` › Activar.
Detalles y problemas frecuentes en [forestal-leon/INSTALAR.md](forestal-leon/INSTALAR.md).

## Revisar el diseño sin WordPress

```bash
python -m http.server 4322
```

Abre <http://localhost:4322/index.html>. Es una maqueta estática
con la portada completa, el logotipo sobre los cuatro fondos, la paleta con sus
ratios de contraste y la escala tipográfica.

## Después de editar el tema

```bash
python empaquetar.py
```

No uses `Compress-Archive` de Windows: escribe las rutas internas con `\` y
WordPress sobre Linux no encuentra la carpeta del tema.

## Decisiones de diseño

1. **El verde.** El del logotipo (`#01735A`) no coincide con el del kit
   (`#2E5940`); la diferencia es ΔE 15.9, visible. Se usa el del logotipo como
   primario para que marca y botones concuerden. Ver `DESIGN-SYSTEM.md` § 1.
2. **La tipografía.** El kit pide Cormorant Garamond + DM Sans; el tema mantiene
   la Open Sans condensada del diseño clonado. Ver `DESIGN-SYSTEM.md` § 2.

**Resuelto — los formularios.** Se pedían cuatro, cada uno a un correo distinto.
Se resolvió con Fluent Forms y FluentSMTP, ambos gratuitos, insertados en las
páginas con el widget Shortcode de Elementor. Ver [FORMULARIOS.md](FORMULARIOS.md).

## Pendiente

`screenshot.png` del tema, que sigue sin existir. Del resto de la lista original
—fotografías, fichas de producto, obras de referencia, contenidos de Empresa— hay
18 imágenes ya optimizadas en `fotos-web/` y el contenido volcado en las páginas
de Elementor; conviene repasar qué queda realmente antes de darlo por cerrado.
Lista completa en [forestal-leon/ESTRUCTURA.md](forestal-leon/ESTRUCTURA.md).
