import { all } from 'redux-saga/effects'

import appSagas from './App/sagas'
import artefactSagas from './Artefact/sagas'
import authenticationSagas from './Authentication/sagas'
import gallerySagas from './Gallery/sagas'

export default function* rootSaga() {
    yield all([
        appSagas(),
        artefactSagas(),
        authenticationSagas(),
        gallerySagas(),
    ])
}