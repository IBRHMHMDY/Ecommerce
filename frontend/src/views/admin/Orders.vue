<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">الطلبات</h1>
  
      <select v-model="statusFilter" class="mb-4 px-4 py-2 border rounded">
        <option value="">كل الحالات</option>
        <option value="pending">قيد الانتظار</option>
        <option value="shipped">تم الشحن</option>
        <option value="delivered">تم التوصيل</option>
      </select>
  
      <table class="w-full bg-white shadow rounded">
        <thead>
          <tr class="bg-gray-100 text-right">
            <th class="p-3">العميل</th>
            <th class="p-3">العنوان</th>
            <th class="p-3">المجموع</th>
            <th class="p-3">الحالة</th>
            <th class="p-3">الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in filteredOrders" :key="order.id" class="border-b">
            <td class="p-3">{{ order.customer_name }}</td>
            <td class="p-3">{{ order.address }}</td>
            <td class="p-3">{{ order.total }} د.إ</td>
            <td class="p-3">
              <span :class="{
                'text-yellow-600': order.status === 'pending',
                'text-blue-600': order.status === 'shipped',
                'text-green-600': order.status === 'delivered'
              }">{{ order.status }}</span>
            </td>
            <td class="p-3">
              <router-link :to="`/admin/orders/${order.id}`" class="text-blue-600 hover:underline">عرض</router-link>
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
      const orders = ref([]);
      const statusFilter = ref('');
  
      const fetchOrders = async () => {
        const res = await api.get('/admin/orders');
        orders.value = res.data;
      };
  
      const filteredOrders = computed(() => {
        if (!statusFilter.value) return orders.value;
        return orders.value.filter(order => order.status === statusFilter.value);
      });
  
      onMounted(fetchOrders);
  
      return {
        orders,
        statusFilter,
        filteredOrders
      };
    }
  };
  </script>
  