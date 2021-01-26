import React, { useState } from 'react'
import { connect } from 'react-redux'
import { isUserAuthenticated } from '../../user/selectors'
import ArtefactForm from './ArtefactForm'
import { requestArtefactUpdate } from '../actions'
import {
  Button,
  Modal
} from 'react-bootstrap'

function ArtefactUpdateModal({ artefact, isAuthenticated, handleSubmit }) {
  const [show, setShow] = useState(false)

  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  if (!isAuthenticated) {
    return ''
  }
  return (
    <>
      <Button variant="primary" onClick={handleShow}>bearbeiten</Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>bearbeiten</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <ArtefactForm artefact={artefact} handleSubmit={handleSubmit} handleClose={handleClose} />
        </Modal.Body>
      </Modal>
    </>
  )
}

const mapStateToProps = (state) => ({
  isAuthenticated: isUserAuthenticated(state),
})
const mapDispatchToProps = dispatch => ({
  handleSubmit: artefact => dispatch(requestArtefactUpdate(artefact))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactUpdateModal)