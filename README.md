> ### ¿Vienes a ver o probar el diseño?
> **Maqueta en vivo:** https://isaiastoledo.github.io/forestal-leon/
> **Cómo probar colores y tipografías:** [LEEME.md](LEEME.md)
>
> Lo que sigue es documentación técnica del tema. La web publicada
> (forestalleon.cl) no se modifica desde este repositorio.

# Forestal León — tema de WordPress

Clon del diseño de `binderholz.com/es/` con el logotipo y los colores corporativos
de Forestal León (Coelemu, Región de Ñuble).

- **Estructura, retícula, tipografía y geometría:** medidas extraídas de binderholz
  (radio 0, condensada, base 8, transiciones de 128/256 ms).
- **Marca:** logotipo original + paleta de `forestal-leon-design-kit` v1.0,
  más el verde muestreado del propio logotipo.

## Estructura

La arquitectura sigue el documento **«Programa forestal león»**: 7 secciones,
productos en 3 familias y proyectos de construcción por tipo.

```
F:\forestal-leon\
├── forestal-leon\               ← el tema (esto va a WordPress)
│   ├── theme.json               19 colores, 9 tamaños, 8 espaciados
│   ├── style.css
│   ├── functions.php            logo, tipos Productos y Proyectos
│   ├── templates\               front-page + catálogo + fichas + 6 más
│   ├── parts\                   cabecera de 7 secciones · pie
│   ├── patterns\                9 secciones con los textos de la estructura
│   ├── assets\images\           logotipo verde y blanco
│   ├── ESTRUCTURA.md            ← mapa documento → tema, y qué falta
│   ├── DESIGN-SYSTEM.md
│   └── INSTALAR.md
├── forestal-leon.zip            paquete listo para subir
├── index.html                   maqueta del home (publicada en GitHub Pages)
└── empaquetar.py                regenera el ZIP
```

## Por qué tema de bloques y no Elementor

Decisión tomada el 9 de agosto de 2026, tras evaluar las dos opciones.

En `WEB FORESTAL LEON\WEB PLANTILLA` hay un Template Kit de Elementor
(formato Envato, `manifest_version` 1.0.23) que se planteó como alternativa.
Se descartó por tres motivos:

1. **La cabecera fija que cambia de color al hacer scroll es una plantilla de
   cabecera, y eso vive en el Theme Builder de Elementor, que es de pago.**
   Aquí solo hay Elementor gratuito, así que ese comportamiento —el que se pidió
   expresamente— no se podría reproducir.
2. El kit de referencia arrastra cuatro plugins (Elementor, ElementsKit Lite,
   Gum Elementor Addon, MetForm). Este tema no depende de ninguno.
3. Elementor genera bastante más HTML y CSS por página que un tema de bloques.

Si algún día se reconsidera: lo reaprovechable son los 19 colores con sus ratios
de contraste, la escala tipográfica y los textos —todo documentado en
`DESIGN-SYSTEM.md` y `ESTRUCTURA.md`—. Lo que habría que rehacer desde cero es
`theme.json`, `style.css`, las 11 plantillas y los 14 patrones: no existe
conversión automática entre Gutenberg y Elementor.

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

## Dos decisiones abiertas

1. **El verde.** El del logotipo (`#01735A`) no coincide con el del kit
   (`#2E5940`); la diferencia es ΔE 15.9, visible. Se usa el del logotipo como
   primario para que marca y botones concuerden. Ver `DESIGN-SYSTEM.md` § 1.
2. **La tipografía.** El kit pide Cormorant Garamond + DM Sans; el tema mantiene
   la Open Sans condensada del diseño clonado. Ver `DESIGN-SYSTEM.md` § 2.

3. **Los formularios.** La estructura pide cuatro, cada uno a un correo distinto.
   WordPress no trae formularios: hace falta un plugin. Ver `ESTRUCTURA.md`.

## Pendiente

Fotografías (hay ~60 en `WEB FORESTAL LEON\9FOTOS PRODUCTOS`), fichas de los 9
productos, obras de referencia, contenidos de Empresa (están en
`Textos pagina FL oficial.docx`), los 4 formularios y `screenshot.png` del tema.
Lista completa en [forestal-leon/ESTRUCTURA.md](forestal-leon/ESTRUCTURA.md).
