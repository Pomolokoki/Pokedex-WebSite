import { test, expect } from '@playwright/test';

test('user can connect from the header', async ({ page }) => {
    await page.goto('http://localhost:3000/src/views/login.php');

    const usernameInput = page.locator('[id="identifier"]');
    const passwordInput = page.locator('[id="pword"]');
    const submitBtn = page.locator('[id="submitButton"]');
    await expect(usernameInput).toBeVisible();
    await expect(passwordInput).toBeVisible();
    await expect(submitBtn).toBeVisible();

    await usernameInput.fill('az');
    await passwordInput.fill('azertyY444');
    await submitBtn.click()
    await page.waitForTimeout(5000);
    await expect(page.url()).toBe('http://localhost:3000/src/views/pokedex.php');
});