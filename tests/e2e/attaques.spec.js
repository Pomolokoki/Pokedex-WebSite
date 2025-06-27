import { test, expect } from '@playwright/test';

test('attaques page has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

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

test('attaques page has moves infos', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const tableHead = page.locator('#thead');
    await expect(tableHead).toBeVisible();
    await expect(tableHead).toContainText('Nom');
    await expect(tableHead).toContainText('Type');
    await expect(tableHead).toContainText('Catégorie');
    await expect(tableHead).toContainText('Puissance');
    await expect(tableHead).toContainText('PP');
    await expect(tableHead).toContainText('Précision');
    await expect(tableHead).toContainText('Priority');
    await expect(tableHead).toContainText('Description');
    await expect(tableHead).toContainText('Taux Critique');

    const queueDeFerLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Queue de Fer' });
    await expect(queueDeFerLine).toBeVisible();
    await expect(queueDeFerLine).toHaveText('Queue de Fer Acier Physique 100 15 75 - - Has a 30% chance to lower the target\'s Defense by one stage. - - ');
});

test('attaques page has text name search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const berceuseLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Berceuse' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(berceuseLine).toBeVisible();

    const nameSearch = page.locator('[id="nameFilter"]');
    await expect(nameSearch).toBeVisible();
    await nameSearch.fill('berceuse');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(berceuseLine).toBeVisible();
});

test('attaques page has filter type search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const vibrecailleLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Vibrécaille' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(vibrecailleLine).toBeVisible();

    const typeSearch = page.locator('[id="typeFilter"]');
    await expect(typeSearch).toBeVisible();
    await typeSearch.selectOption('Dragon');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(vibrecailleLine).toBeVisible();
});

test('attaques page has filter categorie search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const voeuSoinLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Vœu Soin' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(voeuSoinLine).toBeVisible();

    const categorySearch = page.locator('[id="categoryFilter"]');
    await expect(categorySearch).toBeVisible();
    await categorySearch.selectOption('Statut');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(voeuSoinLine).toBeVisible();
});

test('attaques page has text power search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const ultralaserLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Ultralaser' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(ultralaserLine).toBeVisible();

    const powerSearch = page.locator('[id="pcFilter"]');
    await expect(powerSearch).toBeVisible();
    await powerSearch.fill('150');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(ultralaserLine).toBeVisible();
});

test('attaques page has text pp search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const airVeinardLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Air Veinard' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(airVeinardLine).toBeVisible();

    const ppSearch = page.locator('[id="ppFilter"]');
    await expect(ppSearch).toBeVisible();
    await ppSearch.fill('30');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(airVeinardLine).toBeVisible();
});

test('attaques page has text précision search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const dynamoPoingLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Dynamo-Poing' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(dynamoPoingLine).toBeVisible();

    const precisionSearch = page.locator('[id="accuracyFilter"]');
    await expect(precisionSearch).toBeVisible();
    await precisionSearch.fill('50');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(dynamoPoingLine).toBeVisible();
});

test('attaques page has text priority search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const riposteLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Riposte' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(riposteLine).toBeVisible();

    const prioritySearch = page.locator('[id="priorityFilter"]');
    await expect(prioritySearch).toBeVisible();
    await prioritySearch.fill('-5');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(riposteLine).toBeVisible();
});

test('attaques page has text description search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const voleVieLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Vole-Vie' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(voleVieLine).toBeVisible();

    const descriptionSearch = page.locator('[id="descriptionFilter"]');
    await expect(descriptionSearch).toBeVisible();
    await descriptionSearch.fill('Drains');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(voleVieLine).toBeVisible();
});

test('attaques page has text critique search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/pokemonMove.php');

    const gigaTonnerreLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Giga-Tonnerre' });
    const tunnelierLine = page.locator('[id="tbody"] tr').filter({ hasText: 'Tunnelier' });
    await expect(gigaTonnerreLine).toBeVisible();
    await expect(tunnelierLine).toBeVisible();

    const critiqueSearch = page.locator('[id="criticityFilter"]');
    await expect(critiqueSearch).toBeVisible();
    await critiqueSearch.fill('1');
    await expect(gigaTonnerreLine).not.toBeVisible();
    await expect(tunnelierLine).toBeVisible();
});