<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/counter";

const currentPage = ref(1);
const ncount = ref(0);
const per_page = 8;
const cari = ref("");

const books = ref([]);
const store = useUserStore();
const router = useRouter();

const customConfig = {
  Authorization: "Bearer " + store.token,
};

const nomor = computed(() => {
  return currentPage.value == 1 ? 1 : (currentPage.value - 1) * per_page + 1;
});

function refreshData() {
  let start_data =
    currentPage.value == 1 ? 0 : (currentPage.value - 1) * per_page;
  let thedata = {
    start: start_data,
    limit: per_page,
    cari: cari.value,
  };

  axios({
    url: "http://localhost:8000/api/book/cari",
    method: "post",
    headers: customConfig,
    data: thedata,
  })
    .then((response) => {
      console.log(response.data);
      if (response.data.success) {
        books.value = response.data.data.buku;
        ncount.value = response.data.data.count;
      }
    })
    .catch((error) => {
      console.error("AJAX Error:", error);
    });
}

function doSearch() {
  currentPage.value = 1;
  refreshData();
}

function deleteDialog(id) {
  alertify.confirm(
    "Confirmation",
    "Are you sure to delete this data?",
    () => {
      deleteBook(id);
    },
    () => {
      console.log("Deletion canceled");
    }
  );
}

function deleteBook(id) {
  axios({
    url: `http://localhost:8000/api/book/delete/${id}`,
    method: "get",
    headers: customConfig,
  })
    .then((response) => {
      if (response.data.success) {
        alertify.alert("Information", "Data has been deleted!", () => {
          alertify.success("OK");
        });
        refreshData();
      }
    })
    .catch((error) => {
      console.error("AJAX Error:", error);
    });
}

const onClickHandler = (page) => {
  refreshData();
};

onMounted(() => {
  refreshData();
});
</script>

<template>
  <div class="container-fluid mt-4">
    <div class="col-md-12 text-start mb-3">
      <router-link to="/bukuview">
        <button
          style="background-color: #eb6134"
          type="button"
          class="btn btn-primary"
        >
          <font-awesome-icon :icon="['fas', 'folder-plus']" />
          Add Book
        </button>
      </router-link>
    </div>
    <div class="row mb-3 flex-column">
      <div class="col-md-12 mb-2">
        <div class="input-group">
          <input
            type="text"
            v-model="cari"
            class="form-control"
            placeholder="Search books..."
            @keyup.enter="doSearch"
          />
          <button
            style="background-color: #eb6134; color: white"
            class="btn btn-outline-secondary"
            @click="doSearch"
          >
            <font-awesome-icon :icon="['fas', 'search']" />
            Search
          </button>
        </div>
      </div>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th class="text-end">#</th>
          <th>ISBN</th>
          <th>Title</th>
          <th>Author</th>
          <th class="text-center">Year</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in books" :key="item.isbn">
          <td class="text-end">{{ nomor + index }}</td>
          <td>{{ item.isbn }}</td>
          <td>{{ item.judul }}</td>
          <td>{{ item.pengarang }}</td>
          <td class="text-center">{{ item.tahun }}</td>
          <td class="text-center">
            <router-link
              :to="{ name: 'bukuview', params: { theisbn: item.isbn } }"
              class="btn btn-outline-success btn-sm me-2"
            >
              <font-awesome-icon :icon="['fas', 'eye']" />
              View
            </router-link>
            <button
              type="button"
              @click="deleteDialog(item.isbn)"
              class="btn btn-outline-danger btn-sm"
            >
              <font-awesome-icon :icon="['fas', 'trash']" />
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="style-pagination">
      <vue-awesome-paginate
        :total-items="ncount"
        v-model="currentPage"
        @click="onClickHandler"
        :items-per-page="per_page"
        :max-pages-shown="10"
      >
        <template #prev-button>
          <span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="black"
              width="8"
              height="8"
              viewBox="0 0 24 24"
            >
              <path d="M8.122 24l-4.122-4 8-8-8-8 4.122-4 11.878 12z" />
            </svg>
            Prev
          </span>
        </template>
        <template #next-button>
          <span>
            Next
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="black"
              width="8"
              height="8"
              viewBox="0 0 24 24"
            >
              <path d="M8.122 24l-4.122-4 8-8-8-8 4.122-4 11.878 12z" />
            </svg>
          </span>
        </template>
      </vue-awesome-paginate>
    </div>
  </div>
</template>

<style>
.style-pagination {
  display: flex;
  justify-content: center;
}

.style-pagination .pagination-container {
  background-color: #f0f0f0;
  border-radius: 5px;
  padding: 10px 0px;
}

.style-pagination .paginate-buttons {
  width: 40px;
  height: 40px;
  margin-inline: 5px;
  cursor: pointer;
  border: none;
  background-color: transparent;
  border-radius: 2px;
}

.style-pagination .back-button {
  width: 70px;
}

.style-pagination .next-button {
  width: 70px;
}

.style-pagination .back-button svg {
  transform: rotate(180deg);
}

.style-pagination .active-page {
  background-color: #eb6134;
  color: #fff;
}

.style-pagination .paginate-buttons:hover {
  background-color: #e5e5e5;
}

.style-pagination .active-page:hover {
  background-color: #eb6134;
  color: #fff;
}

.style-pagination .back-button:active,
.style-pagination .next-button:active {
  background-color: #dedede;
}
</style>
