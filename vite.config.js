import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jquery',
            'jQuery': 'jquery',
        },
    },
    server: {
        host: '127.0.0.1',
    },
    optimizeDeps: {
        include: [
            'jquery',
            'bootstrap',
            'datatables.net',
            'datatables.net-bs4',
            'sweetalert2',
            'admin-lte'
        ],
        exclude: [
            'pdfmake',
            'datatables.net-buttons'
        ]
    },
    build: {
        rollupOptions: {
            external: ['pdfmake/build/vfs_fonts']
        }
    }
});