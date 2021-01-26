import React, { useState } from 'react'
import { connect } from 'react-redux'

import {
  Button,
  Form,
  FormControl
} from 'react-bootstrap'

function ArtefactForm({artefact, onSubmit}) {
  const [name, setName] = useState(artefact.name)
  const [description, setDescription] = useState(artefact.description)

  function validateForm() {
    return name.length > 0 && description.length > 0
  }

  function handleSubmit(event) {
    event.preventDefault()
    onSubmit({name, description})
  }

  return (
    <Form onSubmit={handleSubmit}>
      <Form.Label>name</Form.Label>
      <FormControl
        type="text"
        placeholder="name"
        className="mr-sm-2"
        value={name}
        onChange={(e) => setName(e.target.value)}
      />

      <Form.Label>beschreibung / description</Form.Label>
      <FormControl
        type="text"
        placeholder="description"
        className="mr-sm-2"
        value={description}
        as="textarea" rows={5}
        onChange={(e) => setDescription(e.target.value)}
      />
      <Button bg="primary" variant="dark" disabled={!validateForm()} type="submit" >daten schicken</Button>
    </Form>
  )
}

const mapStateToProps = (state) => ({
})
const mapDispatchToProps = dispatch => ({
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactForm)