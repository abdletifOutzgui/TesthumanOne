import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.axios = axios;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

const channel = window.Echo.channel('product-stock');

channel.listen('StockLow', function(data) {
    console.log('Stock low notification:', event);

    const notificationCountElement = document.getElementById('notification-count');

    const count = parseInt(notificationCountElement.textContent) + 1;
    
    notificationCountElement.textContent = count;

    const productInfo = `
            <p><strong>Product Name:</strong> ${event.product_name}</p>
            <p><strong>Current Stock:</strong> ${event.quantity_in_stock}</p>
            <p><strong>Minimum Threshold:</strong> ${event.min_threshold}</p>
        `;
        document.getElementById('product-info').innerHTML = productInfo;

    alert(count);
});