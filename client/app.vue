<template>
  <div>
    <NuxtLayout>
      <VitePwaManifest />
      <NuxtPage />
      <PreviewOverlay v-if="!isMobile && isPreviewOverlay" />
    </NuxtLayout>
  </div>
</template>

<script setup>
import { useUserStore } from "./store/user";
import { storeToRefs } from "pinia";

const userStore = useUserStore();
const { isMobile, isPreviewOverlay, updatedLinkId, addLinkOverlay, id } =
  storeToRefs(userStore);

const route = useRoute();
let show = ref(false);
let bgIsGray = ref(false);

onMounted(async () => {
  userStore.colors = colors();
  updatedLinkId.value = 0;
  addLinkOverlay.value = false;
  isPreviewOverlay.value = false;
  isMobile.value = false;

  try {
    if (userStore.id) {
      await userStore.hasSessionExpired();
      await userStore.getUser();
      await userStore.getAllLinks();
    }
  } catch (error) {
    console.log(error);
  }

  checkPath(route.fullPath);

  if ("ontouchstart" in window) {
    isMobile.value = true;
  }

  setTimeout(() => (show.value = true), 1);
});

watch(
  () => id.value,
  () => {
    if (!userStore.colors) {
      userStore.colors = colors();
    }
  }
);

const colors = () => {
  return [
    { id: 1, color: "bg-white", text: "text-black", name: "Air White" },
    { id: 2, color: "bg-gray-800", text: "text-white", name: "Lake Black" },
    {
      id: 3,
      color: "bg-gradient-to-t from-indigo-500 via-purple-500 to-pink-500",
      text: "text-white",
      name: "Purple Pie",
    },
    {
      id: 4,
      color: "bg-gradient-to-t from-gray-500 via-blue-500 to-green-500",
      text: "text-white",
      name: "Green Grass",
    },
    {
      id: 5,
      color: "bg-gradient-to-t from-orange-500 via-blue-500 to-red-500",
      text: "text-white",
      name: "Traffic Lights",
    },
    {
      id: 6,
      color: "bg-gradient-to-b from-blue-800 via-blue-500 to-green-500",
      text: "text-white",
      name: "Blue Sky",
    },
    {
      id: 7,
      color: "bg-gradient-to-t from-lime-500 via-indigo-700 to-amber-500",
      text: "text-white",
      name: "Soft Horizontal",
    },
    {
      id: 8,
      color: "bg-gradient-to-t from-gray-800 to-emerald-500",
      text: "text-white",
      name: "Tinted Lake",
    },
  ];
};

const checkPath = (path) => {
  if (path == "/" || path == "/register") {
    bgIsGray.value = false;
    return;
  }
  bgIsGray.value = true;
};

watch(
  () => route.fullPath,
  (path) => checkPath(path)
);

watch(
  () => isPreviewOverlay.value,
  (val) => {
    let id = null;
    if (route.fullPath == "/admin") {
      id = "AdminPage";
    } else if (route.fullPath == "/admin/apperance") {
      id = "ApperancePage";
    } else if (route.fullPath == "/admin/settings") {
      id = "SettingsPage";
    }

    userStore.hidePageOverflow(val, id);
  }
);
</script>