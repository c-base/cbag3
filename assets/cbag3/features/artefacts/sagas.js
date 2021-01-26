import { put, takeEvery, call, select } from 'redux-saga/effects'
import { 
  initArtefacts, 
  initArtefactsDone, 
  successfulAssetCreate,
  failedAssetCreate
} from './actions'
import { getUrlConfig } from '../App/selectors'

function* initializeArtefacts(action) {
  yield put(initArtefacts(window.state.artefacts))
  yield put(initArtefactsDone())
}

function* createArtefactAsset(action) {
  console.log(action.payload)

  let formData = new FormData()
  const asset = action.payload.asset

  formData.append("file", asset.file)
  formData.append("title", asset.title)
  formData.append("description", asset.description)
  formData.append("author", asset.author)
  formData.append("license", asset.license)

  let urlConfig = yield select(getUrlConfig, 'asset-create')

  const uploadRequest = () => fetch(urlConfig.path, {
    method: urlConfig.method,
    headers: {},
    body: formData
  })
    .then(response => {
      if (response.status == 200) {
        return response
      }
      throw new Error('oh no! the server said you lost your towel!')
    })
    .then(data => data)
    .catch(error => {
      throw error
    })

  try {
    const data = yield call(uploadRequest)
    yield put(successfulAssetCreate(data))
  } catch (error) {
    console.log(error)
    yield put(failedAssetCreate(error))
  }
}

// use them in parallel
export default function* artefactsSagas() {
  yield takeEvery('APP_START', initializeArtefacts)
  yield takeEvery('ARTEFACT_ASSET_REQUEST_CREATE', createArtefactAsset)
}