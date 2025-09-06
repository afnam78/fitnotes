import axios from 'axios';
window.axios = axios;
import '../../vendor/masmerise/livewire-toaster/resources/js'; // 👈
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
