
export const initialState = {
  byId: {},
  allIds: [],
}

function initAllArtefacts(artefacts) {
  let state = {
    byId: {},
    allIds: [],
  }
  artefacts.map(artefact => {
    state.byId[artefact.slug] = {
      ...artefact,
      hasImages: artefact.assets.length > 0
    }
    state.allIds = [...state.allIds, artefact.slug]
  })
  // sort ids alphabetical
  state.allIds.sort((a, b) => a.localeCompare(b))
  return {
    ...state,
    lastUpdated: new Date()
  }
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
      case 'ARTEFACTS_INIT':
          return initAllArtefacts(action.payload.artefacts)
      default:
          return state
  }
}


export default reducer