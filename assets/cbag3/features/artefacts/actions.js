export const initArtefacts = (artefacts) => ({
  type: 'ARTEFACTS_INIT',
  payload: {
    artefacts
  }
})

export const initArtefactsDone = () => ({
  type: 'ARTEFACTS_INIT_DONE'
})

export const requestArtefactUpdate = (artefact) => ({
  type: 'ARTEFACT_REQUST_UPDATE',
  payload: {
    artefact
  }
})