import './bootstrap';
import Swal from 'sweetalert2';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import moment from 'moment';
import VanillaCalendar from '@uvarov.frontend/vanilla-calendar';
import '@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css';
import Choices from 'choices.js';
import 'flowbite';

import.meta.glob([
    '../images/**',
]);

window.Choices = Choices;
window.Swiper = Swiper;
window.Swal = Swal;
window.VanillaCalendar = VanillaCalendar;

window.modal = (title, text, icon) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    })
}

window.moment = moment
