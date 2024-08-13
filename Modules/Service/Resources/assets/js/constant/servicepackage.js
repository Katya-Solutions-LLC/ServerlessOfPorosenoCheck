export const MODULE = 'servicepackage'

export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'POST'}}
export const EMPLOYEE_LIST = ({type = 'select',id = null}) => {return {path: `servicepackage/index_list_data?type=${type}&parent_id=${id}`, method: 'GET'}}
export const CATEGORY_LIST = ({type = 'select',id = null}) => {return {path: `servicepackage/category_list?type=${type}&parent_id=${id}`, method: 'GET'}}
export const CATEGORY_SERVICE_LIST = (category_id) => {return {path: `category_service_list?category_id=${category_id}`, method: 'GET'}}
//export const SERVICE_LIST = (employee_id,category_id=null) => {return {path: `index_list?employee_id=${employee_id}&category_id=${category_id}`, method: 'GET'}}
export const SERVICE_LIST = ({employee_id, category_id = null}) => {
    let url = `index_list?employee_id=${employee_id}`;
    if (category_id) {
      url += `&category_id=${category_id}`;
    }
    return { path: url, method: 'GET' };
  };
