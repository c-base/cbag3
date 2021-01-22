import { put, takeEvery, select } from 'redux-saga/effects'
import { 
  initArtefacts, 
  initArtefactsDone, 
  successfulAssetUpload,
  failedAssetUpload
} from './actions'
import { getUrlConfig } from '../App/selectors'

function* initializeArtefacts(action) {
  yield put(initArtefacts(window.state.artefacts))
  yield put(initArtefactsDone())
}

function* uploadArtefactAsset(action) {
  console.log(action.payload)

  let formData = new FormData()

  formData.append("artefact", action.payload.slug)
  formData.append("file", action.payload.file)
  formData.append("filename", action.payload.file.name)
  formData.append("title", action.payload.title)
  formData.append("description", action.payload.description)
  formData.append("author", action.payload.author)
  formData.append("license", action.payload.license)

  let urlConfig = yield select(getUrlConfig, 'asset-create')

  const uploadRequest = () => fetch(urlConfig.path, {
    method: urlConfig.method,
    headers: {
      'Content-Type': "multipart/form-data",
    },
    body: formData
  })
    .then(response => {
      if (response.status == 200) {
        return response
      }
      throw new Error('oh no! the server said you lost your towel!')
    })
    .then(response => response.json())
    .catch(error => {
      throw error
    })

  try {
    const data = yield call(uploadRequest)
    yield put(successfulAssetUpload(data))
  } catch (error) {
    yield put(failedAssetUpload({error}))
  }
}

// use them in parallel
export default function* artefactsSagas() {
  yield takeEvery('APP_START', initializeArtefacts)
  yield takeEvery('ARTEFACT_ASSET_REQUST_UPLOAD', uploadArtefactAsset)
}