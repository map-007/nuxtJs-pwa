<template>
  <div>
    <NuxtLayout>
      <VitePwaManifest />
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup>
import { useUserStore } from "./store/user";
import { storeToRefs } from "pinia";

const userStore = useUserStore();
const { isMobile, isPreviewOverlay, updatedLinkId, addLinkOverlay, id } =
  storeToRefs(userStore);

onMounted(() => {
  if ("ontouchstart" in window) {
    isMobile.value = true;
  }
});
</script>