import React from 'react'

import {
  Navbar,
  Row
} from 'react-bootstrap'
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom"
import './App.css'

const App = () => (
  <Router>
    <Navbar bg="dark">
      <Navbar.Brand>
        <Link to="/">CBAG3 - c-base artefact guide 3.2</Link>
      </Navbar.Brand>
    </Navbar>

    <Row>
      <Switch>
        <Route path="/">
          <Home />
        </Route>
      </Switch>
    </Row>
  </Router>
)

function Home() {
  return <h2>Home</h2>;
}

export default App
