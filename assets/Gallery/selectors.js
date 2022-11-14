
export const getGalleryImages = (state) => state.gallery.allIds.map(id => state.gallery.byId[id])
export const getGalleryImagesDeluxe = (state) => {
  const artefactImages = getArtefactImages(state)
  return state.gallery.allIds.map(id => {
    return {...state.gallery.byId[id], artefacts: artefactImages.hasOwnProperty(id) ? artefactImages[id] : []}
  })
}
export const getArtefactImages = (state) => {
  let artefactImages = {}
  state.artefact.allIds.forEach(artefactId => {
    state.artefact.byId[artefactId].images.map(image => {
      if (!artefactImages.hasOwnProperty(image.id)) {
        artefactImages[image.id] = []
      }
      artefactImages[image.id] = [...artefactImages[image.id], artefactId]
    })
  })
  return artefactImages
}



export const countGalleryImages = (state) => state.gallery.allIds.length
