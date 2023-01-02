import {put, takeEvery} from 'redux-saga/effects'
import {initAppConfig, initAppDone} from './actions'

function* fetchAppConfig() {
  yield put(initAppConfig(window.config));
  yield put(initAppDone())
}

/*
  Watcher
*/
export default function* appSagas() {
  yield takeEvery("APP_INIT", fetchAppConfig)
}