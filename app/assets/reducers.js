import { combineReducers } from 'redux'

import appReducer from './App/reducer'
import artefactReducer from './Artefact/reducer'
import authenticationReducer from './Authentication/reducer'
import galleryReducer from './Gallery/reducer'

export default combineReducers({
  app: appReducer,
  artefact: artefactReducer,
  auth: authenticationReducer,
  gallery: galleryReducer,
})