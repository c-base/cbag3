import React,  { useEffect } from 'react'
import { connect } from 'react-redux'
import {Card, CardGroup, Container, Row} from "react-bootstrap"
import { run as runHolder } from 'holderjs/holder'
import {getLastCreated} from './selectors'

function ArtefactPrimaryAsset({assets}) {
  if (assets.length > 0) {
    return <Card.Img variant="top" src={"/uploads/assets/"+assets[0].path} />
  }
  return <Card.Img variant="top" data-src="holder.js/100px250?text=Bild folgt&bg=434a52&fg=3d688f" fluid className="holderJs" />
}

function Artefact({artefact}) {
  return (
    <Card bg={"dark"}>
      <ArtefactPrimaryAsset assets={artefact.assets} />
      <Card.Body>
        <Card.Title>{artefact.name}</Card.Title>
        <Card.Text>{artefact.description}</Card.Text>
      </Card.Body>
      <Card.Footer>
        <small className="text-muted">created by {artefact.createdBy}</small>
      </Card.Footer>
    </Card>
  )
}

function ArtefactCollection({artefacts}) {
  useEffect(() => {
    runHolder('holderJs')
  })
  return (
    <Container>
      <Row>
        <CardGroup>
          {artefacts.map(artefact => <Artefact key={'artefact_' + artefact.id} artefact={artefact}/>)}
        </CardGroup>
      </Row>
    </Container>
  )
}

const mapStateToProps = state => ({
  artefacts: getLastCreated(state, 3)
})
const mapDispatchToProps = {}

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactCollection)