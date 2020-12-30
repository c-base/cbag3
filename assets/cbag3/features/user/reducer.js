
export const initialState = {
  isAuthenticated: false,
  loginUrl: '/login',
  logoutUrl: '/logout'
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
      case 'USER_INIT':
        return {...state, ...action.payload.user}
      case 'USER_AUTHENTICATION_REQUEST_SUCCESS':
        return {...state, ...action.payload.user}
      case 'USER_AUTHENTICATION_REQUEST_FAILURE':
      default:
          return state
  }
}


export default reducer