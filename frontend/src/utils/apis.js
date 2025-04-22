import axios from "axios"

const api = axios.create({
    baseURL: 'http://localhost:8000/api', 
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${localStorage.getItem('token')}`, // احفظ التوكن في LocalStorage أو استخدم متاجر Pinia
    }
  })
  export default api