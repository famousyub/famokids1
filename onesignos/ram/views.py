from django.shortcuts import render,redirect
from .models import project,certificate

import  requests

def display(request,username):
    p = project.objects.all()
    c = certificate.objects.all()

    #request.GET['login']
    return render(request,'portfolio.html',{'username':username})





def   getprofile(request):
    pass


    #profiles    =requests
