import React from "react"
import ReactDOM from "react-dom"
import { BrowserRouter } from "react-router-dom"

import { createStore, applyMiddleware, compose } from 'redux'
import { Provider } from 'react-redux'

import createSagaMiddleware from 'redux-saga'
import createAppMiddleware from "./App/middleware"

import rootReducer from "./reducers"
import rootSaga from './sagas'

const app = createAppMiddleware()
const saga = createSagaMiddleware()
const middleWares = [app, saga]

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose
const store = createStore(rootReducer, composeEnhancers(
  applyMiddleware(...middleWares)
))
saga.run(rootSaga)

import 'bootstrap/dist/css/bootstrap.min.css'
import './index.css'

import App from "./App/App.js"

const rootElement = document.getElementById('root')
ReactDOM.render(
  <Provider store={store}>
    <BrowserRouter>
      <App />
    </BrowserRouter>
  </Provider>,
  rootElement
)
