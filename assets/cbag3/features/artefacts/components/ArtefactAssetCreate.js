import React, { useState } from 'react'
import { connect } from 'react-redux'
import { requestArtefactAssetCreate } from '../actions'
import ArtefactAssetForm from './ArtefactAssetForm'
import { isUserAuthenticated } from '../../user/selectors'
import {
  Button,
  Modal
} from 'react-bootstrap'

function ArtefactAssetCreate({isAuthenticated, handleSubmit }) {
  const [show, setShow] = useState(false)

  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  if (!isAuthenticated) {
    return ''
  }
  return (
    <>
      <Button variant="primary" onClick={handleShow}>bild hinzufügen</Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>bild hinzufügen</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <ArtefactAssetForm handleSubmit={handleSubmit} handleClose={handleClose} />
        </Modal.Body>
      </Modal>
    </>
  )
}

const mapStateToProps = (state) => ({
  isAuthenticated: isUserAuthenticated(state),
})
const mapDispatchToProps = dispatch => ({
  handleSubmit: asset => dispatch(requestArtefactAssetCreate(asset))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactAssetCreate)