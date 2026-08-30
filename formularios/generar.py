# Genera los cuatro formularios de Forestal León en el formato de exportación
# de Fluent Forms 6.2.12, tomado del export real de «Contact Form Demo».
import json, io, os

MSG_REQ = 'Este campo es obligatorio'
REQ = {"required": {"value": True, "message": MSG_REQ}}
OPC = {"required": {"value": False, "message": MSG_REQ}}
CL = {"type": "any", "status": False, "conditions": [{"field": "", "value": "", "operator": ""}]}


def texto(name, label, ph, req=False):
    return {
        "index": 0, "element": "input_text",
        "attributes": {"type": "text", "name": name, "value": "", "class": "", "placeholder": ph},
        "settings": {"container_class": "", "label": label, "label_placement": "",
                     "admin_field_label": label, "help_message": "",
                     "validation_rules": json.loads(json.dumps(REQ if req else OPC)),
                     "conditional_logics": json.loads(json.dumps(CL))},
        "editor_options": {"title": "Simple Text", "icon_class": "ff-edit-text", "template": "inputText"},
        "uniqElKey": "el_fl_" + name,
    }


def correo():
    return {
        "index": 0, "element": "input_email",
        "attributes": {"type": "email", "name": "email", "value": "", "id": "", "class": "",
                       "placeholder": "tu@correo.cl"},
        "settings": {"container_class": "", "label": "Correo electrónico", "label_placement": "",
                     "help_message": "", "admin_field_label": "Correo",
                     "validation_rules": {
                         "required": {"value": True, "message": MSG_REQ},
                         "email": {"value": True, "message": "Escribe un correo electrónico válido"}},
                     "conditional_logics": []},
        "editor_options": {"title": "Email Address", "icon_class": "ff-edit-email", "template": "inputText"},
        "uniqElKey": "el_fl_email",
    }


def area(ph):
    return {
        "index": 0, "element": "textarea",
        "attributes": {"name": "mensaje", "value": "", "id": "", "class": "", "placeholder": ph,
                       "rows": 5, "cols": 2},
        "settings": {"container_class": "", "label": "Mensaje", "admin_field_label": "Mensaje",
                     "label_placement": "", "help_message": "",
                     "validation_rules": json.loads(json.dumps(REQ)),
                     "conditional_logics": json.loads(json.dumps(CL))},
        "editor_options": {"title": "Text Area", "icon_class": "ff-edit-textarea", "template": "inputTextarea"},
        "uniqElKey": "el_fl_mensaje",
    }


def lista(name, label, opciones, req=True):
    return {
        "index": 0, "element": "select",
        "attributes": {"name": name, "value": "", "id": "", "class": "",
                       "placeholder": "Selecciona una opción"},
        "settings": {"container_class": "", "label": label, "admin_field_label": label,
                     "label_placement": "", "help_message": "",
                     "validation_rules": json.loads(json.dumps(REQ if req else OPC)),
                     "conditional_logics": json.loads(json.dumps(CL)),
                     "placeholder": "Selecciona una opción", "enable_select_2": "no", "max_selection": "",
                     "advanced_options": [{"label": o, "value": o, "image": "", "calc_value": ""}
                                          for o in opciones]},
        "editor_options": {"title": "Dropdown", "icon_class": "ff-edit-dropdown", "template": "select"},
        "uniqElKey": "el_fl_" + name,
    }


def casilla(name, label, opcion):
    return {
        "index": 0, "element": "input_checkbox",
        "attributes": {"type": "checkbox", "name": name, "value": [], "class": ""},
        "settings": {"container_class": "", "label": label, "admin_field_label": label,
                     "label_placement": "", "help_message": "",
                     "validation_rules": json.loads(json.dumps(OPC)),
                     "conditional_logics": json.loads(json.dumps(CL)),
                     "advanced_options": [{"label": opcion, "value": "si", "image": "", "calc_value": ""}]},
        "editor_options": {"title": "Check Box", "icon_class": "ff-edit-checkbox",
                           "template": "inputCheckable"},
        "uniqElKey": "el_fl_" + name,
    }


BOTON = {
    "uniqElKey": "el_fl_submit", "element": "button",
    "attributes": {"type": "submit", "class": ""},
    "settings": {"align": "left", "button_style": "default", "container_class": "", "help_message": "",
                 "background_color": "#01735A", "button_size": "md", "color": "#ffffff",
                 "button_ui": {"type": "default", "text": "Enviar", "img_url": ""}},
    "editor_options": {"title": "Submit Button"},
}


def comunes():
    return [texto("nombre", "Nombre", "Tu nombre y apellido", req=True),
            correo(),
            texto("telefono", "Teléfono", "+56 9 1234 5678"),
            texto("empresa", "Empresa", "Nombre de tu empresa u organización")]


