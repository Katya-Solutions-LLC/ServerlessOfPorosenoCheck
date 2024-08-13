import { defineStore } from 'pinia'

export const useQuickBooking = defineStore('quickBooking', {
    state: () => ({

        user : {
            "profile_image": null,
            "email": null,
            "first_name": null,
            "last_name": null,
            "mobile": null,
            "gender" : null
         },

        booking: {
            "booking_id": null,
            "service_id": null,
            "user_id": null,
            "pet": null,
        },
        bookingResponse: null
       
    }),
    actions: {

        updateUserValues(payload) {
            this.user[payload.key] = payload.value
        },
      
        updateBookingValues(payload) {
            this.booking[payload.key] = payload.value
        },
       
        updateBookingResponse (payload) {
            this.bookingResponse = payload
        },
     
        resetState () {
            // this.bookingResponse = null
            // this.booking = {
            //     "booking_id": null,
            //     "service_id": null,
            //     "user_id": null,
            //     "pet": null,
            // }
            
            // this.user = {
            //     "profile_image": null,
            //     "email": null,
            //     "first_name": null,
            //     "last_name": null,
            //     "mobile": null,
            //     "gender" : null,
             
            // }

        
        }
    }
  })
