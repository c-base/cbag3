export const isAuthenticated = (state) => state.auth.authenticated
export const getUsername = (state) => state.auth.username

export const getAuthPath = (state) => state.app.resources['api_auth_cbase'].path