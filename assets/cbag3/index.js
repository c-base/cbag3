import React from 'react'
import ReactDOM from 'react-dom'

import { createStore, applyMiddleware, compose } from 'redux'
import createSagaMiddleware from 'redux-saga'

import { Provider } from 'react-redux'
import rootReducer from "./reducers"
import rootSaga from './sagas'

import createAppMiddleware from './features/App/middleware'

import './index.css'

import App from './features/App/App';

const app = createAppMiddleware()
const saga = createSagaMiddleware()
const middleWares = [app, saga]

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose
const store = createStore(rootReducer, composeEnhancers(
  applyMiddleware(...middleWares)
))

const rootElement = document.getElementById('root')
ReactDOM.render(
  <Provider store={store}>
    <App />
  </Provider>,
  rootElement
)

saga.run(rootSaga)
