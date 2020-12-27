import React from 'react'
import { connect } from 'react-redux'

import {
  Button
} from 'react-bootstrap'
import {
  useParams
} from "react-router-dom"
import { getArtefactBySlug } from '../selectors'

function ArtefactDetail({artefact}) {
  if (artefact != undefined) {
    return (
      <h1>Artefact: { artefact.name }</h1>
    )
  }
  // atefacts are not yet initialized if the detail page route is opened
  return <h1>we wait</h1>
}

const mapStateToProps = (state, {match}) => ({
  artefact: getArtefactBySlug(state, match.params.slug)
})

const mapDispatchToProps = dispatch => ({})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactDetail)