import React,  { useState, useEffect, useCallback } from 'react'
import { connect, useDispatch, useSelector } from 'react-redux'
import { Button, Card, CardGroup, Container, Row } from "react-bootstrap"
import { updateArtefactPrimaryImage, selectArtefactDetail } from './actions'
import { getArtefact, getSelectedArtefact } from './selectors'
import { useParams } from "react-router-dom";
import {run as runHolder} from "holderjs";
import { PhotoStar } from 'tabler-icons-react';

function PrimaryImage({primaryImage}) {
  if (primaryImage === null) {
    return <Card.Img variant="top" data-src="holder.js/100px250?text=primary image missing&bg=434a52&fg=3d688f" fluid="true" />
  }
  return <Card.Img variant="top" src={"/uploads/assets/"+primaryImage.path} />
}

function Images({images}) {
  return <CardGroup>{images.map(image => <Image key={'image_'+image.id} image={image} />)}</CardGroup>
}

function MakePrimaryImageButton({image}) {
  const artefactId = useSelector(getSelectedArtefact)
  const dispatch = useDispatch()
  function handleClick() {
    dispatch(updateArtefactPrimaryImage(artefactId, image.id))
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
      <Images images={artefact.images}/>
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