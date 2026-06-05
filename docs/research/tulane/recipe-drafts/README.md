# Recipe Drafts — REVIEW PROPOSALS (do not apply as-is)

⚠️ **These are DRAFTS for discussion, not runnable recipes.** They live under `docs/research/`
on purpose — **not** in the project's `/recipes` or `/config`. Treat them as a proposed shape
for how Tulane's platform could be provisioned with Drupal Recipes once direction is decided
(D10 vs D11, component approach, hosting).

Derived from [../component-backlog.md](../component-backlog.md) and
[../../governance-models.md](../../governance-models.md).

## What's here
- `tulane_person/` — faculty/staff profile content type (+ Person schema).
- `tulane_program/` — degree/program content type.
- `tulane_event/` — event content type (smart_date).
- `editorial_workflow/` — content moderation + the three-tier role model.
- `accessibility_defaults/` — a11y baseline (Editoria11y, reduced-motion, tap targets).
- `department_site/` — composes the above into a provision-a-subsite recipe.

## Caveats (be honest)
- Each real recipe also needs a `config/` directory with the actual field/display YAML — these
  drafts **describe** those fields (from the backlog) rather than ship them. Generating exact
  field config is best done in a live Drupal via the UI/Drush then `cex`, per the project's
  CLAUDE.md workflow.
- Module lists assume the YaleSites-style stack (see [../../yalesites/modules.md](../../yalesites/modules.md)).
- `actions:` blocks are illustrative; verify config-action verb names against the installed
  module versions.
- This is **provisioning** (recipes); ongoing changes flow through config-sync, not re-applying
  (see the recipes discussion in the conversation / `architecture-considerations.md`).
