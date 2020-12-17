from MyHTMLParser import MyHTMLParser
from urllib import urlopen

parser = MyHTMLParser()
parser.feed(urlopen("http://10.0.1.44/artefact/").read())
artefacts = parser.get_artefacts()
artefactlist = [{'name': key, 'slug': artefacts[key][10:]} for key in artefacts.keys()]
for artefact in artefactlist:
    print artefact['slug']+';'+artefact['name']

