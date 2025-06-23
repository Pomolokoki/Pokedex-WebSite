import { test, expect } from '@playwright/test';

test('types page has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/typeTable.php');

    await expect(page).toHaveTitle('Pokedex');

    const headerLogo = page.getByRole('img', { name: 'Logo' });
    const headerPokedexButton = page.locator('#pokedexPage');
    const headerTypesButton = page.locator('#typeTablePage');
    const headerMapsButton = page.locator('#mapPage');
    const headerAttacksButton = page.locator('#attackPage');
    const headerObjectsButton = page.locator('#itemsPage');
    const headerForumButton = page.locator('#forumPage');
    const headerConnectButton = page.getByRole('button', { name: 'Connexion' });

    await expect(headerLogo).toBeVisible();
    await expect(headerPokedexButton).toBeVisible();
    await expect(headerTypesButton).toBeVisible();
    await expect(headerMapsButton).toBeVisible();
    await expect(headerAttacksButton).toBeVisible();
    await expect(headerObjectsButton).toBeVisible();
    await expect(headerForumButton).toBeVisible();
    await expect(headerConnectButton).toBeVisible();
});

test('types can be selected', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/typeTable.php');

    const resetBtn = page.locator('[id="0;0"]');
    const attackFireBtn = page.locator('[id="10;0"]');
    const attackPsyBtn = page.locator('[id="14;0"]');
    const defendWaterBtn = page.locator('[id="0;11"]');
    const defendFairyBtn = page.locator('[id="0;18"]');
    const fireAgainstWaterBtn = page.locator('[id="10;11"]');
    const psyAgainstFairyBtn = page.locator('[id="14;18"]');
    await expect(resetBtn).toBeVisible();
    await expect(attackFireBtn).toBeVisible();
    await expect(attackFireBtn).toHaveCSS('opacity', '1');
    await expect(attackPsyBtn).toBeVisible();
    await expect(attackPsyBtn).toHaveCSS('opacity', '1');
    await expect(defendWaterBtn).toBeVisible();
    await expect(defendWaterBtn).toHaveCSS('opacity', '1');
    await expect(defendFairyBtn).toBeVisible();
    await expect(defendFairyBtn).toHaveCSS('opacity', '1');
    await expect(fireAgainstWaterBtn).toBeVisible();
    await expect(fireAgainstWaterBtn).toHaveCSS('opacity', '1');
    await expect(psyAgainstFairyBtn).toBeVisible();
    await expect(psyAgainstFairyBtn).toHaveCSS('opacity', '1');

    await attackFireBtn.click();
    await expect(attackFireBtn).toHaveCSS('opacity', '1');
    await expect(attackPsyBtn).toHaveCSS('opacity', '0.5');
    await expect(defendWaterBtn).toHaveCSS('opacity', '1');
    await expect(defendFairyBtn).toHaveCSS('opacity', '1');
    await expect(fireAgainstWaterBtn).toHaveCSS('opacity', '1');
    await expect(psyAgainstFairyBtn).toHaveCSS('opacity', '0.5');

    await defendWaterBtn.click();
    await expect(attackFireBtn).toHaveCSS('opacity', '1');
    await expect(attackPsyBtn).toHaveCSS('opacity', '0.5');
    await expect(defendWaterBtn).toHaveCSS('opacity', '1');
    await expect(defendFairyBtn).toHaveCSS('opacity', '0.5');
    await expect(fireAgainstWaterBtn).toHaveCSS('opacity', '1');
    await expect(psyAgainstFairyBtn).toHaveCSS('opacity', '0.5');

    await resetBtn.click();
    await expect(attackFireBtn).toHaveCSS('opacity', '1');
    await expect(attackPsyBtn).toHaveCSS('opacity', '1');
    await expect(defendWaterBtn).toHaveCSS('opacity', '1');
    await expect(defendFairyBtn).toHaveCSS('opacity', '1');
    await expect(fireAgainstWaterBtn).toHaveCSS('opacity', '1');
    await expect(psyAgainstFairyBtn).toHaveCSS('opacity', '1');

    await psyAgainstFairyBtn.click();
    await expect(attackFireBtn).toHaveCSS('opacity', '0.5');
    await expect(attackPsyBtn).toHaveCSS('opacity', '1');
    await expect(defendWaterBtn).toHaveCSS('opacity', '0.5');
    await expect(defendFairyBtn).toHaveCSS('opacity', '1');
    await expect(fireAgainstWaterBtn).toHaveCSS('opacity', '0.5');
    await expect(psyAgainstFairyBtn).toHaveCSS('opacity', '1');
});