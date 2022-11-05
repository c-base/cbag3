export const isAuthenticated = (state) => state.auth.isAuthenticated

export const getAuthPath = (state) => state.app.resources['api_auth_cbase'].path