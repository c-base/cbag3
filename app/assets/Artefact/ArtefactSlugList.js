import React from 'react'
import {connect} from 'react-redux'
import {Container, Row, Col, Badge} from "react-bootstrap"
import {getAllArtefacts} from './selectors'


function ArtefactSlugList({artefacts}) {
  return (
    <Container key={'artefact-slug-list'}>
      <Row>
        <Col>
          {artefacts.map(artefact => {
              return (
                <a href={'/artefacts/' + artefact.slug} key={'slug_' + artefact.slug} className={'me-sm-2'}>
                  <Badge pill bg="dark" >
                    {artefact.name}
                  </Badge>
                </a>
              )
            }
          )}
        </Col>
      </Row>
    </Container>
  )
}

const mapStateToProps = state => ({
  artefacts: getAllArtefacts(state)
})
const mapDispatchToProps = {}

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactSlugList)