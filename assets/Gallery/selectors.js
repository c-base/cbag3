
export const getGalleryImages = (state) => state.gallery.allIds.map(id => state.gallery.byId[id])