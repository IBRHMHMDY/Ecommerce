<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">لوحة التحكم</h1>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6 text-center">
          <h2 class="text-lg font-semibold">عدد الفئات</h2>
          <p class="text-3xl">{{ stats.categories }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
          <h2 class="text-lg font-semibold">عدد المنتجات</h2>
          <p class="text-3xl">{{ stats.products }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
          <h2 class="text-lg font-semibold">عدد الطلبات</h2>
          <p class="text-3xl">{{ stats.orders }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import api from '@/utils/apis';
  
  export default {
    setup() {
      const stats = ref({
        categories: 0,
        products: 0,
        orders: 0
      });
  
      const fetchStats = async () => {
        try {
          const res = await api.get('/admin/stats');
          stats.value = res.data;
        } catch (err) {
          console.error('Error fetching stats', err);
        }
      };
  
      onMounted(fetchStats);
  
      return {
        stats
      };
    }
  };
  </script>
  