# Forestal León — espacio de pruebas de diseño

Este repositorio es un **banco de pruebas paralelo**. Sirve para ensayar ideas de
diseño —colores, tipografías, proporciones— y poder enseñárselas a alguien con un
enlace.

> **La web publicada no se toca desde aquí.** Nada de lo que se cambie en este
> repositorio llega a forestalleon.cl. Son dos cosas separadas, a propósito:
> así se puede probar sin miedo a romper nada.

---

## Ver la maqueta

**https://isaiastoledo.github.io/forestal-leon/**

Es el home completo: portada, «Madera con valor agregado», «Referencias más
destacadas», «Actualidad» y «Servicio». Se puede abrir en el móvil y compartir
el enlace con quien sea.

---

## Probar un color o una tipografía

Todo el aspecto de la maqueta se controla desde **un solo sitio**: las primeras
líneas del archivo [`index.html`](index.html), dentro del bloque `:root`.

```css
--primary:#01735a;        /* Verde León — titulares, botones, enlaces */
--primary-dark:#015644;   /* el mismo verde al pasar el ratón */
--forest-deep:#1c3829;    /* fondo del pie de página */
--cream:#f4efe4;          /* fondos suaves de sección */
```

Cambiar uno de esos códigos y guardar recolorea la maqueta entera.

**Cómo hacerlo sin instalar nada:**

1. Abrir [`index.html`](index.html) aquí en GitHub.
2. Pulsar el lápiz (✏️) de la esquina superior derecha.
3. Cambiar el código de color, por ejemplo `#01735a` por `#0a5f8a`.
4. Bajar del todo y pulsar **Commit changes**.
5. Esperar un minuto y recargar la dirección de arriba.

Si el resultado no gusta, se vuelve atrás: en el historial del archivo está cada
versión anterior y se puede restaurar cualquiera.

---

## Qué es cada cosa

| Carpeta o archivo | Qué es |
|---|---|
| `index.html` | **La maqueta.** Es lo que se ve en el enlace y donde se prueban las ideas |
| `forestal-leon/` | El tema real de WordPress. **Mirar, no tocar** |
| `elementor/` | Las páginas en formato Elementor |
| `fotos-web/` | Las fotografías optimizadas |
| `SUBIDA.md`, `INSTALAR.md`, `FORMULARIOS.md` | Manuales de la web real |
| `forestal-leon/DESIGN-SYSTEM.md` | Los 20 colores con sus nombres y contrastes |

---

## Dos advertencias importantes

**La maqueta es solo el home.** Las páginas interiores —productos, proyectos,
fichas, contacto— no están. Una idea que afecte a esas páginas no se verá aquí.

**Un cambio aquí no es un cambio en la web.** La maqueta imita el diseño, pero es
un archivo aparte. Cuando una combinación convenza, hay que trasladarla al tema
(`forestal-leon/theme.json`) y volver a publicar la web. Ese paso es manual y lo
hace quien lleve el desarrollo.

---

## Si algo se rompe

No pasa nada: la web real sigue intacta. Cada cambio queda registrado en el
historial y se puede deshacer. En el peor caso, se restaura la versión
etiquetada `v2.16.0`, que es el estado de partida.
