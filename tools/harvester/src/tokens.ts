import type { Page } from '@playwright/test';
import type { TokenSet } from './types.js';

/**
 * Read getComputedStyle across representative elements and infer the design scales.
 * This is the "compute margin/padding/font-weight via CDP" deliverable — real rendered
 * values, not raw CSS.
 */
export async function extractTokens(page: Page): Promise<TokenSet> {
  return page.evaluate(() => {
    const selectors = ['body', 'h1', 'h2', 'h3', 'h4', 'p', 'a', 'button', '[class*="card"]', '[class*="btn"]', 'nav'];
    const samples: Record<string, Record<string, string>> = {};
    const spacing = new Set<number>();
    const sizes = new Set<number>();
    const weights = new Set<number>();
    const lineHeights = new Set<number>();
    const families = new Set<string>();
    const text = new Set<string>();
    const background = new Set<string>();
    const radii = new Set<number>();
    const shadows = new Set<string>();

    const px = (v: string) => parseFloat(v);
    const addSpace = (v: string) => v.split(' ').forEach((p) => { const n = px(p); if (n > 0) spacing.add(n); });

    for (const sel of selectors) {
      const el = document.querySelector(sel);
      if (!el) continue;
      const cs = getComputedStyle(el);
      samples[sel] = {
        margin: cs.margin, padding: cs.padding, fontFamily: cs.fontFamily,
        fontSize: cs.fontSize, fontWeight: cs.fontWeight, lineHeight: cs.lineHeight,
        color: cs.color, backgroundColor: cs.backgroundColor, borderRadius: cs.borderRadius,
        boxShadow: cs.boxShadow,
      };
      addSpace(cs.margin); addSpace(cs.padding);
      if (px(cs.fontSize) > 0) sizes.add(px(cs.fontSize));
      if (parseInt(cs.fontWeight) > 0) weights.add(parseInt(cs.fontWeight));
      if (px(cs.lineHeight) > 0) lineHeights.add(Math.round(px(cs.lineHeight) * 100) / 100);
      cs.fontFamily.split(',').forEach((f) => families.add(f.trim().replace(/["']/g, '')));
      if (cs.color) text.add(cs.color);
      if (cs.backgroundColor && cs.backgroundColor !== 'rgba(0, 0, 0, 0)') background.add(cs.backgroundColor);
      if (px(cs.borderRadius) > 0) radii.add(px(cs.borderRadius));
      if (cs.boxShadow && cs.boxShadow !== 'none') shadows.add(cs.boxShadow);
    }

    const sortNum = (s: Set<number>) => Array.from(s).sort((a, b) => a - b);
    return {
      spacing: sortNum(spacing),
      typography: { family: Array.from(families), sizes: sortNum(sizes), weights: sortNum(weights), lineHeights: sortNum(lineHeights) },
      colors: { palette: Array.from(new Set([...text, ...background])), text: Array.from(text), background: Array.from(background) },
      radii: sortNum(radii),
      shadows: Array.from(shadows),
      samples,
    };
  });
}
