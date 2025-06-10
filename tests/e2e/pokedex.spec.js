import { test, expect } from '@playwright/test';

test('pokedex has navbar', async ({ page }) => {
    await page.goto('http://localhost:3000');

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

test('pokedex has pokemon list', async ({ page }) => {
    await page.goto('http://localhost:3000');

    const pokemonsDiv = page.locator('[id="pokedex"]');
    await expect(pokemonsDiv).not.toBeEmpty();

    const bulbizarreDiv = page.locator('[id="1"]');
    const herbizarreDiv = page.locator('[id="2"]');
    const florizarreDiv = page.locator('[id="3"]');
    const wattouatDiv = page.locator('[id="179"]');

    await expect(bulbizarreDiv).toBeVisible;
    await expect(bulbizarreDiv).toHaveClass('pokemon');
    await expect(bulbizarreDiv).toHaveText('1 Bulbizarre Plante Poison commun');

    await expect(herbizarreDiv).toBeVisible;
    await expect(herbizarreDiv).toHaveClass('pokemon');
    await expect(herbizarreDiv).toHaveText('2 Herbizarre Plante Poison commun');

    await expect(florizarreDiv).toBeVisible;
    await expect(florizarreDiv).toHaveClass('pokemon');
    await expect(florizarreDiv).toHaveText('3 Florizarre Plante Poison commun');

    await expect(wattouatDiv).not.toBeVisible;
    await expect(wattouatDiv).toHaveClass('pokemon');
    await expect(wattouatDiv).toHaveText('179 Wattouat Électrik commun');
});

test('pokedex has pokemon infomations', async ({ page }) => {
    await page.goto('http://localhost:3000');

    const pikachuDiv = page.locator('[id="25"]');
    await pikachuDiv.click();

    const pokemonInfosDiv = page.locator('[id="Info_Pokemon"]');
    const pokemonSpritImg = page.locator('[id="img"]');
    const pokemonSpritBtn = page.locator('[id="gender_button"]');
    await expect(pokemonInfosDiv).toBeVisible;
    await expect(pokemonSpritImg).toHaveCSS('background-image', 'url("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png")');
    await pokemonSpritBtn.click();
    await expect(pokemonSpritImg).toHaveCSS('background-image', 'url("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/female/25.png")');

    const pokemonLeftInfosDiv = page.locator('[id="Info_Pok_l"]');
    const pokemonRightInfosDiv = page.locator('[id="Info_Pok_r"]');
    await expect(pokemonLeftInfosDiv).toHaveText('Id : 25 Nom : Pikachu Commun Électrik');
    await expect(pokemonRightInfosDiv).toHaveText('Gen : 1 Taille : 0.4 m Poids : 6 Kg Taux de capture : 190');

    const pokemonTalent = page.locator('[id="Talent"]');
    await expect(pokemonTalent).toBeVisible;
    await expect(pokemonTalent).toContainText('Statik');
    await expect(pokemonTalent).toContainText('Paratonnerre');
    await expect(pokemonTalent).toContainText('Les capacités directes reçues ont 30 % de chances de donner le statut paralysie à leur lanceur.');
    await expect(pokemonTalent).toContainText("Immunité contre les capacités de type Électrik : elles augmentent d'un niveau l'Attaque Spéciale du Pokémon. Les capacités de type Électrik utilisées par un Pokémon adjacent touchent obligatoirement ce Pokémon.");

    const pokemonDescription = page.locator('[id="Description"]');
    await expect(pokemonDescription).toBeVisible;
    await expect(pokemonDescription).toContainText('Les Pikachu se disent bonjour en se frottant la queue et en y faisant passer du courant électrique.');

    const pokemonStatistic = page.locator('[id="Stat"]');
    await expect(pokemonStatistic).toBeVisible;
    await expect(pokemonStatistic).toContainText('StatPVAttaqueDéfenseAttaque SpécialeDéfense SpécialeVitesse');
    await expect(pokemonStatistic).toContainText('Valeur 35 55 40 50 50 90');
    await expect(pokemonStatistic).toContainText('Graphique');

    const pokemonTypes = page.locator('[id="Table_type"]');
    await expect(pokemonTypes).toBeVisible;
    await expect(pokemonTypes).toContainText('x1 x1 x0.5 x1 x2 x1 x1 x1 x0.5 x1 x1 x1 x0.5 x1 x1 x1 x1 x1');

    const pokemonAttaqueTitle = page.locator('[id="TitleAtk"]');
    const pokemonAttaqueNextBtn = page.locator('[id="gen+"]');
    const pokemonAttaqueInfos = page.locator('[id="Attaque"]');
    await expect(pokemonAttaqueInfos).not.toBeVisible;
    pokemonAttaqueTitle.click();
    await expect(pokemonAttaqueInfos).toBeVisible;
    await expect(pokemonAttaqueInfos).toContainText('NomTypeCatégoriePrécisionPuissancePPLearning');
    await expect(pokemonAttaqueInfos).toContainText('UltimapoingNormalPhysique858020CT/CS');
    pokemonAttaqueNextBtn.click();
    await expect(pokemonAttaqueInfos).not.toContainText('UltimapoingNormalPhysique858020CT/CS');

    const pokemonEvolutions = page.locator('[id="Evo"]');
    const pokemonEvolutionsStage1Img = page.locator('[id="stage1"] img');
    const pokemonEvolutionsStage2Img = page.locator('[id="stage2"] img');
    const pokemonEvolutionsStage3Img = page.locator('[id="stage3"] img');
    await expect(pokemonEvolutions).toBeVisible;
    await expect(pokemonEvolutionsStage1Img).toHaveAttribute('src', 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/172.png');
    await expect(pokemonEvolutions).toContainText('Montée de niveauniveau de bonheur 220');
    await expect(pokemonEvolutionsStage2Img).toHaveAttribute('src', 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png');
    await expect(pokemonEvolutions).toContainText('Utilisation d\'un objet');
    await expect(pokemonEvolutionsStage3Img).toHaveAttribute('src', 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/26.png');
});

// TODO recherche par filtre
test('pokedex has filter search', async ({ page }) => {
    await page.goto('http://localhost:3000');

    const genSelect = page.locator('[id="gen"]'); //TODO gen filter pour finir ce test
    const typeSelect = page.locator('[id="type"]');
    const rareteSelect = page.locator('[id="rarete"]');
    await genSelect.selectOption('2');
    await typeSelect.selectOption('Flying');
    await rareteSelect.selectOption('1');

    // await page.pause();
});

test('pokedex has type search', async ({ page }) => {
    await page.goto('http://localhost:3000');

    const searchInput = page.locator('[id="searchBarInput"]')
    await searchInput.fill('Nanméouïe');

    const bulbizarreDiv = page.locator('[id="1"]');
    const nanmeouieDiv = page.locator('[id="531"]');
    await expect(bulbizarreDiv).not.toBeVisible;
    await expect(nanmeouieDiv).toBeVisible;
});