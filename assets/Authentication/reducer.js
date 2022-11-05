export const initialState = {
  isAuthenticated: false
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case 'AUTH_INIT_STATE':
      return {
        ...state,
        isAuthenticated: action.payload.auth !== null
      }
    default:
      return state
  }
}


export default reducer