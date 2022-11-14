import { put, takeEvery, select, call } from 'redux-saga/effects'
import {
  initGallery,
  initGalleryFail,
  initGalleryDone,
  uploadGalleryImage,
  uploadGalleryImageFail,
  uploadGalleryImageDone,
} from './actions'
import {getResourceById} from "../App/selectors";
import {initArtefactCollection, initArtefactCollectionDone} from "../Artefact/actions";

function* loadGallery() {
  const api = yield select(getResourceById, 'api_image_collection')
  const response = yield fetch(api.path, {
    method: api.method,
    headers: {
      'Content-Type': 'application/json'}
  })
    .then(response => response.json())
  yield put(initGallery(response.images))
  yield put(initGalleryDone())
}

function* uploadImage(action) {
  const formData = new FormData();
  formData.append("image", action.payload.image);

  const api = yield select(getResourceById, 'api_gallery_upload')
  const response = yield fetch(api.path, {
    method: api.method,
    headers: {
      // "Content-Type": "multipart/form-data",
    },
    body: formData,
  })
    .then(response => response.json())
  yield put(uploadGalleryImageDone(response))
}

export default function* gallerySagas() {
  yield takeEvery("APP_INIT_DONE", loadGallery)
  yield takeEvery("GALLERY_IMAGE_UPLOAD", uploadImage)
}
