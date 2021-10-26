import React from "react"
import {Navbar, Nav, Container, CardGroup, Card, Row} from "react-bootstrap";
import "./App.css"

const App = () => (
    <div className="App">
      <Navbar bg="dark" variant="dark">
        <Container>
          <Navbar.Brand href="#home">CBRP3 : artefactguide</Navbar.Brand>
          <Nav className="me-auto">
            <Nav.Link href="#artefacts">Artefacts</Nav.Link>
            <Nav.Link href="#gallery">Gallery</Nav.Link>
            <Nav.Link href="#login">Login</Nav.Link>
          </Nav>
        </Container>
      </Navbar>

      <Container>
        <Row>&nbsp;</Row>
        <Row>
        <CardGroup>
          <Card bg={"dark"}>
            <Card.Img variant="top" src="holder.js/100px160?theme=industrial" />
            <Card.Body>
              <Card.Title>Card title</Card.Title>
              <Card.Text>
                This is a wider card with supporting text below as a natural lead-in to
                additional content. This content is a little bit longer.
              </Card.Text>
            </Card.Body>
            <Card.Footer>
              <small className="text-muted">Last updated 3 mins ago</small>
            </Card.Footer>
          </Card>
        </CardGroup>
        </Row>
      </Container>
    </div>
)

export default App;