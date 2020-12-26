from cbag3.models import Artefact

from django.views import View
from django.shortcuts import render

# Create your views here.


# @method_decorator(login_required, name='dispatch')
class Home(View):
    template_name = 'home.html'

    def get(self, request):
        context = {
            'state': {
                'config': {},
                'artefacts': [artefact.as_dict() for artefact in Artefact.objects.all()]
            }
        }
        return render(request, self.template_name, context)