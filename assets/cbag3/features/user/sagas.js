import { call, put, select, takeEvery, takeLatest } from 'redux-saga/effects'
import { 
  initUser, 
  initUserDone, 
  successfulAuthentication, 
  failedAuthentication, 
  successfulLogout, 
  failedLogout,
} from './actions'
import { getConfig } from '../App/selectors'

function* initializeUser(action) {
  yield put(initUser(action.payload.user))
  yield put(initUserDone())
}

function* userRequestAuthentication(action) {
  let config = yield select(getConfig)

  const loginRequest = () => fetch(config.urls.login.path, {
    method: config.urls.login.method,
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
      'username': action.payload.username,
      'password': action.payload.password,
    })
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
    const data = yield call(loginRequest)
    yield put(successfulAuthentication({
      isAuthenticated: true,
      username: action.payload.username,
      ...data
    }))
  } catch (error) {
    yield put(failedAuthentication(error))
  }
}

function* userLogout(action) {
  let config = yield select(getConfig)

  const logoutRequest = () => fetch(config.urls.logout.path, {
    method: config.urls.logout.method,
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    }
  })
    .then(res => {
      if (res.status == 200) {
        return { isAuthenticated: false }
      }
      throw new Error('oh no! the server said you lost your towel!')
    })
    .catch(exception => {
      throw exception
    })

    try {
      const data = yield call(logoutRequest)
      yield put(successfulLogout(data))
    } catch (error) {
      yield put(failedLogout(error))
    }
  
}

// use them in parallel
export default function* userSagas() {
  yield takeEvery('APP_START', initializeUser)
  yield takeLatest('USER_AUTHENTICATION_REQUEST', userRequestAuthentication)
  yield takeLatest('USER_LOGOUT', userLogout)
}