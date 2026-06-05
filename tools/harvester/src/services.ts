import { readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';
import type { Page } from '@playwright/test';
import type { ServiceInventory } from './types.js';

const __dirname = dirname(fileURLToPath(import.meta.url));
interface Sig { category: string; name: string; patterns: string[] }
const SIGS: Sig[] = JSON.parse(readFileSync(join(__dirname, '../signatures/services.json'), 'utf8')).services;

/**
 * Detect third-party services from page HTML + response headers, matched against the
 * signature catalog. GA/GTM omitted (assumed). Confidence: a vendor script/asset domain
 * is "confirmed"; a bare class/cookie token is "likely".
 */
export async function detectServices(page: Page, headers: Record<string, string> = {}): Promise<ServiceInventory> {
  const html = await page.content();
  const hay = html + '\n' + Object.entries(headers).map(([k, v]) => `${k}: ${v}`).join('\n');

  const services: ServiceInventory['services'] = [];
  for (const sig of SIGS) {
    for (const p of sig.patterns) {
      const re = new RegExp(p, 'i');
      const m = hay.match(re);
      if (m) {
        const evidence = m[0];
        const confidence = /https?:|\.com|\.net|\.org|googleapis|cloudflare/i.test(evidence) ? 'confirmed' : 'likely';
        services.push({ category: sig.category, name: sig.name, confidence, evidence });
        break;
      }
    }
  }
  return { services };
}
