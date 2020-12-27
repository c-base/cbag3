import React from 'react'
import { connect } from 'react-redux'

import {
  Button
} from 'react-bootstrap'
import { getAllArtefacts, getAllSlugs } from '../selectors'

function ArtefactSlugList({artefacts, slugs}) {
  return (
    <>
      {slugs.map(slug => (
        <>
          <Button key={slug+'-listLink'} bsStyle="primary" bsSize="xsmall">{artefacts[slug].name}</Button>{' '}
        </>
        ))}
    </>
  )
}

const mapStateToProps = state => ({
  artefacts: getAllArtefacts(state),
  slugs: getAllSlugs(state)
})
const mapDispatchToProps = dispatch => ({
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactSlugList)