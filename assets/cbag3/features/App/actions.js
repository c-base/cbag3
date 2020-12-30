export const startApp = (initialState) => ({
  type: 'APP_START',
  payload: {
    ...initialState
  }
})