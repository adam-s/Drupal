import type { Page, APIRequestContext } from '@playwright/test';
import type { SeoProfile } from './types.js';

/** Extract SEO posture: head meta/OG/Twitter/canonical, JSON-LD types, sitemap + robots. */
export async function extractSeo(page: Page, request: APIRequestContext): Promise<SeoProfile> {
  const head = await page.evaluate(() => {
    const meta = (sel: string, attr = 'content') =>
      (document.querySelector(sel) as HTMLMetaElement | null)?.getAttribute(attr) ?? undefined;
    const props = (prefix: string) =>
      Array.from(document.querySelectorAll(`meta[property^="${prefix}"], meta[name^="${prefix}"]`))
        .map((m) => m.getAttribute('property') ?? m.getAttribute('name') ?? '')
        .filter(Boolean);
    const jsonLd = Array.from(document.querySelectorAll('script[type="application/ld+json"]'))
      .flatMap((s) => {
        try { const d = JSON.parse(s.textContent ?? '{}'); return (Array.isArray(d) ? d : [d]).map((x) => x['@type']).filter(Boolean); }
        catch { return []; }
      });
    return {
      title: document.title,
      description: meta('meta[name="description"]'),
      canonical: meta('link[rel="canonical"]', 'href'),
      openGraph: props('og:'),
      twitter: props('twitter:'),
      jsonLdTypes: Array.from(new Set(jsonLd)),
    };
  });

  const origin = new URL(page.url()).origin;
  let sitemapStatus: number | undefined;
  let robotsDirectives: number | undefined;
  try { sitemapStatus = (await request.get(`${origin}/sitemap.xml`, { timeout: 12_000 })).status(); } catch { /* ignore */ }
  try {
    const r = await request.get(`${origin}/robots.txt`, { timeout: 12_000 });
    if (r.ok()) robotsDirectives = ((await r.text()).match(/^(Disallow|Sitemap):/gim) ?? []).length;
  } catch { /* ignore */ }

  return { ...head, sitemapStatus, robotsDirectives };
}
