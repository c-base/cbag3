import uuid
from django.db import models


class Artefact(models.Model):
    uuid = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    name = models.CharField(max_length=255, unique=True, null=True)
    slug = models.CharField(max_length=255, unique=True)
    description = models.TextField(null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    created_by = models.CharField(max_length=255, null=True)
    # assets = models.ManyToManyField(Asset, blank=True)

    def as_dict(self):
        return {
            'uuid': str(self.uuid),
            'name': self.name,
            'slug': self.slug,
            'description': self.description,
            'created_at': str(self.created_at),
            'created_by': self.created_by,
        }

class Asset(models.Model):
    uuid = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    title = models.CharField(max_length=255, unique=True, null=True)
    author = models.CharField(max_length=255, null=True)
    licence = models.CharField(max_length=255, null=True)
    description = models.TextField(null=True)
    file = models.FileField(upload_to='artefacts/', null=True)
    artefact = models.ForeignKey(Artefact, on_delete=models.CASCADE, related_name='artefact', null=True)
