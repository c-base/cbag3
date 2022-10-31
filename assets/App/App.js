import React from "react"
import { useDispatch } from "react-redux"
import { Navbar, Nav, Container } from "react-bootstrap"
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link,
  useRouteMatch,
  useParams
} from "react-router-dom"

import "./App.css"
import { initApp } from './actions'

import ArtefactCollection from "../artefact/ArtefactCollection";
import ArtefactSlugList from "../artefact/ArtefactSlugList";

const App = () => {
  useDispatch()(initApp())
  return (
    <Router>
      <div className="App">
        <Navbar bg="dark" variant="dark">
          <Container>
            <Navbar.Brand href="/">CBRP3 : artefactguide</Navbar.Brand>
            <Nav className="me-auto">
              <Link to="/artefacts" className={'nav-link'}>Artefacts</Link>
            </Nav>
          </Container>
        </Navbar>

        <Switch>
          <Route path="/artefacts/:slug">
            ArtefactDetail
          </Route>
          <Route path="/artefacts">
            <ArtefactCollection />
            <ArtefactSlugList />
          </Route>

          <Route path="/">
            Home
          </Route>
        </Switch>


      </div>
    </Router>
)
}

export default App