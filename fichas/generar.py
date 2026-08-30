# Genera el marcado de bloques de las cuatro fichas de proyecto que faltan,
# a partir de los documentos que entregó el cliente el 29 de agosto de 2026.
import io, os

SALIDA = "F:/forestal-leon/fichas"


def datos(pares):
    filas = []
    for etiqueta, valor in pares:
        filas.append(
            "<!-- wp:paragraph -->\n"
            "<p><strong>{}</strong> {}</p>\n"
            "<!-- /wp:paragraph -->".format(etiqueta, valor))
    return (
        '<!-- wp:group {"metadata":{"name":"Datos del proyecto"},'
        '"className":"is-style-filete-verde",'
        '"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},'
        '"layout":{"type":"constrained"}} -->\n'
        '<div class="wp-block-group is-style-filete-verde">'
        '<!-- wp:heading {"level":2,"fontSize":"heading-s"} -->\n'
        '<h2 class="wp-block-heading has-heading-s-font-size">Datos del proyecto</h2>\n'
        '<!-- /wp:heading -->\n\n' + "\n\n".join(filas) + "</div>\n"
        '<!-- /wp:group -->')


def carrusel(nota):
    return (
        '<!-- wp:group {"metadata":{"name":"Carrusel — pendiente plugin"},'
        '"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},'
        '"layout":{"type":"constrained"}} -->\n'
        '<div class="wp-block-group">'
        '<!-- wp:paragraph {"className":"is-style-antetitulo","align":"center","fontSize":"x-small"} -->\n'
        '<p class="is-style-antetitulo has-text-align-center has-x-small-font-size">' + nota + '</p>\n'
        '<!-- /wp:paragraph -->\n\n'
        '<!-- wp:gallery {"columns":1,"linkTo":"none"} -->\n'
        '<figure class="wp-block-gallery has-nested-images columns-1 is-cropped"></figure>\n'
        '<!-- /wp:gallery --></div>\n'
        '<!-- /wp:group -->')


def tres_fotos():
    return (
        '<!-- wp:group {"metadata":{"name":"Tres fotos — pendiente"},'
        '"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},'
        '"layout":{"type":"constrained"}} -->\n'
        '<div class="wp-block-group alignwide">'
        '<!-- wp:paragraph {"className":"is-style-antetitulo","fontSize":"x-small"} -->\n'
        '<p class="is-style-antetitulo has-x-small-font-size">Tres fotos a ancho completo — pendientes</p>\n'
        '<!-- /wp:paragraph -->\n\n'
        '<!-- wp:gallery {"columns":3,"linkTo":"none"} -->\n'
        '<figure class="wp-block-gallery has-nested-images columns-3 is-cropped"></figure>\n'
        '<!-- /wp:gallery --></div>\n'
        '<!-- /wp:group -->')


def parrafos(texto):
    trozos = [t.strip() for t in texto.split("\n") if t.strip()]
    return "\n\n".join(
        "<!-- wp:paragraph -->\n<p>{}</p>\n<!-- /wp:paragraph -->".format(t) for t in trozos)


def collage(nota):
    return (
        '<!-- wp:group {"metadata":{"name":"Collage final"},"align":"full",'
        '"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},'
        '"layout":{"type":"constrained"}} -->\n'
        '<div class="wp-block-group alignfull">'
        '<!-- wp:paragraph {"className":"is-style-antetitulo","fontSize":"x-small"} -->\n'
        '<p class="is-style-antetitulo has-x-small-font-size">' + nota + '</p>\n'
        '<!-- /wp:paragraph -->\n\n'
        '<!-- wp:gallery {"columns":4,"linkTo":"none"} -->\n'
        '<figure class="wp-block-gallery has-nested-images columns-4 is-cropped"></figure>\n'
        '<!-- /wp:gallery --></div>\n'
        '<!-- /wp:group -->')


