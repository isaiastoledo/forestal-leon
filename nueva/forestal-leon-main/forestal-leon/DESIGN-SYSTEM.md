# Forestal León — sistema de diseño del tema

Este tema combina dos fuentes:

- **La estructura** viene del análisis de `binderholz.com/es/`: retícula, escala
  tipográfica, ritmo de espaciado, geometría (radio 0) y duraciones de transición.
  Son medidas, no código: no se copió CSS, HTML, JS, marca ni imágenes de ese sitio.
- **La marca** viene de `forestal-leon-design-kit` v1.0 (mayo 2025) y del logotipo
  original de Forestal León.

---

## 1. Color

### Verde de marca

| Token WP | Nombre | Valor | Contraste sobre blanco |
|---|---|---|---|
| `primary` | Verde León | `#01735A` | 5.83:1 — AA ✔ AAA ✘ |
| `primary-dark` | Verde León oscuro | `#015644` | 8.69:1 — AA ✔ AAA ✔ |

`#01735A` es el verde **muestreado del propio logotipo** (64.5% de sus píxeles
opacos). `primary-dark` se deriva de él al 75% de luminosidad para el estado hover.

> **Decisión que conviene revisar.** El verde del logotipo no coincide con ningún
> color del kit de marca. La diferencia con Forest Mid (`#2E5940`) es de **ΔE 15.9**:
> por encima de 10 el ojo los lee como dos verdes distintos, no como una variación.
> Se ha puesto el verde del logotipo como `primary` para que la cabecera y los
> botones concuerden con la marca que ve el visitante.
>
> Si el cliente prefiere que mande el kit, es un solo cambio en `theme.json`:
> `primary` → `#2E5940` y `primary-dark` → `#1C3829`. El logotipo seguirá
> desentonando ligeramente; la solución de fondo sería actualizar el kit o el
> archivo del logotipo para que ambos usen el mismo verde.

### Verdes del kit

| Token WP | Nombre kit | Valor | Sobre blanco | Uso |
|---|---|---|---|---|
| `forest-deep` | Forest Deep | `#1C3829` | 12.75:1 | Pie de página, fondos oscuros |
| `forest-mid` | Forest Mid | `#2E5940` | 8.02:1 | Bandas secundarias |
| `forest-light` | Forest Light | `#4A7C5F` | 4.84:1 | Texto grande, iconos |
| `sage` | Sage | `#7A9E7E` | 2.84:1 | **Solo superficie**, nunca texto |
| `sage-pale` | Sage pálido | `#C5D9C6` | — | Fondo de etiquetas y avisos |

### Acento madera

| Token WP | Valor | Sobre blanco | Uso |
|---|---|---|---|
| `wood` | `#C4832A` | **3.17:1 — falla AA** | Filetes, superficies, gráficos |
| `wood-text` | `#A16B22` | 4.52:1 — AA ✔ | La misma familia, para texto |
| `wood-pale` | `#E8C48A` | — | Superficies suaves |
| `bark` | `#3D2B1F` | 12.4:1 | Fondo oscuro cálido |

> `#C4832A` es el acento del kit, pero con 3.17:1 sobre blanco **no cumple AA**
> para texto normal (mínimo 4.5:1). El tema lo mantiene para superficies y filetes,
> y añade `wood-text` (`#A16B22`) para cuando el acento tiene que ser texto.
> `style.css` § 6 reencamina automáticamente el texto suelto pintado en Wood.

### Neutros

| Token WP | Nombre kit | Valor | Sobre blanco | Uso |
|---|---|---|---|---|
| `ink` | Ink | `#1A1A17` | 18.4:1 | Titulares |
| `contrast` | Ink Suave | `#3C3C38` | 10.5:1 | Texto corrido |
| `contrast-mid` | Muted | `#6B6B64` | 5.37:1 | Pies de foto, metadatos |
| `stone` | Stone | `#8A8679` | **3.64:1** | Solo superficie |
| `border` | Stone Claro | `#D4D0C8` | — | Filetes, tablas |
| `cream` | Cream | `#F4EFE4` | — | Bandas cálidas |
| `base-alt` | Cream Light | `#FAFAF7` | — | Fondo alterno |
| `base` | Blanco | `#FFFFFF` | — | Fondo |

