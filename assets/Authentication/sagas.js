import {put, takeEvery} from 'redux-saga/effects'
import {initAuthState, initAuthStateDone} from './actions'

function* initAuth(action) {
  yield put(initAuthState(action.payload.auth));
  yield put(initAuthStateDone())
}

/*
  Watcher
*/
export default function* authSagas() {
  yield takeEvery("APP_INIT_CONFIG", initAuth)
}