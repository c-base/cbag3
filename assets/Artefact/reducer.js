export const initialState = {
    isLoaded: false,
    byId: {},
    allIds: [],
    lastUpdated: null,
    selected: null,
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
        case 'ARTEFACT_SELECT_DETAIL':
            return {
                ...state,
                selected: action.payload.id,
            }
        case 'ARTEFACT_UPDATE_PRIMARY_IMAGE':
            const id = action.payload.id
            return {
                ...state,
                byId: {
                    ...state.byId,
                    [id]: {
                        ...state.byId[id],
                        ...{primaryImage: action.payload.imageId}
                    }
                }
            }
        default:
            return state
    }
}


export default reducer