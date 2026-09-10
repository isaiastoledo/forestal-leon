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

El correo de `forestalleon.cl` lo gestiona **Google Workspace**, no Hostinger.
Comprobado el 30 de agosto de 2026: los registros MX del dominio apuntan a
`aspmx.l.google.com`. Cualquier configuración contra `smtp.hostinger.com` no
funciona, aunque el sitio esté alojado allí.

**Ajustes › FluentSMTP › Añadir conexión**

| Campo | Valor |
|---|---|
| From Email | `contacto@forestalleon.cl` |
| Force From Email | Sí |
| From Name | Forestal León |
| Proveedor | Other SMTP |
| SMTP Host | `smtp.gmail.com` |
| Port | 587 |
| Encryption | TLS |
| Auto TLS | Activado |
| Authentication | Activado |
| Username | `contacto@forestalleon.cl` |
| Password | **contraseña de aplicación**, no la del correo |

### La contraseña de aplicación

No es la contraseña del buzón, sino un código de 16 letras que se genera en
`myaccount.google.com/apppasswords`. Requiere tener activada la verificación en
dos pasos en esa cuenta. Solo sirve para enviar correo y se puede anular en
cualquier momento sin tocar la contraseña real.

> **Ojo con las cuentas sin estrenar.** Un buzón de Workspace que nunca se ha
> usado pide definir contraseña en el primer acceso. Si es del cliente, ese paso
> lo tiene que dar él: cambiarla por tu cuenta le deja fuera de su propio correo.
> Pasó el 8 de septiembre de 2026 con tres de los cuatro buzones.

### Estado de la conexión

**Configurada el 10 de septiembre de 2026** con `contacto@forestalleon.cl`. Las
claves no se guardan en este repositorio, que es público: están en poder del
cliente y de quien administra la web.

Las contraseñas de aplicación **no caducan**, pero Google las anula en cuatro
casos:

- **si se cambia la contraseña principal del buzón** — el caso realista;
- si se desactiva la verificación en dos pasos;
- si alguien la revoca a mano en `myaccount.google.com/apppasswords`;
- si Google detecta actividad sospechosa en la cuenta.

En cualquiera de ellos **los formularios dejan de enviar sin avisar**: los
mensajes se siguen guardando en Fluent Forms › Entries, pero no llega el correo.
Si el cliente cambia la contraseña de `contacto@`, hay que generar una clave de
aplicación nueva y ponerla en FluentSMTP.

> Las claves que el cliente pasó para `ventas@` y `reclamos@` son idénticas y
> tienen 14 caracteres en lugar de 16: un error al copiarlas. No se usan —basta
> una conexión—, pero si algún día cada formulario ha de salir desde su propio
> buzón, habrá que regenerarlas.

### Sobre el remitente

Los cuatro formularios salen desde `contacto@forestalleon.cl`, porque es la
cuenta que autentica el envío, pero **cada uno sigue llegando a su destino**.
Como la notificación pone la dirección del visitante en «responder a», al
pulsar Responder se contesta directamente a quien escribió.

Si algún día se quiere que cada formulario salga desde su propia dirección, son
cuatro conexiones en FluentSMTP con cuatro contraseñas de aplicación.

> Si el volumen crece o hay un administrador de Workspace de por medio, la vía
> ordenada es la **retransmisión SMTP** de Google: se configura una vez para
> toda la organización y no reparte contraseñas por usuario.

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
| Contacto | Compra de productos | `[fluentform id="4"]` |
| Contacto | Construcción e ingeniería | `[fluentform id="5"]` |
| Contacto | Reclamos y MPD | `[fluentform id="6"]` |
| Contacto | Contacto general | `[fluentform id="7"]` |
| Ficha de proyecto | Las cuatro vías | `4`, `5`, `6` y `7` |

**Los identificadores son del 4 al 7, confirmados el 30 de agosto de 2026.**
Los números 1 y 2 eran de los dos formularios de ejemplo que instala el propio
plugin, y el 3 quedó ocupado al reimportar uno de ellos. Fluent Forms no
reutiliza identificadores borrados, así que si algún día se rehace un
formulario habrá que actualizar su shortcode en `elementor/contacto.json` y en
`forestal-leon/patterns/formularios-ficha-proyecto.php`.

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
