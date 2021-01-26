import json
import logging

from django.contrib.auth import authenticate, login, logout
from django.db.models.functions import Lower
from django.http import HttpResponse, JsonResponse
from django.middleware.csrf import get_token
from django.shortcuts import get_object_or_404, render
from django.utils.decorators import method_decorator
from django.views import View
from django.views.decorators.csrf import csrf_exempt
from rest_framework import viewsets
from rest_framework.response import Response
from braces.views import CsrfExemptMixin

from cbag3.models import Artefact, Asset
from cbag3.serializers import ArtefactSerializer, AssetSerializer

# from cbag3.serializers import UserSerializer


logger = logging.getLogger(__name__)


class HomeView(View):
    template_name = 'home.html'

    def get(self, request):
        context = {
            'state': json.dumps({
                'config': {
                    'urls': {
                        'login': {'path': '/api-auth/login', 'method': 'POST'},
                        'logout': {'path': '/api-auth/logout', 'method': 'POST'},
                        'artefact-create': {'path': '/api/artefacts/', 'method': 'POST'},
                        'asset-create': {'path': '/api/assets/', 'method': 'POST'},
                    }
                },
                'csrfToken': get_token(request),
                'user': {
                    'username': request.user.username if request.user.is_authenticated else None,
                    'isAuthenticated': request.user.is_authenticated,
                },
                'artefacts': [artefact.as_dict() for artefact in Artefact.objects.all().order_by(Lower('name'))],
            })
        }
        return render(request, self.template_name, context)


@method_decorator(csrf_exempt, name='dispatch')
class LoginView(View):

    def post(self, request, *args, **kwargs):
        logging.error(f"request: {request.POST.get('username')}")
        logging.error(f"args: {args}")
        logging.error(f"kwargs: {kwargs}")
        user = authenticate(username=request.POST.get('username'), password=request.POST.get('password'))
        logging.error(user)
        if user is not None:
            login(request, user)
            return JsonResponse({'isAuthenticated': True, 'username': user.username})
        return JsonResponse({'isAuthenticated': False, 'username': None}, status=401)


@method_decorator(csrf_exempt, name='dispatch')
class LogoutView(View):

    def post(self, request, *args, **kwargs):
        logout(request)
        return JsonResponse({'isAuthenticated': False, 'username': None}, status=200)


@method_decorator(csrf_exempt, name='dispatch')
class ArtefactViewSet(CsrfExemptMixin, viewsets.ViewSet):
    """
    A simple ViewSet for artefacts.
    """
    def list(self, request):
        queryset = Artefact.objects.all()
        serializer = ArtefactSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Artefact.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = ArtefactSerializer(user)
        return Response(serializer.data)


@method_decorator(csrf_exempt, name='dispatch')
class AssetViewSet(CsrfExemptMixin, viewsets.ViewSet):
    """
    A simple ViewSet for assets.
    """
    def list(self, request):
        queryset = Asset.objects.all()
        serializer = AssetSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Asset.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = AssetSerializer(user)
        return Response(serializer.data)

    def create(self, request):
        logger.error(request)
        return Response()

    def update(self, request, pk=None):
        logger.error(request)
        return Response()
