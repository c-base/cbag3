

export const initGallery = (artefacts) => ({
  type: 'GALLERY_INIT',
  payload: {
    artefacts
  }
})
export const initGalleryDone = () => ({
  type: 'GALLERY_INIT_DONE'
})
