export const initUser = (user) => ({
  type: 'USER_INIT',
  payload: {...user}
})

export const initUserDone = () => ({
  type: 'USER_INIT_DONE'
})

export const requestAuthentication = (username, password) => ({
  type: 'USER_AUTHENTICATION_REQUEST',
  payload: {
    username, 
    password
  }
})

export const successfulAuthentication = (user) => ({
  type: 'USER_AUTHENTICATION_REQUEST_SUCCESS',
  payload: {
    user
  }
})

export const failedAuthentication = (reason) => ({
  type: 'USER_AUTHENTICATION_REQUEST_FAILURE',
  payload: {
    reason
  }
})