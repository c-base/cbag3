import React, { useState } from 'react'
import { connect } from 'react-redux'
import { requestArtefactAssetUpload } from '../actions'

import {
  Button,
  Form,
} from 'react-bootstrap'

function ArtefactAssetForm({ isNew, asset, handleSubmit, handleClose }) {

  const [fileName, setFileName] = useState("")

  const [title, setTitle] = useState(asset.title)
  const [description, setDescription] = useState(asset.description)
  const [license, setLicense] = useState(asset.license)
  const [author, setAuthor] = useState(asset.author)

  const onFormSubmit = event => {
    event.preventDefault()
    if (isNew) {
      const file = event.target[0].files[0]
      asset = { file, title, description, license, author }
    } else {
      asset = { ...asset, title, description, license, author }
    }
    handleSubmit(asset)
    if (isNew) {
      clearForm()
    }
    handleClose()
  }

  const clearForm = () => {
    setFileName('')
    setTitle('')
    setDescription('')
    setLicense('')
    setAuthor('')
  }

  const UploadField = () => {
    if (!isNew) {
      return ''
    }
    return (
      <>
        <Form.Label>auswahl des bildes ...</Form.Label>
        <Form.File
          id="artefact-asset-upload"
          custom
          label={fileName}
          onChange={event => setFileName(event.target.files[0].name)}
          placeholder="artefact bild"
          required
        />
      </>
    )
  }

  return (
    <Form onSubmit={onFormSubmit}>

      <UploadField />

      <Form.Label>bildueberschrift</Form.Label>
      <Form.Control
        id="artefact-asset-title"
        name="title"
        onChange={event => setTitle(event.target.value)}
        required
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
        as="select"
        required
      >
        <option value=""></option>
        <option value="CC-BY-NC">CC-BY-NC</option>
        <option value="CC-BY-SA">CC-BY-SA</option>
        <option value="CC-BY">CC-BY</option>
      </Form.Control>

      <Form.Label>author</Form.Label>
      <Form.Control
        id="artefact-asset-author"
        name="author"
        onChange={event => setAuthor(event.target.value)}
        required
      />

      <Button bg="primary" variant="dark" type="submit" >hochladen</Button>
    </Form>
  )
}

const mapStateToProps = (state, ownProps) => {
  if (ownProps.hasOwnProperty("asset")) {
    const { asset } = ownProps
    return {
      isNew: false,
      asset
    }
  }
  return {
    isNew: true,
    asset: { title: '', description: '', license: '', author: '' }
  }
}
const mapDispatchToProps = dispatch => ({
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactAssetForm)