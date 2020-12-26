import uuid
from django.db import models


class Artefact(models.Model):
    uuid = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    name = models.CharField(max_length=255)
    slug = models.CharField(max_length=255)
    description = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    created_by = models.CharField(max_length=255)
    # assets = models.ManyToManyField(Asset, blank=True)

    def as_dict(self):
        return {
            'uuid': self.uuid,
            'name': self.name,
            'slug': self.slug,
            'description': self.description,
            'created_at': self.created_at,
            'created_by': self.created_by,
        }

class Asset(models.Model):
    uuid = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    name = models.CharField(max_length=255)
    file = models.FileField(upload_to='artefacts/')
    artefact = models.ForeignKey(Artefact, on_delete=models.CASCADE, related_name='artefact')
