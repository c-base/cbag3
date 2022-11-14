

export const initGallery = (artefacts) => ({
  type: 'GALLERY_INIT',
  payload: {
    artefacts
  }
})
export const initGalleryDone = () => ({
  type: 'GALLERY_INIT_DONE'
})

export const uploadGalleryImage = (image) => ({
  type: 'GALLERY_IMAGE_UPLOAD',
  payload: {
    image
  }
})

export const uploadGalleryImageDone = (image) => ({
  type: 'GALLERY_IMAGE_UPLOAD_DONE',
  payload: {
    image
  }
})

export const uploadGalleryImageFail = (error) => ({
  type: 'GALLERY_IMAGE_UPLOAD_FAIL',
  payload: { error }
})


