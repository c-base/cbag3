import React, { useState } from 'react'
import { connect, useDispatch, useSelector } from "react-redux"
import { Button, Badge, Form, FloatingLabel, Row, Col } from 'react-bootstrap'

import { uploadGalleryImage } from './actions'
import { getLicences } from './../App/selectors'

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

  const licences = useSelector(getLicences)

  return (
    <Form>
      <Row className="mb-3">
        <Form.Control
          type="file"
          placeholder="bild auswählen"
          onChange={(e) => onFileSelect(e)}
          accept="image/*"
        />
      </Row>

      <Row className="mb-3">
        <FloatingLabel
          controlId="floatingTextarea"
          label="beschreibung"
        >
          <Form.Control
            as="textarea"
            placeholder="was sieht man auf dem bild"
            style={{ height: '100px' }}
            required
          />
        </FloatingLabel>
      </Row>

      <Row className="mb-3">
        <Col>
          <FloatingLabel
            controlId="authorInput"
            label="author"
          >
            <Form.Control
              type="text"
              placeholder="alien"
              required
            />
          </FloatingLabel>
        </Col>

        <Col md>
          <FloatingLabel
            controlId="licenceSelectGrid"
            label="licenc"
          >
            <Form.Select aria-label="Floating label select example">
              {licences.map(licence => <option value={licence}>{licence}</option>)}
            </Form.Select>
          </FloatingLabel>
        </Col>
      </Row>

      <Row>
        <Button disabled={!selectedFiles} onClick={upload}>upload</Button>
      </Row>
    </Form>
  )
}

const mapStateToProps = state => ({
})

export default connect(mapStateToProps)(ImageUpload)