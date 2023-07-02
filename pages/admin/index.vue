<template>
  <div id="AdminPage" class="flex h-[100vh] pb-4">
    <div v-if="!userStore.isMobile"
        id="TopNav"
        class="w-full flex items-center justify-between md:pt-2.5 md:px-2.5"
    >

    </div>
  </div>
</template>

<script>
import { useUserStore } from "../../store/user"
definePageMeta({
  layout: "adminlayout",
});

const userStore = useUserStore()
</script>