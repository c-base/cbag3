

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
  type: 'ARTEFACT_UPDATE',
  payload: {
    id,
    artefact: {
      primaryImage: imageId
    }
  }
})

export const updateArtefactFailed = (error) => ({
  type: 'ARTEFACT_UPDATE_FAILED',
  payload: {
    error
  }
})

export const updateArtefactDone = (artefact) => ({
  type: 'ARTEFACT_UPDATE_DONE',
  payload: {
    id: artefact.slug,
    artefact
  }
})

export const assignImageToArtefact = (id, images) => ({
  type: 'ARTEFACT_UPDATE',
  payload: {
    id,
    artefact: {
      images
    }
  }
})
