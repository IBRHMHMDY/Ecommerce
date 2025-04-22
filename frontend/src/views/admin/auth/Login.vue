<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">تسجيل دخول المسؤول</h2>

      <form @submit.prevent="handleLogin" method="post">
        <div class="mb-4">
          <label class="block mb-1">البريد الإلكتروني</label>
          <input type="email" v-model="form.email" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1">كلمة المرور</label>
          <input type="password" v-model="form.password" class="w-full border rounded px-3 py-2" required />
        </div>

        <div v-if="error" class="text-red-600 mb-4 text-sm">
          {{ error }}
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
          تسجيل الدخول
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import api from '@/utils/apis'

const router = useRouter()
const form = ref({
  email: '',
  password: ''
})
const error = ref(null)

const handleLogin = async () => {
  error.value = null
  try {
    const res = await api.post('/admin/login', form.value)
    localStorage.setItem('admin_token', res.data.token)
    router.push('/admin/dashboard')
  } catch (err) {
    if (err.response && err.response.status === 401) {
      error.value = 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
    } else if (err.response && err.response.status === 403) {
      error.value = 'ليس لديك صلاحية الدخول'
    } else {
      error.value = 'حدث خطأ أثناء تسجيل الدخول'
    }
  }
}
</script>
