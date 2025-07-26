// 1. Importa jQuery primero y hazlo global
import $ from 'jquery';
window.$ = window.jQuery = $;

// 2. Configuración robusta de pdfMake
const initializePdfMake = async () => {
    try {
        const pdfMakeModule = await import('pdfmake/build/pdfmake');
        const vfsFontsModule = await import('pdfmake/build/vfs_fonts');
        
        if (pdfMakeModule && pdfMakeModule.default && vfsFontsModule && vfsFontsModule.default) {
            window.pdfMake = pdfMakeModule.default;
            window.pdfMake.vfs = vfsFontsModule.default.pdfMake.vfs;
            console.log('pdfMake configurado correctamente');
        } else {
            console.warn('pdfMake o vfs_fonts no se cargaron correctamente');
        }
    } catch (error) {
        console.error('Error al cargar pdfmake:', error);
    }
};

// 3. Importa otras dependencias
import 'bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'datatables.net';
import 'datatables.net-bs4';
import 'datatables.net-responsive';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';

import 'admin-lte';
import Swal from 'sweetalert2';
window.Swal = Swal;

// 4. Inicialización
document.addEventListener('DOMContentLoaded', async () => {
    await initializePdfMake();
    console.log('Dependencias cargadas - jQuery:', typeof $ !== 'undefined', 'pdfMake:', typeof pdfMake !== 'undefined');
});