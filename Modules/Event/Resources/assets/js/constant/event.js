export const MODULE = 'events'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const USER_LIST = ({type = 'select',id = null}) => {return {path: `users/organizer_list`, method: 'GET'}}