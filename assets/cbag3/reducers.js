import { combineReducers } from 'redux'

import artefactsReducer from './features/artefacts/reducer'

export default combineReducers({
  artefacts: artefactsReducer
})