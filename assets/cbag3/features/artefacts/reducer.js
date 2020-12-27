
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
    state.byId[artefact.slug] = artefact
    state.allIds = [...state.allIds, artefact.slug]
  })
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