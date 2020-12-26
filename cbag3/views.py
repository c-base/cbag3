import json

from django.shortcuts import render
from django.views import View

from cbag3.models import Artefact


class Home(View):
    template_name = 'home.html'

    def get(self, request):
        context = {
            'state': json.dumps({
                'config': {},
                'artefacts': [artefact.as_dict() for artefact in Artefact.objects.all()]
            })
        }
        return render(request, self.template_name, context)
