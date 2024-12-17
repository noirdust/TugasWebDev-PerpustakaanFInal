<script setup>
import { useUserStore } from "../stores/counter";
const store = useUserStore();
function increase() {
  store.thecounter++;
}
</script>
<template>
  <button type="button" @click="increase()" class="btn btn-danger">
    COUNTER IN BARANG
  </button>
  <h3 style="color: white;">Click to increase THE COUNTER</h3>
</template>
