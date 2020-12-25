import React from 'react'
import App from './App'
import renderer from 'react-test-renderer'
import configureStore from 'redux-mock-store'
import { Provider } from 'react-redux'

const middlewares = []
const mockStore = configureStore(middlewares)


describe('App', () => {
  
  it('renders without crashing', () => {

    const initialState = {
      now: new Date(),
    }
    const store = mockStore(initialState)

    const app = renderer.create(
    <Provider store={store}>
      <App />
    </Provider>)
  })
})
