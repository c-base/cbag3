import React, { useState } from 'react'
import { connect } from 'react-redux'

import {
  Button,
  Modal
} from 'react-bootstrap'
import { getUser } from '../selectors'
import { logoutUser } from '../actions'
import LoginForm from './LoginForm'

function LoginModal({ user, logout }) {
  const [show, setShow] = useState(false)

  const handleClose = () => setShow(false)
  const handleShow = () => setShow(true)

  const handleLogout = () => {
    setShow(false)
    logout()
  }

  if (user.isAuthenticated) {
    return <Button variant="primary" onClick={handleLogout}>logout</Button>
  }
  return (
    <>
      <Button variant="primary" onClick={handleShow}>login</Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>login</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <LoginForm />
        </Modal.Body>
      </Modal>
    </>
  )
}

const mapStateToProps = (state) => ({
  user: getUser(state),
})
const mapDispatchToProps = dispatch => ({
  logout: () => dispatch(logoutUser()),
})

export default connect(mapStateToProps, mapDispatchToProps)(LoginModal)