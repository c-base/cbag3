import React,  { useEffect } from 'react'
import { connect } from 'react-redux'
import { Card, CardGroup, Container, Row } from "react-bootstrap"
import { run as runHolder } from 'holderjs/holder'
import { getLastCreated } from './selectors'

function ArtefactPrimaryAsset({primaryImage}) {
  if (primaryImage === null) {
    return <Card.Img variant="top" data-src="holder.js/100px250?text=Bild folgt&bg=434a52&fg=3d688f" fluid="true" />
  }
  return <Card.Img variant="top" src={"/uploads/assets/"+primaryImage.path} />
}

function Artefact({artefact}) {
  return (
    <Card bg={"dark"}>
      <ArtefactPrimaryAsset primaryImage={artefact.primaryImage} />
      <Card.Body>
        <Card.Title>
          <a href={'/artefacts/' + artefact.slug}>{artefact.name}</a>
        </Card.Title>
        <Card.Text>{artefact.description}</Card.Text>
      </Card.Body>
      <Card.Footer>
        <small className="text-muted">created by {artefact.createdBy} / {artefact.createdAt}</small>
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
          {artefacts.map(artefact => <Artefact key={'artefact_' + artefact.slug} artefact={artefact}/>)}
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