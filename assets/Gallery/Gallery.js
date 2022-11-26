import React, { useState } from 'react'
import { connect, useDispatch, useSelector } from "react-redux"
import { Container, Row, Col, CardGroup, Card, Button, Badge, Form, Modal } from 'react-bootstrap'
import { getSelectedArtefact, getSelectedArtefactImageIds} from "../Artefact/selectors";
import { getGalleryImages, getArtefactImages, getGalleryImagesDeluxe, showGalleryUploadModal} from "./selectors";
import { showGalleryImageUploadModal, closeGalleryImageUploadModal } from './actions'
import { PhotoUp } from 'tabler-icons-react';
import ImageUpload from "./ImageUpload";

function AddImageToGallery() {
  const artefact = useSelector(getSelectedArtefact)
  const show = useSelector(showGalleryUploadModal)
  const dispatch = useDispatch()

  function handleClose() {
    dispatch(closeGalleryImageUploadModal())
  }
  function handleShow() {
    dispatch(showGalleryImageUploadModal())
  }

  return (
    <>
      <Button variant="info" className="float-end" size={'sm'} onClick={handleShow}>
        <PhotoUp size={22} strokeWidth={1} color={'black'}/> upload image to gallery
      </Button>

      <Modal
        show={show}
        onHide={handleClose}
        bg={'Light'}
        size="lg"
        backdrop="static"
      >
        <Modal.Header closeButton>
          <Modal.Title>abbild eines artefacts in gallerie hochlorden</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <ImageUpload />
        </Modal.Body>
      </Modal>
    </>
  )
}

function Image({image}) {
  return (
    <Card className="bg-dark text-white" border="info">
      <Card.Img variant={'bottom'} src={"/uploads/gallery/" + image.path} alt="" />
      <Card.Body>
        <Card.Title>{image.description}</Card.Title>
        <Card.Text>created by {image.author} on {image.createdAt}</Card.Text>
      </Card.Body>
      <Card.Footer>
        artefacte: {image.artefacts.map(id => <Badge pill bg="info" text={'dark'} key={'gallery_image_slug_' + id + '_' + image.id}>{id}</Badge>)}
      </Card.Footer>
    </Card>
  )
}

function Gallery() {
  const images = useSelector(getGalleryImages)
  return (
    <Container>
      <Row>
        <Col>
          <AddImageToGallery />
        </Col>
      </Row>
      <Row xs={1} md={5} className="g-4">
        {images.map(image => <Col key={'gallery_image_'+image.id}><Image image={image} /></Col>)}
      </Row>
    </Container>
  )
}


const mapStateToProps = state => ({
})

export default connect(mapStateToProps)(Gallery)