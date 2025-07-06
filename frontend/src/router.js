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
import YourProfile from "./pages/YourProfile.vue";
import GuestLayout from "./components/GuestLayout.vue";
import HomeGuest from "./pages/HomeGuest.vue";
import AboutGuest from "./pages/AboutGuest.vue";
import ContactGuest from "./pages/ContactGuest.vue";
import FAQGuest from "./pages/FAQGuest.vue";
import History from "./pages/History.vue";
import Notifications from "./pages/Notifications.vue";
import Notifications_Show from "./pages/Notifications_Show.vue";
import EmailVerificationNotice from "./pages/EmailVerificationNotice.vue";
import ForgotPassword from "./pages/ForgotPassword.vue";
import ResetPassword from "./pages/ResetPassword.vue";

const routes = [
  {
    path: "/user",
    component: DefaultLayout,
    children: [
      { path: "", name: "Home", component: Home },
      {
        path: "warranty",
        name: "MyWarranty",
        component: MyWarranty,
        props: (route) => ({
          seller: route.query.seller || "",
          status: route.query.status || "",
          product_name: route.query.product_name || "",
          sortBy: route.query.sortBy || "",
        }),
      },
      {
        path: "warranty/create",
        name: "MyWarranty_Create",
        component: MyWarranty_Create,
      },
      {
        path: "warranty/show/:id",
        name: "MyWarranty_Show",
        component: MyWarranty_Show,
      },
      {
        path: "warranty/edit/:id",
        name: "MyWarranty_Edit",
        component: MyWarranty_Edit,
      },
      {
        path: "invoice",
        name: "MyInvoice",
        component: MyInvoice,
        props: (route) => ({
          seller: route.query.seller || "",
          product_name: route.query.product_name || "",
          sortBy: route.query.sortBy || "",
        }),
      },
      {
        path: "invoice/show/:id",
        name: "MyInvoice_Show",
        component: MyInvoice_Show,
      },
      {
        path: "invoice/create",
        name: "MyInvoice_Create",
        component: MyInvoice_Create,
      },
      {
        path: "invoice/edit/:id",
        name: "MyInvoice_Edit",
        component: MyInvoice_Edit,
      },
      {
        path: "history",
        name: "History",
        component: History,
      },
      {
        path: "notifications",
        name: "Notifications",
        component: Notifications,
      },
      {
        path: "notifications_show/:id",
        name: "Notifications_Show",
        component: Notifications_Show,
      },
      {
        path: "profile",
        name: "YourProfile",
        component: YourProfile,
      },
    ],
    beforeEnter: async (to, from, next) => {
      const userStore = useUserStore();
      try {
        if (!userStore.user) {
          await userStore.fetchUser();
        }

        const isLoggedIn = !!userStore.user;
        const isVerified = !!userStore.user?.email_verified_at;

        if (!isLoggedIn) {
          return next({ name: "Login" });
        }

        if (!isVerified && to.name !== "EmailVerificationNotice") {
          return next({ name: "EmailVerificationNotice" });
        }

        next();
      } catch (error) {
        return next({ name: "Login" });
      }
    },
  },

  {
    path: "/",
    component: GuestLayout,
    children: [
      { path: "", name: "HomeGuest", component: HomeGuest },
      {
        path: "/verify-email",
        name: "EmailVerificationNotice",
        component: EmailVerificationNotice,
      },
      {
        path: "/about",
        name: "AboutGuest",
        component: AboutGuest,
      },
      {
        path: "/contact",
        name: "ContactGuest",
        component: ContactGuest,
      },
      {
        path: "/faq",
        name: "FAQGuest",
        component: FAQGuest,
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
        path: "/forgot-password",
        name: "ForgotPassword",
        component: ForgotPassword,
      },
      {
        path: "/password-reset/:token",
        name: "ResetPassword",
        component: ResetPassword,
      },
    ],
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
