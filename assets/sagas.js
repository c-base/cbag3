import { all } from 'redux-saga/effects'

import artefactSagas from './Artefact/sagas'

export default function* rootSaga() {
    yield all([
        artefactSagas(),
    ])
}