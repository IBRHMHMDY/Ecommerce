<template>
    <div class="p-6">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">إدارة الفئات</h1>
        <router-link to="/admin/categories/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          إضافة فئة
        </router-link>
      </div>
  
      <input
        type="text"
        v-model="search"
        placeholder="بحث عن فئة..."
        class="mb-4 px-4 py-2 border rounded w-full"
      />
  
      <table class="w-full bg-white shadow rounded">
        <thead>
          <tr class="bg-gray-100 text-right">
            <th class="p-3">الاسم</th>
            <th class="p-3">تاريخ الإنشاء</th>
            <th class="p-3">الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in filteredCategories" :key="category.id" class="border-b">
            <td class="p-3">{{ category.name }}</td>
            <td class="p-3">{{ new Date(category.created_at).toLocaleDateString() }}</td>
            <td class="p-3 space-x-2">
              <router-link :to="`/admin/categories/${category.id}/edit`" class="text-blue-600 hover:underline">تعديل</router-link>
              <button @click="deleteCategory(category.id)" class="text-red-600 hover:underline">حذف</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import { ref, computed, onMounted } from 'vue';
  import api from '@/utils/apis';
  
  export default {
    setup() {
      const categories = ref([]);
      const search = ref('');
  
      const fetchCategories = async () => {
        const res = await api.get('/admin/categories');
        categories.value = res.data;
      };
  
      const deleteCategory = async (id) => {
        if (confirm('هل أنت متأكد من حذف الفئة؟')) {
          await api.delete(`/admin/categories/${id}`);
          fetchCategories();
        }
      };
  
      const filteredCategories = computed(() => {
        return categories.value.filter(cat =>
          cat.name.toLowerCase().includes(search.value.toLowerCase())
        );
      });
  
      onMounted(fetchCategories);
  
      return {
        categories,
        search,
        deleteCategory,
        filteredCategories
      };
    }
  };
  </script>
  