import { defineConfig, devices } from '@playwright/test';

/**
 * University Drupal harvester. Drives target sites with Chromium and captures
 * structured profiles via explicit, token-optimized primitives (not auto-screenshots).
 * Polite by default: serial, generous timeouts, single pass.
 *
 * Mirrors the prairielearn-debug runner conventions (explicit capture, json reporter).
 */
export default defineConfig({
  testDir: './targets',
  testMatch: '**/*scenario*.ts',
  timeout: 90_000,
  fullyParallel: false,
  workers: 1, // polite: one site at a time
  retries: 0,
  reporter: [
    ['json', { outputFile: process.env.HARVEST_RESULT ?? 'out/result.json' }],
    ['list'],
  ],
  use: {
    headless: true,
    screenshot: 'off', // capture is explicit via shot()
    trace: 'off',
    video: 'off',
    userAgent:
      process.env.HARVEST_UA ??
      'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36 uni-drupal-harvester',
  },
  projects: [{ name: 'chromium', use: { ...devices['Desktop Chrome'] } }],
});
