# Estructura de la web → cómo está implementada

Mapa entre el documento **«Programa forestal león»** y lo que hay en el tema.
Si algo del documento no está construido, aparece aquí como pendiente.

---

## Las 7 secciones

| Sección del documento | URL | Qué la sirve |
|---|---|---|
| Inicio | `/` | `templates/front-page.html` |
| Construcción en madera | `/construccion-en-madera` | Página + patrones `construccion-madera` y `ventajas-madera` |
| Productos | `/productos` | `templates/archive-producto.html` (catálogo automático) |
| Servicios | `/servicios` | Página + patrón `servicios` |
| Quiénes somos / Empresa | `/empresa` | Página (contenido pendiente) |
| Noticias | `/noticias` | Entradas de WordPress + patrón `noticias` |
| Grupo León | `/grupo-leon` | Página + patrón `grupo-leon` |

En la cabecera aparece «Empresa» en vez de «Quiénes somos» para que los siete
elementos quepan en una línea. Se cambia en Apariencia › Editor › Patrones › Cabecera.

## Inicio — los ocho módulos

La portada sigue el orden y el ritmo de la referencia. `front-page.html` los monta
en este orden; cada uno es un patrón independiente, así que se pueden reordenar o
quitar desde Apariencia › Editor sin tocar código.

| # | Módulo | Patrón | Contenido del documento |
|---|---|---|---|
| 1 | Imagen a sangre, sin texto | `hero-home` | — |
| 2 | Introducción de la empresa | `intro-empresa` | Bloque 1: qué hace Forestal León |
| 3 | Vídeo corporativo | `video-corporativo` | El vídeo que pide Quiénes somos |
| 4 | Banda de imagen — Productos | `banda-productos` | Bloque 2: productos + «ver más» |
| 5 | Referencias más destacadas | `referencias-destacadas` | Bloque 3: construcción + referencias |
| 7 | Actualidad | `actualidad` | Bloque 4: noticias |
| 8 | Servicio — cuatro accesos | `servicio-tiles` | Bloque 5: los 4 servicios |

Los módulos 5 y 7 se llenan solos: toman las seis últimas obras y las cuatro
últimas noticias. No hay que editar la portada cada vez que se publica algo.

**El hero no lleva texto.** Es así en la referencia: la fotografía ocupa 776 px y
el mensaje principal —y el único `<h1>` de la página— está en el módulo 2. Es
correcto para SEO y evita el problema clásico de texto ilegible sobre foto.

### El par de titulares

Es el gesto que más define esta portada, y no es el orden tipográfico habitual:

| | Fuente | Tamaño | Color |
|---|---|---|---|
| **Título de sección** | Open Sans **sin condensar**, mayúsculas | 36 → 76 px fluido | Verde León |
| **Subtítulo** | Open Sans **condensada 75%** | 26 → 46 px fluido | Gris texto |

A 1280 px da exactamente 76/46 px, igual que la referencia. La diferencia es que
aquí ambos son fluidos: en la referencia el subtítulo está fijo en 46 px y a
partir de ~950 px acaba casi tan grande como el título.

En el editor son dos estilos de bloque: **Título de sección (verde)** y
**Subtítulo de sección**. Van siempre juntos y en ese orden.

### Las bandas de imagen

Los módulos 4 y 6 son bloques Portada a todo el ancho: fotografía, velo oscuro al
55%, antetítulo, titular condensado en blanco, un párrafo de 62 caracteres máximo
y el botón **Más** alineado a la derecha (a la izquierda por debajo de 700 px).

## Productos — cómo se cargan

El documento define 3 familias con 9 tipos y pide «información relevante en cada
ventana». Eso es una ficha por producto, así que el tema registra un tipo de
contenido propio en lugar de páginas sueltas.

**Menú lateral de WordPress → «Productos»**. Cada producto se asigna a una familia.

| Familia (`familia-producto`) | Productos |
|---|---|
| Madera aserrada | Seco cepillado · Impregnado |
| Madera estructural | Estructural · Mueblería · Ranurado · Impregnado |
| Laminado | Vigas y pilares laminados · Deck y repisas · Laminado Glulam CNC |

Las tres familias se crean solas al activar el tema. URLs resultantes:

```
/productos                                  catálogo completo
/familia-producto/madera-aserrada           una familia
/productos/seco-cepillado                   una ficha
```

Plantillas: `archive-producto.html`, `taxonomy-familia-producto.html`,
`single-producto.html`.

## Construcción en madera

