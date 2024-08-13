export const MODULE = 'bussinesshours'
export const LISTING_URL = ({branch_id, type}) => {return {path: `bussinesshours/index_list?branch_id=${branch_id}&type=${type}`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
