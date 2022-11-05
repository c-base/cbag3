export const initialState = {
  authenticated: false,
  username: null
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case 'AUTH_INIT_STATE':
      return {
        ...state,
        ...action.payload.auth
      }
    default:
      return state
  }
}


export default reducer