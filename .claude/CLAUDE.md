# CLAUDE.md

## Principles

- Don't use the word "kill" except inside a Unix command.

## Driving development: MCP first, Drush fallback

Make changes through the **MCP Tools** server (`drupal/mcp_tools`) so the agent calls typed Drupal APIs. If a tool is missing or fails, fall back to `ddev drush`.

Either path writes to **active config in the database** — never the source of truth. After any change, export to clean YAML and review before commit:

```bash
ddev drush cex -y          # DB active config -> config/sync (git)
ddev drush config:status   # confirm DB and YAML are in sync
git diff config/sync       # review before committing
```

Keep `config/sync` as the single source of truth. Don't hand-edit config YAML.
