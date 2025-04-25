<script setup>
import { RouterLink } from "vue-router";
import logoImage from '../assets/images/logoMYGI.png'

</script>

<template>
    <RouterLink :to="{ name: 'HomeGuest' }">
      <img
        class="h-12 w-12"
        :src="logoImage"
      />
    </RouterLink>
</template>

<style scoped></style>
