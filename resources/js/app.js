import './bootstrap';

// --- INICIO DE LA CORRECCIÓN ---

// 1. Importa el objeto de Bootstrap
import * as bootstrap from 'bootstrap';

// 2. Hazlo disponible globalmente
window.bootstrap = bootstrap;

// --- FIN DE LA CORRECCIÓN ---


// Tus otras importaciones están bien
import 'admin-lte';
import 'datatables.net-bs4';
import 'jquery';

// Importa SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;
