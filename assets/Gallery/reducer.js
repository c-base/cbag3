export const initialState = {
    isLoaded: false,
    byId: {},
    allIds: [],
    lastUpdated: null,
    selected: null,
    showUploadModal: false,
}

function init(images) {
    let state = {
        ...initialState,
        lastUpdated: Date.now()
    }

    images.map(image => {
        state.byId[image.id] = image
        state.allIds = [...state.allIds, image.id]
    })
    return state
}

const reducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GALLERY_INIT':
            if (state.isLoaded) {
                return state
            }
            return init(action.payload.images)
        case 'GALLERY_INIT_DONE':
            return {
                ...state,
                isLoaded: true
            }
        case 'GALLERY_IMAGE_UPLOAD_DONE':
            const id = action.payload.image.id
            return {
                ...state,
                byId: {
                    ...state.byId,
                    [id]: action.payload.image
                },
                allIds: [...state.allIds, id],
            }
        case 'GALLERY_IMAGE_UPLOAD_MODAL_SHOW':
            return {
                ...state,
                showUploadModal: true,
            }
        case 'GALLERY_IMAGE_UPLOAD_MODAL_CLOSE':
            return {
                ...state,
                showUploadModal: false,
            }
        default:
            return state
    }
}

export default reducer