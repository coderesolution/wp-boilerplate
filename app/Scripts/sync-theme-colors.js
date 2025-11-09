#!/usr/bin/env node

/**
 * Sync custom colors from @theme block in app.css to theme.json
 * This ensures custom colors defined in @theme are available in WordPress editor
 */

import { readFileSync, writeFileSync } from 'fs';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const rootDir = resolve(__dirname, '../..');

const appCssPath = resolve(rootDir, 'resources/css/app.css');
const themeJsonPath = resolve(rootDir, 'theme.json');

// Read app.css
const appCss = readFileSync(appCssPath, 'utf-8');

// Extract colors from @theme block
const themeBlockRegex = /@theme\s*\{([^}]+)\}/s;
const match = appCss.match(themeBlockRegex);

if (!match) {
  console.log('No @theme block found in app.css');
  process.exit(0);
}

const themeBlockContent = match[1];
const colorRegex = /--color-([a-z0-9-]+):\s*([^;]+);/gi;

const customColors = [];
let colorMatch;

while ((colorMatch = colorRegex.exec(themeBlockContent)) !== null) {
  const [, slug, colorValue] = colorMatch;
  // Convert slug to name (e.g., "lagoon" -> "Lagoon")
  const name = slug
    .split('-')
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');

  customColors.push({
    name,
    slug,
    color: colorValue.trim(),
  });
}

if (customColors.length === 0) {
  console.log('No custom colors found in @theme block');
  process.exit(0);
}

// Read theme.json
const themeJson = JSON.parse(readFileSync(themeJsonPath, 'utf-8'));

// Ensure color.palette exists
if (!themeJson.settings.color.palette) {
  themeJson.settings.color.palette = [];
}

// Remove existing custom colors (those not from Tailwind defaults)
// We'll keep Tailwind colors and add our custom ones
const existingCustomSlugs = customColors.map((c) => c.slug);
themeJson.settings.color.palette = themeJson.settings.color.palette.filter(
  (color) => !existingCustomSlugs.includes(color.slug)
);

// Add custom colors at the beginning of the palette
themeJson.settings.color.palette = [
  ...customColors,
  ...themeJson.settings.color.palette,
];

// Write updated theme.json
writeFileSync(themeJsonPath, JSON.stringify(themeJson, null, 2) + '\n');

console.log(
  `✅ Synced ${customColors.length} custom colors from @theme to theme.json:`
);
customColors.forEach((color) => {
  console.log(`   - ${color.name} (${color.slug})`);
});
