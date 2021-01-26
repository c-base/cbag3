import React, { useState } from 'react'
import { connect } from 'react-redux'
import { requestArtefactAssetEdit } from '../actions'
import ArtefactAssetForm from './ArtefactAssetForm'


function ArtefactAssetEdit({ handleSubmit }) {
  return (
    <ArtefactAssetForm handleSubmit={handleSubmit}/>
  )
}

const mapStateToProps = (state) => ({
})
const mapDispatchToProps = dispatch => ({
  handleSubmit: asset => dispatch(requestArtefactAssetEdit(asset))
})

export default connect(mapStateToProps, mapDispatchToProps)(ArtefactAssetEdit)