# Visual Component Catalog

Token-optimized screenshots (1280px capture → downscaled to 1024px JPEG) of key
components/sections on YaleSites and Tulane, for side-by-side reference. Captured via
Playwright element screenshots.

## Yale (yalesites.yale.edu)

| Image | Notes |
|-------|-------|
| `yale-header.jpg` | Slim header; logo + primary nav + search. |
| `yale-hero.jpg` | **Split hero** — gold theme panel (left) with **sans heading** + **two CTAs** ("Get Started" solid + "Sign up" outlined), campus photo (right). Conversion-oriented; rectangular buttons (radius 0). |
| `yale-callout-or-card.jpg` | **Reference-card grid** with **faceted search** (Search / Category / Areas of Study + Apply) above, and a **Yale-Blue (`#00356b`) callout** with "LATEST RELEASE" eyebrow + large **YaleNew serif** heading + date + body. Shows the eyebrow + serif-heading + themed-block pattern. |
| `yale-footer.jpg` | Multi-column footer. |

## Tulane (www.tulane.edu)

| Image | Notes |
|-------|-------|
| `tulane-header.jpg` | **Green header** (Tulane Green), white logo/wordmark; nav: Request Info / Visit / Apply / Give / Alumni + Search + **Menu hamburger (even on desktop)**. 64px tall. |
| `tulane-hero.jpg` | **Full-bleed campus aerial** with a **green overlay box** + huge **Freight serif display** heading ("Make Way for a Parade of Possibilities"). **No CTA buttons** — brand/emotional, not conversion. GDPR consent bar at bottom. |
| `tulane-quick-links.jpg` | Quick-links block (Tulane's existing component). |
| `tulane-footer.jpg` | Footer (small fragment captured). |

## Observations (grounded in the screenshots)

1. **Tulane is green-led, not teal.** The homepage header + hero overlay are **Tulane Green**
   — correcting the earlier "leans teal/sky" note (teal `#138094`/`#5fb5d4` are accents, not
   the dominant brand). See the correction in [../tulane/brand-tokens.md](../tulane/brand-tokens.md).
2. **Type personalities confirmed visually:** Tulane = **big serif display** (Freight, ~96px),
   editorial/dramatic. Yale = **sans hero heading** + serif (YaleNew) reserved for content
   callouts — cleaner/modern.
3. **CTA strategy differs:** Yale's hero has **two clear CTAs**; Tulane's hero has **none**
   (just a statement). For a prospective-student conversion path, Tulane's hero could add
   primary/secondary CTAs (Apply / Request Info) like Yale.
4. **Both use rectangular, radius-0** elements — shared institutional design language.
5. **Tulane's desktop nav already collapses to a hamburger** — unusual; worth confirming
   whether that's intentional (it reduces top-level wayfinding vs. Yale's exposed nav).
6. **Reference cards + faceted search** (Yale) is a strong pattern Tulane lacks — directly
   supports the cards/card-collection items in the
   [component backlog](../tulane/component-backlog.md).

## Method / confidence
- Element screenshots via best-guess selectors; some captures are partial (tulane-footer
  caught a small fragment; a tighter selector would improve it).
- Images downscaled to 1024px (token-optimized) — legible for review, cheap for LLM analysis.
- Captured at 1280px desktop viewport; mobile catalog not yet done.
