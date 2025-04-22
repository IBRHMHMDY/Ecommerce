<template>
    <div class="p-6 max-w-2xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">إضافة منتج</h1>
      <form @submit.prevent="createProduct" class="space-y-4">
        <div>
          <label class="block mb-1">اسم المنتج</label>
          <input v-model="form.name" type="text" class="w-full border px-4 py-2 rounded" required />
        </div>
        <div>
          <label class="block mb-1">الوصف</label>
          <textarea v-model="form.description" class="w-full border px-4 py-2 rounded" rows="4"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block mb-1">السعر</label>
            <input v-model="form.price" type="number" step="0.01" class="w-full border px-4 py-2 rounded" required />
          </div>
          <div>
            <label class="block mb-1">الفئة</label>
            <select v-model="form.category_id" class="w-full border px-4 py-2 rounded" required>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
        </div>
        <div>
          <label class="block mb-1">صورة المنتج</label>
          <input type="file" @change="handleFile" class="w-full border px-4 py-2 rounded" />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">حفظ المنتج</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import api from '@/utils/apis';
  import { useRouter } from 'vue-router';
  
  export default {
    setup() {
      const form = ref({
        name: '',
        description: '',
        price: '',
        category_id: ''
      });
  
      const image = ref(null);
      const categories = ref([]);
      const router = useRouter();
  
      const fetchCategories = async () => {
        const res = await api.get('/admin/categories');
        categories.value = res.data;
      };
  
      const handleFile = (e) => {
        image.value = e.target.files[0];
      };
  
      const createProduct = async () => {
        const data = new FormData();
        data.append('name', form.value.name);
        data.append('description', form.value.description);
        data.append('price', form.value.price);
        data.append('category_id', form.value.category_id);
        if (image.value) data.append('image', image.value);
  
        await api.post('/admin/products', data);
        router.push('/admin/products');
      };
  
      onMounted(fetchCategories);
  
      return {
        form,
        categories,
        image,
        handleFile,
        createProduct
      };
    }
  };
  </script>
  