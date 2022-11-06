export const initialState = {
    isLoaded: false,
    byId: {},
    allIds: [],
    lastUpdated: null,
    selected: null,
}

function init(artefacts) {
    let state = {
        byId: {},
        allIds: [],
        lastUpdated: Date.now()
    }

    artefacts.map(artefact => {
        artefact.images.map(image => {

            let imageArtefacts = []
            if (state.byId.hasOwnProperty(image.id)) {
                imageArtefacts = state.byId[image.id].artefacts
            }
            imageArtefacts = [...imageArtefacts, artefact.slug]

            state.byId[image.id] = { ...image, 'artefacts': imageArtefacts }
            state.allIds = [...state.allIds, image.id]
        })
    })
    return state
}

const reducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GALLERY_INIT':
            if (state.isLoaded) {
                return state
            }
            return init(action.payload.artefacts)
        case 'GALLERY_INIT_DONE':
            return {
                ...state,
                isLoaded: true
            }
        default:
            return state
    }
}

export default reducer