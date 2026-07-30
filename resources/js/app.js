import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import intersect from '@alpinejs/intersect';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;
window.Alpine = Alpine;
Alpine.plugin(mask);
Alpine.plugin(intersect);
window.flatpickr = flatpickr;

Alpine.start();
