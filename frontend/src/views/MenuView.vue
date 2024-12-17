<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/counter";
import { storeToRefs, createPinia } from "pinia";

const pini = createPinia();
const store = useUserStore();
const { thecounter } = storeToRefs(store);
const therouter = useRouter();

const customConfig = {
  Authorization: "Bearer " + store.token,
};

function logout() {
  axios({
    url: "http://localhost:8000/api/logout",
    method: "get",
    headers: customConfig,
  })
    .then((response) => {
      console.log(response.data); //only for development
      if (response.data.success === true) {
        store.reset();
        therouter.push("/");
      }
    })
    .catch((error) => {
      console.log("AJAX" + error);
    })
    .finally();
}
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-custom2 fixed-top">
    <div class="container">
      <!-- Brand and Dropdown -->
      <div class="dropdown">
        <a
          class="navbar-brand dropdown-toggle"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <font-awesome-icon icon="book" class="me-2" />
        </a>
        <ul class="dropdown-menu">
          <li>
            <router-link to="/buku" class="dropdown-item">Buku</router-link>
          </li>
          <li>
            <router-link to="/peminjaman" class="dropdown-item"
              >Peminjaman</router-link
            >
          </li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <router-link to="/pembelian" class="dropdown-item"
              >Pembelian</router-link
            >
          </li>
        </ul>
      </div>

      <!-- Toggle button for mobile -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link to="/barang" class="nav-link" active-class="active"
              >Barang</router-link
            >
          </li>
          <li class="nav-item">
            <router-link to="/pegawai" class="nav-link" active-class="active"
              >Pegawai</router-link
            >
          </li>
        </ul>

        <!-- Right side of navbar -->
        <div class="d-flex align-items-center">
          <span class="text-light me-3">Test counter (global state): {{ thecounter }}</span>
          <button @click="logout" class="btn btn-outline-light">
            <font-awesome-icon icon="sign-out-alt" class="me-2" />
            Logout
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.bg-custom2 {
  background-color: #eb6134;
}

.navbar {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav-link.active {
  font-weight: bold;
}

.nav-link {
  transition: color 0.2s ease-in-out;
}

.nav-link:hover {
  color: #fff !important;
  opacity: 0.8;
}

.dropdown-menu {
  margin-top: 0.5rem;
  border: none;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.dropdown-item {
  padding: 0.5rem 1.5rem;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}
</style>
