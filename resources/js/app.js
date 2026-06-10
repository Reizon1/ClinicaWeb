import './bootstrap';

import * as BSLib from 'bootstrap';
window.BSLib = BSLib;

// Inicializar tooltips y popovers de Bootstrap globalmente
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new BSLib.Tooltip(el);
    });
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
        new BSLib.Popover(el);
    });
});
