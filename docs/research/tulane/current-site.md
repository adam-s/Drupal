# Tulane — Current Site Teardown (www.tulane.edu)

**Key discovery:** Tulane already runs a Drupal site. This reframes the project from
greenfield to **evolution/redesign of an existing platform.** Captured from public HTML +
headers (`html_www.tulane.edu.html`).

## Current stack

| Aspect | Finding |
|--------|---------|
| **Drupal core** | **10** |
| **Hosting/CDN** | **Pantheon + Fastly** (nginx; `cache-chi/cache-lim` Fastly nodes) |
| **Theme** | `tulane_tailwindcss` — **Tailwind CSS** based (not SCSS/Emulsify) |
| **Page building** | **Layout Builder** (`layout__region`, `layout--onecol`) + **Paragraphs** |
| **Brand type** | **Freight** family (`font-freight` ×23) + `font-serif` |
| **Services** | Slate (admissions), Google Tag Manager, Font Awesome |
| **SEO** | 1 JSON-LD block (ahead of peers!); minimal Open Graph (`og:title` only) |

Tulane's stack already **matches the peer mainstream** (Pantheon + Fastly + Layout Builder +
custom theme + Slate). The differentiator vs. Yale: **Tailwind** (Tulane) vs. **SCSS/Emulsify**
(Yale).

## Theme structure (`tulane_tailwindcss`)
Organized as **patterns** + a Tailwind build:
- `patterns/events/css/events.css`, `patterns/newsremote/css/remotenews.css` — component CSS
- `dist/tailwind.css` — compiled Tailwind
- So the component model is **pattern-based Tailwind**, not Emulsify atomic design.

## Current component set (small — the main gap)
Paragraph + block types in use:
- **Paragraphs:** `hero`, `image-and-text`, `quick-links`
- **Block types:** hero, image-and-text, quick-links, svg-standalone, basic, block-content,
  plus system blocks (branding, menu, main, views)

That's **~5 real components** vs. Yale's **~30 molecules + organisms**. The biggest gap
between Tulane and the peer leaders is **component library breadth**, not platform.

## Brand tokens (observed)
- **Type:** Freight (serif superfamily) — `font-freight`, `font-serif`, weights bold/black/normal.
- **Colors (from inline styles / CSS vars):** `#138094` (teal), `#5fb5d4` (sky blue),
  `#E6F6FC` (pale sky), `#54585A` (gray), `#ffffff`; `--icon-color-secondary`. A **teal/sky-blue**
  accent palette is in use (verify against official Tulane brand: traditionally green + blue).
- Custom Tailwind color tokens live in the compiled `dist/tailwind.css` (not inline) — read
  the theme's `tailwind.config.js` for the authoritative palette when we have repo access.

## What this means for the project

The work is **not "build a new Drupal site"** — it's **"evolve the existing Tulane D10
Tailwind/Paragraphs platform"**, likely:
1. **Expand the component library** from ~5 to a Yale-class set (cards, callouts,
   facts-and-figures, pull-quote, accordion, tabs, related-content, tiles, galleries,
   in-this-section, etc.) — the clearest gap.
2. **Formalize a design-token system** (Tulane currently has ad-hoc hex + Tailwind utilities;
   Yale has a structured token system). Adopt Yale's *token structure* but express it as
   **Tailwind theme tokens** (`tailwind.config.js`), not SCSS — fits Tulane's stack.
3. **Consider a Drupal 11 upgrade** (peers — Stanford, Penn, Harvard College — are on 11).
4. **Strengthen SEO** — expand Open Graph + JSON-LD coverage (already has a JSON-LD head start).

> **Important architecture note:** because Tulane is **Tailwind** and Yale is **SCSS/Emulsify**,
> do **not** drop in Yale's component library wholesale. Adopt Yale's component *taxonomy* and
> *token structure*, re-implement in Tulane's Tailwind pattern system. "Emulate Yale" =
> match the richness and rigor, not the CSS toolchain.

## Open questions to confirm
- Is there a Tulane theme/repo we can read (`tailwind.config.js`, pattern library)?
- Is the goal a **redesign on D10**, a **D11 upgrade**, or a **rebuild**?
- Official Tulane brand palette + type (Freight confirmed; need the full token set).
- Scope: whole www.tulane.edu, or department subdomains too (the "many subdomains" goal)?
