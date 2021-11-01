export const getLastCreated = (state, num = 3) => state.artefact.allIds
  .slice(num * -1)
  .map((id => state.artefact.byId[id]))