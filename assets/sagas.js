import { all } from 'redux-saga/effects'

import artefactSagas from './artefact/sagas'

export default function* rootSaga() {
    yield all([
        artefactSagas(),
    ])
}