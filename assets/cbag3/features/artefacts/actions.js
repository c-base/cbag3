export const initArtefacts = (artefacts) => ({
  type: 'ARTEFACTS_INIT',
  payload: {
    artefacts
  }
})

export const initArtefactsDone = () => ({
  type: 'ARTEFACTS_INIT_DONE'
})

export const requestArtefactCreate = (artefact) => ({
  type: 'ARTEFACT_REQUST_CREATE',
  payload: {
    artefact
  }
})

export const requestArtefactUpdate = (artefact) => ({
  type: 'ARTEFACT_REQUST_UPDATE',
  payload: {
    artefact
  }
})

export const requestArtefactAssetCreate = (asset) => ({
  type: 'ARTEFACT_ASSET_REQUEST_CREATE',
  payload: {
    asset
  }
})

export const successfulAssetCreate = () => ({
  type: 'ARTEFACT_ASSET_CREATE_SUCCESS',
  payload: {
    //@TODO: add new asset payload here
  }
})

export const failedAssetCreate = (error) => ({
  type: 'ARTEFACT_ASSET_CREATE_FAILED',
  payload: { error }
})


export const requestArtefactAssetUpdate = (asset) => ({
  type: 'ARTEFACT_ASSET_REQUEST_UPDATE',
  payload: {
    asset
  }
})

export const successfulAssetUpdate = () => ({
  type: 'ARTEFACT_ASSET_UPDATE_SUCCESS',
})

export const failedAssetUpdate = (error) => ({
  type: 'ARTEFACT_ASSET_UPDATE_FAILED',
  payload: { error }
})