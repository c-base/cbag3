import {put, takeEvery} from 'redux-saga/effects'
import {initArtefactCollection, initArtefactCollectionDone} from './actions'

function* fetchArtefacts() {
  const json = yield fetch('/api/artefacts')
    .then(response => response.json());
  yield put(initArtefactCollection(json.artefacts));
  yield put(initArtefactCollectionDone())
}

/*
  Watcher
*/
export default function* artefactSagas() {
  yield takeEvery("APP_INIT", fetchArtefacts)
}