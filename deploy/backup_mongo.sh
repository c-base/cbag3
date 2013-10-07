#!/bin/bash

folder=$(date +%Y-%m-%d_%H-%M)
mkdir $folder
cd $folder

mongoexport --db cbag3_database --collection system.indexes --out cbag3_system.indexes.json
mongoexport --db cbag3_database --collection Artefact --out cbag3_artefact.json
mongoexport --db cbag3_database --collection Asset --out cbag3_asset.json