FICHAS = [
    dict(
        orden=2, slug="pasarelas-cercos-bucalemu",
        titulo="Pasarelas y Cercos, Bucalemu, Chile",
        tipo="turismo",
        datos=[("Proyecto", "Pasarelas y Cercos"),
               ("Localidad", "Bucalemu, Chile — sector costero"),
               ("Cliente", "Privado"),
               ("Fecha", "Noviembre 2025"),
               ("Alcance", "Suministro de materiales"),
               ("Volumen", "19 m³"),
               ("Material", "Madera laminada CNC y conectores de acero FL")],
        intro=("Forestal León suministró piezas de madera laminada diseñadas y cortadas íntegramente "
               "en CNC para la construcción de pasarelas y cercos en Bucalemu, Chile, un proyecto "
               "desarrollado para un cliente privado en un sector costero, a orillas del mar. A "
               "diferencia de nuestros proyectos de diseño y ejecución integral, en este caso nuestro "
               "rol se centró en la fabricación y entrega de las piezas: 19 m³ de madera laminada, "
               "trabajadas a medida en nuestra planta de Coelemu en noviembre de 2025 y despachadas "
               "listas para su instalación directa en obra."),
        complementario=("La ubicación costera del proyecto fue un factor determinante en la elección "
                        "del material. El ambiente salino propio del borde mar resulta especialmente "
                        "agresivo para estructuras metálicas, acelerando procesos de corrosión que "
                        "comprometen la vida útil del acero con el paso del tiempo. La madera laminada "
                        "se planteó como la alternativa técnica adecuada para cubrir la amplia "
                        "superficie de pasarelas requerida por el cliente, ofreciendo una resistencia "
                        "estable frente a la humedad y salinidad constantes del entorno, sin los "
                        "riesgos de oxidación asociados a otros materiales.\n"
                        "Cada pieza, tanto de las pasarelas como de los cercos, quedó preparada y "
                        "numerada en planta pensando en el montaje final, de modo que en destino el "
                        "proceso se redujo únicamente a enterrar los postes, ensamblar los paños de "
                        "cerco e instalar los tramos de pasarela. Esto permitió avanzar con rapidez "
                        "pese a tratarse de un proyecto de superficie extensa, sin necesidad de "
                        "ajustes, cortes ni trabajos adicionales en terreno."),
        con_tres_fotos=True),
    dict(
        orden=3, slug="oficinas-generales-forestal-leon",
        titulo="Oficinas Generales Forestal León, Coelemu, Chile",
        tipo="edificios",
        datos=[("Proyecto", "Oficinas Generales Forestal León"),
               ("Localidad", "Coelemu"),
               ("Fecha de inicio", "Enero 2022"),
               ("Fecha de término", "Diciembre 2022"),
               ("Arquitectura", "Jaime Opazo"),
               ("Ejecución", "Forestal León"),
               ("Superficie", "952 m²"),
               ("Volumen", "174 m³")],
        intro="",
        complementario="",
        con_tres_fotos=True),
    dict(
        orden=4, slug="casa-mirador-punta-pite",
        titulo="Casa Mirador Punta Pite, Papudo, Chile",
        tipo="viviendas",
        datos=[("Proyecto", "Casa Mirador Punta Pite"),
               ("Localidad", "Papudo — sector costero, Punta Pite"),
               ("Arquitectura", "Carlos Mardones"),
               ("Fecha de inicio", "Junio 2026"),
               ("Fecha de término", "Pendiente"),
               ("Estado", "En proceso de construcción"),
               ("Tipo de intervención", "Ampliación de vivienda existente"),
               ("Superficie", "255 m²"),
               ("Volumen", "35 m³"),
               ("Material", "Vigas y pilares Glulam, madera laminada trabajada en corte CNC")],
        intro=("La Casa Mirador Punta Pite es un proyecto de ampliación para una vivienda existente "
               "en Papudo, a orillas de la playa, diseñado por el arquitecto Carlos Mardones. "
               "Actualmente en proceso de construcción, la extensión se resuelve con vigas y pilares "
               "Glulam junto con piezas de madera laminada trabajadas en corte CNC, fabricadas por "
               "Forestal León."),
        complementario=("La madera laminada con prefabricación CNC facilita enormemente la "
                        "construcción sobre viviendas o edificios existentes. Al tener cada pieza "
                        "preparada de antemano, la obra en terreno consiste únicamente en el montaje "
                        "de la estructura, lo que reduce considerablemente los tiempos de ejecución y "
                        "genera mucha menos disrupción sobre el edificio y su entorno, incluso cuando "
                        "la construcción original se sigue utilizando durante el proceso.\n"
                        "A esto se suma el menor peso propio de la madera frente a otros materiales, "
                        "lo que reduce la carga adicional sobre la estructura existente y simplifica "
                        "los requerimientos de refuerzo. Con 35 m³ de madera trabajados en nuestra "
                        "planta de Coelemu, este proyecto confirma la versatilidad de nuestro sistema "
                        "constructivo para intervenir y ampliar edificaciones ya construidas sin "
                        "comprometer su estabilidad."),
        con_tres_fotos=True),
    dict(
        orden=5, slug="oficinas-vivero-forestal-leon",
        titulo="Oficinas Vivero Forestal León, Coelemu, Chile",
        tipo="edificios",
        datos=[("Proyecto", "Oficinas Vivero Forestal León"),
               ("Localidad", "Coelemu"),
               ("Cliente", "Grupo León"),
               ("Fecha de inicio", "Febrero 2024"),
               ("Fecha de término", "Diciembre 2024"),
               ("Duración de ejecución", "10 meses"),
               ("Arquitectura", "Jaime Opazo"),
               ("Cálculo estructural", "Pendiente"),
               ("Ejecución", "Forestal León"),
               ("Superficie", "370 m²"),
               ("Volumen", "85 m³"),
               ("Material", "Vigas y pilares Glulam, madera laminada trabajada con CNC, conectores de acero"),
               ("Fabricación", "Planta Coelemu, piezas prefabricadas y trasladadas listas para montaje")],
        intro=("Las Oficinas Vivero Forestal León son el centro logístico de nuestro vivero forestal, "
               "un edificio de 370 m² que aloja comedor, vestidores y oficinas administrativas para "
               "uso interno del Grupo León. Levantado en Coelemu entre febrero y diciembre de 2024, "
               "fue diseñado por el arquitecto Jaime Opazo y ejecutado íntegramente por Forestal León. "
               "Su estructura se resolvió con madera laminada y conectores de acero, combinando vigas "
               "y pilares Glulam con piezas trabajadas mediante corte CNC, todas fabricadas en nuestra "
               "propia planta de Coelemu y trasladadas ya listas para su montaje. La estructura queda "
               "completamente a la vista en el interior, generando un ambiente de trabajo cálido y "
               "coherente con la identidad del vivero."),
        complementario="",
        con_tres_fotos=False),   # indicación expresa del cliente en su documento
]

