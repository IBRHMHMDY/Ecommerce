<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">تفاصيل الطلب رقم #{{ orderId }}</h1>
  
      <div v-if="loading" class="text-gray-500">جاري تحميل تفاصيل الطلب...</div>
  
      <div v-else>
        <div class="bg-white rounded shadow p-4 mb-6">
          <h2 class="text-xl font-semibold mb-2">معلومات المستخدم</h2>
          <p><strong>الاسم:</strong> {{ order.user?.name }}</p>
          <p><strong>البريد الإلكتروني:</strong> {{ order.user?.email }}</p>
        </div>
  
        <div class="bg-white rounded shadow p-4 mb-6">
          <h2 class="text-xl font-semibold mb-2">معلومات الطلب</h2>
          <p><strong>الحالة:</strong> {{ order.status }}</p>
          <p><strong>الإجمالي:</strong> {{ order.total }} $</p>
          <p><strong>تاريخ الإنشاء:</strong> {{ formatDate(order.created_at) }}</p>
        </div>
  
        <div class="bg-white rounded shadow p-4">
          <h2 class="text-xl font-semibold mb-4">العناصر المطلوبة</h2>
          <table class="min-w-full text-right">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">المنتج</th>
                <th class="px-4 py-2">الكمية</th>
                <th class="px-4 py-2">السعر</th>
                <th class="px-4 py-2">الإجمالي</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in order.items" :key="item.id" class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ item.product?.name }}</td>
                <td class="px-4 py-2">{{ item.quantity }}</td>
                <td class="px-4 py-2">{{ item.price }} $</td>
                <td class="px-4 py-2">{{ item.price * item.quantity }} $</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import api from '@/utils/apis';
  
  export default {
    setup() {
      const route = useRoute();
      const orderId = route.params.id;
      const order = ref({});
      const loading = ref(true);
  
      const fetchOrder = async () => {
        loading.value = true;
        const res = await api.get(`/admin/orders/${orderId}`);
        order.value = res.data;
        loading.value = false;
      };
  
      const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleString('ar-EG');
      };
  
      onMounted(fetchOrder);
  
      return {
        order,
        orderId,
        loading,
        formatDate
      };
    }
  };
  </script>
  