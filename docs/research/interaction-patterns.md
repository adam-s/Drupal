# Interaction Patterns — Header / Menu Scroll Behavior

How peer universities animate headers and menus on scroll, captured by the harvester
(`captureScrollBehavior` — scrolls through offsets 0/200/500/900 and snapshots the header's
computed `position`/`height`/`transform`/`classList`). Profiles in `tools/harvester/out*/`.

## Observed patterns

| Site | Page | Header behavior | Detail |
|------|------|-----------------|--------|
| **www.tulane.edu** | homepage + interior | **fixed sticky, no animation** | `position: fixed`, constant **80px** at all offsets; no shrink, no hide/reveal |
| college.harvard.edu | homepage | **animated (mixed)** | shrink + hide/reveal across 4 states — the richest pattern found |
| www.nyu.edu | homepage | **shrink** | header height changes on scroll |
| www.law.ox.ac.uk | homepage | **sticky** | pinned header |
| news.berkeley.edu | homepage | **sticky** | pinned |
| www.upenn.edu | homepage | **sticky** | pinned |
| undergrad.stanford.edu | homepage + program | **not sticky** | `position: relative`, ~274px header scrolls away |
| yalesites.yale.edu | homepage + doc | **static** | header not pinned on these pages |
| law.yale.edu / CU / UT / Cornell | homepage | static | no pinning detected |

## What this tells us

### Tulane today: simple fixed sticky (80px)
Tulane's header is **always-visible fixed at 80px with no scroll animation** — confirmed on
homepage *and* interior pages (academics, news, events). It's functional but the least
dynamic of the peers with sticky headers. **Opportunity:** add a subtle scroll behavior
(shrink on scroll-down, or hide-on-down/reveal-on-up) to feel more modern, matching Harvard
and NYU.

### Three header archetypes to choose from
1. **Static / scroll-away** (Yale, Stanford undergrad) — header leaves on scroll; maximizes
   content space; simplest.
2. **Plain sticky** (Tulane today, Penn, Oxford Law, Berkeley) — always visible, fixed; good
   for persistent nav.
3. **Animated sticky** (Harvard College = shrink + hide/reveal; NYU = shrink) — best
   perceived polish; reclaims space by shrinking/hiding on scroll-down and revealing on
   scroll-up.

**Best emulation references:** Harvard College (full shrink + hide/reveal — the harvester
captured its 4 states) and NYU (shrink). If Tulane wants "modern," archetype 3 is the target.

### Implementation notes (for the Tulane Tailwind theme)
- A hide-on-down/reveal-on-up header is cheap: track scroll direction, toggle a
  `.is-pinned/.is-unpinned` class, animate `transform: translateY()` with a CSS transition.
  (Library option: Headroom.js; or ~30 lines of vanilla + IntersectionObserver.)
- A shrink header: toggle a `.scrolled` class past a threshold, transition `height` +
  logo/padding. Respect `prefers-reduced-motion` (Yale's tokens already do this — a good
  accessibility pattern to copy).

## Method caveats (honest)
- **Homepages may understate behavior** — short pages don't scroll far enough to trigger
  pinned-header JS. The harvester's fixed offsets (max 900px) caught Tulane/Harvard/NYU but
  could miss a behavior that only engages after deeper scroll. Re-run with larger offsets on
  long article pages to confirm the "static" sites.
- `transform: none` at every offset = genuinely no translate animation (reliable negative).
- Library detection is class-name based; a custom scroll handler with neutral class names
  reads as `custom`/none even when present. Confidence: pattern = high; library = medium.

## Refined capture (larger offsets 0/400/1000/2000 + scroll-up reveal test)

Re-ran with deeper offsets and a scroll-up step (`tools/harvester/out-scroll/`):

| Site | Confirmed behavior |
|------|--------------------|
| **college.harvard.edu** | **Shrink + pin** — header `relative 105px` at top → `fixed 72px` with a slight `translateY(-7px)` once scrolled. Genuine animated header. **Best reference.** |
| **www.upenn.edu** | **Becomes sticky** — `position: absolute 145px` at top → `fixed 145px` after scrolling past (constant height, no shrink). |
| **www.tulane.edu** (news) | **Fixed 80px, unchanged** across 0→2400px and on scroll-up — robust confirmation of *no animation*. |
| **www.nyu.edu** | **Inconclusive** — the header selector matched a 5478px page container, not the nav (the earlier "shrink" was this artifact). Tool caveat below. |

**Tool caveat (honest):** the header selector (`[class*="header"]`) can match a large wrapper
instead of the nav (NYU case). Treat a header `height` in the thousands as a mis-match, not a
real header. A more specific selector (nearest sticky/fixed element containing the primary
nav) would fix this — noted as a harvester improvement.

## Mobile (375px) — hamburger menus

All four sampled sites show a hamburger toggle at mobile width:

| Site | Toggles | Pattern |
|------|---------|---------|
| www.tulane.edu | 2 | combined `search-hamburger-bar` (search + menu together) |
| college.harvard.edu | 3 | labeled "Menu, Guides, and Resources" |
| yalesites.yale.edu | **16** | nested **accessible disclosure** (`menu-toggle` + `aria-expanded`) — accordion submenus |
| undergrad.stanford.edu | 4 | "Page logo, menu and search" cluster |

**Takeaway:** Yale's mobile menu is the accessibility model — every submenu is an
`aria-expanded` disclosure button (keyboard + screen-reader friendly). Tulane's mobile nav
combines search + hamburger in one bar (2 toggles) — functional; worth auditing its
`aria-expanded`/focus handling against Yale's pattern.

## Header-selector fix (wave 4)

`scroll.ts` now **scores** candidate headers (prefers sticky/fixed, contains nav, near top,
plausible height ≤400px) and tags the winner with `data-harvest-header` instead of a brittle
class match. Validated:
- **Berkeley** — now reads a sane **42px relative** header (static) instead of a giant
  container. Fix works.
- **Harvard** — unchanged **105→72px shrink+pin** (consistent control). ✅
- **NYU** — now **render-gates in headless** (`gotoRendered` returns not-rendered → skipped);
  NYU blocks/stalls the headless browser. So NYU header behavior is **unconfirmed** (and its
  earlier "shrink" was the selector artifact, now removed). Honest: not feasible in this
  harness without a non-headless/anti-bot workaround.

## Next
- Capture hamburger open/close *animation* (currently only presence is detected).
- Retry NYU/Cornell with a non-headless context if their behavior is needed.
