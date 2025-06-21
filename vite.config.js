import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'public',
    assetsDir: 'assets',
    rollupOptions: {
      input: 'src/main.js',
      output: {
        entryFileNames: 'assets/[name].js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: 'assets/[name][extname]'
      }
    }
  }
});
