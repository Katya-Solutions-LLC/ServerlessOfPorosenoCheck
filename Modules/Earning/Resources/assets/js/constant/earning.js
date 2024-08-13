export const MODULE = 'earnings'

export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const EDIT_URL = ({id, commission_type}) => {return {path: `${MODULE}/${id}/edit?commission_type=${commission_type}`, method: 'GET'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'PUT'}}

export const GET_EMPLOYEE_COMMISSSION_URL = ({id:id,type}) => {return {path: `${MODULE}/get-employee-commissions?id=${id}&type=${type}`, method: 'GET'}}

export const LISTING_URL = ({type}) => {return {path: `${MODULE}/get_search_data?type=${type}`, method: 'GET'}}