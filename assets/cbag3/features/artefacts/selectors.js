export const getAllSlugs = state => state.artefacts.allIds
export const getAllArtefacts = state => state.artefacts.byId
export const getArtefactBySlug = (state, slug) => state.artefacts.byId[slug]
export const getAllArtefactImages = state => {
  let assets = []
  getAllSlugs(state).map(slug => {
    let artefactAssets = getArtefactBySlug(state, slug).assets
    artefactAssets.map(asset => {
      asset.artefactSlug = slug
      asset.title = asset.title == "" ? asset.description : asset.title
    })
    assets = [...assets, ...artefactAssets]
  })
  return assets
}