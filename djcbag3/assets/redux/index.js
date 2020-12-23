import React from 'react'
import ReactDOM from 'react-dom'

import { createStore, applyMiddleware, compose } from 'redux'
import createSagaMiddleware from 'redux-saga'

import { Provider } from 'react-redux'
import rootReducer from "./reducers"
import rootSaga from './sagas'

import createAppMiddleware from './features/App/middleware'
import createMqttMiddleware from './features/mqtt/middleware'
import config from './utils/config'

import './index.css'

import {getEnv} from './utils/env'

import AppDev from './features/App/AppDev';
import App from './features/App/App';

const app = createAppMiddleware()
const mqtt = createMqttMiddleware(config.mqtt.host)
const saga = createSagaMiddleware()
const middleWares = [app, saga, mqtt]

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose
const store = createStore(rootReducer, composeEnhancers(
  applyMiddleware(...middleWares)
))

function Main () {
  if(getEnv() == 'dev') return <AppDev />
  return <App />
}

const rootElement = document.getElementById('root')
ReactDOM.render(
  <Provider store={store}>
    <Main />
  </Provider>,
  rootElement
)

saga.run(rootSaga)
