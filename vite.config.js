import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import commonjs from '@rollup/plugin-commonjs';     

export default defineConfig({
    plugins: [
        laravel({

            input: [
                'resources/css/style.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/table.css',
                'node_modules/admin-lte/plugins/jquery/jquery.min.js',
                'node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js',
                'node_modules/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                'node_modules/admin-lte/plugins/select2/js/select2.full.min.js',
                'node_modules/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js',
                'node_modules/admin-lte/plugins/bs-stepper/css/bs-stepper.min.css',
                'node_modules/admin-lte/plugins/select2/js/select2.full.min.js',
                'node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js',
                'node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js',
                'node_modules/admin-lte/plugins/select2/css/select2.min.css',
                'node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js',
                'node_modules/admin-lte/dist/js/demo.js',
                'resources/js/scripts.js',
                'node_modules/admin-lte/dist/css/adminlte.min.css',
                'node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.css',
                'node_modules/frappe-gantt/dist/frappe-gantt.css',
                'node_modules/frappe-gantt/dist/frappe-gantt.min.js',
                'node_modules/frappe-gantt/dist/frappe-gantt.min.css',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js',
                'node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js',
                'node_modules/admin-lte/plugins/jszip/jszip.min.js',
                'node_modules/admin-lte/plugins/jquery-ui/jquery-ui.min.js',
                'resources/js/graphique.js',
                'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js',
                'node_modules/admin-lte/plugins/chart.js/Chart.min.js',
                'node_modules/admin-lte/plugins/summernote/summernote-bs4.min.js',
                'node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js',
                'node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
                'resources/js/tableau.js',
                'node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.js'
            ],
           

            refresh: true,
        }),
        commonjs(),
    ],
    resolve: {
        alias: [
            {
                // this is required for the SCSS modules
                find: /^~(.*)$/,
                replacement: '$1',
            },
        ],
    },
    build: {
        commonjsOptions: {
            include: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/table.css',
                'node_modules/admin-lte/plugins/jquery/jquery.min.js',
                'node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js',
                'node_modules/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                'node_modules/admin-lte/plugins/select2/js/select2.full.min.js',
                'node_modules/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js',
                'node_modules/admin-lte/plugins/bs-stepper/css/bs-stepper.min.css',
                'node_modules/admin-lte/plugins/select2/js/select2.full.min.js',
                'node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
                'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js',
                'node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js',
                'node_modules/admin-lte/plugins/select2/css/select2.min.css',
                'node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js',
                'node_modules/admin-lte/dist/js/demo.js',
                'resources/js/scripts.js',
                'node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.css',
                'node_modules/frappe-gantt/dist/frappe-gantt.css',
                'node_modules/frappe-gantt/dist/frappe-gantt.min.js',
                'node_modules/frappe-gantt/dist/frappe-gantt.min.css',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js',
                'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js',
                'node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js',
                'node_modules/admin-lte/plugins/jszip/jszip.min.js',
                'node_modules/admin-lte/plugins/jquery-ui/jquery-ui.min.js',
                'resources/js/graphique.js',
                'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js',
                'node_modules/admin-lte/plugins/chart.js/Chart.min.js',
                'node_modules/admin-lte/plugins/summernote/summernote-bs4.min.js',
                'node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js',
                'node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
                'resources/js/tableau.js',
                'node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.js'
                
            ],
        },
    }

});
