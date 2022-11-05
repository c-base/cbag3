
export const initAuthState = (auth) => ({
  type: 'AUTH_INIT_STATE',
  payload: {
    auth
  }
})
export const initAuthStateDone = () => ({
  type: 'AUTH_INIT_STATE_DONE'
})

