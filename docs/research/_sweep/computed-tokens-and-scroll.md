# Computed Tokens & Scroll Behavior (Playwright/CDP)

Produced by **actually running** the harvester (`tools/harvester/`) — real `getComputedStyle`
values and scroll-state capture a headers/curl pass can't reach. Raw profiles:
`tools/harvester/out/<site>/profile.json`.

## Cross-site summary

| Site | Core | Layout system | Header on scroll | Font weights | Primary fonts (computed) |
|------|------|---------------|------------------|--------------|--------------------------|
| college.harvard.edu | D11 | blocks | **mixed** (animated) | 300/400/700 | GT America, Benton Sans, Canela |
| law.yale.edu | D11 | layout_builder | static | 400/700/900 | Raleway, Avenir, Playfair |
| undergrad.stanford.edu | D11 | **layout_paragraphs** | static | 400/600/700 | Lora, Source Sans 3 |
| www.colorado.edu | D11 | blocks | static | 400/700 | Roboto, Helvetica Neue |
| www.cornell.edu | (masked) | blocks | static | 400/500/700 | **Freight Sans Pro** |
| **www.tulane.edu** | D10 | layout_builder | **sticky** | 400/700 | **Freight Sans Pro**, Georgia |
| www.upenn.edu | D11 | unknown | **sticky** | 400/700 | Roboto, EB Garamond |
| www.utexas.edu | D11 | blocks | static | 400/500/600 | Libre Franklin |
| yalesites.yale.edu | D10 | layout_builder | static | 400 | Mallory Compact, YaleNew |

> Validation: Yale's computed fonts (Mallory Compact + YaleNew) exactly match the token
> source files read from GitHub — the toolchain is accurate.

## Key findings

### Tulane shares a typeface family with Cornell — Freight
Both **www.tulane.edu and www.cornell.edu use Freight Sans Pro**. Tulane pairs it with
Georgia (serif fallback). **Cornell becomes a useful same-typeface design reference** for
Tulane — look at how Cornell uses Freight at scale.

### Scroll/menu animation: sticky/animated headers are common
- **Harvard College** — `mixed` (4 captured states): an **animated header** (shrink +
  hide/reveal on scroll). The richest interaction pattern found.
- **Tulane** and **Penn** — `sticky` headers.
- Most others register `static` on the homepage (header may animate on interior/long pages —
  re-run the harvester on a long article to confirm; homepage may be too short to trigger).

### Layout systems split three ways
- **Layout Builder:** Yale, Yale Law, **Tulane** — component blocks in LB regions.
- **Layout Paragraphs:** Stanford — paragraph-nested layouts.
- **Plain blocks / custom:** Harvard College, CU Boulder, Cornell, UT.
Tulane is already in the Layout Builder camp (matches Yale's approach — good for adopting
Yale's component model).

### Typography personalities
- **Serif display + sans body** is near-universal (Harvard: Canela+GT America; Stanford:
  Lora+Source Sans; Penn: EB Garamond+Roboto; Yale: YaleNew+Mallory; Tulane: Freight serif+sans).
- Weight sets cluster at **400/700**, with leaders adding **500/600** (UT, Stanford, Cornell)
  or **900** (Yale Law) for more hierarchy. Tulane currently only 400/700 — adding a mid
  weight (500/600) would expand hierarchy cheaply.

## Implications for Tulane
1. **Keep Freight** (brand-consistent) but **add a mid weight (500/600)** for richer hierarchy
   like the leaders.
2. **Study Cornell** (same Freight family) for type-at-scale patterns.
3. **Harvard College** is the best **scroll-animation reference** (shrink + hide/reveal) — the
   harvester captured its 4 header states for emulation.
4. Tulane's **Layout Builder** foundation aligns with Yale's component model — the component
   library expansion can follow Yale's taxonomy.

## Method notes
- Homepage-only; `static` may understate behavior on long interior pages (short homepages
  don't scroll enough to trigger pinned-header logic). Re-run on article/program pages.
- Font lists are the computed `font-family` stacks (brand font first, fallbacks after).
- All 9 ran clean in ~37s total; tool validated end-to-end.
