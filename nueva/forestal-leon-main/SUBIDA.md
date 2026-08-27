# Subida a WordPress — Forestal León v2.16.0

Paso a paso para dejar la web con todos los cambios del documento
«Comentarios pagina web 11 Ago».

El tema y el contenido son cosas distintas: el ZIP del tema **no** lleva las
páginas, que viven en la base de datos. Por eso subir el tema no borra lo
maquetado. Lo único que sobrescribe es el paso 4.

---

## Antes de empezar · copia de seguridad

**Herramientas › Exportar › Todo el contenido › Descargar**

Se baja un XML con todas las páginas y productos. Si algo sale mal, se
reimporta desde Herramientas › Importar.

Si Hostinger ofrece copia completa en su panel, mejor: esa incluye la base de
datos entera.

---

## 1 · Subir el tema

**Apariencia › Temas › Añadir nuevo › Subir tema** → `forestal-leon.zip` →
**Sustituir el actual**.

Al activarse crea las páginas que falten. Las que ya existen no las toca.

Comprobar en **Páginas** que están: Productos, Proyectos, Madera aserrada,
Plywood, Laminado y Contacto.

## 2 · Borrar las páginas que sobran · limpieza, no urgencia

Al renombrarse, estas dos quedaron obsoletas:

- **Servicios** — la sustituye Contacto
- **Madera estructural** — la sustituye Plywood

Los slugs son distintos (`/servicios` frente a `/contacto`), así que **no
chocan entre sí**: el menú funciona igual sin borrarlas. Pero conviene hacerlo
por dos motivos: en la lista de Páginas aparecen las dos versiones y es fácil
acabar editando la equivocada, y las viejas siguen respondiendo por URL, con lo
que Google puede indexar contenido antiguo.

**Páginas** → pasar el ratón por encima → **Papelera**. Dejarlas ahí unos días
antes de vaciarla.

> **No hace falta activar Elementor para «Productos» en los ajustes del
> plugin.** Tenía sentido cuando cada producto era una página propia; ahora son
> secciones dentro de las tres familias y no queda ningún enlace a
> `/productos/{slug}` en el menú, las plantillas ni el tema.

## 3 · Cargar las plantillas

**Plantillas › Plantillas guardadas**

1. Borrar todas las que haya: son de versiones anteriores
2. **Importar plantillas** → los 16 JSON de golpe

Aquí no se toca ninguna página, solo se llena la biblioteca.

## 4 · Montar las páginas · el paso delicado

Para cada una:

1. Abrir con **Editar con Elementor**
2. Si tiene contenido antiguo: seleccionar todo y **borrar**. Si no, quedan las
   dos versiones pegadas una debajo de otra
3. Icono de carpeta (**Añadir plantilla**) → pestaña **Mis plantillas** →
   insertar la que corresponda
4. **Publicar**

### Orden recomendado

Empezar por **Laminado**, que es nueva y no tiene nada que perder. Publicarla,
mirarla, y si va bien seguir con el resto.

| Página | Plantilla |
|---|---|
| Inicio | `inicio.json` |
| Construcción en madera | `construccion-en-madera.json` |
| Referencias | `referencias.json` |
| La madera como material | `madera-material-construccion.json` |
| Viviendas | `viviendas.json` |
| Edificios | `edificios.json` |
| Turismo | `turismo.json` |
| Productos | `productos.json` |
| Madera aserrada | `madera-aserrada.json` |
| Plywood | `plywood.json` |
| Laminado | `laminado.json` |
| Quiénes Somos | `quienes-somos.json` |
| Contacto | `contacto.json` |
| Grupo León | `grupo-leon.json` |
| Noticias | `noticias.json` |
| Proyectos | `proyectos.json` |

## 5 · Comprobar

- [ ] El menú Productos abre solo tres: Madera aserrada, Plywood, Laminado
- [ ] No aparece el botón Cotizar
- [ ] No hay título negro encima de las páginas
- [ ] Las franjas de color llegan de borde a borde, con el texto alineado
- [ ] En Inicio el vídeo cubre la pantalla y no se ve texto de YouTube
- [ ] Los enlaces de contacto bajan al bloque correcto de `/contacto`
- [ ] Todo lo anterior también a 375 px de ancho

---

## Lo que queda pendiente

**Formularios.** Sin montar: faltan las cuatro direcciones de correo y una
cuenta del dominio para enviar. El procedimiento completo está en
`FORMULARIOS.md` y la plantilla del correo en `correo-formulario.html`.

**Fotos de obra.** 29 imágenes vacías, todas en fichas de referencia: Inicio 4,
Referencias 6, Proyectos 6, y 3 en cada tipología. Las de Quiénes Somos hay que
reinsertarlas eligiendo **Tamaño: Completo**.

**Nombres de las referencias.** Van por tipología —«Lodge turístico, Los Lagos
| Chile»— y no con nombres de obra concretos, para no atribuirle a Forestal
León proyectos que quizá no ha hecho. Se sustituyen cuando lleguen los reales.

**Ficha técnica de producto.** Falta el dato real: escuadrías, largos, humedad,
grados de impregnación y certificaciones.

**Traducción ES/EN.** Necesita plugin. La traducción la hace Vicente.

**Logos FSC™ y PEFC.** No incluidos: son activos licenciados.

**Verde corporativo.** Sigue sin decidirse entre el del logo `#01735A` y el del
kit de marca `#2E5940`. La web usa el del logo.

**Contenidos huérfanos.** Los 9 productos y los proyectos siguen en la base de
datos pero ya no los enlaza nada. Decidir si se borran o se dejan.
