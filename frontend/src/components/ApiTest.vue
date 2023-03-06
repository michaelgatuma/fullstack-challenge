<script setup>
import {onBeforeMount, ref} from "vue";

let apiResponse = ref(null);

async function fetchData() {
  const url = "http://localhost/";
  apiResponse.value = await (await fetch(url)).json();
}

onBeforeMount(() => {
  fetchData();
});
</script>

<template>
  <div v-if="!apiResponse">
    Pinging the api...
  </div>

  <div v-if="apiResponse">
    The api responded with: <br/>
    <code>
      {{ apiResponse }}
    </code>
  </div>
</template>