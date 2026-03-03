const esbuild = require('esbuild');
const fs = require('fs');
const glob = require('glob');

const tailwindPath = '.tmp/app.css';
const assets = glob.sync('src/**/*.{svg,png,jpg,woff,woff2,js,ttf}');
const entryPoints = [
  tailwindPath,
  ...assets
];

const outdir = 'public/dist';


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

      if (!fs.existsSync(outdir)) {
        fs.mkdirSync(outdir, { recursive: true });
      }

      fs.writeFileSync(`${outdir}/manifest.json`, JSON.stringify(mapping, null, 2));

      const date = new Date().toLocaleTimeString();
      console.log(`[${date}] ⚡ Build mis à jour avec succès !`);
    });
  },
};

async function run() {
  if (fs.existsSync(outdir)) {
    fs.rmSync(outdir, { recursive: true, force: true });
    console.log('🧹 Dossier build vidé.');
  }

  const ctx = await esbuild.context({
    entryPoints: entryPoints,
    bundle: true,
    outdir: outdir,
    plugins: [manifestPlugin],
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
