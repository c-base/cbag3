export const initialState = {
    isLoaded: false,
    byId: {},
    allIds: [],
    lastUpdated: null
}

function initArtefacts(artefacts) {
    let state = {
        byId: {},
        allIds: [],
        lastUpdated: Date.now()
    }

    artefacts.map(artefact => {
        state.byId[artefact.slug] = artefact
        state.allIds = [...state.allIds, artefact.slug]
    })
    return state
}

const reducer = (state = initialState, action) => {
    switch (action.type) {
        case 'ARTEFACT_INIT_COLLECTION':
            if (state.isLoaded) {
                return state
            }
            return initArtefacts(action.payload.artefacts)
        case 'ARTEFACT_INIT_COLLECTION_DONE':
            return {
                ...state,
                isLoaded: true
            }
        default:
            return state
    }
}


export default reducer