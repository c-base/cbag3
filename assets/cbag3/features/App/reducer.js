
export const initialState = {
  csrfToken: null
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
      case 'APP_START':
          return {...state, csrfToken: action.payload.csrfToken}
      default:
          return state
  }
}


export default reducer