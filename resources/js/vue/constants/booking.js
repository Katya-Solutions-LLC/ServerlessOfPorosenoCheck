export const MODULE = 'bookings'

//Booking module
export const INDEX_URL = () => {return {path: `${MODULE}/index_list`, method: 'GET'}}
export const EDIT_URL = (id) => {return {path: `${MODULE}/${id}/edit`, method: 'GET'}}
export const BOOKING_DETAIL = (id) => {return {path: `${MODULE}/${id}`, method: 'GET'}}
export const STORE_URL = () => {return {path: `${MODULE}`, method: 'POST'}}
export const UPDATE_URL = (id) => {return {path: `${MODULE}/${id}`, method: 'PUT'}}

//Payment module
export const CHECKOUT_URL = (id) => {return {path: `${MODULE}/${id}/checkout`, method: 'PUT'}}
export const PAYMENT_CREATE_URL = ({ booking_id }) => {return {path: `${MODULE}/payment-create?booking_id=${booking_id}`, method: 'GET'}}
export const PAYMENT_PUT_URL = (booking_id) => {return {path: `${MODULE}/booking-payment/${booking_id}`, method: 'PUT'}}
export const UPDATE_STATUS = (id) => {return {path: `${MODULE}/update-status/${id}`, method: 'POST'}} 

export const SLOT_LIST = ({date, branch_id}) => {return { path: `${MODULE}/slots?date=${date}&branch_id=${branch_id}`, method: 'GET',}}
export const UPDATE_PAYMENT_DATA = (booking_transaction_id) => {return {path: `${MODULE}/booking-payment-update/${booking_transaction_id}`, method: 'PUT'}}
export const STRIPE_PAYMENT_DATA = () => {return {path: `${MODULE}/stripe-payment`, method: 'POST'}}

// Price calculation
export const BOOKING_PRICE = ({type = ''}) => {return {path: `get-service-price?type=${type}`, method: 'GET'}}
export const TAX_DATA = () => {return {path: `tax/tax-list`, method: 'GET'}}

//User list
export const CUSTOMER_LIST = () => {return {path: `users/user-list?role=user`, method: 'GET'}}
export const EMPLOYEE_LIST = () => {return {path: `users/user-list?role=boarder`, method: 'GET'}}

// Pet module
export const PET_LIST = ({user_id = ''}) => {return {path: `pets/index_list?user_id=${user_id}`, method: 'GET'}}
export const FACILITY_LIST = () => {return {path: `service-facility/index_list`, method: 'GET'}}


// Boarding

// Veteranry module
export const VETERINARY_TYPE_LIST = () => {return {path: `categories/index_list?type=veterinary`, method: 'GET'}}
export const VET_LIST = ({service_id=''}) => {return {path: `users/user-list?role=vet&service_id=${service_id}`, method: 'GET'}}
// export const VETERINARY_SERVICE_LIST = () => {return {path: `services/index_list?type=veterinary`, method: 'GET'}}
export const VETERINARY_SERVICE_LIST = ({veterinarytype = ''}) => {return {path: `services/service_list?veterinarytype=${veterinarytype}`, method: 'GET'}}
export const SERVICE_PRICE = ({serviceid = ''}) => {return {path: `service-price?serviceid=${serviceid}`, method: 'GET'}}

// Grooming module
export const GROOMER_LIST = ({service_id=''}) => {return {path: `users/user-list?role=groomer&service_id=${service_id}`, method: 'GET'}}
export const GROOMING_SERVICE_LIST = () => {return {path: `services/index_list?type=grooming`, method: 'GET'}}

// Walking module
export const WALKER_LIST = () => {return {path: `users/user-list?role=walker`, method: 'GET'}}

// Daycare module
export const DAYCARE_TAKER_LIST = () => {return {path: `users/user-list?role=day_taker`, method: 'GET'}}

// Training module
export const TRAINING_LIST = () => {return {path: `service-training/index_list`, method: 'GET'}}
export const TRAINER_LIST = () => {return {path: `users/user-list?role=trainer`, method: 'GET'}}
export const DURATION_LIST = ({type = ''}) => {return {path: `service-duration/index_list?type=${type}`, method: 'GET'}}
export const DURATION_PRICE = ({duration_id = ''}) => {return {path: `service-duration/duration_price?duration_id=${duration_id}`, method: 'GET'}}

export const SERVICE_LIST = ({id: employee_id, branch_id}) => {return {path: `${MODULE}/services-index_list?employee_id=${employee_id}&branch_id=${branch_id}`, method: 'GET'}} 

