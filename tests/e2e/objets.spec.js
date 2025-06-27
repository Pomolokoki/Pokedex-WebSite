import { test, expect } from '@playwright/test';

test('objets page has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/items.php');

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

test('objets page has items infos', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/items.php');

    const tableHeader = page.locator('thead');
    await expect(tableHeader).toBeVisible();
    await expect(tableHeader).toHaveText('Nom Categorie Description Effet');

    await page.waitForTimeout(5000);

    const luxeBallLine = page.locator('[id="itemListBody"] tr').filter({ hasText: 'Luxe Ball' });
    await expect(luxeBallLine).toBeVisible();
    await expect(luxeBallLine).toContainText('Luxe Ball');
    await expect(luxeBallLine).toContainText('pokeballs');
    await expect(luxeBallLine).toContainText('Une Poké Ball pratique qui permet de gagner rapidement l’amitié d’un Pokémon sauvage attrapé.');
    await expect(luxeBallLine).toContainText('Tries to catch a wild Pokémon. Caught Pokémon start with 200 happiness.');
});

test('objects page has text search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/items.php');

    await page.waitForTimeout(5000);

    const masterBallLine = page.locator('[id="itemListBody"] tr').filter({ hasText: 'Master Ball' });
    const totalSoinLine = page.locator('[id="itemListBody"] tr').filter({ hasText: 'Total Soin' });
    await expect(masterBallLine).toBeVisible();
    await expect(totalSoinLine).toBeVisible();

    const searchBar = page.locator('[id="inputName"]');
    await expect(searchBar).toBeVisible();
    await searchBar.fill('Total Soin');
    await expect(masterBallLine).not.toBeVisible();
    await expect(totalSoinLine).toBeVisible();
});

test('objects page has category filter search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/items.php');

    await page.waitForTimeout(5000);

    const masterBallLine = page.locator('[id="itemListBody"] tr').filter({ hasText: 'Master Ball' });
    const muscleLine = page.locator('[id="itemListBody"] tr').filter({ hasText: 'Muscle +' });
    await expect(masterBallLine).toBeVisible();
    await expect(muscleLine).toBeVisible();

    const categorySelect = page.locator('[id="inputCategory"]');
    await expect(categorySelect).toBeVisible();
    await categorySelect.selectOption('battle');
    await expect(masterBallLine).not.toBeVisible();
    await expect(muscleLine).toBeVisible();
});
