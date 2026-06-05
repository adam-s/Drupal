import type { Page } from '@playwright/test';
import type { RegionTree } from './types.js';

/**
 * Walk the DOM for Drupal region/block/component structure and infer the layout system.
 * The central deliverable: how pages are composed (regions, blocks, components).
 */
export async function extractRegions(page: Page): Promise<RegionTree> {
  return page.evaluate(() => {
    const html = document.documentElement.outerHTML;
    const count = (re: RegExp) => (html.match(re) ?? []).length;

    const signals: Record<string, number> = {
      'region--': count(/class="[^"]*\bregion--[a-z0-9_-]+/gi),
      'layout__region': count(/layout__region/gi),
      'layout--': count(/class="[^"]*\blayout--[a-z0-9_-]+/gi),
      'layout-paragraphs': count(/layout-paragraphs/gi),
      'block-': count(/class="[^"]*\bblock-[a-z0-9_-]+/gi),
      'paragraph--type--': count(/paragraph--type--[a-z0-9_-]+/gi),
      'data-component': count(/data-component[-a-z]*/gi),
      'views-row': count(/views-row/gi),
    };

    let layoutSystem: RegionTree['layoutSystem'] = 'unknown';
    if (signals['layout-paragraphs'] > 0) layoutSystem = 'layout_paragraphs';
    else if (signals['layout__region'] > 0) layoutSystem = 'layout_builder';
    else if (signals['block-'] > 0) layoutSystem = 'blocks';

    // Region landmarks (HTML5 + Drupal region classes)
    const regionEls = Array.from(
      document.querySelectorAll('[class*="region--"], [class*="region-"], header, nav, main, aside, footer'),
    ).slice(0, 40);

    const regions = regionEls.map((el) => {
      const cls = (el.getAttribute('class') ?? '').split(/\s+/).filter(Boolean);
      const name =
        cls.find((c) => c.startsWith('region--') || c.startsWith('region-')) ?? el.tagName.toLowerCase();
      const blockEls = Array.from(el.querySelectorAll('[class*="block-"], [data-component-width]')).slice(0, 12);
      const blocks = blockEls.map((b) => {
        const bc = (b.getAttribute('class') ?? '').split(/\s+/).filter(Boolean);
        const r = (b as HTMLElement).getBoundingClientRect();
        return {
          type: bc.find((c) => c.startsWith('block-')) ?? 'component',
          classes: bc.slice(0, 6),
          componentGuess: b.getAttribute('data-component-variation') ?? undefined,
          box: { w: Math.round(r.width), h: Math.round(r.height) },
        };
      });
      return { name, selector: cls[0] ? `.${cls[0]}` : el.tagName.toLowerCase(), blocks };
    });

    return { regions, layoutSystem, signals };
  });
}
