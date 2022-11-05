import React from 'react'
import { Button, Badge } from 'react-bootstrap'
import { isAuthenticated, getUsername, getAuthPath } from "../Authentication/selectors"
import { connect } from "react-redux"
import { User } from 'tabler-icons-react'

function Auth({authenticated, username, authPath}) {
  if (authenticated === false) {
    return(
        <>
          <Button href={authPath}>Login</Button>
        </>
    )
  }
  return(
    <>
      <Badge bg="primary">
        <User
        size={22}
        strokeWidth={1}
        color={'white'}
      /> {username}</Badge>
    </>
  )
}

const mapStateToProps = state => ({
  authenticated: isAuthenticated(state),
  username: getUsername(state),
  authPath: getAuthPath(state),
})
const mapDispatchToProps = {}

export default connect(mapStateToProps, mapDispatchToProps)(Auth)