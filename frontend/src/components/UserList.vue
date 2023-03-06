<script setup>
import { onMounted, reactive, ref } from "vue";
import { useAlert } from "@/composables/useAlert";
import WeatherModal from "@/components/WeatherModal.vue";

let { alert } = useAlert();

const users = ref([]);
const selectedUser = ref(false);

function showModal(user) {
  selectedUser.value = user;
}

function closeModal() {
  selectedUser.value = null;
}

async function fetchUsers() {
  const url = "http://localhost/users?weather=true";
  let response = await (await fetch(url)).json();
  users.value = response.data;
  console.log(response.data);
}

onMounted(() => {
  fetchUsers();
  setTimeout(() => {
    if (users.value.length === 0) {
      alert(
          "Experiencing Difficulties",
          "We are unable to fetch user weather reports at the moment! Kindly try again later",
          "warning"
      );
    }
  }, 3000);
});
</script>

<template>
  <div
      v-if="users.length > 0"
      class="bg-gray-100 rounded-lg shadow px-5 py-6 sm:px-6 grid grid-cols-3 gap-6"
  >
    <div
        v-for="user in users"
        :key="user.id"
        @click="showModal(user)"
        class="flex flex-col bg-white rounded-xl shadow p-4 w-full max-w-xs cursor-pointer"
    >
      <div
          class="text-6xl self-center inline-flex items-center justify-center rounded-lg text-indigo-400 h-24 w-24"
      >
        <img
            :src="'http://openweathermap.org/img/wn/' +
            ((((user || {}).weather || {}).data || {}).weather[0] || {}).icon +
            '@2x.png'
          "
            alt="weather-icon"
        />
      </div>
      <div class="flex flex-row items-center justify-center mt-6">
        <div class="font-medium text-6xl">
          {{ ((((user || {}).weather || {}).data || {}).main || {}).temp }}°
        </div>
        <div class="flex flex-col items-center ml-6">
          <div>
            {{
              ((((user || {}).weather || {}).data || {}).weather[0] || {}).main
            }}
          </div>
          <div class="mt-1">
            <span class="text-sm"><i class="far fa-long-arrow-up"></i></span>
            <span class="text-sm font-light text-gray-500"
            >{{
                ((((user || {}).weather || {}).data || {}).main || {}).temp_max
              }}°C</span
            >
          </div>
          <div>
            <span class="text-sm"><i class="far fa-long-arrow-down"></i></span>
            <span class="text-sm font-light text-gray-500"
            >{{
                ((((user || {}).weather || {}).data || {}).main || {}).temp_min
              }}°C</span
            >
          </div>
        </div>
      </div>
      <div class="flex flex-row justify-between mt-6">
        <div class="flex flex-col items-center">
          <div class="font-medium text-sm">Wind</div>
          <div class="text-sm text-gray-500">
            {{
              ((((user || {}).weather || {}).data || {}).wind || {}).speed
            }}k/h
          </div>
        </div>
        <div class="flex flex-col items-center">
          <div class="font-medium text-sm">Humidity</div>
          <div class="text-sm text-gray-500">
            {{
              ((((user || {}).weather || {}).data || {}).main || {}).humidity
            }}%
          </div>
        </div>
        <div class="flex flex-col items-center">
          <div class="font-medium text-sm">Visibility</div>
          <div class="text-sm text-gray-500">
            {{
              (
                  (((user || {}).weather || {}).data || {}).visibility / 1000
              ).toFixed(1)
            }}km
          </div>
        </div>
      </div>
      <div class="mt-6">
        <div class="font-bold text-xl">{{ user.name }}</div>
        <div class="text-sm text-gray-500 italic">
          {{
            (((user || {}).weather || {}).data || {}).name === ""
                ? "-"
                : (((user || {}).weather || {}).data || {}).name
          }}
        </div>
      </div>
    </div>
  </div>
    <weather-modal :user="selectedUser" v-if="selectedUser" @close="closeModal" />
</template>

<style scoped></style>