Resumen de accesibilidad: **todo el texto por defecto cumple AA**. Los tres colores
que no sirven como texto sobre blanco (`sage`, `stone`, `wood`) están marcados como
tales en el nombre que ve el editor o en esta tabla.

## 2. Tipografía

Familia única: **Open Sans variable**, ejes de grosor (`wght` 300–800) y ancho
(`wdth` 75–100). El ancho 75% reproduce la antigua "Open Sans Condensed", que Google
descontinuó. Verificado en navegador: al 75% el texto ocupa el 71,4% del ancho normal.

| Token WP | Tamaño | Fluido | Familia | Uso |
|---|---|---|---|---|
| `x-small` | 13 px | no | Texto | Pies de foto, legales |
| `small` | 15 px | no | Texto | Metadatos, antetítulos |
| `medium` | 16 px | no | Texto | Cuerpo |
| `large` | 18 px | no | Texto 700 | Navegación |
| `x-large` | 20 px | no | Texto | Entradillas |
| `heading-s` | 24 px | 20 → 24 | Condensada | H4 |
| `heading-m` | 40 px | 28 → 40 | Condensada | H3 |
| `heading-l` | 46 px | 32 → 46 | Condensada | H1, H2 |
| `display` | 76 px | 40 → 76 | Condensada | Portadas, cifras |

Interlineados: cuerpo `1.75`, titulares `1.05`, H3 `1.25`, H4 `1.3`.

> **El kit define otra tipografía:** Cormorant Garamond (serif) para titulares,
> DM Sans para texto y DM Mono para etiquetas. El tema mantiene la del sitio
> clonado porque el encargo era clonar ese diseño cambiando logotipo y colores.
>
> Para pasarte a las del kit: en `theme.json`, cambia el `fontFamily` de la familia
> `condensada` a `"Cormorant Garamond", Georgia, serif` y el de `texto` a
> `"DM Sans", system-ui, sans-serif`; en `functions.php`, cambia la URL de
> `forestal_leon_fonts()` por
> `https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=DM+Sans:wght@300;400;700&display=swap`;
> y en `style.css`, borra las reglas de `font-stretch` de la sección 1.
> Ojo: el kit también pide radios de 2/6/12 px, incompatibles con el radio 0 de este diseño.

## 3. Espaciado

Escala base 8, tomada del sitio de referencia. Coincide casi punto por punto con la
del kit (4/8/12/16/24/32/48/64/80/120).

| Token WP | Valor | Uso |
|---|---|---|
| `10` | 8 px | Dentro de un componente |
| `20` | 16 px | Entre elementos relacionados |
| `30` | 24 px | Entre bloques de un grupo |
| `40` | 32 px | `blockGap` por defecto |
| `50` | 48 px | Entre grupos |
| `60` | 80 px (fluido) | Padding vertical de sección |
| `70` | 96 px (fluido) | Sección amplia, pie |
| `80` | 128 px (fluido) | Portadas, 404 |

## 4. Composición

- **Contenido:** 1200 px · **Ancho:** 1600 px · **Tope del sitio:** 2000 px
- **Columna de lectura:** 760 px (~65 caracteres por línea)
- **Padding lateral:** `clamp(1rem, 4vw, 3.25rem)`
- **Radio: 0 en todo**, forzado en `theme.json` para el bloque botón
- **Transiciones:** `0.128s ease-out` (color/fondo/borde) y `0.256s ease-out`
  (opacidad). Respeta `prefers-reduced-motion`.

## 5. Logotipo

`assets/images/` incluye dos archivos:

| Archivo | Uso |
|---|---|
| `logo-forestal-leon.png` | 1878×612 px, verde `#01735A`, fondo transparente |
| `logo-forestal-leon-blanco.png` | La misma silueta en blanco, para fondos oscuros |

