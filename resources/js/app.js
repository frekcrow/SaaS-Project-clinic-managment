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

// Start Alpine for the initial page load
window.Alpine.start();

// Use turbo:load instead of turbo:render to ensure any dynamically injected
// scripts inside the new body have fully executed before Alpine evaluates x-data.
document.addEventListener("turbo:load", () => {
    // Re-initialize Alpine on the new body
    window.Alpine.initTree(document.body);
});
