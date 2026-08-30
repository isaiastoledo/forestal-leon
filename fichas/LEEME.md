# Fichas de proyecto — cómo crearlas

Las cinco referencias que pidió el cliente el 29 de agosto de 2026. La primera
—el Galpón de Coelemu— ya está creada; aquí están las cuatro que faltan.

| # | Obra | Slug | Tipo |
|---|---|---|---|
| 1 | Galpón de Madera Forestal León | `ejemplo-referencia` | ya creada |
| 2 | Pasarelas y Cercos, Bucalemu | `pasarelas-cercos-bucalemu` | turismo |
| 3 | Oficinas Generales Forestal León | `oficinas-generales-forestal-leon` | edificios |
| 4 | Casa Mirador Punta Pite | `casa-mirador-punta-pite` | viviendas |
| 5 | Oficinas Vivero Forestal León | `oficinas-vivero-forestal-leon` | edificios |

## Cómo crear cada una

**No se hace reactivando el tema.** Al activarlo vuelve a crear las páginas que
falten, y el 30 de agosto de 2026 eso duplicó dieciocho páginas del sitio. Se
crean a mano, una por una:

1. **Proyectos › Añadir proyecto**
2. **Título:** el de la tabla de arriba
3. **Enlace permanente:** el slug de la tabla
4. Abre el menú de tres puntos (arriba a la derecha) → **Editor de código**
5. Pega el contenido de `N-slug.html` y vuelve al editor visual
6. En la barra lateral, **Extracto**: pega el contenido de `N-slug.extracto.txt`
7. **Tipo de proyecto:** el de la tabla
8. Publicar

El extracto es el texto introductorio: la plantilla lo muestra bajo el titular,
antes del carrusel.

## Qué falta en cada ficha

Los huecos vienen marcados con una nota dentro, para que se vean al editar:

- **Carrusel** — pendiente de fotos y del plugin de carrusel con autoplay
- **Tres fotos a ancho completo** — pendientes
- **Collage final** — pendiente de fotos

La ficha 5, Oficinas Vivero, va **sin las tres fotos y sin texto complementario**
por indicación expresa del cliente en su documento: solo texto introductorio,
foto principal y collage.

## Lo que falta por parte del cliente

- **El texto introductorio de Oficinas Generales.** Es la única de las cinco que
  llegó solo con datos. Mientras tanto su extracto dice «PENDIENTE».
- **Las fotografías de las cinco obras.** Hoy solo hay las nueve del galpón.
- **La forma del collage.** El cliente pidió que se parezca al de
  binderholz.com/es/soluciones-de-construccion/under-armour-headquaters-baltimore-usa/,
  que es un mosaico irregular de 22 fotos con proporciones mixtas, no una
  cuadrícula. La galería de WordPress solo hace cuadrícula uniforme: hará falta
  un plugin de galería o CSS a medida.

## Un problema conocido

Los cuatro formularios del cierre **no se muestran** en las fichas. El bloque lo
pinta la plantilla del tema, y ahí el shortcode de Fluent Forms no llega a
ejecutarse: sale el texto literal `[fluentform id="4"]`. En la página de
Contacto sí funcionan, porque los inserta Elementor.

Está pendiente de resolver, probablemente cambiando el shortcode por el bloque
propio de Fluent Forms.
