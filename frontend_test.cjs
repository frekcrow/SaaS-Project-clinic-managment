const { chromium } = require('playwright');

(async () => {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    try {
        await page.goto('http://127.0.0.1:8000/login');
        await page.fill('#email', 'doctor@example.com');
        await page.fill('#password', 'password');
        await page.click('button[type="submit"]');
        await page.waitForURL('http://127.0.0.1:8000/dashboard');
        console.log('Logged in successfully');

        await page.goto('http://127.0.0.1:8000/surgeries');
        await page.waitForLoadState('networkidle');
        console.log('Loaded Surgeries Grid successfully');

        await page.goto('http://127.0.0.1:8000/patients');
        await page.waitForLoadState('networkidle');
        console.log('Loaded Patients Grid successfully');

        // Target the button by title attribute instead of text content since it's an icon-only button
        await page.click('button[title="تحويل إلى العمليات"]');
        await page.waitForSelector('text=تحويل إلى العمليات -', { state: 'visible' });
        console.log('Opened Transfer Modal successfully');

        const logs = [];
        page.on('console', msg => logs.push(msg.text()));

    } catch (e) {
        console.error('Error:', e);
    } finally {
        await browser.close();
    }
})();
