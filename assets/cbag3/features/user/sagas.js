import { call, put, select, takeEvery, takeLatest } from 'redux-saga/effects'
import { initUser, initUserDone, successfulAuthentication, failedAuthentication } from './actions'
import { getCsrfToken } from '../App/selectors'
import { getUser } from '../user/selectors'

function* initializeUser(action) {
  yield put(initUser(action.payload.user))
  yield put(initUserDone())
}

// const fetchData = async () => {
//   try {
//     const response = await fetch("https://randomuser.me/api");
//     const data = await response.json();
//     return data;
//   } catch (e) {
//     console.log(e);
//   }

function* userRequestAuthentication(action) {
  let token = yield select(getCsrfToken)
  let user = yield select(getUser)
  
  const loginRequest = () => fetch(user.loginUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Cookie': 'csrftoken='+token+';'
      },
      body: new URLSearchParams({
        'csrfmiddlewaretoken': token,
        'username': action.payload.username,
        'password': action.payload.password,
        'next': '',
      })
    })
    .then(res => {
      console.log(res)
      if (res.status == 302) {
        return {isAuthenticated: true, username: action.username}
      }
      return {}
    })
    .catch(exception => {
      console.log('parsing failed', exception);
      return ({ exception })
    })

  const { data, exception } = yield call(loginRequest)

  if (exception != undefined) {
    yield put(failedAuthentication(exception))
    return
  }

  yield put(successfulAuthentication(data))
}

// use them in parallel
export default function* userSagas() {
  yield takeEvery('APP_START', initializeUser)
  yield takeLatest('USER_AUTHENTICATION_REQUEST', userRequestAuthentication)
}