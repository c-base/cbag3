export const getLastCreated = (state, num = 3) => state.artefact.allIds
  .slice(num * -1)
  .map((id => state.artefact.byId[id]))

export const getAllArtefacts = (state) => state.artefact.allIds.sort().map((id => state.artefact.byId[id]))

export const getArtefact = (state, id) => state.artefact.byId.hasOwnProperty(id) ? state.artefact.byId[id] : null
export const getSelectedArtefact = (state) => state.artefact.selected
