export const MODULE = 'pets'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const PETTYPE_LIST = ({type = 'select',id = null}) => {return {path: `pet/pettype/index_list`, method: 'GET'}}
export const USER_LIST = ({type = 'select',id = null}) => {return {path: `users/owner_list`, method: 'GET'}}

export const BREED_LIST = ({id = null}) => {return {path: `pet/breed/index_list?pettype_id=${id}`, method: 'GET'}}
export const GET_USER_PET_URL = (id) => {return {path: `${MODULE}/user_pet_list/${id}`, method: 'GET'}}
export const DELETE_PET = (id) =>{return {path: `${MODULE}/${id}`, method: 'DELETE'}}
