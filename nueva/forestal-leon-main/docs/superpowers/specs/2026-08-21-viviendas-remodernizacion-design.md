# Viviendas — remodernización de la página

**Fecha:** 21 de agosto de 2026
**Página:** Construcción en madera › Viviendas
**Referencia:** `binderholz.com/es/soluciones-de-construccion/vivienda-unifamiliar/`
**Enfoque elegido:** espejo de la referencia (opción B)

---

## 1. Por qué

La página de Viviendas es hoy la más pobre de la web. Cinco contenedores:
antetítulo, título, subtítulo, una foto, tres párrafos corridos, tres
referencias con la imagen vacía y la banda de contacto. El molde es idéntico al
de Edificios y Turismo, así que ninguna de las tres dice nada que la otra no
diga.

El 21 de agosto de 2026 se remodernizó «La madera como material de
construcción» con el método de vista previa estática más JSON regenerado. Este
documento aplica el mismo método a Viviendas.

## 2. Decisiones tomadas

| Decisión | Valor | Consecuencia |
|---|---|---|
| Alcance | Solo Viviendas | Edificios y Turismo se replican después con el molde ya validado |
| Fotografía | Existe, sin volcar al repo | El plan incluye selección y optimización |
| Qué vende la página | El kit estructural | Público: arquitectos y constructoras, no la familia |
| Entregable | Vista previa + JSON | El patrón del tema no se toca |
| Estructura | Espejo de binderholz | Se asume que la página no argumenta *por qué* la madera |

### Sobre el enfoque elegido

Se evaluaron tres enfoques. El recomendado era reordenar la página alrededor de
lo que sale de la planta —qué piezas fabrica Forestal León y qué hace el
constructor—, porque es la pregunta que trae el arquitecto y que la página hoy
no contesta en ningún punto.

Se eligió el espejo de binderholz. Queda registrado el motivo de la reserva, no
para reabrirla sino para que se sepa qué se sopesó si algún día se revisa: la
página resultante es más corta y con menos argumento técnico que la
alternativa, y depende de una parrilla de referencias con fotografía real.

## 3. Los cinco módulos

### Módulo 1 · Portada

Par de titulares del tema, sin cambios de estilo:

```
Construcción en madera        antetítulo · Open Sans 700 15 px · MAYÚSCULAS · --primary
Viviendas                     H1 · sin condensar · MAYÚSCULAS · --primary · clamp(2rem, 5.5vw, 3.875rem)
Construcción de viviendas
unifamiliares en madera       H2 · condensada 75% · --contrast · clamp(1.5rem, 3.4vw, 2.5rem)
```

Fondo: `linear-gradient(180deg, var(--base), var(--base-alt))`.

**Cambio de contenido.** Binderholz abre con el bienestar, no con la técnica:
su primera frase es «Una casa de madera es sinónimo de bienestar». Ese párrafo
en Viviendas es hoy el tercero. Sube a entradilla de portada, a 1.125 rem. El
texto no se reescribe, solo cambia de posición.

Imagen `tipologia-viviendas.jpg` en banda ancha bajo el titular, relación 16/9,
`object-fit: cover`, `--sombra-alta`.

### Módulo 2 · Tarjeta destacada

Binderholz coloca aquí su descargable —el PDF «Sueño de vivienda de madera
maciza»— en una tarjeta con peso visual propio.

**Forestal León no tiene ese documento**, y producirlo excede este trabajo. Se
conserva el slot y su jerarquía; cambia la carga:

- Fondo `--cream`, borde superior de 4 px en `--primary`, radio 0
- Título: «Ficha técnica del sistema Timber Frame»
- Botón que **no descarga: solicita**, enlazado al formulario de Construcción e
  ingeniería

Mismo lugar, mismo peso, promesa que sí se puede cumplir. Cuando exista el PDF
se cambia el destino del botón y nada más.

### Módulo 3 · Texto de soluciones constructivas

Los párrafos 1 y 2 actuales, que ya son el equivalente del bloque de
binderholz: sistema Timber Frame, componentes fabricados en planta, panelería
liviana no estructural, adaptabilidad arquitectónica.

**El texto oficial se conserva.** `tipologia-viviendas.php` documenta que el
cliente pidió en «Comentarios SOLUCIONES DE CONSTRUCCIÓN» que la información
vaya completa, sin resumir en punteos ni collages.

Un solo ajuste de redacción: dejar explícito **qué sale de planta y qué se hace
en obra**. El público decidido es arquitecto y constructora, y esa frase es la
que hoy falta. La redacción concreta se propone en el plan y la valida
ingeniería antes de publicar.

