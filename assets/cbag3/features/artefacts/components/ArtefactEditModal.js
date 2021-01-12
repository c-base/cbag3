import React, { useState } from 'react'
import { connect } from 'react-redux'

import {
  Button,
  Modal
} from 'react-bootstrap'
import { getUser } from '../../user/selectors'
import ArtefactForm from './ArtefactForm'
import { requestArtefactUpdate } from '../actions'

function ArtefactEditModal({ artefact, user, onSubmit }) {
  const [show, setShow] = useState(false)

  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  if (!user.isAuthenticated) {
    return ''
  }
  return (
    <>
      <Button variant="primary" onClick={handleShow}>edit</Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>edit</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <ArtefactForm artefact={artefact} onSubmit={onSubmit} />
        </Modal.Body>
      </Modal>
    </>
  )
}

const mapStateToProps = (state) => ({
  user: getUser(state),
})
const mapDispatchToProps = dispatch => ({
  onSubmit: (artefact) => dispatch(requestArtefactUpdate(artefact))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactEditModal)