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

export const requestArtefactAssetUpload = (formData) => ({
  type: 'ARTEFACT_ASSET_REQUST_UPLOAD',
  payload: formData
})

export const successfulAssetUpload = () => ({
  type: 'ARTEFACT_ASSET_UPLOAD_SUCCESS',
})

export const failedAssetUpload = (error) => ({
  type: 'ARTEFACT_ASSET_UPLOAD_FAILED',
  payload: { error }
})