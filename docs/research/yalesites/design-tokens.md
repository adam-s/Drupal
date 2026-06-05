# YaleSites — Design Tokens (from open source)

Extracted from `yalesites-org/tokens` (Style Dictionary source) and
`yalesites-org/component-library-twig/components/00-tokens`. Raw files saved in
[`tokens-src/`](tokens-src/). These are **ground-truth values**, not CDP-computed
approximations.

> For Tulane: adopt this **token *structure*** (the system), author Tulane's own **values**.

## Color palette (hex — canonical)

**Blues** (the brand core):
| Token | Hex | Name |
|-------|-----|------|
| `blue.yale` | `#00356b` | **Yale Blue** (primary) |
| `blue.medium` | `#286dc0` | Medium Blue |
| `blue.light` | `#63aaff` | Light Blue |
| `blue.horizon` | `#3E75AD` | Horizon |
| `blue.shale` | `#779FB1` | Shale |
| `blue.pewter` | `#B6C9CA` | Pewter |
| `blue.royal` | `#375597` | Royal |
| `blue.slate` | `#475B5E` | Slate |
| `blue.oceanic` | `#346F6A` | Oceanic |
| `blue.soft-oceanic` | `#E2F7F5` | Soft Oceanic |
| `blue.soft` | `#E7F1F7` | Soft |
| `blue.deep-teal` | `#314253` | Deep Teal |
| `blue.mint` | `#89d0c8` | Mint |
| `blue.ocean` | `#336F6A` | Ocean |

**Greens:** basil `#57674F` · ground `#929E83` · fog `#DEDBC7` · pine `#28372F`
**Orange:** peach `#D6A760` · coral `#FF6654`
**Yellow:** umbrella `#E2C579` · **yale-gold `#FFD55A`**
**Purple (links):** visited `#4C2C92` · visited-hover `#6438C3` · visited-light `#DDD1F8` · plum `#5C546C`
**Brown:** sand (via gray) · brown-gray `#787069`
**Grays:** 100 `#f7f7f7` · 200 `#d9d9d9` · 300 `#bababa` · 400 `#9c9c9c` · 500 `#757575` ·
600 `#5e5e5e` · 700 `#4A4A4A` · 800 `#222222` · 900 `#1B1B1B` · hale `#444C57`
**Basic:** white `#ffffff` · black `#000000`

**Semantic defaults:** background = white · body text = gray.700 (`#4A4A4A`) ·
headings = gray.800 (`#222222`).

## Theming system (this is the clever part)

Yale doesn't hardcode colors per component — components read a **theme** of **8 color
slots** via `data-*` attributes. Four theme layers:

- **Global themes** (named, swap the whole site palette):
  1. *Old Blues* · 2. *New Haven Green* · 3. *Shoreline Summer* · 4. *Onha* ·
  5. *It's Your Yale* · 6. *AI* · 7. *Whitney Humanities Center*
- **Component themes** (`data-component-theme='one'..'five'`) — per-component palette.
- **Basic themes** (`data-basic-theme`) — `white`, `gray-100/200/700/800`, `blue-yale`.
- **Button/CTA themes** (`button-cta-themes` one–seven).

**Takeaway for Tulane:** the architecture supports multiple named palettes per site — ideal
for "many subdomains, one platform, distinct sub-brands within a system."

## Typography

**Typefaces** (`type-faces.yml`):
| Family | Role | Weights |
|--------|------|---------|
| **YaleNew** | serif (headings) | 400 Roman, 700 Bold |
| **Mallory** | sans-serif (body/UI) | 400 Book, 500 Medium, 700 Bold |
| **Mallory Compact** | sans (compact headings) | 400 Book, 500 Medium, 700 Bold |

**Font pairings** (`data-font-pairing`): `yalenew` (default, old-style numerals) ·
`yalenew-oldstyle` (lining numerals) · `mallory`.

**Heading scale:** mixins `h1`–`h6` per typeface (`--font-style-heading-h{n}-*`).
Headings use **old-style numerals** by default (`font-variant-numeric: oldstyle-nums`).

**Body scale:** `xl`, `l`, `default`, `default-condensed`, `s`, `s-condensed`, `xs`.

## Spacing & layout

- **Numbered scale:** `--size-spacing-1` … `--size-spacing-12` (consumed everywhere).
- **Semantic, responsive spacing:**
  - `--size-spacing-site-gutter`: 5 → 6 (≥m) → 7 (≥l) → 8 (≥xl) → 10 (≥2xl)
  - `--spacing-page-section` (between standalone sections): 8 → 10 (≥l)
  - `--spacing-page-inner` (within a section): 7
  - `--spacing-component-banner` (banners/quick-links/callouts/quotes): 9 → 10 → 11 → 12
- **Component widths** via `data-component-width` (max-width from `size.component-layout.width`).
- **Mixins:** `spacing-page-inner` (content-like), `spacing-page-section` (stand-out blocks).

## Breakpoints

| Name | Width |
|------|-------|
| s | 576px |
| m | 768px |
| l | 992px |
| xl | 1200px |
| 2xl | 1400px |
| max-width | 2400px |
| mobile | = l (992px) |

## Effects & micro-interactions (`effects.scss`)

The animation vocabulary — directly relevant to the "how they animate" question:
- **`animate()`** mixin — transitions gated by `prefers-reduced-motion`, `--animation-speed-default`.
- **`underline-slide`** — links grow an underline on hover (background-size animation), thin
  or thick variants (`--underline-thick`: thickness-4 → thickness-8 ≥mobile).
- **`rise-effect`** — **cards lift on hover** (`translateY(-0.25em)`) + CTA color swap.
- **`fade-in-up`** — pull-quotes fade + slide up into view (`.animate` class triggers).
- **`expand-out`** — dividers scale from center (`scaleX(0)→1`).
- **`animate-hidden`** — accessible close (fade-out + removes from SR/keyboard nav).
- **Radii / shadows / borders** in `effects/{radii,shadows,borders}.twig`; thickness scale
  in `base/thickness.yml`.

All motion is **reduced-motion aware** — an accessibility best practice worth copying.

## Other tokens

- **`size.click-target-minimum`: 2.75(rem)** — min tap target (~44px), an accessibility
  guardrail.

## Source files (saved locally)
`tokens-src/`: `base-color.yml`, `base-size.yml`, `base-breakpoints.yml`,
`base-thickness.yml`, `base-effects.yml`, `base-font.yml`, `figma-tokens.json` (hex),
`typography.scss`, `type-faces.yml`, `effects.scss`, `layout.scss`, `colors-data.yml`.
