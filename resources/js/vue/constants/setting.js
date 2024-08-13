export const STORE_URL = () => {return {path: `settings`, method: 'POST'}}
export const GET_URL = (data) => {return {path: `settings-data?fields=${data}`, method: 'GET'}}

export const GET_URL1 = () => {return {path: `settings-data`, method: 'GET'}}

export const CACHE_CLEAR = () => {return {path: `clear-cache`, method: 'GET'}}

export const RELOAD_DATABASE = () => {return {path: `reload-database`, method: 'GET'}}

export const GET_NOTIFICATION_URL = () => {return {path: `notifications-templates/index_list`, method: 'GET'}}

export const CHANNEL_UPDATE_URL = () => {return {path: `notifications-templates/channels-update`, method: 'POST'}}

export const TIME_ZONE_LIST = ({type = ''}) => {return {path: `get_search_data?type=${type}`, method: 'GET'}}

export const VERIFIED_EMAIL = (mailObject) => { return { path: `verify-email`, method: 'POST', request: mailObject  };};

export const CURRENCY_LIST = () => {return {path: `currencies/index_list`, method: 'GET'}}

