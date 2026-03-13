import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { glob } from 'glob';
import { fileURLToPath } from 'node:url';
import { relative } from 'node:path';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: glob.sync('src/**/*.{js,css}').map(file => fileURLToPath(new URL(file, import.meta.url)))
    }
  },
  server: {
    strictPort: true,
    port: 5173,
    origin: 'http://localhost:5173'
  }
});
