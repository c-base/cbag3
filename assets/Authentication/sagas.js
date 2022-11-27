import {put, takeEvery, select} from 'redux-saga/effects'
import {initAuthState, initAuthStateDone} from './actions'
import {getResourceById} from "../App/selectors";

function* initAuth(action) {
  yield put(initAuthState(action.payload.auth));
  yield put(initAuthStateDone())
}

function* handleAuthRequired(action) {
  const api = yield select(getResourceById, 'api_auth_cbase')
  window.location.href=api.path;
}

/*
  Watcher
*/
export default function* authSagas() {
  yield takeEvery("APP_INIT_CONFIG", initAuth)
  yield takeEvery("AUTH_REQUIRED", handleAuthRequired)
}
