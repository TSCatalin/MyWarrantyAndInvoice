import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/Home.vue";
import MyWarranty from "./pages/MyWarranty.vue";
import Login from "./pages/Login.vue";
import Signup from "./pages/Signup.vue";
import DefaultLayout from "./components/DefaultLayout.vue";
import NotFound from "./pages/NotFound.vue";
import useUserStore from "./store/user";
import MyWarranty_Create from "./pages/MyWarranty_Create.vue";
import MyWarranty_Show from "./pages/MyWarranty_Show.vue";
import MyWarranty_Edit from "./pages/MyWarranty_Edit.vue";
import MyInvoice from "./pages/MyInvoice.vue";
import MyInvoice_Show from "./pages/MyInvoice_Show.vue";
import MyInvoice_Create from "./pages/MyInvoice_Create.vue";
import MyInvoice_Edit from "./pages/MyInvoice_Edit.vue";

const routes = [
  {
    path: "/",
    component: DefaultLayout,
    children: [
      { path: "/", name: "Home", component: Home },
      {
        path: "/warranty",
        name: "MyWarranty",
        component: MyWarranty,
        props: (route) => ({
          seller: route.query.seller || "",
          status: route.query.status || "",
          product_name: route.query.product_name || "",
        }),
      },
      {
        path: "/warranty/create",
        name: "MyWarranty_Create",
        component: MyWarranty_Create,
      },
      {
        path: "/warranty/show/:id",
        name: "MyWarranty_Show",
        component: MyWarranty_Show,
      },
      {
        path: "/warranty/edit/:id",
        name: "MyWarranty_Edit",
        component: MyWarranty_Edit,
      },
      {
        path: "/invoice",
        name: "MyInvoice",
        component: MyInvoice,
        props: (route) => ({
          seller: route.query.seller || "",
          product_name: route.query.product_name || "",
        }),
      },
      {
        path: "/invoice/show/:id",
        name: "MyInvoice_Show",
        component: MyInvoice_Show,
      },
      {
        path: "/invoice/create",
        name: "MyInvoice_Create",
        component: MyInvoice_Create,
      },
      {
        path: "/invoice/edit/:id",
        name: "MyInvoice_Edit",
        component: MyInvoice_Edit,
      },
    ],
    beforeEnter: async (to, from, next) => {
      try {
        const userStore = useUserStore();
        await userStore.fetchUser();
        next();
      } catch (error) {
        next(false);
      }
    },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/signup",
    name: "Signup",
    component: Signup,
  },
  {
    path: "/:pathMatch(.*)",
    name: "NotFound",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
