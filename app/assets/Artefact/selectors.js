export const getLastCreated = (state, num = 3) => state.artefact.allIds
  .slice(num * -1)
  .map((id => state.artefact.byId[id]))

export const getAllArtefacts = (state) => state.artefact.allIds.sort().map((id => state.artefact.byId[id]))

export const getArtefact = (state, id) => state.artefact.byId.hasOwnProperty(id) ? state.artefact.byId[id] : null
export const getSelectedArtefactId = (state) => state.artefact.selected
export const getSelectedArtefact = (state) => state.artefact.byId.hasOwnProperty(state.artefact.selected) ? state.artefact.byId[state.artefact.selected] : null
export const getSelectedArtefactImageIds = function(state) {
  const artefact = getSelectedArtefact(state)
  return  (artefact !== null) ? artefact.images.map(image => image.id) : []
}
