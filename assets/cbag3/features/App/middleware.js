const createAppMiddleware = () => ({ dispatch }) => {
  return next => (action) => {
    if (action.type == 'MQTT_CONNECTED') {
      dispatch({type: 'APP_START'})
    }
    next(action)
  };
};

export default createAppMiddleware;