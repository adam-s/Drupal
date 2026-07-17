# Drupal Pattern Research & Catalog

A research project exploring how major, prestigious institutions build their Drupal sites — then turning what we learn into original, reusable components.

## What we're trying to accomplish

Rather than designing from a blank page, we use a **harvester** (Playwright/CDP tooling) to profile many institutional Drupal sites and their subdomains: region and block structure, content models, design tokens, interaction patterns, and module fingerprints. The harvested patterns feed a **local, browsable catalog** where those patterns are rebuilt as real Drupal configuration — so the approaches the best sites converge on can be navigated, compared, and used as a foundation for an original brand and build of our own.

## What's in `docs/`

- **[design-research.md](docs/design-research.md)** — the research approach: what to capture per site, open-source references, and teardown methodology.
- **[harvester-tooling.md](docs/harvester-tooling.md)** — how the harvester itself is built and the conventions it follows.
- **[design-catalog.md](docs/design-catalog.md)** — the plan for the local catalog and its multisite architecture.
- **[design-patterns.md](docs/design-patterns.md)** — a playbook for rebuilding common web patterns as original Drupal components (our own markup, tokens, and content).
- **[architecture-considerations.md](docs/architecture-considerations.md)** — a build guide for a large institutional Drupal site: platform choices, content model, governance, theming, and operations.
- **[research/](docs/research/)** — harvested findings and per-site notes.

## Custom modules

- **Meridian Feature** — a fully code-defined content entity for an editorial homepage banner section, including a custom compound field type so editors author repeating cards inline, plus a block to place it.
- **Meridian Patterns** — original block implementations of common web patterns (featured news, tile mosaics, and the like) for the catalog.
