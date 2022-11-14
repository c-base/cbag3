import React, { useState } from 'react'
import { connect, useDispatch, useSelector } from "react-redux"
import { Container, CardGroup, Card, Row, Button, Badge, Form, Modal } from 'react-bootstrap'
import { getSelectedArtefact, getSelectedArtefactImageIds} from "../Artefact/selectors";
import {getGalleryImages, getArtefactImages, getGalleryImagesDeluxe} from "./selectors";
import { PhotoUp } from 'tabler-icons-react';
import ImageUpload from "./ImageUpload";

function AddImageToGallery() {
  const artefact = useSelector(getSelectedArtefact)

  const [show, setShow] = useState(false);
  function handleClose() {
    setShow(false);
  }
  function handleShow() {
    setShow(true);
  }

  return (
    <>
      <Button variant="info" className="float-end" size={'sm'} onClick={handleShow}>
        <PhotoUp size={22} strokeWidth={1} color={'black'}/> upload image to gallery
      </Button>

      <Modal show={show} onHide={handleClose} bg={'Light'} >
        <Modal.Header closeButton>
          <Modal.Title>upload image to gallery</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <ImageUpload />
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
        </Modal.Footer>
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
    </Card>
  )
}

function Gallery() {
  const images = useSelector(getGalleryImagesDeluxe)
  return (
    <Container>
      <Row>
        <AddImageToGallery />
      </Row>
      <Row xs={1} md={5} className="g-4">
        {images.map(image => <Image key={'gallery_image_'+image.id} image={image} />)}
      </Row>
    </Container>
  )
}


const mapStateToProps = state => ({
})

export default connect(mapStateToProps)(Gallery)