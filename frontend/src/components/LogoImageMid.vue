<script setup>
import { RouterLink } from "vue-router";
import logoImage from '../assets/images/logoMYGI.png'

</script>

<template>
    <RouterLink :to="{ name: 'HomeGuest' }">
      <img
        class="h-64 w-64"
        :src="logoImage"
      />
    </RouterLink>
</template>

<style scoped></style>
