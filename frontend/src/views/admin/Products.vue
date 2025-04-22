<template>
    <div class="p-6">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">إدارة المنتجات</h1>
        <router-link to="/admin/products/create" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          إضافة منتج
        </router-link>
      </div>
  
      <input
        type="text"
        v-model="search"
        placeholder="بحث عن منتج..."
        class="mb-4 px-4 py-2 border rounded w-full"
      />
  
      <table class="w-full bg-white shadow rounded">
        <thead>
          <tr class="bg-gray-100 text-right">
            <th class="p-3">الصورة</th>
            <th class="p-3">الاسم</th>
            <th class="p-3">السعر</th>
            <th class="p-3">الفئة</th>
            <th class="p-3">الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id" class="border-b">
            <td class="p-3"><img :src="product.image" class="w-12 h-12 object-cover rounded" /></td>
            <td class="p-3">{{ product.name }}</td>
            <td class="p-3">{{ product.price }} د.إ</td>
            <td class="p-3">{{ product.category.name }}</td>
            <td class="p-3 space-x-2">
              <router-link :to="`/admin/products/${product.id}/edit`" class="text-blue-600 hover:underline">تعديل</router-link>
              <button @click="deleteProduct(product.id)" class="text-red-600 hover:underline">حذف</button>
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
      const products = ref([]);
      const search = ref('');
  
      const fetchProducts = async () => {
        const res = await api.get('/admin/products');
        products.value = res.data;
      };
  
      const deleteProduct = async (id) => {
        if (confirm('هل أنت متأكد من حذف المنتج؟')) {
          await api.delete(`/admin/products/${id}`);
          fetchProducts();
        }
      };
  
      const filteredProducts = computed(() => {
        return products.value.filter(p =>
          p.name.toLowerCase().includes(search.value.toLowerCase())
        );
      });
  
      onMounted(fetchProducts);
  
      return {
        products,
        search,
        filteredProducts,
        deleteProduct
      };
    }
  };
  </script>
  