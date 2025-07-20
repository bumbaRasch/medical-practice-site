import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/services-slideshow.js',
                'resources/js/theme-controller.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Enable CSS minification
        cssMinify: true,
        // Enable JS minification
        minify: 'terser',
        // Configure terser options for better compression
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.logs in production
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
        },
        // Enable rollup optimizations
        rollupOptions: {
            output: {
                // Manual chunks for better caching
                manualChunks: {
                    // Vendor chunk for third-party dependencies
                    vendor: ['axios'],
                },
                // Consistent file names for better caching
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },
        // Optimize chunk size
        chunkSizeWarningLimit: 1000,
        // Enable source maps in development only
        sourcemap: false,
    },
    css: {
        // PostCSS optimizations
        postcss: {
            plugins: [
                // TailwindCSS will handle purging via the config
            ],
        },
    },
    // Server configuration for development
    server: {
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: false,
        },
    },
    // Optimize dependencies
    optimizeDeps: {
        include: ['axios'],
        exclude: [],
    },
});
