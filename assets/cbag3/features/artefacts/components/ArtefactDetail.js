import React from 'react'
import { connect } from 'react-redux'

import {
  Card
} from 'react-bootstrap'
import { getArtefactBySlug } from '../selectors'
import { AssetGallery } from './ArtefactGallery'
import ReactMarkdown from 'react-markdown'

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
          <Card.Text><ReactMarkdown>{artefact.description}</ReactMarkdown></Card.Text>
        </Card.Body>
        <AssetGallery assets={artefact.assets} />
      </Card>
    </>
  )
}

const mapStateToProps = (state, { match }) => ({
  artefact: getArtefactBySlug(state, match.params.slug)
})
const mapDispatchToProps = dispatch => ({})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactDetail)