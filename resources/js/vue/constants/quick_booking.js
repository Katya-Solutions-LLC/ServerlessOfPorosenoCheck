
export const SERVICE_LIST = () => {return {path: `api/quick-booking/services-list`, method: 'GET'}}
export const BRANCH_LIST = ({employee_id, service_id, start_date_time}) => {return {path: `api/quick-booking/branch-list?employee_id=${employee_id}&service_id=${service_id}&start_date_time=${start_date_time}`, method: 'GET'}}
export const EMPLOYEE_LIST = ({branch_id,service_id, start_date_time}) => {return {path: `api/quick-booking/employee-list?branch_id=${branch_id}&service_id=${service_id}&start_date_time=${start_date_time}`, method: 'GET'}}
export const SLOT_TIME_LIST = ({branch_id, date, service_id, employee_id}) => {return {path: `api/quick-booking/slot-time-list?branch_id=${branch_id}&date=${date}&employee_id=${employee_id}&service_id=${service_id}`, method: 'GET'}}
export const STORE_URL = () => {return {path: `api/quick-booking/store`, method: 'POST'}}

export const VERIFY_CUSTOMER = () => {return {path: `api/quick-booking/verify_customer`, method: 'POST'}}
export const STORE_CUSTOMER = () => {return {path: `api/quick-booking/store_customer`, method: 'POST'}}
export const PETTYPE_LIST = ({type = 'select',id = null}) => {return {path: `api/quick-booking/pettype_list`, method: 'GET'}}
export const BREED_LIST = ({id = null}) => {return {path: `api/quick-booking/breed_list?pettype_id=${id}`, method: 'GET'}}

export const STORE_PET = () => {return {path: `api/quick-booking/store_pet`, method: 'POST'}}


// Veteranry module
export const VETERINARY_TYPE_LIST = () => {return {path: `api/quick-booking/index_list?type=veterinary`, method: 'GET'}}
export const VET_LIST = ({service_id=''}) => {return {path: `api/quick-booking/user-list?role=vet&service_id=${service_id}`, method: 'GET'}}
// export const VETERINARY_SERVICE_LIST = () => {return {path: `services/index_list?type=veterinary`, method: 'GET'}}
export const VETERINARY_SERVICE_LIST = ({veterinarytype = ''}) => {return {path: `api/quick-booking/service_list?veterinarytype=${veterinarytype}`, method: 'GET'}}
export const SERVICE_PRICE = ({serviceid = ''}) => {return {path: `api/quick-booking/service-price?serviceid=${serviceid}`, method: 'GET'}}

export const TAX_DATA = () => {return {path: `api/quick-booking/tax-list`, method: 'GET'}}

export const BOOKING_STORE_URL = () => {return {path: `api/quick-booking/store_booking`, method: 'POST'}}

export const GET_BOOKING_DATA = (id) => {return {path: `api/quick-booking/get_booking/${id}`, method: 'GET'}}

export const GROOMER_LIST = ({service_id=''}) => {return {path: `api/quick-booking/user-list?role=groomer&service_id=${service_id}`, method: 'GET'}}
export const GROOMING_SERVICE_LIST = () => {return {path: `api/quick-booking/service_index_list?type=grooming`, method: 'GET'}}
