import React from 'react'

import {
  Navbar,
  Row,
  Col
} from 'react-bootstrap'
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom"
import './App.css'

import ArtefactSlugList from '../artefacts/components/ArtefactSlugList'

function App() {
  return (
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
} 
function Home() {
  return (
    <Row>
      <Col sm={4}>
        <ArtefactSlugList />
      </Col>
      <Col sm={8}>
        der cbag3 soll dacu dienen, informationen über die auf der station materialisierten artefacte zu sammeln und 
        interessierten bereitzustellen. cu diesem zweck wurden in der nähe der artefacte eingec_weißte QR codes platziert, 
        die mit modernen communicatoren gescannt werden können und den benutzer dann automatisch zu den informationen 
        des jweiligen artefacts weiterleitet. 
        so haben aliens und member jederzeit die möglichkeit, mehr cu den an 
        bord befindlichen artefacten zu erfahren, auch wenn gerade kein member da ist, welches eine ausführliche 
        führung geben könnte.
      </Col>
    </Row>
  )
}

export default App
