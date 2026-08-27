# Entrega — Ficha de proyecto (referencias)

Convierte las tarjetas de referencia (imagen + «Nombre del proyecto, Ciudad
| Chile ») del Inicio y de las páginas de Construcción en madera en enlaces
que llevan a una ficha completa, con la estructura de las páginas de obra de
binderholz.com: carrusel, datos del proyecto, tres fotos, un bloque de texto,
un collage final y los formularios de contacto.

**Ver el diseño primero:** [vista previa navegable](https://claude.ai/code/artifact/dd1c67c4-b392-4ff2-ac41-e2144d0a1fd7) —
no es la web real, es una maqueta para revisar la estructura y las fotos ya
puestas antes de tocar nada.

---

## Importante antes de aplicar nada

Este repositorio es una foto de cómo estaba el tema y las páginas de
Elementor en un momento dado. **Si ya has seguido editando el sitio real
desde entonces, no reemplaces archivos enteros a ciegas** — perderías tu
trabajo. Por eso cada archivo de abajo dice si es seguro subirlo tal cual o
si conviene aplicar solo el fragmento que cambió.

## Qué es cada archivo

| Archivo | Qué le pasó | Cómo aplicarlo sin perder tu trabajo |
|---|---|---|
| `forestal-leon/patterns/ficha-proyecto-estructura.php` | **Nuevo.** | Sin riesgo: es un archivo que no existía. Cópialo tal cual. |
| `forestal-leon/patterns/formularios-ficha-proyecto.php` | **Nuevo.** | Sin riesgo, igual que el anterior. |
| `forestal-leon/templates/single-proyecto.html` | **Reemplazado entero** (es una plantilla corta, de 20 líneas). | Bajo riesgo: solo la tocaría alguien que haya rediseñado a mano la ficha de «Proyecto». Si no es tu caso, sube el archivo tal cual. |
| `forestal-leon/functions.php` | Se **añadieron** dos funciones nuevas (`forestal_leon_contenido_ficha_ejemplo` y `forestal_leon_sembrar_proyecto_ejemplo`) y una línea en `forestal_leon_sembrar_taxonomias()` que las llama. No se borró ni se modificó nada que ya existiera, salvo el número de versión en la línea 12. | **No lo reemplaces entero si has tocado este archivo tú.** Copia solo las funciones nuevas (búscalas por ese nombre) y la línea que las invoca, y actualiza el número de versión a mano. |
| `forestal-leon/style.css` | Se **añadieron** ~10 líneas al final de la sección de estilos de texto (buscar `.single-proyecto .is-style-entradilla`) y el número de versión. Nada existente se modificó. | Mismo criterio: si es un archivo que sigues editando, copia solo el bloque nuevo. |
| `elementor/inicio.json`, `proyectos.json`, `edificios.json`, `referencias.json`, `turismo.json` | A cada tarjeta de referencia se le añadió **un enlace** (`link` a `/proyectos/ejemplo-referencia`) en su contenedor. Nada más cambió. | **No los reimportes en Elementor** — reconstruir una página sustituye su contenido actual y no hay forma de deshacerlo. Si ya has editado esas páginas, el enlace se agrega a mano en 30 segundos por tarjeta: seleccionar el contenedor de la tarjeta (imagen + texto) → pestaña Diseño → **Enlace** → pegar la URL. Si las páginas siguen tal cual estaban, sí puedes reimportar el JSON completo. |
| `fotos-web/galpon-*.jpg` (9 fotos) | **Nuevas.** | Sin riesgo: solo subirlas en Medios › Añadir nueva. |

## Después de aplicarlo

1. **Crear la entrada de ejemplo:** si usas `functions.php`, se crea sola al
   reactivar el tema (o entrar al panel, gracias al «seguro» que ya tiene
   `forestal_leon_sembrar_si_falta`). Si prefieres no tocar ese archivo,
   créala a mano: Proyectos › Añadir proyecto, slug `ejemplo-referencia`, y
   pega el contenido del patrón «Ficha de proyecto — estructura».
2. **Subir las 9 fotos** de `fotos-web/` y asignarlas donde dice la nota de
   cada bloque (carrusel y collage).
3. **Instalar un plugin de carrusel** con autoplay para el hueco marcado
   arriba del todo de la ficha (Jetpack trae uno gratis).

## Lo que falta (no está en esta entrega)

- Las 3 fotos a ancho completo y el bloque de texto de cierre de la ficha
  del Galpón — pendientes de que Vicente los mande.
- Una ficha real por cada referencia (hoy todas las tarjetas apuntan a la
  misma, `ejemplo-referencia`, a modo de demostración).
