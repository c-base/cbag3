import React from 'react'
import { connect } from 'react-redux'

import {
  Badge
} from 'react-bootstrap'
import {
  Link
} from "react-router-dom"
import { getAllArtefacts, getAllSlugs } from '../selectors'
import { selectArtefact } from '../actions'

function ArtefactSlugList({artefacts, slugs}) {
  return (
    <>
      {slugs.map(slug => (
        <Link to={'/artefact/' + slug} key={slug + '-slugLink'}>
          <Badge className="artefactSlugLink" variant="primary" size="sm">{artefacts[slug].name}{artefacts[slug].hasImages ? '' : ' *'}</Badge>{' '}
        </Link>
        ))}
    </>
  )
}

const mapStateToProps = state => ({
  artefacts: getAllArtefacts(state),
  slugs: getAllSlugs(state)
})
const mapDispatchToProps = dispatch => ({
  selectArtefact: slug => dispatch(selectArtefact(slug))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactSlugList)