const { test, expect } = require('@playwright/test');

test('Verify Doctor Surgeries Page and Form Submission', async ({ page }) => {
    // Navigate to login
    await page.goto('http://127.0.0.1:8000/login');

    // Login
    await page.fill('#email', 'doctor@example.com');
    await page.fill('#password', 'password');
    await page.click('button[type="submit"]');

    // Make sure we are logged in
    await expect(page).toHaveURL(/.*dashboard/);

    // Go to the doctor surgeries route
    await page.goto('http://127.0.0.1:8000/doctor/surgeries');

    // Check if the title is right
    await expect(page.locator('h2', { hasText: 'العمليات' })).toBeVisible({ timeout: 10000 });

    // Expand first card
    const firstCard = page.locator('.grid > div').first();
    await firstCard.locator('.p-6.cursor-pointer').click();

    // Wait for animation
    await page.waitForTimeout(500);

    // Check if doctor_notes textarea is visible
    const notesInput = firstCard.locator('textarea[name="doctor_notes"]');
    await expect(notesInput).toBeVisible();

    // Fill notes
    await notesInput.fill('These are highly private notes for the doctor.');

    // Submit form
    await firstCard.locator('button[type="submit"]').click();

    // Wait for page reload/success message
    await expect(page.locator('.bg-teal-50', { hasText: 'تم تحديث معلومات العملية بنجاح.' })).toBeVisible();

    // Re-expand to check if value was saved
    const firstCardAfter = page.locator('.grid > div').first();
    await firstCardAfter.locator('.p-6.cursor-pointer').click();
    await page.waitForTimeout(500);
    const notesInputAfter = firstCardAfter.locator('textarea[name="doctor_notes"]');
    await expect(notesInputAfter).toHaveValue('These are highly private notes for the doctor.');
});
