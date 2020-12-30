import { all } from 'redux-saga/effects'

import artefactsSagas from './features/artefacts/sagas'
import userSagas from './features/user/sagas'

export default function* rootSaga() {
    yield all([
        artefactsSagas(),
        userSagas(),
    ])
}