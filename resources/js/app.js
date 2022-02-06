require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        alert(notification.body);
    });
