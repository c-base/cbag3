import React from 'react'
import {connect} from 'react-redux'
import {Container, Row, Col, Badge} from "react-bootstrap"
import {getAllArtefacts} from './selectors'


function ArtefactSlugList({artefacts}) {
  return (
    <Container>
      <Row>
        <Col>
          {artefacts.map(artefact => {
              return (
                <>
                  <a href={'/artefacts/' + artefact.slug}>
                    <Badge pill bg="dark" key={'slug_' + artefact.slug}>
                      {artefact.name}
                    </Badge>
                  </a>{' '}
                </>
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