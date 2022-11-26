import React, { useState } from 'react'
import { useForm } from "react-hook-form"
import { connect, useDispatch, useSelector } from "react-redux"
import { Button, Badge, Form, FloatingLabel, Row, Col } from 'react-bootstrap'

import { uploadGalleryImage } from './actions'
import { getLicences } from './../App/selectors'

function ErrorMessage({message}) {
  if (message === undefined) {
    return ''
  }
  return <Form.Control.Feedback type="invalid">{message}</Form.Control.Feedback>
}

function ImageUpload() {
  const dispatch = useDispatch()
  const { register, handleSubmit, watch, formState: { errors, touchedFields, isValid } } = useForm({
    mode: 'all',
    reValidateMode: 'onChange',
    defaultValues: {},
    resolver: undefined,
    context: undefined,
    criteriaMode: "firstError",
    shouldFocusError: true,
    shouldUnregister: false,
    shouldUseNativeValidation: false,
    delayError: undefined
  })
  const onSubmit = data => console.log({data}) //dispatch(uploadGalleryImage(currentFile))

  // const onFileSelect = (event) => {
  //   setSelectedFiles(event.target.files)
  // }
  //
  // const upload = () => {
  //   setProgress(0);
  //   let currentFile = selectedFiles[0];
  //
  //   dispatch(uploadGalleryImage(currentFile))
  //
  //   setSelectedFiles(undefined)
  // }

  const licences = useSelector(getLicences)

  // console.log({
  //   errors, touchedFields, isValid,
  //   file: watch("file"),
  // })

  return (
    <Form noValidate validated={isValid} onSubmit={handleSubmit(onSubmit)} >
      <Row className="mb-3">
        <Col>
          <Form.Control
            type="file"
            placeholder="bild auswählen"
            accept="image/*"
            {...register("file", { required: "es muss ein fotographisches abbild ausgewählt werden" })}
            isValid={touchedFields.file && !errors.file}
            isInvalid={touchedFields.file && errors.file}
          />
          <ErrorMessage message={errors?.file?.message}/>
        </Col>
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
            {...register("description", {
              required: "es muss eine beschreibung des artefacts angegeben werden",
              minLength: { value: 42, message: "die beschreibung sollte mindestens aus 42 characteren bestehen" }
            })}
            isValid={touchedFields.description && !errors.description}
            isInvalid={touchedFields.description && errors.description}
          />
          <ErrorMessage message={errors?.description?.message}/>
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
              {...register("author", {
                required: "author ist ein pflichtfeld",
                minLength: { value: 2, message: "der name der authorin muss mindestens 2 zeichen lang sein" }
              })}
              isValid={touchedFields.author && !errors.author}
              isInvalid={touchedFields.author && errors.author}
            />
            <ErrorMessage message={errors?.author?.message}/>
          </FloatingLabel>
        </Col>

        <Col md>
          <FloatingLabel
            controlId="licenceSelectGrid"
            label="licenc"
          >
            <Form.Select
              aria-label="Floating label select example"
              {...register("licence", { required: "licenc ist ein pflichtfeld" })}
              isValid={touchedFields.licence && !errors.licence}
              isInvalid={touchedFields.licence && errors.licence}
            >
              <option value="">bitte weahle eine licenc</option>
              {licences.map(licence => <option key={'licence_' + licence} value={licence}>{licence}</option>)}
            </Form.Select>
            <ErrorMessage message={errors?.licence?.message}/>
          </FloatingLabel>
        </Col>
      </Row>

      <Row>
        <Button type="submit">upload</Button>
      </Row>
    </Form>
  )
}

const mapStateToProps = state => ({
})

export default connect(mapStateToProps)(ImageUpload)