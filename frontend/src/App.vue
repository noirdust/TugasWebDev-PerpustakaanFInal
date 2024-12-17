<script setup>
import { ref, computed } from "vue";
import FooterView from "./views/FooterView.vue";
import MenuView from "./views/MenuView.vue";
import { useRoute } from "vue-router";
const theroute = useRoute();
const isnotlogin = computed(() => {
  return theroute.name != "login" ? true : false;
});
</script>

<template>
  <div style="color: white;" class="d-flex flex-column min-vh-100 wdth bg-custom1">
    <MenuView v-if="isnotlogin" />
    <div style="margin-top: 65px">
      <router-view></router-view>
    </div>
    <FooterView v-if="isnotlogin" />
  </div>
</template>

<style>
.table {
  width: 100%;
}

.wdth {
  width: 90dvw;
}

.bg-custom1 {
  background-color: #111b24;
}
</style>
