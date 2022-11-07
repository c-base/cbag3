import React,  { useState, useEffect, useCallback } from 'react'
import { connect, useDispatch, useSelector } from 'react-redux'
import {Button, Card, CardGroup, Container, Row, Col, Modal, Badge} from "react-bootstrap"
import {
  updateArtefactPrimaryImage,
  selectArtefactDetail,
  assignImageToArtefact,
} from './actions'
import {getArtefact, getSelectedArtefact, getSelectedArtefactImageIds} from './selectors'
import { getGalleryImages } from './../Gallery/selectors'
import { useParams } from "react-router-dom";
import {run as runHolder} from "holderjs";
import { PhotoStar, PhotoPlus } from 'tabler-icons-react';

function PrimaryImage({primaryImage}) {
  if (primaryImage === null) {
    return <Card.Img variant="top" data-src="holder.js/100px250?text=primary image missing&bg=434a52&fg=3d688f" fluid="true" />
  }
  return <Card.Img variant="top" src={"/uploads/assets/"+primaryImage.path} />
}

function AssignImage({image}) {
  const artefact = useSelector(getSelectedArtefact)
  if (artefact === null) {
    return <>Loading ...</>
  }
  const dispatch = useDispatch()
  function handleClick() {
    dispatch(assignImageToArtefact(artefact.slug, [...artefact.images, image]))
  }

  return (
    <Card className="bg-dark text-white" border="info" onClick={handleClick}>
      <Card.Img variant={'bottom'} src={"/uploads/assets/" + image.path} alt="" />
      <Card.Body>
        <Card.Title>{image.description}</Card.Title>
      </Card.Body>
      <Card.Footer>
        {image.artefacts.map(id => <><Badge pill bg="info" text={'dark'} key={'slug_' + id}>{id}</Badge>{' '}</>)}
      </Card.Footer>
    </Card>
  )
}

function UnassignImage({artefact, image}) {
  const dispatch = useDispatch()
  function handleClick() {
    dispatch(assignImageToArtefact(artefact.slug, artefact.images.filter(artefactImage => artefactImage.id !== image.id)))
  }

  return (
    <Card className="bg-dark text-white" border="info" onClick={handleClick}>
      <Card.Img variant={'bottom'} src={"/uploads/assets/" + image.path} alt="" />
      <Card.Body>
        <Card.Title>{image.description}</Card.Title>
      </Card.Body>
    </Card>
  )
}

function AddImagesFromGallery() {
  const artefact = useSelector(getSelectedArtefact)
  if (artefact === null) {
    return <>Loading ...</>
  }
  const artefactImageIds = useSelector(getSelectedArtefactImageIds)
  const galleryImages = useSelector(getGalleryImages).filter(image => !artefactImageIds.includes(image.id))

  const [fullscreen, setFullscreen] = useState(true);

  const [show, setShow] = useState(false);
  function handleClose() {
    setFullscreen(false);
    setShow(false);
  }
  function handleShow() {
    setFullscreen(true);
    setShow(true);
  }

  return (
    <>
      <Button variant="info" className="float-end" size={'sm'} onClick={handleShow}>
        <PhotoPlus size={22} strokeWidth={1} color={'black'}/> add images from gallery
      </Button>

      <Modal show={show} onHide={handleClose} fullscreen={fullscreen} bg={'Light'} >
        <Modal.Header closeButton>
          <Modal.Title>assign artefact images from gallery to <b>{artefact.name}</b></Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <h4>artefact images</h4>
          <p>if you click on an image it gets unassigned from the artefact</p>
          <Row xs={1} md={5} className="g-4" key={'modal_artefact_images'}>
            {artefact.images.map(image => <Col key={'modal_artefact_image_'+image.id} ><UnassignImage image={image} artefact={artefact} /></Col>)}
          </Row>
          <h4>gallery</h4>
          <p>if you click on an image it gets assigned to the artefact</p>
          <Row xs={1} md={5} className="g-4" key={'modal_gallery_images'}>
            {galleryImages.map(image => <Col key={'modal_gallery_image_'+image.id}><AssignImage image={image} /></Col>)}
          </Row>
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
          <Button variant="primary" onClick={handleClose}>
            Save Changes
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  )
}

function Gallery({images, keyPrefix = 'image_'}) {
  return <CardGroup>{images.map(image => <Image key={keyPrefix+image.id} image={image} />)}</CardGroup>
}

function MakePrimaryImageButton({image}) {
  const artefact = useSelector(getSelectedArtefact)
  if (artefact.primaryImage !== null && artefact.primaryImage.hasOwnProperty('id') && artefact.primaryImage.id === image.id) {
    return '';
  }

  const dispatch = useDispatch()
  function handleClick() {
    dispatch(updateArtefactPrimaryImage(artefact.slug, image.id))
  }
  return (
    <Button variant="info" className="float-end" size={'sm'} onClick={handleClick}>
      <PhotoStar size={22} strokeWidth={1} color={'white'}/>
    </Button>
  )
}

function Image({image}) {
  const [isPrimary, setIsPrimary] = useState(null);
  return (
    <Card className="bg-dark text-white" border="info">
      <Card.Img variant={'bottom'} src={"/uploads/assets/" + image.path} alt="" />
      <Card.ImgOverlay>
        <MakePrimaryImageButton image={image}/>
        <Card.Title>{image.description}</Card.Title>
        <Card.Text>created by {image.author} on {image.createdAt}</Card.Text>
      </Card.ImgOverlay>
    </Card>
  )
}

function Artefact({artefact}) {
  return (
    <Card bg={"dark"}>
      <PrimaryImage primaryImage={artefact.primaryImage} />
      <Card.Body>
        <Card.Title>{artefact.name}</Card.Title>
        <Card.Text>{artefact.description}</Card.Text>
      </Card.Body>
      <Card.Footer>
        <small className="text-muted">created by {artefact.createdBy} / {artefact.createdAt}</small>
      </Card.Footer>
      <Card.Footer>
        <AddImagesFromGallery />
      </Card.Footer>
      <Gallery images={artefact.images}/>
    </Card>
  )
}

function ArtefactDetail({artefact}) {
  if (artefact === null) {
    return <>Loading ...</>
  }

  useEffect(() => {
    runHolder('holderJs')
  })

  // set selected artefact
  const dispatch = useDispatch()
  dispatch(selectArtefactDetail(artefact.slug))

  return (
    <Container>
      <Row>
        <CardGroup>
          <Artefact key={'artefact_' + artefact.slug} artefact={artefact}/>
        </CardGroup>
      </Row>
    </Container>
  )
}

const mapStateToProps = function(state, ownProps) {
  const { slug } = ownProps
  return {
    artefact: getArtefact(state, slug)
  }
}
const mapDispatchToProps = {}

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactDetail)