import React from "react"
import { useDispatch } from "react-redux"
import {Navbar, Nav, Container} from "react-bootstrap"
import "./App.css"
import { initApp } from './actions'

import ArtefactCollection from "../artefact/ArtefactCollection";
import ArtefactSlugList from "../artefact/ArtefactSlugList";

const App = () => {
  useDispatch()(initApp())
  return (
    <div className="App">
      <Navbar bg="dark" variant="dark">
        <Container>
          <Navbar.Brand href="/">CBRP3 : artefactguide</Navbar.Brand>
          <Nav className="me-auto">
            <Nav.Link href="/artefacts">Artefacts</Nav.Link>
            <Nav.Link href="/gallery">Gallery</Nav.Link>
            <Nav.Link href="/login">Login</Nav.Link>
          </Nav>
        </Container>
      </Navbar>

      <ArtefactCollection />
      <ArtefactSlugList />
    </div>
)
}

export default App