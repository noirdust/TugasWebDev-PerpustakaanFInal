import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css";
import bootstrap from "bootstrap/dist/js/bootstrap.min.js";
import VueAwesomePaginate from "vue-awesome-paginate";
import "../node_modules/vue-awesome-paginate/dist/style.css";
/* Import the FontAwesome core */
import { library } from "@fortawesome/fontawesome-svg-core";
/* Import Font Awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
/* Import specific icons */
import {
  faUserSecret,
  faSignOutAlt,
  faEnvelope,
  faLock,
  faSignInAlt,
  faFolderPlus,
  faEye,
  faTrash,
  faSave,
  faBook
} from "@fortawesome/free-solid-svg-icons";

/* Add icons to the library */
library.add(
  faUserSecret,
  faSignOutAlt,
  faEnvelope,
  faLock,
  faSignInAlt,
  faFolderPlus,
  faEye,
  faTrash,
  faSave,
  faBook
);

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(bootstrap);
app.use(VueAwesomePaginate)

/* Register FontAwesomeIcon as a global component */
app.component("font-awesome-icon", FontAwesomeIcon);

app.mount("#app");
