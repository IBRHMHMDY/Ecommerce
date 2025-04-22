<template>
  <component :is="layoutComponent">
    <router-view />
  </component>
</template>

<script>
import AdminLayout from '@/layouts/adminLayout.vue';
import DefaultLayout from '@/layouts/defaultLayout.vue';

export default {
  computed: {
    layoutComponent() {
      const layout = this.$route.meta.layout;
      if (layout === 'admin') return AdminLayout;
      if (layout === 'default') return DefaultLayout;
      return 'div'; // لا يوجد Layout
    }
  }
};
</script>
