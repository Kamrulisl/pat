const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const chrome = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const base = 'http://localhost/pat';
const outDir = path.join(process.cwd(), 'screenshots');
const profileDir = path.join(process.cwd(), '.chrome-screenshot-profile');

fs.mkdirSync(outDir, { recursive: true });

function wait(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

async function fetchJson(url) {
  const res = await fetch(url);
  return res.json();
}

async function connect(wsUrl) {
  const ws = new WebSocket(wsUrl);
  let id = 0;
  const pending = new Map();

  ws.onmessage = (event) => {
    const data = JSON.parse(event.data);
    if (data.id && pending.has(data.id)) {
      const { resolve, reject } = pending.get(data.id);
      pending.delete(data.id);
      data.error ? reject(new Error(JSON.stringify(data.error))) : resolve(data.result);
    }
  };

  await new Promise((resolve) => ws.onopen = resolve);

  return {
    send(method, params = {}) {
      const messageId = ++id;
      ws.send(JSON.stringify({ id: messageId, method, params }));
      return new Promise((resolve, reject) => pending.set(messageId, { resolve, reject }));
    },
    close() {
      ws.close();
    }
  };
}

async function screenshot(page, file) {
  const result = await page.send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
  fs.writeFileSync(path.join(outDir, file), Buffer.from(result.data, 'base64'));
}

async function navigate(page, url) {
  await page.send('Page.navigate', { url });
  await wait(1200);
}

async function submitLogin(page, email, password) {
  await page.send('Runtime.evaluate', {
    expression: `
      document.querySelector('input[name="email"]').value = ${JSON.stringify(email)};
      document.querySelector('input[name="password"]').value = ${JSON.stringify(password)};
      document.querySelector('form').submit();
    `
  });
  await wait(1200);
}

(async () => {
  const chromeProcess = spawn(chrome, [
    '--headless=new',
    '--disable-gpu',
    '--no-sandbox',
    '--remote-debugging-port=9223',
    '--window-size=1366,900',
    `--user-data-dir=${profileDir}`,
    'about:blank'
  ], { stdio: 'ignore' });

  try {
    await wait(1500);
    const targets = await fetchJson('http://127.0.0.1:9223/json/list');
    const target = targets.find((item) => item.type === 'page') || targets[0];
    const page = await connect(target.webSocketDebuggerUrl);
    await page.send('Page.enable');
    await page.send('Runtime.enable');

    await navigate(page, `${base}/`);
    await screenshot(page, 'home.png');

    await navigate(page, `${base}/browse.php`);
    await screenshot(page, 'browse.png');

    await navigate(page, `${base}/admin/login.php`);
    await screenshot(page, 'admin-login.png');
    await submitLogin(page, 'admin@petpals.com', '123456');
    await navigate(page, `${base}/admin/index.php`);
    await screenshot(page, 'admin-panel.png');

    await navigate(page, `${base}/login.php`);
    await screenshot(page, 'user-login.png');
    await submitLogin(page, 'user@petpals.com', '123456');
    await navigate(page, `${base}/user/index.php`);
    await screenshot(page, 'user-panel.png');

    page.close();
  } finally {
    chromeProcess.kill();
  }
})();
