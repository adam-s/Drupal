# Gap Analysis — Tulane vs. Peers

Answering: *are there consistent things the other universities have that Tulane lacks?*
Built from the sweep ([_sweep/](_sweep/)), the harvester profiles, and the Tulane teardown.
**Honest framing up front:** the peer estate is **heterogeneous** (mixed Drupal versions,
mixed service stacks), so *no single feature appears on literally all peers*. "Consistent
gap" below means **common among the majors and absent on Tulane**, not universal.

## The one genuinely consistent gap: accessibility monitoring (Siteimprove)

Service detection across the profiled sites (homepage signals):

| Service | Peers with it | Tulane |
|---------|---------------|--------|
| **Siteimprove** (a11y + QA monitoring) | Harvard College, Yale (main + Law), Berkeley, Stanford, Cornell, Stanford GSB — **~7** | **No** |
| Slate (admissions CRM) | CU Boulder, Stanford GSB, + many in wider sweep | **Yes** ✓ |
| Localist (events) | Stanford, CU Boulder, (Harvard SEAS) | No |
| Font Awesome | widespread | Yes ✓ |
| Editoria11y | Yale only | No (Yale-specific) |
| Adobe Fonts | Cornell, Oxford Physics | No (Tulane self-hosts Freight) |

**Takeaway:** the clearest "majors have it, Tulane doesn't" is **Siteimprove** — an
accessibility/QA monitoring platform on ~7 peers including Harvard, Yale, Berkeley, Stanford,
Cornell, but **not detected on Tulane**. Given the ADA Title II / WCAG 2.1 AA deadline, this is
a meaningful, defensible gap (Tulane has no detected automated a11y monitoring; Yale uses its
own Editoria11y instead).

## The biggest structural gap: component-library depth

Not a service but the largest difference. The **platform leaders all have a deep, governed
component library**; Tulane doesn't:

| | Components (editor-placeable) |
|---|---|
| Yale (Emulsify) | ~30 (atoms→molecules→organisms) |
| Stanford (Layout Paragraphs) | many named paragraph layouts |
| **Tulane** | **~5** (hero, image-and-text, quick-links, svg-standalone, basic) |

This is consistent across the *leaders* and is the single highest-impact gap. Build plan:
[tulane/component-backlog.md](tulane/component-backlog.md).

## Gaps that are real but NOT universal among peers

- **Drupal 11.** Leaders (Stanford, Harvard College, Penn, CU Boulder, Yale Law, UT Austin) are
  on 11; Tulane on 10. But it's *not* consistent — Yale's flagship is **D7**, Stanford GSB
  **D8**, Oxford spans D7–D11. So "behind on version" is true vs. the leaders, not vs. all.
- **Typographic weight range.** UT, Stanford, Cornell use a mid weight (500/600); Tulane only
  400/700. Common among some, not all.
- **Exposed primary nav.** Most peers expose top-level nav on desktop; **Tulane collapses to a
  hamburger even on desktop** — reduces wayfinding. (Worth confirming it's intentional.)
- **Hero CTAs.** Yale's hero has dual CTAs (Apply/Get Started); **Tulane's hero has none** —
  a conversion-path gap. Not all peers do this, but the conversion-focused ones do.

## NOT gaps — Tulane already matches or leads

- **Hosting/CDN:** Pantheon + Fastly — the peer mainstream. ✓
- **Slate** admissions CRM — Tulane has it. ✓
- **Layout Builder + Paragraphs** — Tulane is in the modern camp. ✓
- **SEO basics** — XML sitemap, Pathauto aliases, Metatag — present. ✓
- **Site-level structured data** — Tulane emits `CollegeOrUniversity`/`WebSite` schema;
  **ahead of several peer homepages** that ship none. ✓

## Shared gap — everyone, including Tulane

- **Per-content-type structured data** (NewsArticle, Course/Program, Event, Person): **no peer
  ships it well, and neither does Tulane** on its news/program/event pages. This is a *shared*
  gap, i.e. an **opportunity to lead**, not a Tulane deficiency. See
  [seo-schema-recommendation.md](seo-schema-recommendation.md).

## Tulane-specific defects (independent of peers)

- **Buttons fall back to Arial** at 13px (brand font not applied) — [tulane/component-deltas.md](tulane/component-deltas.md).
- Only **400/700** weights; tight, ad-hoc spacing (no formal token scale).
- Flat fixed header (no animation); Harvard's shrink/hide-reveal is the modern reference.

## Bottom line

- **Yes**, there are consistent gaps — but only two are both *common among peers* **and**
  *absent on Tulane*: **(1) accessibility monitoring (Siteimprove-class tooling)** and **(2) a
  deep, governed component library.**
- Most other "gaps" are **vs. the leaders specifically** (D11, mid-weight type, hero CTAs), not
  universal — Tulane already matches the mainstream on hosting, CRM, page-building, and SEO
  basics, and **leads** on site-level structured data.
- The biggest shared opportunity (per-content-type schema) is one **no one** has claimed.

## Confidence
- Service detection is **homepage-only + signature-based** → "not detected" ≠ "absent
  platform-wide" (e.g. Tulane could run Siteimprove on a subdomain or via a backend not
  visible in markup). Treat the Siteimprove gap as *strong signal, verify with the Tulane
  team*.
- Component counts are from rendered markup + the Tulane teardown — high confidence.
- Sample is ~16 deeply-profiled sites + the 42-site sweep, not the whole sector.
