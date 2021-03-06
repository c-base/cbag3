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
import ArtefactDetail from '../artefacts/components/ArtefactDetail'
import ArtefactGallery from '../artefacts/components/ArtefactGallery'

import LoginModal from '../user/components/LoginModal'

function App() {
  return (
    <Router>
      <Navbar bg="dark" variant="dark">
        <Navbar.Brand>
          <Link to="/" key="home-link">CBAG3 - c-base artefact guide 3.2</Link>
        </Navbar.Brand>
        <Link to="/gallery" key="gallery-link">gallery</Link>
        <LoginModal />
      </Navbar>
      <Row>
        <Col sm={2}>
          <ArtefactSlugList />
        </Col>
        <Col sm={10}>

          <Switch>
            <Route path="/" exact={true} component={Home}></Route>
            <Route path="/artefact/:slug" render={(props) => <ArtefactDetail {...props} />}></Route>
            <Route path="/gallery" component={ArtefactGallery}></Route>
          </Switch>

        </Col>
      </Row>
    </Router>
  )
}
function Home() {
  return (
    <Row>
      der cbag3 informiert über die auf der station materialisierten artefacte. 
      zu diesem zweck wurden in der nähe der artefacte eingec_weißte QR codes platziert,
      die mit modernen communicatoren gescannt werden können und den benutzer dann automatisch zu den informationen
      des jweiligen artefacts weiterleitet.
      so haben aliens und member jederzeit die möglichkeit, mehr cu den an bord befindlichen artefacten zu erfahren, 
      auch wenn gerade kein member da ist, welches eine ausführliche führung geben könnte.
    </Row>
  )
}

export default App
