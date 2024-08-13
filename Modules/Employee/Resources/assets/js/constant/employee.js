export const MODULE = 'employees'
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const BRANCH_LIST = () => {return {path: `employees/index_list`, method: 'GET'}}
export const SERVICE_LIST = ({branch_id = '', category_id = '', employee_id = '', type = '' }) => {return {path: `service/index_list?branch_id=${branch_id}&employee_id=${employee_id}&category_id=${category_id}&type=${type}`, method: 'GET'}}
export const COMMISSION_LIST = ({type=''}) => {return {path: `commissions/index_list?type=${type}`, method: 'GET'}}
export const CHANGE_PASSWORD_URL = () => {return {path: `${MODULE}/change-password/`, method: 'POST'}}

export const SEND_PUSH_NOTIFICATION = () => {return {path: `${MODULE}/send-push-notification`, method: 'POST'}}







