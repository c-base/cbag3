

export const initGallery = (images) => ({
  type: 'GALLERY_INIT',
  payload: {
    images
  }
})
export const initGalleryDone = () => ({
  type: 'GALLERY_INIT_DONE'
})

export const initGalleryFail = (error) => ({
  type: 'GALLERY_INIT_FAIL',
  payload: { error }
})

export const showGalleryImageUploadModal = () => ({
  type: 'GALLERY_IMAGE_UPLOAD_MODAL_SHOW'
})

export const closeGalleryImageUploadModal = () => ({
  type: 'GALLERY_IMAGE_UPLOAD_MODAL_CLOSE'
})

export const uploadGalleryImage = (data) => ({
  type: 'GALLERY_IMAGE_UPLOAD',
  payload: {
    ...data,
    image: data.image[0]
  }
})

export const uploadGalleryImageDone = ({image}) => ({
  type: 'GALLERY_IMAGE_UPLOAD_DONE',
  payload: {
    image
  }
})

export const uploadGalleryImageFail = (error) => ({
  type: 'GALLERY_IMAGE_UPLOAD_FAIL',
  payload: { error }
})


