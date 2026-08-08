import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import intersect from '@alpinejs/intersect';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import ApexCharts from 'apexcharts';
import '@hotwired/turbo';

window.ApexCharts = ApexCharts;
window.Alpine = Alpine;
Alpine.plugin(mask);
Alpine.plugin(intersect);
window.flatpickr = flatpickr;

window.Alpine.start();

document.addEventListener("turbo:render", () => {
    // Re-initialize Alpine on the new body injected by Turbo
    window.Alpine.initTree(document.body);
});
