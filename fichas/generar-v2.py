# Rehace el contenido de las cuatro fichas de proyecto con la estructura que
# quedó validada en la del galpón: carrusel, datos, texto y collage.
# Las galerías de FooGallery son las del galpón como relleno provisional.
import io, os, importlib.util

CARRUSEL = 6817
COLLAGE = 6793
SALIDA = "F:/forestal-leon/fichas"

# Reutiliza datos y textos de la primera versión, que ya estaban revisados.
spec = importlib.util.spec_from_file_location("v1", "F:/forestal-leon/fichas/generar.py")


def cargar_fichas():
    fuente = io.open("F:/forestal-leon/fichas/generar.py", encoding="utf-8").read()
    fuente = fuente.split("os.makedirs(SALIDA")[0]      # solo las definiciones
    ns = {}
    exec(fuente, ns)
    return ns["FICHAS"], ns["datos"], ns["parrafos"]


FICHAS, datos, parrafos = cargar_fichas()


def galeria(numero, nombre):
    return ('<!-- wp:shortcode {"metadata":{"name":"' + nombre + '"}} -->\n'
            '[foogallery id="' + str(numero) + '"]\n'
            '<!-- /wp:shortcode -->')


for f in FICHAS:
    partes = [galeria(CARRUSEL, "Carrusel"), datos(f["datos"])]
    if f["complementario"]:
        partes.append(parrafos(f["complementario"]))
    partes.append(galeria(COLLAGE, "Collage"))
    cuerpo = "\n\n".join(partes) + "\n"

    nombre = "{}-{}".format(f["orden"], f["slug"])
    io.open(os.path.join(SALIDA, nombre + ".html"), "w",
            encoding="utf-8", newline="\n").write(cuerpo)
    print("{:40} carrusel {} · {} datos · texto {} · collage {}".format(
        nombre, CARRUSEL, len(f["datos"]),
        "sí" if f["complementario"] else "no", COLLAGE))
