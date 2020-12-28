import React from 'react'
import { connect } from 'react-redux'

import {
  Carousel
} from 'react-bootstrap'
import { getAllArtefactImages } from '../selectors'

function ArtefactGallery({assets}) {
  return (
    <>
      <AssetGallery assets={assets} />
    </>
  )
}

export function AssetGallery({assets}) {
  if (assets.length == 0) {
    return ''
  }

  return (
    <Carousel>
      {assets.map(asset => (
        <Carousel.Item key={asset.uuid}>
          <img
            src={asset.url}
            alt={asset.description}
            style={{
               maxWidth: window.screen.width - 100,
               maxHeight: window.screen.height - 200,
               height: 'auto',
               margin: 'auto'
              }}
          />
          <Carousel.Caption>
            <h3>{asset.title}</h3>
            <p>{asset.description}</p>
            <p>author: {asset.author} / license: {asset.licence}</p>
          </Carousel.Caption>
        </Carousel.Item>
      ))}
    </Carousel>
  )
}

const mapStateToProps = (state) => ({
  assets: getAllArtefactImages(state)
})

const mapDispatchToProps = dispatch => ({})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactGallery)