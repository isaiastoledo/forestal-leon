# Forestal León con Elementor — ajustes previos

El tema sigue puesto y sigue dando la cabecera, el pie, los colores, las
tipografías, el catálogo de productos y las nueve fichas. Lo único que pasa a
Elementor es el **contenido de las páginas**.

---

## 1. Colores globales

Elementor › Ajustes del sitio › **Colores globales**. Pon estos y usa siempre el
color global, nunca un color escrito a mano: así, si mañana cambia el verde,
cambia en toda la web de una vez.

| Nombre en Elementor | Valor | Para qué |
|---|---|---|
| Primario | `#01735A` | Verde León. Titulares de sección, enlaces, botones |
| Secundario | `#015644` | Verde oscuro. Estado hover |
| Texto | `#3C3C38` | Todo el texto corrido |
| Acento | `#1C3829` | Fondos oscuros y el pie |

Y como colores personalizados:

| Nombre | Valor | Para qué |
|---|---|---|
| Tinta | `#1A1A17` | Titulares |
| Texto secundario | `#6B6B64` | Pies de foto, metadatos |
| Borde | `#D4D0C8` | Filetes y separadores |
| Crema | `#F4EFE4` | Bandas cálidas |
| Crema claro | `#FAFAF7` | Fondo alterno de sección |
| Sage pálido | `#C5D9C6` | Antetítulos sobre fondo verde |

**Ojo con el acento madera `#C4832A`:** no cumple contraste como texto sobre
blanco. Para texto usa `#A16B22`.

## 2. Tipografías globales

Elementor › Ajustes del sitio › **Fuentes globales**. Todo es **Open Sans**.

| Estilo | Fuente | Tamaño | Detalles |
|---|---|---|---|
| Primaria (título de sección) | Open Sans 400 | 48 → 76 px | MAYÚSCULAS, color Primario |
| Secundaria (subtítulo) | Open Sans 400 | 26 → 46 px | Ancho 75%, color Texto |
| Texto | Open Sans 400 | 16 px | Interlineado 1.75 |
| Acento (antetítulo) | Open Sans 700 | 15 px | MAYÚSCULAS, espaciado 0.08em, color Primario |

El «ancho 75%» es `font-stretch: 75%`. Si Elementor no lo ofrece, se añade en el
CSS personalizado de la sección:

```css
selector h2 { font-stretch: 75%; }
```

## 3. Ajustes de diseño

Elementor › Ajustes del sitio › **Diseño**:

- **Ancho del contenido:** 1360 px
- **Espacio entre widgets:** 24 px

El sitio de referencia usa el **68% del ancho de pantalla**. Con 1360 px de tope
el resultado es equivalente a partir de 2000 px.

## 4. El par de titulares

Es el gesto que define el diseño. Cada sección abre con dos líneas seguidas:

1. **Título** en Primario, mayúsculas, Open Sans normal (sin condensar)
2. **Subtítulo** justo debajo, en Texto, Open Sans condensada al 75%

Van pegados, sin espacio entre ellos.

## 5. Lo que NO hay que tocar

Estas cosas las da el tema. Si se rehacen en Elementor, se duplican:

- La cabecera con los dos desplegables y el selector de idioma
- El pie verde con las cuatro columnas y las redes
- Las fichas de producto y sus familias
- Las plantillas de artículo y de proyecto

## 6. Orden sugerido para reconstruir

De más visible a menos:

1. **Inicio** — vídeo, introducción, banda de Productos, referencias, actualidad, servicio
2. **Construcción en madera** y sus cinco subpáginas
3. **Quiénes Somos** — vídeo, introducción, historia, valores, misión y visión
4. **Servicio** — las cuatro puertas a los formularios
5. **Grupo León**

Los textos definitivos están en `Textos pagina FL oficial.docx` y ya volcados en
las páginas actuales: se pueden copiar desde ahí antes de rehacerlas.

## 7. Antes de empezar

Haz una **copia de seguridad** del sitio. Al reconstruir una página con Elementor
se sustituye su contenido actual, y no hay vuelta atrás desde el propio editor.
