<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/counter";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
const therouter = useRouter();
const auth = ref(null);
const username = ref("");
const password = ref("");
const store = useUserStore();

const customConfig = {
  "Content-Type": "application/json",
};

const bodyParameters = computed(() => {
  return { email: username.value, password: password.value };
});

function login() {
  axios({
    url: "http://localhost:8000/api/login",
    method: "post",
    data: bodyParameters.value,
    headers: customConfig,
  })
    .then((response) => {
      auth.value = response.data;
      console.log(response.data); //only for development
      if (auth.value.success === true) {
        store.email = username.value;
        store.token = auth.value.data;
        store.thecounter++;
        therouter.push("/menu");
      }
    })
    .catch((error) => {
      console.log("AJAX" + error);
    })
    .finally();
}
</script>

<template>
  <div class="container-fluid">
    <div class="justify-content-center min-vh-100 wdth align-items-center">
      <div class="card shadow">
        <div class="card-body p-5">
          <div class="text-center mb-4">
            <h2 class="font-weight-bold">Login</h2>
          </div>

          <form @submit.prevent="login">
            <div class="mb-3">
              <label for="username" class="form-label">
                <font-awesome-icon icon="envelope" class="me-2" />
                Email
              </label>
              <input
                type="email"
                class="form-control"
                id="username"
                v-model="username"
                required
                placeholder="Enter your email"
                autocomplete="email"
              />
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">
                <font-awesome-icon icon="lock" class="me-2" />
                Password
              </label>
              <input
                type="password"
                class="form-control"
                id="password"
                v-model="password"
                required
                placeholder="Enter your password"
                autocomplete="current-password"
              />
            </div>

            <button
              type="submit"
              class="btn btn-primary w-100 mb-3"
              :disabled="!username || !password"
            >
              <font-awesome-icon icon="sign-in-alt" class="me-2" />
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border: none;
  border-radius: 15px;
  background-color: #eb6134;
  color: #fff;
}

.form-control {
  padding: 0.75rem 1rem;
  border-radius: 8px;
}

.form-control:focus {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-weight: 500;
}

.btn-primary {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.btn-primary:hover {
  background-color: #0b5ed7;
  border-color: #0a58ca;
}

.wdth {
  width: 30dvw;
}
</style>
