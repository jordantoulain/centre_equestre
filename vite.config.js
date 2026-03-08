import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: [
        'src/app.css',
        'src/index.js'
      ]
    }
  },
  server: {
    strictPort: true,
    port: 5173,
    origin: 'http://localhost:5173'
  }
});
