# cbrp3: artefact guide 

The artefact guide is a project of the 3rd reconstruction project. It shows a collection of artefacts of c-base e.V.

This version of the artefact guide brings 

* a Django api to serve all data and provide security layers and 
* a react (maybe redux) client to make it look nice for users

The storage layer moved to PostgreSQL.

And all this is wrapped up in docker. 

## Setup development environment

Run 

* `make build`
* `make install`
* `make ci`


## Deploy

Travis will do its thing. Not yet. tbd
