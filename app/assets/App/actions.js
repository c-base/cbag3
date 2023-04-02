export const initApp = () => ({
    type: 'APP_INIT'
})

export const initAppDone = () => ({
    type: 'APP_INIT_DONE'
})

export const initAppConfig = (config) => ({
    type: 'APP_INIT_CONFIG',
    payload: {
        ...config
    }
})