# Instalar el tema Forestal León

Requisitos: WordPress 6.5 o superior y PHP 7.4 o superior.
Es un tema de bloques (Full Site Editing) y no depende de ningún constructor para
funcionar.

> **Pero en esta web Elementor sí hace falta y debe seguir activo.** Desde el 18
> de agosto de 2026 el contenido de las 17 páginas está maquetado con Elementor
> gratuito; el tema aporta cabecera, pie, colores, tipografías y el catálogo de
> productos. Desactivar Elementor vaciaría las páginas. El reparto está explicado
> en el [README](../README.md) y la configuración en [ELEMENTOR.md](../ELEMENTOR.md).

---

## Subirlo (2 minutos)

1. Entra en WordPress como administrador.
2. **Apariencia › Temas › Añadir nuevo tema › Subir tema**.
3. Elige `forestal-leon.zip` y pulsa **Instalar ahora**.
4. Pulsa **Activar**.

Al activarse, el tema copia el logotipo a la biblioteca de medios y lo deja
configurado solo. La cabecera no aparecerá vacía.

Si el hosting rechaza el ZIP por tamaño, súbelo por FTP o por el gestor de archivos
del panel: descomprímelo en `/wp-content/themes/`, de modo que quede
`/wp-content/themes/forestal-leon/style.css`.

## Primeros pasos después de activar

1. **Ajustes › Lectura** → «Tu página de inicio muestra: una página estática».
   Crea una página vacía llamada «Inicio» y selecciónala. La plantilla
   `front-page.html` ya monta portada, cifras, productos, sustentabilidad y CTA.
2. **Ajustes › Enlaces permanentes** → «Nombre de la entrada» y guarda.
   Es el paso que casi todo el mundo olvida.
3. **Apariencia › Editor › Patrones › Cabecera** — el menú viene con los cinco
   enlaces del kit (Inicio, Quiénes Somos, Productos, Sustentabilidad, Contacto).
   Ajusta las URL cuando existan las páginas.
4. **Sube las fotos.** Los patrones traen los huecos de imagen vacíos.
   Hay material en `WEB FORESTAL LEON\9FOTOS PRODUCTOS`.
5. **Apariencia › Editor › Estilos** — aquí se cambia cualquier color o tamaño
   sin tocar código.

## Las páginas se crean solas

Al activar el tema no hay que crear nada a mano. Se generan:

| Página | Qué trae |
|---|---|
| `/` Inicio | Portada de 8 módulos, ya marcada como página de inicio |
| `/construccion-en-madera` | Apertura, ventajas de la madera, las tres tipologías, referencias y CTA |
| `/servicios` | Las cuatro vías de contacto |
| `/empresa` | Introducción, vídeo, historia por hitos, misión, visión y los cinco valores |
| `/grupo-leon` | Forestal León, Energía León y Vivero León |
| `/noticias` | Vacía, ya asignada como página de entradas |
| `/trabaja-con-nosotros` · `/aviso-legal` · `/privacidad` | Vacías, con nota de lo que falta |

Los textos son los oficiales del documento **«Textos pagina FL oficial»**, no
texto de relleno. Se editan como cualquier página.

Y estas no son páginas, las genera el propio tema:

```
/productos                          catálogo (tipo de contenido Productos)
/productos/seco-cepillado           las nueve fichas, creadas al activar
/familia-producto/madera-aserrada   las tres familias
/proyectos  ·  /tipo-proyecto/…     obras de construcción
```

> La portada y la página de entradas solo se configuran si nadie lo había hecho
> antes. Si el sitio ya tenía una portada estática elegida, el tema no la toca.

El mapa completo entre el documento de estructura y el tema está en
`ESTRUCTURA.md`.

## Los formularios necesitan un plugin

La estructura pide cuatro formularios, cada uno a un correo distinto y respondible
directamente al remitente. WordPress no trae formularios: instala **Fluent Forms**
(gratuito) y crea los cuatro con las anclas `#compra-de-productos`,
`#construccion-e-ingenieria`, `#reclamos` y `#contacto-general` dentro de
`/servicios`. Añade también **FluentSMTP** para que los avisos no caigan en spam.
Detalle en `ESTRUCTURA.md`.

## Cambiar el color principal

- **Sin código:** Apariencia › Editor › Estilos › Colores › Paleta › **Verde León**.
- **Permanente:** `theme.json`, slug `primary` (y `primary-dark` para el hover).

Antes de cambiarlo, lee la sección 1 de `DESIGN-SYSTEM.md`: el verde actual está
muestreado del logotipo, y el kit de marca propone otro distinto.

## Qué incluye

```
forestal-leon/
├── style.css              Cabecera del tema + CSS de componentes
├── theme.json             ← el sistema de diseño completo (19 colores)
├── functions.php          Fuentes, estilos de bloque, logo, Productos y Proyectos
├── templates/             front-page · productos (3) · proyectos (2) · index ·
│                          single · page · pagina-ancha · 404 · search
├── parts/                 header (menú de 7 secciones) · footer
├── patterns/              9 secciones con los textos de la estructura
├── assets/images/         logotipo en verde y en blanco
├── ESTRUCTURA.md          ← mapa documento de estructura → tema
├── DESIGN-SYSTEM.md       Documentación de todos los tokens
└── INSTALAR.md            Este archivo
```

## Problemas frecuentes

**«El paquete no se ha podido instalar. No se han encontrado temas.»**
El ZIP tiene que contener la carpeta `forestal-leon` dentro, no los archivos sueltos.
Si lo regeneraste con `Compress-Archive` de Windows, es eso: usa `empaquetar.py`.

**No veo Apariencia › Editor.**
Hay un tema clásico activo. Comprueba que Forestal León figura como activo.

**La cabecera sale sin logotipo.**
La instalación automática solo corre al activar el tema. Ponlo a mano en
Apariencia › Editor › Patrones › Cabecera, o desde el Personalizador.

**Los titulares no salen condensados.**
Un plugin de optimización (WP Rocket, Autoptimize, LiteSpeed) está bloqueando
Google Fonts o eliminando `font-stretch` al minificar. Excluye
`fonts.googleapis.com` de la optimización, o pasa a fuentes locales
(`DESIGN-SYSTEM.md` § 8).

**Cambio `theme.json` y no se ve.**
Los cambios hechos desde el editor tienen prioridad sobre el archivo.
En Apariencia › Editor › Estilos, menú de tres puntos → **Restablecer a los
valores predeterminados**.
