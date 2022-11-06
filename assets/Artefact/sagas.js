import { put, takeEvery, select } from 'redux-saga/effects'
import { initArtefactCollection, initArtefactCollectionDone, updateArtefactDone } from './actions'
import { getResourceById } from './../App/selectors'

function* fetchArtefacts() {
  const api = yield select(getResourceById, 'api_artefact_collection')
  const json = yield fetch(api.path)
    .then(response => response.json());
  yield put(initArtefactCollection(json.artefacts));
  yield put(initArtefactCollectionDone())
}

function* updateArtefact(action) {
  const api = yield select(getResourceById, 'api_artefact_update')
  const path = api.path.replace('{slug}', action.payload.id);
  const json = yield fetch(path, {
    method: api.method,
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(action.payload)
  })
    .then(response => response.json());
  yield put(updateArtefactDone(json))
}

/*
  Watcher
*/
export default function* artefactSagas() {
  yield takeEvery("APP_INIT_DONE", fetchArtefacts)
  yield takeEvery("ARTEFACT_UPDATE", updateArtefact)
}