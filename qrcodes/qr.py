from PIL import Image
import qrcode
from qrcode.image.pure import PymagingImage
from jinja2 import Environment, FileSystemLoader
import os


logo = Image.open('logo.png', 'r')
logo_w, logo_h = logo.size

artefacts = open('artefacts', 'r')

artefact_list = []
#line = artefacts.readline()
for line in artefacts:
    qr = qrcode.QRCode(
        version=2,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=10,
        border=4,
    )
    cols = line.split(';') 
    artefact = {}
    artefact['slug'] = cols[0]
    artefact['name'] = cols[1]
    artefact_list.append(artefact)
    url = 'https://cbag3.c-base.org/artefact/' + cols[0]

    qr.add_data(url)
    qr.make(fit=True)

    img = qr.make_image()
    img_w, img_h = img.size
    offset = ((img_w - logo_w) / 2, (img_h - logo_h) / 2)
    img.paste(logo, offset)
    f = open('%s.png' % cols[0], 'w')
    img.save(f)
    f.close()



# Capture our current directory
THIS_DIR = os.path.dirname(os.path.abspath(__file__))

j2_env = Environment(loader=FileSystemLoader(THIS_DIR),
                         trim_blocks=True)
print j2_env.get_template('cbag3-qr.tex.jinja').render(
        artefacts=artefact_list
)
