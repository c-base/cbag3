from cbag3.models import Artefact, Asset
from rest_framework import serializers


class ArtefactSerializer(serializers.ModelSerializer):
    assets = serializers.PrimaryKeyRelatedField(many=True, queryset=Asset.objects.all())

    class Meta:
        model = Artefact
        fields = ['uuid', 'name', 'slug', 'description', 'created_at', 'created_by', 'assets']
