export const initialState = {
  resources: null,
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case 'APP_INIT_CONFIG':
      return {
        ...state,
        resources: action.payload.resources
      }
    default:
      return state
  }
}


export default reducer