import React, { useState } from 'react'
import { connect, useDispatch } from "react-redux"
import { Button, Badge, Form } from 'react-bootstrap'
import { uploadGalleryImage } from './actions'

function ImageUpload() {
  const dispatch = useDispatch()

  const [selectedFiles, setSelectedFiles] = useState(undefined)
  const [currentFile, setCurrentFile] = useState(undefined)
  const [progress, setProgress] = useState(0)
  const [message, setMessage] = useState("")

  const [fileInfos, setFileInfos] = useState([])

  const onFileSelect = (event) => {
    setSelectedFiles(event.target.files)
  }

  const upload = () => {
    setProgress(0);
    let currentFile = selectedFiles[0];

    dispatch(uploadGalleryImage(currentFile))

    setSelectedFiles(undefined)
  }

  return (
    <>
      <Form.Control
        type="file"
        placeholder="upload an image of an artefact"
        onChange={(e) => onFileSelect(e)}
        accept="image/*"
        multiple
      />
      <Button disabled={!selectedFiles} onClick={upload}>upload</Button>
    </>
  )
}

const mapStateToProps = state => ({
})

export default connect(mapStateToProps)(ImageUpload)