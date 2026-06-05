# Tulane vs Yale — Component Computed-CSS Deltas

Side-by-side `getComputedStyle` of comparable elements on www.tulane.edu vs
yalesites.yale.edu (desktop 1280px). Raw values: `component-deltas.json`. This shows how the
two design languages actually render — useful for deciding Tulane's direction.

## Measured comparison

| Element | Tulane (computed) | Yale (computed) |
|---------|-------------------|-----------------|
| **h1** | **96px / 700**, serif (ui-serif), padding `0 64px` | (not sampled on page) |
| **h2** | 22px / 700, Freight Sans, padding `0 0 32px` | 24.5px / **400**, **YaleNew** (serif) |
| **body** | 20px / 400, **Bookmania** (serif) | 19.5px / 400, **Mallory Compact** (sans) |
| **card** | 22px / 700, Freight Sans, padding `12px 20px` | 19.5px / 400, Mallory, padding `0 40px` |
| **hero text** | 16px / 400, Freight Sans | 19.5px / 400, Mallory Compact |
| **button/link** | 13.3px / 400, **Arial** (fallback!), padding `12px 20px` | 19.5px / 400, Mallory, padding `8px` |
| **border-radius** | **0** everywhere sampled | **0** everywhere sampled |

## What the deltas reveal

### Type personality: Tulane = serif/editorial, Yale = sans/modern
- **Tulane leans serif** — body in **Bookmania** (a Freight-family serif) and a large **96px
  serif h1**. Traditional, editorial, high-contrast display.
- **Yale leans sans** — **Mallory** sans for body/UI, **YaleNew** serif reserved for headings
  at a light **400** weight. Cleaner, more contemporary.
- **Weight strategy differs:** Tulane pushes hierarchy with **bold (700)** + size (96px);
  Yale gets elegance from a **serif at 400**. Tulane currently lacks a mid weight (500/600)
  — see [brand-tokens.md](brand-tokens.md).

### Shared: sharp corners
Both render **`border-radius: 0`** on sampled components — a rectilinear, institutional design
language. If Tulane wants to feel softer/more modern, radius is an easy lever; if it wants to
stay classic, it already matches Yale.

### Tulane weak spot: buttons fall back to Arial
Tulane's button computed font is **Arial at 13.3px** — the brand font (Freight) isn't applied
to buttons, and the size is small. Yale's CTA uses the brand font (Mallory) at 19.5px. **Fix:
apply Freight/FreightSans to buttons and bump size** — a quick, visible polish.

### Spacing
Tulane cards use tighter padding (`12px 20px`) vs Yale's generous `0 40px` inline padding.
Yale's larger gutters read as more premium/airy. Consider increasing Tulane component padding
to the token scale (Yale's `--size-spacing-*`).

## Recommendations for Tulane
1. **Decide the type direction** — keep the serif/editorial identity (distinct from Yale's
   sans) but **add a mid weight** and **fix the button font** (Arial → Freight).
2. **Standardize spacing on a token scale** (Yale-style semantic spacing) — current padding is
   ad-hoc and tighter than peers.
3. **Make `border-radius` a deliberate token** (0 = classic; small = modern) rather than
   incidental.
4. **Buttons need a design pass** — brand font, larger size, consistent padding, a defined
   hover (Yale animates a CTA color + rise; Tulane's is plain).

## Confidence / caveats
- Single representative element per type per homepage; interior templates may differ. Treat
  as directional, not exhaustive.
- Computed `font-family` reports the *resolved* face (e.g. Bookmania, Arial fallback), which
  is exactly what renders — reliable for "what the user sees."
- Yale h1 wasn't present on the sampled homepage region (returned null).
