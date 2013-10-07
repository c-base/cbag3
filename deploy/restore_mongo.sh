#!/bin/bash

#folder=$(date +%Y-%m-%d_%H-%M)
folder=$1
cd $folder

mongoimport --db cbag3_database --collection system.indexes --file cbag3_system.indexes.json
mongoimport --db cbag3_database --collection Artefact --file cbag3_artefact.json
mongoimport --db cbag3_database --collection Asset --file cbag3_asset.json
