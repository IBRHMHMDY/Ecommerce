<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">تفاصيل الطلب</h1>

    <div v-if="loading" class="text-gray-500">جاري تحميل تفاصيل الطلب...</div>

    <div v-else>
      <div class="space-y-4">
        <p><strong>رقم الطلب:</strong> {{ order.id }}</p>
        <p><strong>الإجمالي:</strong> {{ order.total }}</p>

        <!-- حالة الطلب الحالية -->
        <div>
          <label class="block mb-2 font-semibold">حالة الطلب الحالية:</label>
          <p class="text-lg text-blue-600">{{ order.status }}</p>
        </div>

        <!-- فورم تحديث الحالة -->
        <div class="mt-6">
          <label class="block mb-2 font-semibold">تغيير الحالة:</label>
          <select v-model="newStatus" class="border p-2 rounded w-full mb-4">
            <option disabled value="">اختر حالة جديدة</option>
            <option value="pending">معلق</option>
            <option value="processing">قيد المعالجة</option>
            <option value="shipped">تم الشحن</option>
            <option value="delivered">تم التسليم</option>
            <option value="canceled">ملغي</option>
          </select>

          <button @click="updateStatus" class="btn btn-primary" :disabled="updating">
            <span v-if="!updating">تحديث الحالة</span>
            <span v-else>جاري التحديث...</span>
          </button>
        </div>

        <!-- زر الرجوع -->
        <router-link to="/admin/orders" class="btn btn-secondary mt-6 block text-center">
          الرجوع إلى الطلبات
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '@/utils/apis';

// المتغيرات
const route = useRoute();
const router = useRouter();
const order = ref(null);
const loading = ref(true);
const newStatus = ref('');
const updating = ref(false);

// تحميل تفاصيل الطلب
const fetchOrder = async () => {
  try {
    const { data } = await api.get(`/admin/orders/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('admin_token')}`
      }
    });
    order.value = data;
    newStatus.value = data.status;
  } catch (error) {
    console.error('فشل تحميل تفاصيل الطلب', error);
    router.push('/admin/orders');
  } finally {
    loading.value = false;
  }
};

// دالة تحديث حالة الطلب
const updateStatus = async () => {
  if (!newStatus.value) return;

  updating.value = true;

  try {
    await api.patch(`/admin/orders/${route.params.id}/status`, {
      status: newStatus.value
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('admin_token')}`
      }
    });

    // تحديث الحالة بعد نجاح التحديث
    order.value.status = newStatus.value;
    alert('تم تحديث الحالة بنجاح!');
  } catch (error) {
    console.error('فشل تحديث الحالة', error);
    alert('حدث خطأ أثناء تحديث الحالة');
  } finally {
    updating.value = false;
  }
};

// تحميل البيانات عند فتح الصفحة
onMounted(fetchOrder);
</script>

<style scoped>
.btn {
  @apply bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
}
.btn-primary {
  @apply bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded;
}
.btn-secondary {
  @apply bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded;
}
</style>
