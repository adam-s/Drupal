import { test } from '@playwright/test';
import {
  gotoRendered, shot, extractRegions, extractTokens, captureScrollBehavior,
  extractSeo, fingerprintModules, detectServices, writeProfile,
} from '../src/index.js';
import type { SiteProfile } from '../src/types.js';

/**
 * Full browser-level profile of each target. Run: `npm run harvest`.
 * Edit TARGETS (or pass HARVEST_TARGETS as a comma-separated list) to choose sites.
 * Focus list = the headers-only-masked sites + the D11 references worth deep capture.
 */
const DEFAULT_TARGETS = [
  'https://college.harvard.edu/',
  'https://www.upenn.edu/',
  'https://www.cornell.edu/',
  'https://yalesites.yale.edu/',
  'https://undergrad.stanford.edu/',
];

const TARGETS = (process.env.HARVEST_TARGETS?.split(',').map((s) => s.trim()).filter(Boolean)) ?? DEFAULT_TARGETS;

for (const url of TARGETS) {
  test(`profile ${url}`, async ({ page, request }) => {
    const r = await gotoRendered(page, url);
    test.skip(!r.rendered, `unrendered: ${r.reason}`);

    // Response headers for fingerprinting (re-fetch head cheaply via APIRequestContext)
    let headers: Record<string, string> = {};
    try { headers = (await request.get(url, { timeout: 20_000 })).headers(); } catch { /* ignore */ }

    const profile: SiteProfile = {
      site: new URL(url).hostname,
      url,
      mode: 'cdp',
      regions: await extractRegions(page),
      tokens: await extractTokens(page),
      scroll: await captureScrollBehavior(page),
      seo: await extractSeo(page, request),
      fingerprint: await fingerprintModules(page, headers),
      services: await detectServices(page, headers),
      screenshots: [await shot(page, new URL(url).hostname)],
    };
    profile.capturedAt = new Date().toISOString();
    const path = writeProfile(profile);
    test.info().annotations.push({ type: 'profile', description: path });
  });
}
