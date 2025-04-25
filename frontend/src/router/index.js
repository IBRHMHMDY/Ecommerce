// Import the necessary modules
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin/login',
      name: 'AdminLogin',
      component: () => import('@/views/admin/auth/Login.vue'),
      meta: { layout: 'none' }
    },    
    {
      path: '/admin',
      component: () => import('../layouts/adminLayout.vue'), // تأكد أن الـ navbar داخل الـ Layout هذا
      children: [
        {
          path: 'dashboard',
          name: 'Admin Dashboard',
          component: () => import('../views/admin/Dashboard.vue'),
          meta: { requiresAuth: true } // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
        },
        {
          path: 'categories',
          name: 'Admin Categories',
          component: () => import('../views/admin/Categories.vue'),
          meta: { requiresAuth: true } // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
        },
        {
          path: 'products',
          name: 'Admin Products',
          component: () => import('../views/admin/Products.vue'),
          meta: { requiresAuth: true } // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
        },
        {
          path: 'orders',
          name: 'Admin Orders',
          component: () => import('../views/admin/Orders.vue'),
          meta: { requiresAuth: true } // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
        },
      ]
    },
    {
      path: '/',
      component: () => import('@/layouts/defaultLayout.vue'), // تأكد أن الـ navbar داخل الـ Layout هذا
      meta: { requiresAuth: false }, // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
      children: [
        {
          path: 'home',
          name: 'Home',
          component: () => import('@/views/home/Home.vue'),
          meta: { requiresAuth: false } // تحقق من أنه لا يوجد قيد يمنع عرض الـ navbar
        }
      ]
    }
  ],
})

export default router
