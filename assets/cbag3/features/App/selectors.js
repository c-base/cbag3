export const getConfig = state => state.app.config
export const getUrlConfig = (state, url) => getConfig(state).urls[url]