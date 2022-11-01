import { combineReducers } from 'redux'

import artefactReducer from './Artefact/reducer'

export default combineReducers({
  artefact: artefactReducer
})