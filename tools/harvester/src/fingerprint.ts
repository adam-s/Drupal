import type { Page } from '@playwright/test';
import type { ModuleFingerprint } from './types.js';

/**
 * Detect Drupal core version, theme, hosting, and contrib modules from rendered HTML +
 * response headers, with confidence tagging. Frontend-only — backend modules invisible.
 */
export async function fingerprintModules(page: Page, headers: Record<string, string> = {}): Promise<ModuleFingerprint> {
  const html = await page.content();
  const modules: ModuleFingerprint['modules'] = [];
  const seen = new Set<string>();
  const add = (name: string, confidence: 'confirmed' | 'likely' | 'inferred', evidence: string) => {
    if (seen.has(name)) return; seen.add(name); modules.push({ name, confidence, evidence });
  };

  // Core version
  const gen = html.match(/Drupal\s+(\d+)/i) ?? Object.values(headers).join(' ').match(/Drupal\s+(\d+)/i);
  const drupalCore = gen ? `Drupal ${gen[1]}` : /drupal-settings-json/i.test(html) ? 'Drupal (unversioned)' : undefined;

  // Theme
  const theme = html.match(/\/themes\/(?:custom|contrib)\/([a-z0-9_]+)/i)?.[1];

  // Contrib modules from asset paths (confirmed)
  for (const m of html.matchAll(/\/modules\/contrib\/([a-z0-9_]+)/gi)) add(m[1], 'confirmed', `asset path /modules/contrib/${m[1]}`);

  // Markup signatures (inferred)
  const sig: Array<[RegExp, string]> = [
    [/\bview-id-[a-z0-9_]+/i, 'views'],
    [/\bparagraph--type--/i, 'paragraphs'],
    [/layout__region|layout-builder/i, 'layout_builder'],
    [/layout-paragraphs/i, 'layout_paragraphs'],
    [/webform-submission-form/i, 'webform'],
    [/\/files\/styles\//i, 'image (responsive styles)'],
    [/editoria11y/i, 'editoria11y'],
  ];
  for (const [re, name] of sig) if (re.test(html)) add(name, 'inferred', 'markup signature');

  // Hosting from headers
  const hstr = Object.entries(headers).map(([k, v]) => `${k}: ${v}`).join('\n');
  let hosting: string | undefined;
  if (/x-pantheon|styx/i.test(hstr)) hosting = 'Pantheon';
  else if (/x-ah-|acquia/i.test(hstr)) hosting = 'Acquia';
  if (/x-served-by.*cache|fastly/i.test(hstr)) hosting = (hosting ? hosting + '+' : '') + 'Fastly';
  if (/cf-ray|cloudflare/i.test(hstr)) hosting = (hosting ? hosting + '+' : '') + 'Cloudflare';

  return { drupalCore, theme, hosting, modules };
}
