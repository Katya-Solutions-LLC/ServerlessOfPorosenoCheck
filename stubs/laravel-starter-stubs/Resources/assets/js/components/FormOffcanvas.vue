<template>
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="form-offcanvasLabel">
                <template v-if="currentId !== 0">
                    {{editTitle}}
                </template>
                <template v-else>
                    {{createTitle}}
                </template>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form @submit="formSubmit">
            <div class="offcanvas-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" v-model="name" id="name">
                            <span v-if="errorMessages['name']">
                                <ul class="text-danger">
                                    <li v-for="err in errorMessages['name']" :key="err">{{ err }}</li>
                                </ul>
                            </span>
                            <span class="text-danger">{{ errors.name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-grid gap-3 p-3">
                    <button class="btn btn-primary d-block">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save
                    </button>
                    <button class="btn btn-outline-primary d-block" type="button" data-bs-dismiss="offcanvas">
                        <i class="fa-solid fa-angles-left"></i>
                        Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import { ref, watch, inject } from 'vue'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../constant'
import { useField, useForm } from 'vee-validate';
;
import * as yup from 'yup';;

// props
defineProps({
    createTitle: {
      type: String,
      default: ''
    },
    editTitle: {
      type: String,
      default: ''
    }
})

// Validations
const validationSchema = yup.object({
    name: yup.string().required()
})
const { handleSubmit, errors,resetForm } = useForm({
    validationSchema,
});
const { value: name } = useField('name');
const errorMessages = ref({})

// Api Call for EDIT, STORE, UPDATE REQUEST FUNCTION
const createRequest = inject('createRequest')
const getRequest = async (id) => {
    return createRequest(EDIT_URL(id))
}
const storeRequest = async (values) => {
    return createRequest(STORE_URL(), {}, values)
}
const updateRequest = async (id,values) => {
    return createRequest(UPDATE_URL(id), {}, values)
}

// Default FORM DATA
const defaultData =  () => {
    errorMessages.value = {}
    return {
        name: '',
    }
}

//  Reset Form
const setFormData = (data) => {
    resetForm({
    values: {
      name: data.name,
    },
  });
}

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const reset_datatable_close_offcanvas = (message) => {
    window.successSnackbar(message)
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#form-offcanvas').hide()
    setFormData(defaultData())
}

// Form Submit
const formSubmit = handleSubmit((values) => {
    if(currentId.value > 0) {
        updateRequest(currentId.value, values).then(res => {
            if(res.status) {
                reset_datatable_close_offcanvas(res.message)
            } else {
                window.errorSnackbar(res.message)
                errorMessages.value = res.all_message
            }
        })
    } else {
        storeRequest(values).then(res => {
            if(res.status) {
                reset_datatable_close_offcanvas(res.message)
            } else {
                window.errorSnackbar(res.message)
                errorMessages.value = res.all_message
            }
        }
        ).catch(err => console.log(err))
    }
})

// Module Current ID Logic
const currentId = ref(0)
document.addEventListener('crud_change_id', function (e) {
    currentId.value = e.detail.form_id
})
watch(currentId, () => {
    if (currentId.value > 0) {
        getRequest(currentId.value).then((res) => {
            if (res.status) {
                setFormData(res.data)
            }
        })
    } else {
        setFormData(defaultData())
    }
}, {deep: true})

</script>
