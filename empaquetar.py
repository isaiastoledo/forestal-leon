"""Regenera forestal-leon.zip listo para subir a WordPress.

Uso:  python empaquetar.py

Genera el ZIP con separadores "/" en las rutas internas. Es importante:
Compress-Archive de Windows los escribe con "\\" y WordPress, sobre un servidor
Linux, no reconoce entonces la carpeta del tema y falla con
"No se han encontrado temas".
"""

import pathlib
import zipfile

BASE = pathlib.Path(__file__).resolve().parent
TEMA = BASE / 'forestal-leon'
ZIP = BASE / 'forestal-leon.zip'
BACKSLASH = chr(92)

EXCLUIR = {'.DS_Store', 'Thumbs.db', 'desktop.ini'}
EXCLUIR_DIRS = {'.git', 'node_modules', '__pycache__'}

OBLIGATORIOS = (
    'forestal-leon/style.css',
    'forestal-leon/theme.json',
    'forestal-leon/functions.php',
    'forestal-leon/templates/index.html',
    'forestal-leon/templates/front-page.html',
    'forestal-leon/parts/header.html',
    'forestal-leon/assets/images/logo-forestal-leon.png',
)


def empaquetar():
    if ZIP.exists():
        ZIP.unlink()

    with zipfile.ZipFile(ZIP, 'w', zipfile.ZIP_DEFLATED, compresslevel=9) as z:
        for p in sorted(TEMA.rglob('*')):
            if not p.is_file() or p.name in EXCLUIR:
                continue
            if EXCLUIR_DIRS & set(p.relative_to(BASE).parts):
                continue
            z.write(p, p.relative_to(BASE).as_posix())


def verificar():
    with zipfile.ZipFile(ZIP) as z:
        nombres = z.namelist()
        assert nombres, 'el ZIP esta vacio'
        assert all(BACKSLASH not in n for n in nombres), 'separadores incorrectos'
        assert all(n.startswith('forestal-leon/') for n in nombres), 'falta la carpeta raiz'
        for obligatorio in OBLIGATORIOS:
            assert obligatorio in nombres, 'falta ' + obligatorio
        assert z.testzip() is None, 'ZIP corrupto'
        return nombres


if __name__ == '__main__':
    empaquetar()
    nombres = verificar()
    print('forestal-leon.zip -> %.1f KB, %d archivos, verificado'
          % (ZIP.stat().st_size / 1024, len(nombres)))
    for n in nombres:
        print('  ' + n)
