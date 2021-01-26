import React, { useState } from 'react'
import { connect } from 'react-redux'

import {
  Button,
  Form,
  FormControl
} from 'react-bootstrap'

function ArtefactForm({isNew, artefact, handleSubmit, handleClose}) {
  const [name, setName] = useState(artefact.name)
  const [description, setDescription] = useState(artefact.description)

  function validateForm() {
    return name.length > 0 && description.length > 0
  }

  function onFormSubmit(event) {
    event.preventDefault()
    handleSubmit({name, description})
    handleClose()
    if (isNew) {
      clearForm()
    }
  }

  const clearForm = () => {
    setName('')
    setDescription('')
  }

  return (
    <Form onSubmit={onFormSubmit}>
      <Form.Label>name</Form.Label>
      <FormControl
        type="text"
        placeholder="name"
        className="mr-sm-2"
        value={name}
        onChange={(e) => setName(e.target.value)}
        required
      />

      <Form.Label>beschreibung / description</Form.Label>
      <FormControl
        type="text"
        placeholder="description"
        className="mr-sm-2"
        value={description}
        as="textarea" rows={5}
        onChange={(e) => setDescription(e.target.value)}
        required
      />
      <Button bg="primary" variant="dark" disabled={!validateForm()} type="submit" >daten schicken</Button>
    </Form>
  )
}

const mapStateToProps = (state, ownProps) => {
  if (ownProps.hasOwnProperty("artefact")) {
    const { artefact } = ownProps
    return {
      isNew: false,
      artefact
    }
  }
  return {
    isNew: true,
    artefact: { name: '', description: '' }
  }
}
const mapDispatchToProps = dispatch => ({
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactForm)