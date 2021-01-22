import React, { useState } from 'react'
import { connect } from 'react-redux'
import { requestArtefactAssetUpload } from './../actions'

import {
  Button,
  Form,
} from 'react-bootstrap'

function ArtefactAssetUpload({ slug, handleSubmit }) {

  const [fileName, setFileName] = useState("artefact bild")
  const [title, setTitle] = useState("")
  const [description, setDescription] = useState("")
  const [license, setLicense] = useState("")
  const [author, setAuthor] = useState("")

  const onFormSubmit = event => {
    event.preventDefault()
    const file = event.target[0].files[0]
    handleSubmit({ slug, file, title, description, license, author })
  }

  return (
    <Form onSubmit={onFormSubmit}>
      <Form.Label>auswahl des bildes ...</Form.Label>
      <Form.File
        id="artefact-asset-upload"
        custom
        label={fileName}
        onChange={event => setFileName(event.target.files[0].name)}
      />
      <Form.Label>bildueberschrift</Form.Label>
      <Form.Control
        id="artefact-asset-title"
        name="title"
        onChange={event => setTitle(event.target.value)}
      />
      <Form.Label>beschreibung</Form.Label>
      <Form.Control
        as="textarea"
        rows={3}
        id="artefact-asset-description"
        name="description"
        onChange={event => setDescription(event.target.value)}
      />
      <Form.Label>license</Form.Label>
      <Form.Control
        id="artefact-asset-license"
        name="license"
        onChange={event => setLicense(event.target.value)}
      />

      <Form.Label>author</Form.Label>
      <Form.Control
        id="artefact-asset-author"
        name="author"
        onChange={event => setAuthor(event.target.value)}
      />

      <Button bg="primary" variant="dark" type="submit" >hochladen</Button>
    </Form>
  )
}

const mapStateToProps = (state) => ({
})
const mapDispatchToProps = dispatch => ({
  handleSubmit: file => dispatch(requestArtefactAssetUpload(file))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactAssetUpload)