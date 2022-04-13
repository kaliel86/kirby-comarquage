<template>
  <k-button :icon="icon" @click="onClick">{{ label }}</k-button>
</template>

<script>
export default {
  props: {
    label: String,
    icon: String
  },
  methods: {
    onClick(event) {
      alert('yolo');
    }
  }
}
</script>