DEFS = [
    dict(titulo="Compra de productos", destino="ventas@forestalleon.cl",
         asunto="[Web] Cotización — {inputs.nombre}",
         extra=[lista("producto", "Producto de interés", ["Madera aserrada", "Plywood", "Laminado"]),
                texto("volumen", "Escuadría y volumen", "Ej: 2x4 pulgadas, 30 m³")],
         ph="Indícanos qué necesitas cotizar",
         msg="Gracias por tu solicitud. Te respondemos en menos de 48 horas hábiles."),
    dict(titulo="Construcción e ingeniería", destino="construcciones@forestalleon.cl",
         asunto="[Web] Proyecto — {inputs.nombre}",
         extra=[lista("tipo", "Tipo de proyecto",
                      ["Vivienda", "Edificio", "Turismo", "Industrial", "Otro"]),
                texto("ubicacion", "Ubicación de la obra", "Comuna y región"),
                lista("estado", "Estado del proyecto", ["Idea", "Anteproyecto", "Cálculo cerrado"])],
         ph="Cuéntanos en qué punto está tu proyecto",
         msg="Gracias. Nuestro equipo de proyectos te responde en menos de 48 horas hábiles."),
    dict(titulo="Reclamos y MPD", destino="reclamos@forestalleon.cl",
         asunto="[Web] Reclamo — {inputs.nombre}",
         extra=[lista("tipo_caso", "Tipo de caso", ["Reclamo", "Denuncia MPD"]),
                casilla("anonimo", "Confidencialidad", "Deseo mantener el anonimato")],
         ph="Describe lo ocurrido con el mayor detalle posible",
         msg="Hemos recibido tu caso. Te confirmamos la recepción en menos de 48 horas hábiles."),
    dict(titulo="Contacto general", destino="contacto@forestalleon.cl",
         asunto="[Web] Consulta — {inputs.nombre}",
         extra=[],
         ph="¿En qué podemos ayudarte?",
         msg="Gracias por escribirnos. Te respondemos en menos de 48 horas hábiles."),
]

CUERPO = (
    "<p><b>Nombre:</b> {inputs.nombre}</p>"
    "<p><b>Correo:</b> {inputs.email}</p>"
    "<p><b>Teléfono:</b> {inputs.telefono}</p>"
    "<p><b>Empresa:</b> {inputs.empresa}</p>"
    "<p><b>Mensaje:</b><br>{inputs.mensaje}</p>"
    "<hr>"
    "<p style='font-size:12px;color:#6B6B64'>Enviado desde el formulario «{form_name}» de forestalleon.cl</p>"
)

salida = []
for n, d in enumerate(DEFS, start=1):
    campos = comunes() + d["extra"] + [area(d["ph"])]
    for i, c in enumerate(campos):
        c["index"] = i
    noti = {
        "name": "Notificación al equipo",
        "sendTo": {"type": "email", "email": d["destino"], "field": "", "routing": []},
        "fromName": "Forestal León", "fromEmail": "", "replyTo": "{inputs.email}", "bcc": "",
        "subject": d["asunto"], "message": CUERPO,
        "conditionals": {"status": False, "type": "all",
                         "conditions": [{"field": "", "operator": "=", "value": ""}]},
        "enabled": True, "email_template": "", "asyncEmail": False,
    }
    ajustes = {
        "confirmation": {"redirectTo": "samePage", "messageToShow": d["msg"], "customPage": None,
                         "samePageFormBehavior": "hide_form", "customUrl": None},
        "restrictions": {
            "limitNumberOfEntries": {"enabled": False, "numberOfEntries": None, "period": "total",
                                     "limitReachedMsg": "Se alcanzó el número máximo de envíos."},
            "scheduleForm": {"enabled": False, "start": None, "end": None,
                             "selectedDays": ["Monday", "Tuesday", "Wednesday", "Thursday",
                                              "Friday", "Saturday", "Sunday"],
                             "pendingMsg": "El formulario aún no está disponible.",
                             "expiredMsg": "El formulario está cerrado."},
            "requireLogin": {"enabled": False, "requireLoginMsg": "Debes iniciar sesión para enviar."},
            "denyEmptySubmission": {"enabled": False,
                                    "message": "No se puede enviar un formulario vacío."}},
        "layout": {"labelPlacement": "top", "helpMessagePlacement": "with_label",
                   "errorMessagePlacement": "inline", "asteriskPlacement": "asterisk-right"},
        "delete_entry_on_submission": "no", "form_layout": "default",
    }
    salida.append({
        "id": n, "title": d["titulo"], "status": "published", "appearance_settings": None,
        "form_fields": {"fields": campos, "submitButton": json.loads(json.dumps(BOTON))},
        "has_payment": "0", "type": "", "conditions": None, "created_by": "1",
        "created_at": "2026-08-30 00:00:00", "updated_at": "2026-08-30 00:00:00",
        "form_meta": [],
        "metas": [
            {"id": 1, "form_id": str(n), "meta_key": "template_name", "value": "blank_form"},
            {"id": 2, "form_id": str(n), "meta_key": "formSettings",
             "value": json.dumps(ajustes, ensure_ascii=False)},
            {"id": 3, "form_id": str(n), "meta_key": "notifications",
             "value": json.dumps(noti, ensure_ascii=False)},
        ],
    })

destino = "F:/forestal-leon/formularios/formularios-forestal-leon.json"
os.makedirs(os.path.dirname(destino), exist_ok=True)
io.open(destino, "w", encoding="utf-8", newline="\n").write(
    json.dumps(salida, ensure_ascii=False, indent=1))

print("generado:", destino)
for f in salida:
    nombres = [c["attributes"]["name"] for c in f["form_fields"]["fields"]]
    print("  {:28} {} campos: {}".format(f["title"], len(nombres), ", ".join(nombres)))
