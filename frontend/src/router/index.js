import { createRouter, createWebHistory } from "vue-router";
import BarangView from "@/views/BarangView.vue";
import PegawaiView from "@/views/PegawaiView.vue";
import LoginView from "@/views/LoginView.vue";
import MenuView from "@/views/MenuView.vue";
import BukuView from "@/views/BukuView.vue";
import FormBukuView from "@/views/FormBukuView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "login",
      component: LoginView,
    },
    {
      path: "/menu",
      name: "menu",
      component: MenuView,
    },
    {
      path: "/barang",
      name: "barang",
      component: BarangView,
    },
    {
      path: "/pegawai",
      name: "pegawai",
      component: PegawaiView,
    },
    {
      path: "/buku",
      name: "buku",
      component: BukuView,
    },
    {
      path: "/bukuview/:theisbn?",
      name: "bukuview",
      component: FormBukuView,
      props: true,
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/AboutView.vue"),
    },
  ],
});

export default router;
