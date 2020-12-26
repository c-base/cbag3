import { all } from 'redux-saga/effects'

import artefactsSagas from './features/artefacts/sagas'

export default function* rootSaga() {
    yield all([
        artefactsSagas(),
    ])
}