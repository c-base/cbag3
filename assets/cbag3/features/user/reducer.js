
export const initialState = {
  isAuthenticated: false,
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case 'USER_INIT':
      return { ...state, ...action.payload.user }
    case 'USER_AUTHENTICATION_REQUEST_SUCCESS':
      return { ...state, ...action.payload.user }
    case 'USER_AUTHENTICATION_REQUEST_FAILURE':
      return state
    case 'USER_LOGOUT_SUCCESS':
      return { ...initialState }
    default:
      return state
  }
}


export default reducer