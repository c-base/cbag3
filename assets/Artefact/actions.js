

export const initArtefactCollection = (artefacts) => ({
  type: 'ARTEFACT_INIT_COLLECTION',
  payload: {
    artefacts
  }
})
export const initArtefactCollectionDone = () => ({
  type: 'ARTEFACT_INIT_COLLECTION_DONE'
})

export const selectArtefactDetail = (id) => ({
  type: 'ARTEFACT_SELECT_DETAIL',
  payload: {
    id
  }
})

export const updateArtefactPrimaryImage = (id, imageId) => ({
  type: 'ARTEFACT_UPDATE_PRIMARY_IMAGE',
  payload: {
    id,
    imageId
  }
})



