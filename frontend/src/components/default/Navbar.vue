<template>
    <nav>
        <ul class="flex space-x-4 bg-gray-800 p-4 text-white">
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/admin">Admin</router-link></li>
            <li><router-link to="/admin/categories">Categories</router-link></li>
            <li><router-link to="/admin/categories/add">Add Category</router-link></li>
        </ul>
    </nav>
</template>