from django.db import models

# Create your models here.

class Artefact(models.Model):
    id = models.TextField()
    name = models.CharField(max_length=30)
    slug = models.CharField()
    description = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    created_by = models.CharField()
    # assets