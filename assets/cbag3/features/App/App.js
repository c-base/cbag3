import React from 'react'

import {Row} from 'react-bootstrap'
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom"
import './App.css'

const App = () => (
  <Router>
    <div>
      <nav>
        <ul>
          <li>
            <Link to="/">CBAG3 - c-base artefact guide 3.2</Link>
          </li>
        </ul>
      </nav>
      
      <Switch>
        <Route path="/">
          <Home />
        </Route>
      </Switch>
    </div>
  </Router>
)

function Home() {
  return <h2>Home</h2>;
}

function About() {
  return <h2>About</h2>;
}

function Users() {
  return <h2>Users</h2>;
}

export default App
