import { put, takeEvery, select } from 'redux-saga/effects'
import { initArtefactCollection, initArtefactCollectionDone, updateArtefactDone, updateArtefactFailed } from './actions'
import { getResourceById } from '../App/selectors'
import { authenticationRequired } from "../Authentication/actions";

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
  try {
    const response = yield fetch(path, {
      method: api.method,
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(action.payload)
    })
      .then(response => response)

    if (response.status >= 200 && response.status < 300) {
      const artefact = yield response.json();
      yield put(updateArtefactDone(artefact))
    } else if(response.status === 401) {
      yield put(authenticationRequired())
    } else {
      throw response;
    }
  }
  catch(error) {
    yield put(updateArtefactFailed(error))
  }
}

/*
  Watcher
*/
export default function* artefactSagas() {
  yield takeEvery("APP_INIT_DONE", fetchArtefacts)
  yield takeEvery("ARTEFACT_UPDATE", updateArtefact)
}