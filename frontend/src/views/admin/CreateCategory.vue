<template>
    <div class="p-6 max-w-lg mx-auto">
      <h1 class="text-2xl font-bold mb-4">إضافة فئة جديدة</h1>
      <form @submit.prevent="createCategory" class="space-y-4">
        <div>
          <label class="block mb-1 font-semibold">اسم الفئة</label>
          <input v-model="name" type="text" class="w-full border px-4 py-2 rounded" required />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">حفظ</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import api from '@/utils/apis';
  import { useRouter } from 'vue-router';
  
  export default {
    setup() {
      const name = ref('');
      const router = useRouter();
  
      const createCategory = async () => {
        await api.post('/admin/categories', { name: name.value });
        router.push('/admin/categories');
      };
  
      return {
        name,
        createCategory
      };
    }
  };
  </script>
  