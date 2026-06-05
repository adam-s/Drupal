import type { Page } from '@playwright/test';
import type { RenderResult } from './types.js';

/**
 * Navigate and verify the page actually rendered, and detect whether it's Drupal.
 * Returns rendered:false with a reason rather than silently profiling a broken page.
 * (Adapted from the prairielearn-debug gotoRendered pattern.)
 */
export async function gotoRendered(page: Page, url: string): Promise<RenderResult> {
  let status: number | null = null;
  try {
    const resp = await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 45_000 });
    status = resp?.status() ?? null;
  } catch (e) {
    return { rendered: false, status, reason: `navigation error: ${String(e)}` };
  }
  if (status && status >= 400) return { rendered: false, status, reason: `http ${status}` };

  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(500);

  const probe = await page.evaluate(() => {
    const text = document.body?.innerText ?? '';
    const broken =
      (document.body?.children.length ?? 0) === 0
        ? 'empty body'
        : /Access denied|Internal Server Error|Page not found/i.test(text.slice(0, 400))
          ? 'error page'
          : null;
    const html = document.documentElement.outerHTML;
    const isDrupal =
      /drupal-settings-json/i.test(html) ||
      /\/core\/(misc|themes|modules)\//i.test(html) ||
      /\/sites\/default\/files\//i.test(html) ||
      /name="Generator"\s+content="Drupal/i.test(html);
    return { broken, isDrupal };
  });

  if (probe.broken) return { rendered: false, status, reason: probe.broken, isDrupal: probe.isDrupal };
  return { rendered: true, status, isDrupal: probe.isDrupal };
}
