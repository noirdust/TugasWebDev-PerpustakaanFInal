<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { useUserStore } from "../stores/counter";

const isbn = ref("");
const judul = ref("");
const pengarang = ref("");
const tahun = ref(2020);
const isbn_readonly = ref(false);

const route = useRoute();
const router = useRouter();
const store = useUserStore();

const customConfig = {
  "Content-Type": "application/json",
  Authorization: "Bearer " + store.token,
};

const thedata = computed(() => ({
  isbn: isbn.value,
  judul: judul.value,
  pengarang: pengarang.value,
  tahun: tahun.value,
}));

function save() {
  const action = route.params.theisbn !== "" ? "update" : "store";
  const url =
    action === "update"
      ? `http://localhost:8000/api/book/update/${route.params.theisbn}`
      : "http://localhost:8000/api/book/store";

  axios({
    url: url,
    method: "post",
    data: thedata.value,
    headers: customConfig,
  })
    .then((response) => {
      console.log(response.data);
      if (response.data.success) {
        alertify.alert("Information", "Data has been saved!", () => {
          alertify.success("OK");
        });
        router.push("/buku");
      }
    })
    .catch((error) => {
      console.error("AJAX Error:", error);
    });
}

onMounted(() => {
  if (route.params.theisbn !== "") {
    isbn_readonly.value = true;
    axios({
      url: `http://localhost:8000/api/book/show/${route.params.theisbn}`,
      method: "get",
      headers: customConfig,
    })
      .then((response) => {
        console.log(response.data);
        if (response.data.success) {
          isbn.value = response.data.data.isbn;
          judul.value = response.data.data.judul;
          pengarang.value = response.data.data.pengarang;
          tahun.value = response.data.data.tahun;
        }
      })
      .catch((error) => {
        console.error("AJAX Error:", error);
      });
  }
});
</script>

<template>
  <div class="container mt-4">
    <h3>{{ route.params.theisbn ? "Update Book" : "Add Book" }}</h3>
    <form @submit.prevent="save">
      <div class="mb-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input
          type="text"
          class="form-control"
          id="isbn"
          v-model="isbn"
          :readonly="isbn_readonly"
          required
        />
      </div>

      <div class="mb-3">
        <label for="judul" class="form-label">Title</label>
        <input
          type="text"
          class="form-control"
          id="judul"
          v-model="judul"
          required
        />
      </div>

      <div class="mb-3">
        <label for="pengarang" class="form-label">Author</label>
        <input
          type="text"
          class="form-control"
          id="pengarang"
          v-model="pengarang"
          required
        />
      </div>

      <div class="mb-3">
        <label for="tahun" class="form-label">Year</label>
        <input
          type="number"
          class="form-control"
          id="tahun"
          v-model="tahun"
          :min="1980"
          :max="2040"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary">
        <font-awesome-icon :icon="['fas', 'save']" />
        Save
      </button>

      <router-link to="/buku" class="btn btn-secondary ms-2">
        <font-awesome-icon :icon="['fas', 'arrow-left']" />
        Back
      </router-link>
      
    </form>
  </div>
</template>
