
export const getGalleryImages = (state) => state.gallery.allIds.map(id => state.gallery.byId[id])
export const countGalleryImages = (state) => state.gallery.allIds.length
export const showGalleryUploadModal = (state) => state.gallery.showUploadModal