os.makedirs(SALIDA, exist_ok=True)
indice = []

for f in FICHAS:
    partes = [carrusel("Carrusel de imágenes — pendiente de fotos y del plugin de carrusel"),
              datos(f["datos"])]
    if f["con_tres_fotos"]:
        partes.append(tres_fotos())
    if f["complementario"]:
        partes.append(parrafos(f["complementario"]))
    else:
        partes.append(
            "<!-- wp:paragraph -->\n<p><em>Texto complementario pendiente.</em></p>\n"
            "<!-- /wp:paragraph -->" if f["orden"] == 3 else "")
    partes.append(collage("Collage final — pendiente de fotos"))
    cuerpo = "\n\n".join(p for p in partes if p)

    nombre = "{}-{}".format(f["orden"], f["slug"])
    ruta = os.path.join(SALIDA, nombre + ".html")
    io.open(ruta, "w", encoding="utf-8", newline="\n").write(cuerpo)

    intro = f["intro"] or "PENDIENTE — falta el texto introductorio de esta obra."
    ruta_x = os.path.join(SALIDA, nombre + ".extracto.txt")
    io.open(ruta_x, "w", encoding="utf-8", newline="\n").write(intro)

    indice.append((f["orden"], f["titulo"], f["slug"], f["tipo"],
                   len(f["datos"]), bool(f["intro"]), bool(f["complementario"]),
                   f["con_tres_fotos"]))
    print("{:38} {} datos | intro:{} | compl:{} | 3fotos:{}".format(
        nombre, len(f["datos"]), "sí" if f["intro"] else "NO",
        "sí" if f["complementario"] else "no", "sí" if f["con_tres_fotos"] else "no"))
