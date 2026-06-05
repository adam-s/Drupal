import type { Page } from '@playwright/test';
import type { ScrollProfile } from './types.js';

/**
 * Characterize header/menu scroll behavior — scriptably scroll and snapshot the header's
 * computed style + classList at each offset, then classify the pattern. Answers the
 * "how do they animate menus/headers on scroll" question.
 */
export async function captureScrollBehavior(page: Page): Promise<ScrollProfile> {
  // Score candidate headers and tag the best one with a data attribute (robust vs.
  // brittle class selectors). Prefer sticky/fixed, containing the primary nav, near the
  // top, and of plausible header height (avoid matching a huge page wrapper — the NYU bug).
  const headerSel = await page.evaluate(() => {
    const cands = Array.from(
      document.querySelectorAll('header, [role="banner"], [class*="site-header"], [class*="masthead"], [class*="navbar"], [class*="header"]'),
    );
    let best: Element | null = null;
    let bestScore = -Infinity;
    for (const el of cands) {
      const r = el.getBoundingClientRect();
      const cs = getComputedStyle(el);
      const h = r.height;
      if (h < 24 || h > 400) continue; // a real header isn't 5000px tall
      let score = 0;
      if (cs.position === 'fixed' || cs.position === 'sticky') score += 5;
      if (el.querySelector('nav, [role="navigation"]')) score += 4;
      if (r.top <= 10) score += 3; // anchored near the very top
      if (el.tagName === 'HEADER' || el.getAttribute('role') === 'banner') score += 2;
      if (h >= 40 && h <= 200) score += 2; // typical header band
      if (score > bestScore) { bestScore = score; best = el; }
    }
    if (!best) return null;
    best.setAttribute('data-harvest-header', '1');
    return '[data-harvest-header]';
  });
  if (!headerSel) return { pattern: 'static', states: [], library: null };

  // Larger offsets reach late-triggering headers; the final -1 is a scroll-UP step
  // (after going deep) to catch hide-on-down / reveal-on-up behavior.
  const offsets = [0, 400, 1000, 2000, -1];
  const states: ScrollProfile['states'] = [];
  for (const offset of offsets) {
    if (offset === -1) {
      // reveal test: jump deep, then scroll up a bit
      await page.evaluate(() => window.scrollTo(0, 2400));
      await page.waitForTimeout(250);
      await page.evaluate(() => window.scrollBy(0, -300));
    } else {
      await page.evaluate((y) => window.scrollTo(0, y), offset);
    }
    await page.waitForTimeout(400);
    const s = await page.evaluate((sel) => {
      const el = document.querySelector(sel) as HTMLElement | null;
      if (!el) return null;
      const cs = getComputedStyle(el);
      return { position: cs.position, transform: cs.transform, height: Math.round(el.getBoundingClientRect().height), classes: el.className.split(/\s+/).filter(Boolean), transition: cs.transition };
    }, headerSel);
    if (s) states.push({ offset, position: s.position, transform: s.transform, height: s.height, classes: s.classes });
  }

  // Classify
  const positions = new Set(states.map((s) => s.position));
  const heights = new Set(states.map((s) => s.height));
  const transforms = new Set(states.map((s) => s.transform).filter((t) => t && t !== 'none'));
  const allClasses = states.flatMap((s) => s.classes).join(' ');

  let pattern: ScrollProfile['pattern'] = 'static';
  if (positions.has('fixed') || positions.has('sticky')) pattern = 'sticky';
  if (heights.size > 1) pattern = 'shrink';
  if (transforms.size > 0 && /translateY\(-/.test([...transforms].join(' '))) pattern = 'hide-reveal';
  if ((heights.size > 1 ? 1 : 0) + (transforms.size > 0 ? 1 : 0) > 1) pattern = 'mixed';

  let library: string | null = null;
  if (/headroom/i.test(allClasses)) library = 'headroom';
  else if (/is-stuck|scrolled|sticky--active|pinned|unpinned/i.test(allClasses)) library = 'custom/class-based';

  await page.evaluate(() => window.scrollTo(0, 0));
  return { pattern, states, library };
}
