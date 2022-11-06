import { put, takeEvery, select } from 'redux-saga/effects'
import { initGallery, initGalleryDone } from './actions'

function* loadGallery(action) {
  yield put(initGallery(action.payload.artefacts));
  yield put(initGalleryDone())
}

export default function* gallerySagas() {
  yield takeEvery("ARTEFACT_INIT_COLLECTION", loadGallery)
}