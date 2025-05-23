// @ts-check
import { test, expect } from '@playwright/test';

test('pokedex has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000');

    await expect(page).toHaveTitle('Pokedex');
});