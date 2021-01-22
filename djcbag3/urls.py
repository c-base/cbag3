"""djcbag3 URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.conf import settings
from django.conf.urls.static import static
from django.contrib import admin
from django.contrib.auth import views as auth_views
from django.urls import include, path, re_path
# from rest_framework.authtoken import views as drfviews
from rest_framework.routers import DefaultRouter

from cbag3.views import ArtefactViewSet, AssetViewSet, HomeView, LoginView, LogoutView

router = DefaultRouter()
router.register(r'artefacts', ArtefactViewSet, basename='api/artefacts')
router.register(r'assets', AssetViewSet, basename='api/assets')

urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/', include(router.urls)),
    re_path(r'^api-auth/login', LoginView.as_view(), name='login'),
    re_path(r'^api-auth/logout', LogoutView.as_view(), name='logout'),
    # re_path(r'^api-token-auth', drfviews.obtain_auth_token, name='api-token-auth'),
    # re_path(r'^api-auth/', include('rest_framework.urls', namespace='rest_framework')),
    # re_path(r'^api/', include(endpoints)),
    # re_path(r'^api/auth/', include('knox.urls')),
    re_path(r'^login/{0,1}', auth_views.LoginView.as_view(template_name='login.html'), name='login'),
    re_path(r'^logout/{0,1}', auth_views.LogoutView.as_view(template_name='logout.html'), name='logout'),
]  # + router.urls

if settings.DEBUG:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)

# catch all other URLs and direct them to home
urlpatterns.append(re_path(r'.*/{0,1}', HomeView.as_view(), name='home'))
