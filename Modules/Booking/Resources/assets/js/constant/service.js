export const MODULE = 'services'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const CATEGORY_LIST = ({type = 'select',id = null}) => {return {path: `categories/index_list?type=${type}&parent_id=${id}`, method: 'GET'}}
export const EMPLOYEE_LIST = ({branch_id, type}) => {return {path: ` ${MODULE}/employee_list?branch_id=${branch_id}&type=${type}`, method: 'GET'}}
export const BRANCH_LIST = () => {return {path: `branch/index_list`, method: 'GET' }}
// Employee Assign
export const GET_EMPLOYEE_ASSIGN_URL = (id) => {return {path: `${MODULE}/assign-employee/${id}`, method: 'GET'}}
export const POST_EMPLOYEE_ASSIGN_URL = (id) => {return {path: `${MODULE}/assign-employee/${id}`, method: 'POST'}}

// Branch Assign
export const GET_BRANCH_ASSIGN_URL = (id) => {return {path: `${MODULE}/assign-branch/${id}`, method: 'GET'}}
export const POST_BRANCH_ASSIGN_URL = (id) => {return {path: `${MODULE}/assign-branch/${id}`, method: 'POST'}}

// Gallery Assign
export const GET_GALLERY_URL = (id) => {return {path: `${MODULE}/gallery-images/${id}`, method: 'GET'}}
export const POST_GALLERY_URL = (id) => {return {path: `${MODULE}/gallery-images/${id}`, method: 'POST'}}
export const SYSTEM_SERVICE_EDIT_URL = (id) => {return {path: `systemservice/${id}/edit`, method: 'GET'}}
export const SYSTEM_SERVICE_UPDATE_URL = (id) => {return {path: `systemservice/${id}`, method: 'POST'}}




