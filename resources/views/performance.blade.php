<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Chatbot Performance Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a1128;
            --bg-secondary: #101f42;
            --bg-card: #1c2d5a;
            --text-main: #ffffff;
            --text-muted: #8fa0c4;
            --accent-glow: #00e5ff;
            --navy-light: #1e3d7a;
            --border-color: rgba(0, 229, 255, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }

        body { background-color: var(--bg-primary); color: var(--text-main); min-height: 100vh; overflow-x: hidden; padding: 40px 20px; }

        .bg-glow-1 { position: fixed; top: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(0,229,255,0.08) 0%, rgba(0,0,0,0) 70%); z-index: -1; animation: pulseGlow 8s infinite alternate; }
        .bg-glow-2 { position: fixed; bottom: -10%; left: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(28,45,90,0.5) 0%, rgba(0,0,0,0) 70%); z-index: -1; }

        .container { max-width: 1400px; margin: 0 auto; position: relative; z-index: 1; }

        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; animation: fadeInDown 0.8s ease-out; }
        .logo-area { display: flex; align-items: center; gap: 15px; }
        .logo-icon { width: 45px; height: 45px; background: linear-gradient(135deg, var(--bg-card), var(--navy-light)); border: 2px solid var(--accent-glow); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 15px rgba(0, 229, 255, 0.3); animation: float 4s ease-in-out infinite; }
        .logo-icon i { color: var(--accent-glow); font-size: 20px; }
        h1 { font-size: 24px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; background: linear-gradient(to right, #ffffff, var(--text-muted)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .status-badge { display: flex; align-items: center; gap: 8px; background: rgba(0, 229, 255, 0.05); border: 1px solid var(--border-color); padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; color: var(--accent-glow); }
        .status-dot { width: 8px; height: 8px; background-color: var(--accent-glow); border-radius: 50%; box-shadow: 0 0 10px var(--accent-glow); animation: blink 1.5s infinite; }

        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px; }

        .card { background: linear-gradient(145deg, var(--bg-secondary), var(--bg-card)); border: 1px solid var(--border-color); border-radius: 16px; padding: 25px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); animation: fadeInUp 0.8s ease-out both; }
        .card:hover { transform: translateY(-5px); border-color: var(--accent-glow); box-shadow: 0 10px 30px rgba(0, 229, 255, 0.1); }
        .card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, transparent, var(--accent-glow), transparent); transform: translateX(-100%); transition: transform 0.6s ease; }
        .card:hover::before { transform: translateX(100%); }
        .card-accent-line { position: absolute; bottom: 0; right: 0; width: 60px; height: 60px; border-bottom: 2px solid rgba(0, 229, 255, 0.1); border-right: 2px solid rgba(0, 229, 255, 0.1); border-radius: 0 0 16px 0; pointer-events: none; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .card-title { font-size: 14px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .card-icon { width: 36px; height: 36px; border-radius: 8px; background: rgba(0, 229, 255, 0.05); display: flex; align-items: center; justify-content: center; color: var(--accent-glow); border: 1px solid rgba(0, 229, 255, 0.1); }
        .card-value { font-size: 32px; font-weight: 700; color: var(--text-main); margin-bottom: 5px; }

        /* ===== GCR SECTION ===== */
        .section-label { font-size: 12px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); font-weight: 600; margin-bottom: 16px; padding-left: 2px; }
        .gcr-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px; }
        .gcr-card { background: linear-gradient(145deg, var(--bg-secondary), var(--bg-card)); border: 1px solid var(--border-color); border-radius: 14px; padding: 20px 24px; position: relative; overflow: hidden; transition: all 0.3s ease; animation: fadeInUp 0.8s ease-out both; }
        .gcr-card:hover { transform: translateY(-4px); border-color: var(--accent-glow); box-shadow: 0 8px 24px rgba(0, 229, 255, 0.08); }
        .gcr-card-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .gcr-card-value { font-size: 28px; font-weight: 700; color: var(--text-main); }
        .gcr-card-value.success { color: #00e5a0; }
        .gcr-card-value.warning { color: #ffb347; }
        .gcr-card-value.accent { color: var(--accent-glow); }
        .gcr-card-sub { font-size: 12px; color: var(--text-muted); margin-top: 6px; }
        .gcr-bar-section { background: linear-gradient(145deg, var(--bg-secondary), var(--bg-card)); border: 1px solid var(--border-color); border-radius: 14px; padding: 24px; margin-bottom: 40px; animation: fadeInUp 0.8s ease-out both; }
        .gcr-bar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .gcr-bar-title { font-size: 14px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .gcr-bar-pct { font-size: 20px; font-weight: 700; color: var(--accent-glow); }
        .gcr-bar-track { height: 10px; background: rgba(255,255,255,0.06); border-radius: 99px; overflow: hidden; border: 1px solid rgba(0,229,255,0.1); }
        .gcr-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #00e5a0, #00e5ff); width: 0%; transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 0 8px rgba(0, 229, 255, 0.4); }
        .gcr-formula { margin-top: 14px; font-size: 12px; color: var(--text-muted); text-align: center; letter-spacing: 0.5px; }
        .gcr-formula span { color: var(--accent-glow); font-weight: 600; }

        /* ===== CHART & TABLE ===== */
        .chart-section { background: linear-gradient(145deg, var(--bg-secondary), var(--bg-card)); border: 1px solid var(--border-color); border-radius: 16px; padding: 30px; margin-bottom: 40px; height: 400px; position: relative; animation: fadeInUp 0.8s ease-out both; animation-delay: 0.2s; }
        .chart-title-area { margin-bottom: 25px; }
        .chart-title-area h3 { font-size: 18px; font-weight: 600; letter-spacing: 0.5px; }
        .chart-wrapper { position: relative; height: 300px; width: 100%; }
        .table-section { background: linear-gradient(145deg, var(--bg-secondary), var(--bg-card)); border: 1px solid var(--border-color); border-radius: 16px; padding: 30px; overflow: hidden; animation: fadeInUp 0.8s ease-out both; animation-delay: 0.4s; }
        .table-section h3 { margin-bottom: 20px; font-size: 18px; font-weight: 600; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        th { background-color: rgba(10, 17, 40, 0.6); color: var(--text-muted); text-transform: uppercase; font-size: 12px; font-weight: 600; letter-spacing: 1px; padding: 16px 20px; border-bottom: 1px solid var(--border-color); }
        td { padding: 20px; background-color: rgba(30, 61, 122, 0.2); border-top: 1px solid rgba(0, 229, 255, 0.05); border-bottom: 1px solid rgba(0, 229, 255, 0.05); font-size: 14px; transition: all 0.3s ease; }
        td:first-child { border-left: 1px solid rgba(0, 229, 255, 0.05); border-top-left-radius: 8px; border-bottom-left-radius: 8px; font-weight: 600; color: var(--accent-glow); }
        td:last-child { border-right: 1px solid rgba(0, 229, 255, 0.05); border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
        tr:hover td { background-color: rgba(30, 61, 122, 0.4); border-color: rgba(0, 229, 255, 0.3); color: #fff; }

        pre { margin: 0; white-space: pre-wrap; font-family: inherit; line-height: 1.5; }

        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-6px); } 100% { transform: translateY(0px); } }
        @keyframes blink { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }
        @keyframes pulseGlow { 0% { opacity: 0.6; transform: scale(1); } 100% { opacity: 1; transform: scale(1.1); } }
        .loading-shimmer { animation: shimmer 1.5s infinite linear; background: linear-gradient(to right, rgba(28,45,90,0.5) 4%, rgba(0,229,255,0.1) 25%, rgba(28,45,90,0.5) 36%); background-size: 1000px 1000px; }
        @keyframes shimmer { 0% { background-position: -400px 0; } 100% { background-position: 400px 0; } }
    </style>
</head>
<body>

<div class="bg-glow-1"></div>
<div class="bg-glow-2"></div>

<div class="container">
    <header>
        <div class="logo-area">
            <div class="logo-icon">
                <i class="fa-solid fa-chart-network"></i>
            </div>
            <div>
                <h1>Data Analytics Platform</h1>
            </div>
        </div>
        <div class="status-badge">
            <div class="status-dot"></div>
            <span>LIVE MONITORING</span>
        </div>
    </header>

    <div class="metrics-grid">
        <div class="card" style="animation-delay: 0.1s;">
            <div class="card-accent-line"></div>
            <div class="card-header">
                <div class="card-title">Total Interaction</div>
                <div class="card-icon"><i class="fa-solid fa-message"></i></div>
            </div>
            <div id="total-response" class="card-value">-</div>
        </div>
        <div class="card" style="animation-delay: 0.2s;">
            <div class="card-accent-line"></div>
            <div class="card-header">
                <div class="card-title">Avg Latency Rate</div>
                <div class="card-icon"><i class="fa-solid fa-gauge-high"></i></div>
            </div>
            <div id="avg-time" class="card-value">-</div>
        </div>
        <div class="card" style="animation-delay: 0.3s;">
            <div class="card-accent-line"></div>
            <div class="card-header">
                <div class="card-title">API Status</div>
                <div class="card-icon"><i class="fa-solid fa-server"></i></div>
            </div>
            <div id="api-status" class="card-value" style="color: var(--accent-glow); font-size: 24px; padding-top: 8px;">CONNECTED</div>
        </div>
    </div>

    <p class="section-label">Goal Completion Rate (GCR)</p>

    <div class="gcr-grid">
        <div class="gcr-card" style="animation-delay: 0.1s;">
            <div class="gcr-card-label">Total Unique Users</div>
            <div id="gcr-unique-users" class="gcr-card-value warning">-</div>
            <div class="gcr-card-sub">Pengguna unik terdeteksi</div>
        </div>
        <div class="gcr-card" style="animation-delay: 0.2s;">
            <div class="gcr-card-label">Successful Reports</div>
            <div id="gcr-success-reports" class="gcr-card-value success">-</div>
            <div class="gcr-card-sub">Status target selesai (clear)</div>
        </div>
        <div class="gcr-card" style="animation-delay: 0.3s;">
            <div class="gcr-card-label">Current GCR Rate</div>
            <div id="gcr-rate-card" class="gcr-card-value accent">-</div>
            <div class="gcr-card-sub">Efisiensi penyelesaian sistem</div>
        </div>
    </div>

    <div class="gcr-bar-section">
        <div class="gcr-bar-header">
            <div class="gcr-bar-title">Progress GCR</div>
            <div class="gcr-bar-pct" id="gcr-bar-label">0%</div>
        </div>
        <div class="gcr-bar-track">
            <div class="gcr-bar-fill" id="gcr-bar"></div>
        </div>
        <div class="gcr-formula">
            GCR = ( <span>Pengguna berhasil melapor</span> ÷ <span>Total pengguna unik</span> ) × 100
        </div>
    </div>

    <div class="chart-section">
        <div class="chart-title-area">
            <h3>Latency Distribution Matrix</h3>
        </div>
        <div class="chart-wrapper">
            <canvas id="timeChart"></canvas>
        </div>
    </div>

    <div class="table-section">
        <h3>Real-time Transaction Logs</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Execution Time</th>
                        <th>User Chat</th>
                        <th>System Response</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <tr>
                        <td colspan="4" style="text-align: center;" class="loading-shimmer">Synchronizing ledger data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const apiUrl = 'https://n8n-production-67cc.up.railway.app/webhook/ef126013-9498-4151-ae2f-2517df48ffdb';
    const gcrUrl = 'https://n8n-production-67cc.up.railway.app/webhook/24642227-dbda-4781-900b-d0db1c822f3f';

    async function fetchData() {
        try {
            const response = await fetch(apiUrl);
            const rawData = await response.json();
            const dataArray = Array.isArray(rawData) ? rawData : [rawData];

            renderMetrics(dataArray);
            renderTable(dataArray);
            renderChart(dataArray);
            
            // Panggil fungsi GCR
            await fetchGCR();
        } catch (error) {
            console.error('Data acquisition failure:', error);
            document.getElementById('api-status').innerText = 'DISCONNECTED';
            document.getElementById('api-status').style.color = '#ff4d4d';
            document.getElementById('data-table-body').innerHTML = `
                <tr>
                    <td colspan="4" style="text-align: center; color: #ff4d4d; font-weight: 600; background: rgba(255,77,77,0.05);">
                        <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> Connection Failed. Verify local gateway and CORS configuration.
                    </td>
                </tr>
            `;
        }
    }

    async function fetchGCR() {
        try {
            const response = await fetch(gcrUrl);
            const gcrData = await response.json();
            
            // Mengambil single object data / elemen pertama array yang dikirim oleh SQL n8n
            const metrics = Array.isArray(gcrData) ? gcrData[0] : gcrData;

            // Mengambil value berdasarkan key baru yang dikembalikan oleh SQL Anda
            const uniqueUsers = metrics.total_unique_users || 0;
            const successReports = metrics.successful_reports || 0;
            const gcrPct = parseFloat(metrics.goal_completion_rate_percentage || 0).toFixed(2);

            // Memetakan data langsung ke elemen HTML Card
            document.getElementById('gcr-unique-users').textContent = uniqueUsers;
            document.getElementById('gcr-success-reports').textContent = successReports;
            document.getElementById('gcr-rate-card').textContent = gcrPct + '%';

            // Memperbarui Progress Bar GCR secara visual
            document.getElementById('gcr-bar-label').textContent = gcrPct + '%';
            setTimeout(() => {
                document.getElementById('gcr-bar').style.width = gcrPct + '%';
            }, 200);

        } catch (error) {
            console.error('GCR data fetch failure:', error);
            document.getElementById('gcr-rate-card').textContent = 'ERR';
            document.getElementById('gcr-rate-card').style.color = '#ff4d4d';
        }
    }

    function renderMetrics(data) {
        const total = data.length;
        const totalTime = data.reduce((sum, item) => sum + parseFloat(item.time || 0), 0);
        const avg = total > 0 ? (totalTime / total).toFixed(2) : 0;
        document.getElementById('total-response').innerText = `${total} Req`;
        document.getElementById('avg-time').innerText = `${avg} ms`;
    }

    function renderTable(data) {
        const tbody = document.getElementById('data-table-body');
        tbody.innerHTML = '';
        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>#TRX-${String(item.id).padStart(4, '0')}</td>
                <td><span style="color: var(--accent-glow); font-weight: 600;">${parseFloat(item.time).toFixed(2)}</span> ms</td>
                <td><span style="background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px;">${item.user_chat || 'N/A'}</span></td>
                <td><pre>${item.chatbot_respon}</pre></td>
            `;
            tbody.appendChild(row);
        });
    }

    function renderChart(data) {
        const ctx = document.getElementById('timeChart').getContext('2d');
        const labels = data.map(item => `TRX-${String(item.id).padStart(4, '0')}`);
        const timeData = data.map(item => parseFloat(item.time));
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 229, 255, 0.25)');
        gradient.addColorStop(1, 'rgba(0, 229, 255, 0.0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Response Latency',
                    data: timeData,
                    borderColor: '#00e5ff',
                    borderWidth: 2,
                    pointBackgroundColor: '#0a1128',
                    pointBorderColor: '#00e5ff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(255, 255, 255, 0.03)' }, ticks: { color: '#8fa0c4', font: { size: 11 } } },
                    y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#8fa0c4', font: { size: 11 } } }
                },
                animation: { duration: 2000, easing: 'easeOutElastic' }
            }
        });
    }

    fetchData();
</script>

</body>
</html>