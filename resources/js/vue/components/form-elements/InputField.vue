<template>
  <div class="form-group">
    <label class="form-label" :for="label"> {{ label }} <span v-if="isRequired" class="text-danger">*</span> </label>
    <input :type="type" class="form-control" :id="label" :value="modelValue" @input="updateModelValue" :placeholder="placeholder" :disabled="isDisabled" />
    <span class="text-danger">{{ errorMessage }}</span>
    <ul class="m-0">
      <li class="text-danger" v-for="msg in errorMessages" :key="msg">{{ msg }}</li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  isLabel: { type: Boolean, default: true },
  isRequired: { type: Boolean, default: false },
  label: { type: String, default: '' },
  type: { type: String, default: 'text' },
  modelValue: '',
  placeholder: { type: String, default: '' },
  errorMessage: { type: String, default: '' },
  errorMessages: { type: Array, default: () => [] },
  isDisabled: { type: Boolean, default: false }
})

const emit = defineEmits(['update:modelValue'])

const updateModelValue = (e) => emit('update:modelValue', e.target.value)
</script>
