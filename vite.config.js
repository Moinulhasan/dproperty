import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
                'resources/css/select2.css',
                'resources/css/listings.css',
                'resources/js/site.js',
                'resources/js/select2.js',
                'resources/js/pages/home.js',
                'resources/js/pages/listings.js',
                'resources/js/pages/location_properties.js',
                'resources/js/pages/property_details.js',
                'resources/js/pages/post_property.js',
                'resources/js/pages/company_register.js',
            ],
            refresh: true,
        }),
    ],
});
