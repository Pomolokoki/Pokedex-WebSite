import { test, expect } from '@playwright/test';

test('maps page has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    await expect(page).toHaveTitle('Pokedex');

    const headerLogo = page.getByRole('img', { name: 'Logo' });
    const headerPokedexButton = page.locator('#pokedexPage');
    const headerTypesButton = page.locator('#typeTablePage');
    const headerMapsButton = page.locator('#mapPage');
    const headerAttacksButton = page.locator('#attackPage');
    const headerObjectsButton = page.locator('#itemsPage');
    const headerForumButton = page.locator('#forumPage');
    const headerConnectButton = page.getByRole('button', { name: 'Connexion' });

    await expect(headerLogo).toBeVisible;
    await expect(headerPokedexButton).toBeVisible;
    await expect(headerTypesButton).toBeVisible;
    await expect(headerMapsButton).toBeVisible;
    await expect(headerAttacksButton).toBeVisible;
    await expect(headerObjectsButton).toBeVisible;
    await expect(headerForumButton).toBeVisible;
    await expect(headerConnectButton).toBeVisible;
});

test('maps page has multiple game maps', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    const mapImg = page.locator('[id="imgMap"]');
    await expect(mapImg).toBeVisible;
    await expect(mapImg).toHaveAttribute('src', '../../public/img/Kanto.png');

    const mapListSelect = page.locator('[id="mapList"]');
    await expect(mapListSelect).toBeVisible;
    await mapListSelect.selectOption('Paldea')
    await expect(mapImg).toHaveAttribute('src', '../../public/img/Paldea.png');
});

test('maps page has multiple realistic maps', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    const realisticLabel = page.locator('[id="realMapLabel"]');
    const mapImg = page.locator('[id="imgMap"]');
    await expect(realisticLabel).toBeVisible;
    await realisticLabel.click();
    await expect(mapImg).toBeVisible;
    await expect(mapImg).toHaveAttribute('src', '../../public/img/KantoRealist.png');

    const mapListSelect = page.locator('[id="mapList"]');
    await expect(mapListSelect).toBeVisible;
    await mapListSelect.selectOption('Paldea')
    await expect(mapImg).toHaveAttribute('src', '../../public/img/PaldeaRealist.png');
});

test('maps page has interactives maps', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    const interactiveLabel = page.locator('[id="interactiveMapLabel"]');
    await expect(interactiveLabel).toBeVisible;
    await interactiveLabel.click();

    const bulbizarreDiv = page.locator('#pokedex div').filter({ hasText: 'Bulbizarre' });
    const roucoolDiv = page.locator('#pokedex div').filter({ hasText: 'Roucool' });
    const pikachuDiv = page.locator('#pokedex div').filter({ hasText: 'Pikachu' });
    await expect(bulbizarreDiv).toBeVisible;
    await expect(roucoolDiv).toBeVisible;
    await expect(pikachuDiv).toBeVisible;

    const road23Rect = page.locator('[id="Route 23"]');
    await expect(road23Rect).toBeVisible;
    await road23Rect.click();
    await expect(bulbizarreDiv).not.toBeVisible;
    await expect(roucoolDiv).toBeVisible;
    await expect(pikachuDiv).not.toBeVisible;

    const centraleBtn = page.getByText('Centrale');
    await expect(centraleBtn).toBeVisible;
    await centraleBtn.click();
    await expect(bulbizarreDiv).not.toBeVisible;
    await expect(roucoolDiv).not.toBeVisible;
    await expect(pikachuDiv).toBeVisible;
});

test('maps page has zone search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    const searchBar = page.locator('#searchBar');
    await expect(searchBar).toBeVisible;

    const caveTaupiqueurBtn = page.getByText('Cave TAUPIQUEUR');
    const celadopoleBtn = page.getByText('Céladopole');
    await expect(caveTaupiqueurBtn).toBeVisible;
    await expect(celadopoleBtn).toBeVisible;

    await searchBar.fill('cave taupiqueur');
    await expect(caveTaupiqueurBtn).toBeVisible;
    await expect(celadopoleBtn).not.toBeVisible;
});

test('maps page has pokemon search', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/map.php');

    const interactiveLabel = page.locator('[id="interactiveMapLabel"]');
    await expect(interactiveLabel).toBeVisible;
    await interactiveLabel.click();

    const bulbizarreDiv = page.locator('#pokedex div').filter({ hasText: 'Bulbizarre' });
    const goupixDiv = page.locator('#pokedex div').filter({ hasText: 'Goupix' });
    await expect(bulbizarreDiv).toBeVisible;
    await expect(goupixDiv).toBeVisible;

    const searchBar = page.locator('[id="pokemonSearch"]');
    await expect(searchBar).toBeVisible;
    await searchBar.fill('goupix');
    await expect(bulbizarreDiv).not.toBeVisible;
    await expect(goupixDiv).toBeVisible;
});