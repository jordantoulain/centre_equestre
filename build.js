const esbuild = require('esbuild');
const { sassPlugin } = require('esbuild-sass-plugin');
const fs = require('fs');
const glob = require('glob');

const assets = glob.sync('src/**/*.{svg,png,jpg,woff,woff2,js,scss,ttf}');

const manifestPlugin = {
  name: 'generate-manifest',
  setup(build) {
    build.onEnd(result => {
      if (result.errors.length > 0) {
        console.error('❌ Echec du build.');
        return;
      }

      const mapping = {};
      
      Object.keys(result.metafile.outputs).forEach(outputFile => {
        const entry = result.metafile.outputs[outputFile].entryPoint;
        if (entry) {
          const cleanOutput = outputFile.replace(/^public\//, '');
          mapping[entry] = cleanOutput;
        }
      });

      fs.writeFileSync('public/build/manifest.json', JSON.stringify(mapping, null, 2));
      
      const date = new Date().toLocaleTimeString();
      console.log(`[${date}] ⚡ Build mis à jour avec succès !`);
    });
  },
};

async function run() {
  const ctx = await esbuild.context({
    entryPoints: assets,
    bundle: true,
    outdir: 'public/build',
    plugins: [sassPlugin(), manifestPlugin],
    metafile: true,
    entryNames: '[name]-[hash]',
    minify: true,
    
    loader: {
      '.svg': 'copy',
      '.png': 'copy',
      '.jpg': 'copy',
      '.ttf': 'copy',
      '.woff': 'file',
      '.woff2': 'file'
    },
  });

  if (process.argv.includes('--watch')) {
    console.log('👀 Mode Watch activé...');
    await ctx.watch();
  } else {
    await ctx.rebuild();
    console.log('✅ Build de production terminé.');
    await ctx.dispose();
  }
}

run().catch(() => process.exit(1));