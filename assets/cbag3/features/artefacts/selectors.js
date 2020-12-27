export const getAllSlugs = state => state.artefacts.allIds
export const getAllArtefacts = state => state.artefacts.byId
export const getArtefactBySlug = (state, slug) => state.artefacts.byId[slug]