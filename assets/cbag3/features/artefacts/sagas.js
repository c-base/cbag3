import { put, takeEvery } from 'redux-saga/effects'
import { initArtefacts, initArtefactsDone } from './actions'

function* initializeArtefacts(action) {
  yield put(initArtefacts(window.state.artefacts))
  yield put(initArtefactsDone())
}

// use them in parallel
export default function* artefactsSagas() {
  yield takeEvery('APP_START', initializeArtefacts)
}