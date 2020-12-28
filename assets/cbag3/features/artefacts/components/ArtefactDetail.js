import React from 'react'
import { connect } from 'react-redux'

import {
  Card,
  Carousel
} from 'react-bootstrap'
import { getArtefactBySlug } from '../selectors'

function ArtefactDetail({ artefact }) {
  if (artefact == undefined) {
    // artefacts are not yet initialized if the detail page route is opened
    return <h1>we wait ... and get a towel</h1>
  }
  return (
    <>
      <Card>
        <Card.Header as="h1">{artefact.name}</Card.Header>
        <Card.Body>
          <Card.Text>{artefact.description}</Card.Text>
        </Card.Body>
        <ArtefactAssets assets={artefact.assets} />
      </Card>
    </>
  )
}

function ArtefactAssets({ assets }) {
  if (assets.length == 0) {
    return ''
  }

  if (assets.length == 1) {
    const asset = assets[0]
    return (
      <>
        <Card.Img variant="bottom" src={asset.url} alt={asset.description} />
        <Card.Body>{asset.description}</Card.Body>
      </>
    )
  }

  return (
    <Carousel>
      {assets.map(asset => (
        <Carousel.Item>
          <img
            className="d-block w-100"
            src={asset.url}
            alt={asset.description}
          />
          <Carousel.Caption>
            <h3>{asset.description}</h3>
            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
          </Carousel.Caption>
        </Carousel.Item>
      ))}
    </Carousel>
  )
}

const mapStateToProps = (state, { match }) => ({
  artefact: getArtefactBySlug(state, match.params.slug)
})

const mapDispatchToProps = dispatch => ({})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactDetail)