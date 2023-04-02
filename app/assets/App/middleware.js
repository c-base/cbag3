const createAppMiddleware = () => ({ dispatch }) => {
  return next => (action) => {

    next(action)
  };
};

export default createAppMiddleware;