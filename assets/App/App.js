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

import ArtefactCollection from "../Artefact/ArtefactCollection";
import ArtefactSlugList from "../Artefact/ArtefactSlugList";
import ArtefactDetail from "../Artefact/ArtefactDetail";
import Auth from "../Authentication/Auth";

const App = () => {
  useDispatch()(initApp())
  return (
    <Router>
      <div className="App">
        <Navbar bg="dark" variant="dark">
          <Container>
            <Navbar.Brand><Link to="/"  className={'nav-link'}>CBRP3 : artefactguide</Link> </Navbar.Brand>
            <Nav className="me-auto">
              <Link to="/artefacts" className={'nav-link'}>Artefacts</Link>
            </Nav>
            <Auth />
          </Container>
        </Navbar>

        <Switch>
          <Route path="/artefacts/:slug" render={(props) => <ArtefactDetail {...props.match.params} />} />
          <Route path="/artefacts">
            <ArtefactCollection />
            <ArtefactSlugList />
          </Route>

          <Route exact path="/">Home</Route>
          <Route render={() => (<div>Miss</div>)} />
        </Switch>


      </div>
    </Router>
)
}

export default App