El tema **instala el logotipo automáticamente al activarse**
(`forestal_leon_instalar_logo()` en `functions.php`): lo copia a la biblioteca de
medios y lo deja puesto como logotipo del sitio, para que la cabecera no aparezca
vacía. Si ya hay uno configurado, no lo toca.

Se fija por **altura** (44 px en escritorio, 34 px en móvil, tokens
`--wp--custom--logo--alto*`), nunca por anchura: el isotipo es apaisado ~3:1 y
fijar la anchura lo descuadraría entre cabecera y pie.

Para el pie verde no hace falta el PNG blanco: el estilo de bloque
**Versión blanca** aplica `filter: brightness(0) invert(1)`, así solo hay un
archivo que mantener. El PNG blanco viaja por si se necesita fuera de la web.

## 6. Estilos de bloque incluidos

| Bloque | Estilo | Qué hace |
|---|---|---|
| Botón | Sólido (Verde León) | Relleno verde; invierte al hover |
| Botón | Sobre fondo oscuro | Contorno blanco, para portadas |
| Párrafo | Antetítulo | Versalitas verdes sobre un titular |
| Párrafo | Entradilla | Párrafo de entrada a 20 px |
| Párrafo | Etiqueta / tag | Píldora Sage con texto Forest Deep |
| Párrafo / Encabezado | Cifra destacada | Las cifras "+50", "3.000", "12+" |
| Grupo | Filete verde superior | Separa secciones |
| Grupo | Filete madera superior | Variante de acento |
| Portada | Velo inferior | Degradado para legibilidad sobre foto |
| Logotipo | Versión blanca | Invierte el logo para fondos oscuros |
| Lista | Sin viñetas | Columnas del pie |

## 7. Patrones incluidos

En el editor, «Patrones» › categoría **Forestal León**. Todos traen los textos
reales del kit de contenidos, listos para ajustar:

- **Portada — Desde Coelemu al mundo**
- **Cifras de la empresa** — +50 años · 3.000 ha · 12+ países · 100% certificado
- **Unidades de negocio** — Plywood León, Laminado León, Remanufactura
- **Sustentabilidad** — banda a media imagen sobre Forest Deep
- **Llamada a la acción — Solicitar cotización**

La plantilla `front-page.html` ya los ensambla en ese orden como página de inicio.

## 8. Alojar las fuentes en el propio servidor

Por defecto Open Sans se carga desde Google Fonts. Para servirla desde el propio
hosting (recomendable por privacidad y por velocidad en Chile):

1. Descarga la variable Open Sans (`.woff2`, ejes `wght` y `wdth`) de
   [fonts.google.com/specimen/Open+Sans](https://fonts.google.com/specimen/Open+Sans).
2. Colócala en `assets/fonts/OpenSans-Variable.woff2`.
3. Borra `forestal_leon_fonts()` de `functions.php` y sus dos `add_action`.
4. Añade a cada entrada de `settings.typography.fontFamilies` en `theme.json`:

```json
"fontFace": [
  {
    "fontFamily": "Open Sans",
    "fontStyle": "normal",
    "fontWeight": "300 800",
    "fontStretch": "75% 100%",
    "src": [ "file:./assets/fonts/OpenSans-Variable.woff2" ]
  }
]
```

WordPress genera el `@font-face` y precarga el archivo automáticamente.

## 9. Qué falta por hacer

- **Fotografías.** Los patrones traen los huecos de imagen vacíos. Hay material en
  `WEB FORESTAL LEON\9FOTOS PRODUCTOS` (unas 60 fotos de producto y 10 vídeos).
- **`screenshot.png`.** Una captura de 1200×900 px en la raíz del tema pone la
  miniatura en Apariencia › Temas.
- **Páginas internas.** Existen las plantillas; los contenidos de Quiénes Somos,
  Productos, Sustentabilidad y Contacto están en los `.docx` de la carpeta del
  proyecto y aún no se han volcado.
- **Formulario de cotización.** El kit define uno (nombre, empresa, correo,
  producto de interés, mensaje). WordPress no trae formularios: hará falta un
  plugin, o construirlo a mano.
