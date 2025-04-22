<template>
    <div>
      <Navbar />
      <main class="p-6 bg-gray-50 min-h-screen">
        <router-view />
      </main>
    </div>
  </template>
  
  <script setup>
  import Navbar from '@/components/admin/Navbar.vue';
  
  </script>
  