import { combineReducers } from 'redux'

import appReducer from './features/App/reducer'
import artefactsReducer from './features/artefacts/reducer'
import userReducer from './features/user/reducer'

export default combineReducers({
  app: appReducer,
  artefacts: artefactsReducer,
  user: userReducer,
})