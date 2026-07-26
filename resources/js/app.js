import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

window.Alpine = Alpine;
Alpine.plugin(mask);
window.flatpickr = flatpickr;

Alpine.start();
