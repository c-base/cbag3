import { combineReducers } from 'redux'

import artefactReducer from './artefact/reducer'

export default combineReducers({
  artefact: artefactReducer
})