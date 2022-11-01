

export const initArtefactCollection = (artefacts) => ({
  type: 'ARTEFACT_INIT_COLLECTION',
  payload: {
    artefacts
  }
})
export const initArtefactCollectionDone = () => ({
  type: 'ARTEFACT_INIT_COLLECTION_DONE'
})