| Documento | Implementación |
|---|---|
| Ventajas de construir en madera | Patrón `ventajas-madera` — peso, aislamiento, resistencia, velocidad, coste y origen |
| Soluciones constructivas + referencias | Tipo de contenido **Proyectos** (`/proyectos`) |
| Viviendas · Edificios · Turismo | Taxonomía `tipo-proyecto`, los tres términos se crean al activar |

```
/proyectos                        todas las obras
/tipo-proyecto/viviendas          por tipo
/proyectos/nombre-de-la-obra      ficha
```

> **Sobre las ventajas de la madera.** El documento sugiere basarse en la ventana
> equivalente de binderholz. Los textos del patrón están **redactados de cero**
> para Forestal León: sirven de guion, no son una traducción de ese sitio.
> Copiar su redacción literalmente sería una infracción de derechos de autor, y
> además sus cifras son de otra empresa. Conviene que ingeniería los revise y
> añada datos propios antes de publicar.

> **Turismo.** El documento la marca como «posible» y justifica su valor para SEO.
> El término existe en la taxonomía pero no hay página propia todavía: decide si
> se abre como sección o se queda como filtro dentro de Proyectos.

## Servicios — los cuatro formularios

Las cuatro puertas están construidas como bloques con ancla:

| Servicio | Ancla | Correo destino |
|---|---|---|
| Compra de productos | `/servicios#compra-de-productos` | por definir |
| Construcción e ingeniería | `/servicios#construccion-e-ingenieria` | por definir |
| Reclamos / MPD | `/servicios#reclamos` | por definir |
| Contacto general | `/servicios#contacto-general` | por definir |

**Los formularios en sí no están hechos, y no pueden estarlo desde el tema.**
WordPress no trae formularios. Hace falta un plugin —WPForms, Fluent Forms o
Gravity Forms— y crear allí los cuatro, cada uno con:

- su **destinatario** propio;
- **Reply-To** con el correo de quien escribe, que es lo que pide el documento
  («que se puedan responder directamente desde el mismo correo hacia el remitente»);
- una **plantilla de correo** propia, para que el aviso no llegue con el formato
  actual.

Recomendación: **Fluent Forms**. Cubre los cuatro casos en la versión gratuita y
no ralentiza el sitio como Gravity. Además conviene un plugin SMTP (FluentSMTP,
gratuito) para que los correos no acaben en spam.

## Grupo León

Patrón `grupo-leon` con las tres empresas y sus anclas:

- **Forestal León** — base del grupo, de los aserraderos de montaña a la alta tecnología
- **Energía León** (`#energia-leon`) — biomasa de residuos, energía y vapor
- **Vivero León** (`#vivero-leon`) — desde 2020, plantas de alta calidad genética

## Noticias

Usa las **Entradas** normales de WordPress. El documento pide formato de artículo
y marca los temas a evitar: salud, cumpleaños, alimentación, psicología y
sustentabilidad cuando no sea relevante para producción o negocio. Eso es una
norma editorial, no algo que el tema pueda imponer — conviene dejarlo escrito en
la guía de contenidos de quien publique.

## Pendiente

| Qué | Dónde vive el material |
|---|---|
| Fotografías (los patrones tienen los huecos vacíos) | `WEB FORESTAL LEON\9FOTOS PRODUCTOS` — ~60 fotos y 10 vídeos |
| La imagen del hero (776 px de alto, apaisada) | elegir de las anteriores |
| La URL del vídeo corporativo | pegarla en el bloque Insertar del módulo 3 |
| Vídeo introductorio de Quiénes somos | por grabar / localizar |
| Textos de historia, valores, misión y visión | `Textos pagina FL oficial.docx` (5 MB) |
| Fichas de los 9 productos | por redactar con ingeniería |
| Obras de referencia para Construcción | por seleccionar |
| Los 4 formularios | plugin, ver arriba |
| `screenshot.png` del tema | captura de 1200×900 |

## Lo que quedó fuera del design kit

El `forestal-leon-design-kit` traía contenidos que **no aparecen en esta
estructura**, así que se retiraron del tema:

- **Sección Sustentabilidad**: no está en el menú. Su contenido real —energía de
  biomasa— vive ahora dentro de Grupo León como Energía León.
- **Cifras «+50 años · 3.000 ha · 12+ países · 100% certificado»**: no figuran en
  el documento y no he podido confirmarlas. Si son correctas, el patrón se puede
  recuperar del historial; publicarlas sin verificar es un riesgo.
- **Nombres comerciales «Plywood León» y «Laminado León»**: el documento no usa
  «Plywood» y organiza el catálogo por familias, no por marcas de producto.
