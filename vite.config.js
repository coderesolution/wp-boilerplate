import { defineConfig } from 'vite';
import { resolve } from 'path';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

export default defineConfig(({ command, mode }) => {
  const isDev = command === 'serve' || mode === 'development';

  return {
    base: '/wp-content/themes/sage/public/build/',
    css: {
      devSourcemap: isDev,
    },
    plugins: [
      tailwindcss(),
      laravel({
        input: [
          'resources/css/app.css',
          'resources/js/app.js',
          'resources/css/editor.css',
          'resources/js/editor.js',
          'resources/css/admin.css',
          'resources/css/login.css',
        ],
        refresh: true,
      }),

      wordpressPlugin(),

      // Generate the theme.json file in the public/build/assets directory
      // based on the Tailwind config and the theme.json file from base theme folder
      wordpressThemeJson({
        cssFile: 'resources/css/app.css',
        disableTailwindColors: false,
        disableTailwindFonts: false,
        disableTailwindFontSizes: false,
        settings: {
          spacing: {
            margin: true,
            padding: true,
            units: ['px', '%', 'em', 'rem', 'vw', 'vh'],
          },
        },
      }),
    ],
    resolve: {
      alias: {
        '@scripts': resolve(__dirname, 'resources/js'),
        '@styles': resolve(__dirname, 'resources/css'),
        '@fonts': resolve(__dirname, 'resources/fonts'),
        '@images': resolve(__dirname, 'resources/images'),
      },
    },
    server: {
      host: '0.0.0.0',
      port: 5173,
      strictPort: true,
      origin: 'http://localhost:5173',
      cors: true,
      hmr: {
        host: 'localhost',
        protocol: 'ws',
      },
    },
  };
});
