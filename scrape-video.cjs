const puppeteer = require("puppeteer");

const args = process.argv.slice(2);
const url = args[0];

if (!url || !url.startsWith("http")) {
    console.error("Invalid or missing URL:", url);
    process.exit(1);
}

(async () => {
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: "networkidle2", timeout: 0 });

    // ✅ Wait 5 seconds manually
    // await new Promise((resolve) => setTimeout(resolve, 1000));

    // Optional: Screenshot to debug
    // await page.screenshot({ path: "screenshot.png" });

    try {
        await page.waitForSelector("#video_pc_id source", { timeout: 10000 });

        const videoSrc = await page.$eval("#video_pc_id source", (el) =>
            el.getAttribute("src")
        );
        console.log(videoSrc);
    } catch (e) {
        console.log("NOT_FOUND");
    }

    await browser.close();
})();
