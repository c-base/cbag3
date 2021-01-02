
export const initialState = {
  urls: {}
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
      case 'APP_START':
          return {...state, config: action.payload.config}
      default:
          return state
  }
}

export default reducer