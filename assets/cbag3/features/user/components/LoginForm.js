import React, { useState } from 'react'
import { connect } from 'react-redux'

import {
  Button,
  Form,
  FormControl
} from 'react-bootstrap'
import { requestAuthentication } from '../actions'

function LoginForm({login}) {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  function validateForm() {
    return username.length > 0 && password.length > 0;
  }

  function handleSubmit(event) {
    event.preventDefault();
    login(username, password)
  }

  return (
    <Form onSubmit={handleSubmit}>
      <FormControl
        type="text"
        placeholder="username"
        className="mr-sm-2"
        value={username}
        onChange={(e) => setUsername(e.target.value)}
      />

      <FormControl
        type="password"
        placeholder="password"
        className="mr-sm-2"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
      />
      <Button bg="primary" variant="dark" disabled={!validateForm()} type="submit" >Login</Button>
    </Form>
  )
}

const mapStateToProps = (state) => ({
})
const mapDispatchToProps = dispatch => ({
  login: (username, password) => dispatch(requestAuthentication(username, password)),
})

export default connect(mapStateToProps, mapDispatchToProps)(LoginForm)