import { put, takeEvery, select, call } from 'redux-saga/effects'
import {
  initGallery,
  initGalleryDone,
  uploadGalleryImage,
  uploadGalleryImageDone,
  uploadGalleryImageFail,
} from './actions'
import {getResourceById} from "../App/selectors";

function* loadGallery(action) {
  yield put(initGallery(action.payload.artefacts));
  yield put(initGalleryDone())
}

function sendImageToApi(api, formData) {
  return fetch(api.path, {
    method: api.method,
    headers: {
      // "Content-Type": "multipart/form-data",
    },
    body: formData,
  })
    .then(response => response.json())
    .catch(error => error)
}

function* uploadImage(action) {
  const formData = new FormData();
  formData.append("image", action.payload.image);

  const api = yield select(getResourceById, 'api_gallery_upload')
  const { response, error } = yield call(sendImageToApi, api, formData)
  if (response)
    yield put(uploadGalleryImageDone(response))
  else
    yield put(uploadGalleryImageFail(error))
}

export default function* gallerySagas() {
  yield takeEvery("ARTEFACT_INIT_COLLECTION", loadGallery)
  yield takeEvery("GALLERY_IMAGE_UPLOAD", uploadImage)
}
