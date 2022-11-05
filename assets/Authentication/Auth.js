import React from 'react'
import { Button } from 'react-bootstrap'
import { isAuthenticated, getAuthPath } from "../Authentication/selectors";
import { connect } from "react-redux";

function Auth({isAuthenticated, authPath}) {
  return(
      <>
        <Button href={authPath}>Login</Button>
      </>
  )
}

const mapStateToProps = state => ({
  isAuthenticated: isAuthenticated(state),
  authPath: getAuthPath(state),
})
const mapDispatchToProps = {}

export default connect(mapStateToProps, mapDispatchToProps)(Auth)