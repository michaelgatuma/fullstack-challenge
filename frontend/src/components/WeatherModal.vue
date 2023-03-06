<script setup>
import {ref} from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
// import { CheckIcon } from "@heroicons/vue/outline";

// const open = ref(false);

defineProps({
  user: Array,
});
</script>
<template>
  <TransitionRoot as="template" :show="true">
    <Dialog
        as="div"
        class="fixed z-10 inset-0 overflow-y-auto"
    >
      <div
          class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
      >
        <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="ease-in duration-200"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
          <DialogOverlay
              class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span
            class="hidden sm:inline-block sm:align-middle sm:h-screen"
            aria-hidden="true"
        >&#8203;</span
        >
        <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
              class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6"
          >
            <div>
              <!--              <div-->
              <!--                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-800"-->
              <!--              >-->
              <!--                  <img src="https://openweathermap.org/themes/openweathermap/assets/img/logo_white_cropped.png" alt="">-->
              <!--              </div>-->
              <div class="mt-3 text-center sm:mt-5">
                <DialogTitle
                    as="h3"
                    class="text-lg leading-6 font-medium text-blue-900"
                >
                  Detailed Weather Report
                </DialogTitle>
                <div class="mt-2 text-left">
                  <div class="my-6">
                    <div class="text-3xl font-semibold">{{ user.name }}</div>
                    <div class="text-gray-600">{{ user.email }}</div>
                  </div>
                  <div
                      class="bg-gray-900 text-white relative min-w-0 break-words rounded-lg overflow-hidden shadow-sm mb-4 w-full bg-white dark:bg-gray-600">
                    <div class="px-6 py-6 relative">
                      <div class="flex mb-4 justify-between items-center">
                        <div>
                          <h5 class="mb-0 font-medium text-xl">{{
                              (((user || {}).weather || {}).data || {}).name === ""
                                  ? "-"
                                  : (((user || {}).weather || {}).data || {}).name
                            }}</h5>
                          <h6 class="mb-0">{{ user.latitude }},{{ user.longitude }}</h6>
                          <small>{{
                              ((((user || {}).weather || {}).data || {}).weather[0] || {}).main
                            }}
                          </small>
                          <br>
                          <small class="text-gray-400">{{
                              ((((user || {}).weather || {}).data || {}).weather[0] || {}).description
                            }}
                          </small>
                        </div>
                        <div class="flex justify-center gap-2 items-end">
                          <h3 class="font-bold text-4xl mb-0">
                            <span>{{ ((((user || {}).weather || {}).data || {}).main || {}).temp }}&deg;</span></h3>
                          <div class="bg-gray-400 rounded-lg">
                            <img
                                :src="
            'http://openweathermap.org/img/wn/' +
            ((((user || {}).weather || {}).data || {}).weather[0] || {}).icon +
            '@2x.png'
          "
                                class="block w-12 h-12"
                                alt="weather-icon"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="block sm:flex justify-between items-center flex-wrap">
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Temp</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).temp
                            }}&nbsp;&deg;C</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Feels like</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).feels_like
                            }}&nbsp;&deg;C</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Temp min</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).temp_min
                            }}&nbsp;&deg;C</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Temp max</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).temp_max
                            }}&nbsp;&deg;C</small></div>
                        </div>
                      </div>
                      <div class="divider table whitespace-nowrap my-2"><span
                          class="inline-block text-orange-400"><small>Atmosphere</small></span></div>
                      <div class="block sm:flex justify-between items-center flex-wrap">
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Pressure</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).pressure
                            }}</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Humidity</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).humidity
                            }} %</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Sea level</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).sea_level
                            }}</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Ground Level</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).main || {}).grnd_level
                            }}</small></div>
                        </div>
                      </div>
                      <div class="divider table whitespace-nowrap my-2"><span
                          class="inline-block text-orange-400"><small>Vision</small></span></div>
                      <div class="block sm:flex justify-between items-center flex-wrap">
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Visibility</span><small
                              class="px-2 inline-block">{{
                              (
                                  (((user || {}).weather || {}).data || {}).visibility / 1000
                              ).toFixed(1)
                            }}km</small></div>
                        </div>
                      </div>
                      <div class="divider table whitespace-nowrap my-2"><span
                          class="inline-block text-orange-400"><small>Wind</small></span></div>
                      <div class="block sm:flex justify-between items-center flex-wrap">
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Speed</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).wind || {}).speec
                            }}</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Degree</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).wind || {}).deg
                            }}&deg;</small></div>
                        </div>
                        <div class="w-full sm:w-1/2">
                          <div class="flex mb-2 justify-between items-center"><span>Gust</span><small
                              class="px-2 inline-block">{{
                              ((((user || {}).weather || {}).data || {}).wind || {}).gust
                            }}m/s</small></div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6 text-center">
              <button
                  type="button"
                  @click="$emit('close')"
                  class="inline-flex justify-center w-sm rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm"
              >
                Go back to dashboard
              </button>
            </div>
          </div>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
