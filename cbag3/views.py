import json

from django.shortcuts import render
from django.views import View
from django.middleware.csrf import get_token

from cbag3.models import Artefact


class Home(View):
    template_name = 'home.html'

    def get(self, request):
        is_authenticated = False
        username = None
        if request.user.is_authenticated():
            is_authenticated = True
            username = request.user.username
        context = {
            'state': json.dumps({
                'config': {},
                'csrfToken': get_token(request),
                'user': {
                    'username': username,
                    'isAuthenticated': is_authenticated,
                },
                'artefacts': [artefact.as_dict() for artefact in Artefact.objects.all()],
            })
        }
        return render(request, self.template_name, context)
