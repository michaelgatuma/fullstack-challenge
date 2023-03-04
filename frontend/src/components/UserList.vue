<script setup lang="ts">
import { onMounted, ref } from "vue";

const users = ref([]);

onMounted(() => {
  fetch("http://localhost")
    .then((request) => request.json())
    .then((data) => (users.value = data.users));
});
</script>

<template>
  <div class="bg-gray-50 rounded-lg shadow px-5 py-6 sm:px-6 grid grid-cols-1 gap-6">
    <div v-for="user in users" :key="user.id" class="border border-gray-200 shadow-sm bg-white rounded-md px-4 py-4 flex justify-between items-center">
      <div>
        <div class="text-2xl text-gray-700 font-semibold mb-0.5">{{ user.name }}</div>
        <div class="text-lg text-gray-600 italic">{{user.email}}</div>
      </div>
      <div class="text-end">
        <div class="text-3xl">27^F</div>
        <div class="text-sm text-gray-500">{{ 'LAT: '+user.latitude }},{{'LONG: '+ user.longitude }}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>