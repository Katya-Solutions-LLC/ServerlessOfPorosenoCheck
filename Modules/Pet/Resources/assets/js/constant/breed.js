export const MODULE = 'breed'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const PETTYPE_LIST = ({type = 'select',id = null}) => {return {path: `pettype/index_list`, method: 'GET'}}