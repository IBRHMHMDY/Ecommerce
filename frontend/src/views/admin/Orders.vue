<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">الطلبات</h1>

    <table class="w-full table-auto border-collapse">
      <thead>
        <tr>
          <th class="border p-2">المعرف</th>
          <th class="border p-2">المستخدم</th>
          <th class="border p-2">الإجمالي</th>
          <th class="border p-2">الحالة</th>
          <th class="border p-2">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td class="border p-2">{{ order.id }}</td>
          <td class="border p-2">{{ order.user?.name }}</td>
          <td class="border p-2">{{ order.total_price }} $</td>
          <td class="border p-2">{{ 
          order.status == 'pending' ? 'قيد الإنتظار' :
          order.status == 'processing' ? 'قيد التنفيذ' :
          order.status == 'shipped' ? 'تم التوصيل' : 'ملغي' }}</td>
          <td class="border p-2">
            <button class="text-blue-600 underline" @click="openModal(order.id)">عرض</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal نافذة التفاصيل -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow max-w-xl w-full relative">
        <button @click="showModal = false" class="absolute top-2 left-2 text-red-500 text-xl">×</button>
        <h2 class="text-xl font-bold mb-4">تفاصيل الطلب رقم #{{ selectedOrder.order.id }}</h2>

        <div class="mb-4">
          <p><strong>المستخدم:</strong> {{ selectedOrder.order.user?.name }}</p>
          <p class="flex items-center justify-between gap-3"><strong>الحالة:</strong> 
            <select v-model="selectedOrder.order.status" class="border rounded px-3 py-1 w-full">
            <option value="pending">قيد الانتظار</option>
            <option value="processing">قيد التنفيذ</option>
            <option value="completed">تم التوصيل</option>
            <option value="canceled">ملغي</option>
          </select>
          <button @click="updateStatus(selectedOrder.order.id)" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
          حفظ التغيير
          </button>
          </p>
          <p><strong>الإجمالي:</strong> {{ selectedOrder.order.total_price }} $</p>
        </div>

        <div>
          <h3 class="text-lg font-semibold mb-2">المنتجات</h3>
          <table class="w-full border text-sm">
            <thead>
              <tr>
                <th class="border p-1">المنتج</th>
                <th class="border p-1">الكمية</th>
                <th class="border p-1">السعر</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in selectedOrder.order.items" :key="item.id">
                <td class="border p-1">{{ item.product?.name }}</td>
                <td class="border p-1">{{ item.quantity }}</td>
                <td class="border p-1">{{ item.price }} $</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          <button class="text-blue-600 underline" @click="closeModal()">إغلاق</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue';
  import api from '@/utils/apis';

  const orders = ref([]);
  const selectedOrder = ref({});
  const showModal = ref(false);

  const fetchOrders = async () => {
    try {
      const res = await api.get('/admin/orders', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('admin_token')}`,
        },
      });
      orders.value = res.data;
    } catch (err) {
      console.error('فشل تحميل الطلبات', err);
    }
  };

  const openModal = async (id) => {
    try {
      const res = await api.get(`/admin/orders/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('admin_token')}`,
        },
      });
      selectedOrder.value = res.data;
      showModal.value = true;
    } catch (err) {
      console.error("فشل تحميل تفاصيل الطلب", err);
    }
  };
  const closeModal = () => {
    showModal.value = false;
  };  
  const updateStatus = async (orderId) => {
    try {
      await api.post(`/admin/orders/${orderId}/status`, {
        status: selectedOrder.value.order.status
      }, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('admin_token')}`,
        },
      });
      alert("تم تحديث الحالة بنجاح");
      showModal.value = false;
      fetchOrders();
    } catch (err) {
      console.error("فشل تحديث الحالة", err);
    }
  };

  onMounted(fetchOrders);
</script>
