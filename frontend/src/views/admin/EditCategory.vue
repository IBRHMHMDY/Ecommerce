<template>
    <div class="p-6 max-w-lg mx-auto">
      <h1 class="text-2xl font-bold mb-4">تعديل الفئة</h1>
      <form @submit.prevent="updateCategory" class="space-y-4">
        <div>
          <label class="block mb-1 font-semibold">اسم الفئة</label>
          <input v-model="name" type="text" class="w-full border px-4 py-2 rounded" required />
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">تحديث</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import api from '@/utils/apis';
  import { useRoute, useRouter } from 'vue-router';
  
  export default {
    setup() {
      const route = useRoute();
      const router = useRouter();
      const name = ref('');
  
      const fetchCategory = async () => {
        const res = await api.get(`/admin/categories/${route.params.id}`);
        name.value = res.data.name;
      };
  
      const updateCategory = async () => {
        await api.put(`/admin/categories/${route.params.id}`, { name: name.value });
        router.push('/admin/categories');
      };
  
      onMounted(fetchCategory);
  
      return {
        name,
        updateCategory
      };
    }
  };
  </script>
  