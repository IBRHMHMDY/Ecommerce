<template>
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
      <!-- شعار -->
      <div class="text-xl font-bold text-blue-600">
        AdminPanel
      </div>
  
      <!-- روابط -->
      <ul class="flex gap-6 text-gray-700">
        <li>
          <router-link to="/admin/dashboard" class="hover:text-blue-600">لوحة التحكم</router-link>
        </li>
        <li>
          <router-link to="/admin/categories" class="hover:text-blue-600">الفئات</router-link>
        </li>
        <li>
          <router-link to="/admin/products" class="hover:text-blue-600">المنتجات</router-link>
        </li>
        <li>
          <router-link to="/admin/orders" class="hover:text-blue-600">الطلبات</router-link>
        </li>
      </ul>
  
      <!-- زر تسجيل الخروج -->
      <button @click="logout"
        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
        تسجيل الخروج
      </button>
    </nav>
  </template>
  
  <script>
  import { useRouter } from 'vue-router';
  
  export default {
    setup() {
      const router = useRouter();
  
      const logout = () => {
        localStorage.removeItem('admin_token');
        router.push('/admin/login');
      };
      return {
        logout
      };
    }
  };
  </script>
  