# Formularios de contacto — Forestal León

Cómo montar los cuatro formularios para que cada uno llegue a un correo
distinto, con formato propio y se puedan responder directamente al remitente.

Elementor gratuito no trae widget de formularios: el de Elementor Pro cuesta
59 USD al año. Se resuelve con dos plugins gratuitos, igual que se hizo con la
rejilla de noticias.

---

## 1 · Instalar los dos plugins

**Plugins › Añadir nuevo**, buscar e instalar:

- **Fluent Forms** — crea los formularios
- **FluentSMTP** — envía los correos de verdad

Sin el segundo, WordPress usa la función `mail()` de PHP: texto plano, sin
formato y con muchas papeletas de acabar en la carpeta de spam.

---

## 2 · Configurar el envío (FluentSMTP)

**Ajustes › FluentSMTP › Añadir conexión**

| Campo | Valor |
|---|---|
| Correo remitente | `web@forestalleon.cl` |
| Nombre remitente | Forestal León |
| Proveedor | Otro SMTP |
| Servidor | `smtp.hostinger.com` |
| Puerto | 465 (SSL) |
| Usuario | `web@forestalleon.cl` |
| Contraseña | la de esa cuenta |

Marcar **Forzar el remitente**, para que ningún plugin lo cambie por su cuenta.

Al terminar, usar **Enviar correo de prueba** antes de seguir.

> La cuenta se crea en el panel de Hostinger, en Correos. Si el volumen crece,
> Brevo da 300 correos al día gratis y mejor entregabilidad.

---

## 3 · Crear los cuatro formularios

**Fluent Forms › Nuevo formulario › Formulario en blanco.** Uno por cada uno:

| # | Formulario | Va a | Asunto del correo |
|---|---|---|---|
| 1 | Compra de productos | `ventas@forestalleon.cl` | `[Web] Cotización — {inputs.nombre}` |
| 2 | Construcción e ingeniería | `construcciones@forestalleon.cl` | `[Web] Proyecto — {inputs.nombre}` |
| 3 | Reclamos y MPD | `reclamos@forestalleon.cl` | `[Web] Reclamo — {inputs.nombre}` |
| 4 | Contacto general | `contacto@forestalleon.cl` | `[Web] Consulta — {inputs.nombre}` |

Direcciones confirmadas por el cliente el 29 de agosto de 2026.

### Campos de cada formulario

Importante: las **claves** de los campos deben llamarse exactamente así, porque
son las que usa la plantilla del correo.

**Los cuatro comparten:**

| Etiqueta | Clave | Tipo | Obligatorio |
|---|---|---|---|
| Nombre | `nombre` | Texto | sí |
| Correo electrónico | `email` | Correo | sí |
| Teléfono | `telefono` | Texto | no |
| Empresa | `empresa` | Texto | no |
| Mensaje | `mensaje` | Área de texto | sí |

**Añadir en el 1 (Compra de productos):**

| Etiqueta | Clave | Tipo |
|---|---|---|
| Producto de interés | `producto` | Desplegable: Madera aserrada · Plywood · Laminado |
| Escuadría y volumen | `volumen` | Texto |

**Añadir en el 2 (Construcción e ingeniería):**

| Etiqueta | Clave | Tipo |
|---|---|---|
| Tipo de proyecto | `tipo` | Desplegable: Vivienda · Edificio · Turismo · Industrial · Otro |
| Ubicación de la obra | `ubicacion` | Texto |
| Estado del proyecto | `estado` | Desplegable: Idea · Anteproyecto · Cálculo cerrado |

**Añadir en el 3 (Reclamos y MPD):**

| Etiqueta | Clave | Tipo |
|---|---|---|
| Tipo de caso | `tipo_caso` | Desplegable: Reclamo · Denuncia MPD |
| Deseo mantener el anonimato | `anonimo` | Casilla |

> Si se marca el anonimato, en el correo llegará igualmente la dirección desde
> la que se envió. Conviene revisarlo con el cliente antes de publicarlo, porque
> un canal de denuncias que promete anonimato y no lo cumple es un problema.

---

## 4 · La notificación por correo

En cada formulario: **Ajustes › Notificaciones por correo › Editar**.

| Campo | Qué poner |
|---|---|
| Enviar a | la dirección de la tabla de arriba |
| De | `web@forestalleon.cl` |
| Nombre del remitente | Forestal León |
| **Responder a** | `{inputs.email}` |
| Asunto | el de la tabla de arriba |
| Cuerpo | el contenido de `correo-formulario.html` |

El cuerpo se pega con el editor en **modo código** (el botón `</>`), o pierde
el formato.

### Por qué «De» no lleva el correo del visitante

Es el error más habitual, y parece lo lógico: si pones ahí su dirección,
respondes directo. Pero entonces el servidor de Hostinger estaría enviando
correo diciendo que viene de `gmail.com` o de la empresa que sea. Eso rompe la
comprobación SPF y el mensaje acaba en spam o rebota.

La forma correcta es la de la tabla: **De** siempre el dominio propio, y
**Responder a** el del visitante. Al pulsar «Responder» en Gmail o en Outlook,
la respuesta va al cliente igualmente.

---

## 5 · Antispam

En cada formulario, **Ajustes › Otros ajustes**, activar **Casilla trampa**.
Es un campo invisible que los robots rellenan y las personas no. Frena casi
todo el correo basura sin poner un captcha delante del usuario.

Si aun así entra spam, en **Fluent Forms › Ajustes globales** se puede añadir
Cloudflare Turnstile, que es gratuito y menos molesto que reCAPTCHA.

---

## 6 · Colocarlos en la web

Ya están puestos en las plantillas de Elementor, con el widget **Shortcode**:

| Página | Sección | Shortcode |
|---|---|---|
| Contacto | Compra de productos | `[fluentform id="1"]` |
| Contacto | Construcción e ingeniería | `[fluentform id="2"]` |
| Contacto | Reclamos y MPD | `[fluentform id="3"]` |
| Contacto | Contacto general | `[fluentform id="4"]` |
| Inicio | Formulario de contacto | `[fluentform id="4"]` |

**Los números del 1 al 4 son una suposición.** Fluent Forms asigna el suyo al
crear cada formulario. Se ve en la columna «Shortcode» de la lista de
formularios; si no coinciden, hay que corregir esos cinco widgets en Elementor.

---

## 7 · Comprobar antes de dar por bueno

Enviar los cuatro formularios de prueba y verificar, uno a uno:

- [ ] Llega al correo correcto, y solo a ese
- [ ] El asunto lleva el nombre de quien escribe
- [ ] Se ve con el formato de la plantilla, no en texto plano
- [ ] Al pulsar «Responder», el destinatario es el visitante
- [ ] No cae en spam (probar con Gmail y con Outlook, que son los más severos)
- [ ] Los campos obligatorios avisan si se dejan vacíos
- [ ] Se ve bien en móvil, a 375 px

---

## Lo que falta para poder montarlo

1. **Las cuatro direcciones de destino** — las confirma el cliente
2. **Una cuenta de correo del dominio** para enviar, con su contraseña SMTP
3. **Confirmar los campos**: si el cliente quiere RUT, comuna o algún otro