Medida limitada a unos 62 caracteres por línea. Sin tarjetas, sin iconos.

### Módulo 4 · Parrilla de referencias

Es el módulo que sostiene la página en la referencia, así que se diseña para
aguantar.

| Aspecto | Valor |
|---|---|
| Tarjeta | Foto 4/3 `object-fit: cover` + título de obra + ubicación |
| Enlace | Toda la tarjeta, hacia `/proyectos/<obra>` |
| Columnas | 3 desde 1024 px · 2 en tablet · 1 en móvil |
| Hover | `scale(1.04)` en la foto, `--sombra-media` → `--sombra-alta` |
| Aparición | Sistema `.reveal` + `--d` escalonado, ya existente |
| Transición | `--t-base` (256 ms) |

**Regla de degradación.** Con menos de 6 obras la parrilla no se renderiza a 3
columnas: quedarían huecos. Pasa a 2 columnas grandes. Es la diferencia entre
una sección que se ve corta y una que se ve rota. La regla va escrita en el CSS
de la vista previa, no dejada al criterio de quien monte la página.

### Módulo 5 · Banda de servicio

Binderholz cierra con cuatro accesos de servicio. Forestal León ya tiene su
equivalente exacto —compra de productos, construcción e ingeniería,
reclamos/MPD, contacto general— e idéntico en las 16 páginas.

**Se conserva sin tocar.** Rehacerla rompería la coherencia del sitio sin ganar
nada.

## 4. Sistema de diseño

No se inventa ningún valor. Todo sale de `theme.json` y del preview anterior:

- Color: `--primary #01735a`, `--primary-dark #015644`, `--cream #f4efe4`,
  `--contrast #3c3c38`, `--ink #1a1a17`, `--border #d4d0c8`
- Tipografía: Open Sans variable, ejes `wght` y `wdth`; condensada = 75%
- Espaciado: base 8, tokens `--s10` a `--s70`
- Geometría: radio 0
- Transiciones: 128 ms y 256 ms
- Sombras: las tres de `theme.json`, `--sombra-sutil` / `-media` / `-alta`
- Ancho de contenido: 1360 px
- `prefers-reduced-motion: reduce` desactiva reveal y transiciones

## 5. Entregables

| Archivo | Qué es |
|---|---|
| `preview-viviendas.html` | Vista previa estática, autónoma, para validar en navegador |
| `elementor/viviendas.json` | Regenerado. Es lo único que llega a producción |

No se toca `forestal-leon/patterns/tipologia-viviendas.php`. Las páginas las
sirve Elementor; `ELEMENTOR.md` § 5 advierte contra rehacer en dos sitios lo
mismo.

El JSON mantiene `version: 0.4`, `type: page` y la estructura de contenedores
de Elementor, para que la importación funcione igual que la de
`madera-material-construccion.json`.

## 6. Lo que hace falta antes de poder publicar

Estas tres cosas no las puede resolver el diseño. Sin ellas la página se
maqueta y se valida, pero no se publica.

1. **Las fotografías de viviendas ejecutadas.** Confirmadas como existentes,
   pendientes de volcar. Van a `fotos-web/` optimizadas, con el mismo criterio
   que las 18 actuales.
2. **Los nombres y ubicaciones reales de las obras.** Los actuales —«Vivienda
   unifamiliar, Los Ríos», «Vivienda de dos plantas, Ñuble», «Ampliación de
   vivienda, Biobío»— son relleno de maqueta. Publicarlos junto a una foto real
   los convertiría de hueco visible en afirmación falsa sobre obras ejecutadas.
3. **Seis obras como mínimo.** Por debajo de eso el módulo central se queda sin
   ancla y el enfoque elegido habría que replantearlo.

Mientras tanto la vista previa se maqueta con las fotos industriales de
`fotos-web/` como marcador visible, nunca con títulos de obra inventados.

## 7. Riesgos asumidos

**La página no argumenta por qué la madera.** Es la consecuencia directa del
enfoque elegido. Binderholz puede permitírselo porque ese argumento vive en su
página de material; aquí también —«La madera como material de construcción»,
rehecha el 21 de agosto de 2026— así que el argumento existe en el sitio, a un
clic desde el menú de Construcción en madera.

**La tarjeta destacada promete algo que no se descarga.** Mitigado: el botón
dice «solicitar», no «descargar». Pero conviene que exista la ficha técnica
antes de que la pida mucha gente.

**Edificios y Turismo quedan desalineadas.** Aceptado: se replican después con
este molde una vez validado.
