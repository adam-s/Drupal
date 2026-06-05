# Tulane — Brand Tokens

Authoritative Tulane brand values, to seed the Tulane design-token set (mapped onto Yale's
*token structure* — see [synthesis.md](../synthesis.md)). Sources: Tulane's public brand
guidelines + colors **observed live** on www.tulane.edu via the harvester.

> **Note:** Tulane's Drupal theme (`tulane_tailwindcss`) is **not public on GitHub** — the
> `Tulane` GitHub org only hosts WordPress themes. So the authoritative `tailwind.config.js`
> palette couldn't be read directly; values below come from the published brand guide +
> computed styles. Confirm against the actual theme config when repo access is available.

## Official university palette (Marketing & Communications brand guide)

**Primary:**
| Name | Hex | Pantone |
|------|-----|---------|
| **Tulane Green** | `#285C4D` | PMS 626 |
| **Tulane Blue** (sky) | `#71C5E8` | PMS 297 |

**Secondary:**
| Name | Hex |
|------|-----|
| Storm Shutters (teal) | `#00778B` |
| Mardi Gras (green) | `#78BE20` |
| Olive Branch | `#658D1B` |
| Medallion (gold) | `#CC9900` |
| Verdigris (mint) | `#71DBD4` |

## Athletics palette (Green Wave) — distinct from the university brand
Dark green `#006747` · Kelly green `#43B02A` · Blue `#418FDE` · White `#FFFFFF` · Black `#000000`.
*(Use the university brand above for the main site, not athletics — they differ.)*

## Colors observed live on www.tulane.edu (harvested)
`#138094` (teal — close to Storm Shutters) · `#5fb5d4` (sky — close to Tulane Blue) ·
`#E6F6FC` (pale sky tint) · `#54585A` (warm gray) · `#ffffff`. Plus a `--icon-color-secondary`
custom property.

**Reconciliation / direction note (revised after visual capture):** the homepage is actually
**green-led** — the header and hero overlay are **Tulane Green** (see
[`../_catalog/tulane-hero.jpg`](../_catalog/tulane-hero.jpg)). The teal/sky values
(`#138094`, `#5fb5d4`) seen in inline styles are **accents** (icons/CSS vars), not the
dominant brand. So the current site already leads with green + serif display type. The brand
decision is less "green vs teal" and more **how much** teal/sky/secondary color to use as
accent, and whether to modernize the green.

## Typography
- **Freight** superfamily — confirmed live (`font-freight` ×23; computed `Freight Sans Pro`
  with Georgia/serif fallback). Freight has serif (FreightText/Display) + sans (FreightSans)
  cuts — a one-family pairing.
- Weights in use: **400 / 700** only (+ `font-black`). **Gap:** leaders use a mid weight
  (500/600) for hierarchy — Tulane should license/enable FreightSans Medium/Book.

## Proposed token structure (Yale-style, Tulane values, expressed for Tailwind)
Adopt Yale's organization; express as `tailwind.config.js` theme tokens:
- **color:** primitives (green/blue/teal/gold/neutrals) → semantic roles (background, text,
  heading, cta) → optional **named themes** for sub-brands (the multi-subdomain goal).
- **spacing:** numbered scale (Yale uses 1–12) + semantic (gutter / page-section / page-inner /
  banner). Tailwind already has a spacing scale — extend with the semantic aliases.
- **typography:** Freight serif (display) + FreightSans (body), sizes xl→xs, weights
  400/500/600/700.
- **breakpoints:** Tailwind defaults are close to Yale's (640/768/1024/1280/1536 vs
  576/768/992/1200/1400) — pick one and standardize.
- **effects:** reduced-motion-aware transitions; card hover-rise; link underline; respect
  `prefers-reduced-motion` (copy Yale's accessibility pattern).

## Open questions
- Read the real `tulane_tailwindcss` `tailwind.config.js` when repo access exists (authoritative).
- Brand direction: green-led vs teal/sky-led?
- License FreightSans mid weights (500/600)?

## Sources
- Tulane Brand Guide / Color: https://communications.tulane.edu/brand/color
- Team Color Codes (Tulane): https://teamcolorcodes.com/tulane-green-wave-color-codes/
- Live computed styles: `tools/harvester/out/www.tulane.edu/profile.json`
