<?php require_once __DIR__ . '/protect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Competition Results — ALL</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --brand:#ff3131;
      --brand-soft:#ffcccc;
    }
    body{background:#fff;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
    .topbar{
      background: linear-gradient(90deg, var(--brand) 0%, #ff4a4a 100%);
      color:#fff; padding:14px 0; margin-bottom:16px; box-shadow:0 6px 18px rgba(0,0,0,.08);
    }
    .logo{height:60px}
    .page-title{font-weight:800; letter-spacing:.5px; text-transform:uppercase; margin:0}
    .sub{opacity:.9; font-weight:500}
    .btn-red{background: #fff; color: var(--brand); border:2px solid #fff; font-weight:700; border-radius:10px}
    .btn-red:hover{background:transparent; color:#fff}
    .wrap{max-width: 1800px;}
    .results-table thead th{
      position: sticky; top:0; z-index:2;
      background: var(--brand-soft); color:#000; font-weight:700;
      white-space: nowrap; text-align:center; border-bottom:2px solid #f1b5b5;
    }
    .results-table td{vertical-align: middle; padding:10px 8px}
    .table-striped>tbody>tr:nth-of-type(odd){--bs-table-accent-bg:#fafafa;}
    .updated-cell{animation: flash 1.2s ease-in-out}
    @keyframes flash{0%{background:#fff6de}100%{background:transparent}}
    footer{margin-top:24px; padding:16px; font-size:.9rem; color:#777; text-align:center; border-top:1px solid #eee}
  </style>
</head>
<body>
  <div class="topbar">
    <div class="container d-flex align-items-center justify-content-between wrap">
      <div class="d-flex align-items-center gap-3">
        <img src="../logo.png" class="logo" onerror="this.src='logo.png';" alt="Logo">
        <div>
          <h1 class="page-title">Competition Results — ALL</h1>
          <div class="sub">Live view from Google Sheets • auto-refreshes every <span id="refreshSeconds">15</span>s</div>
        </div>
      </div>
      <div class="text-end">
        <div class="small">Last updated: <span id="lastUpdated">—</span></div>
        <button id="refreshBtn" class="btn btn-red btn-sm mt-1">Refresh Now</button>
      </div>
    </div>
  </div>

  <div class="container wrap">
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped align-middle text-center results-table" id="resultsTable">
        <thead id="thead"></thead>
        <tbody id="tbody"></tbody>
      </table>
    </div>
  </div>

  <footer>
    <div class="fw-bold" style="color:#ff3131;">© SRWTC GYMNASTICS SCORING SYSTEM</div>
    <div>Designed and maintained by Freddie Mullen — support@srwtc.co.uk • 07796 184248</div>
  </footer>

  <script>
    const DATA_URL = 'data.php?sheet=ALL';
    const REFRESH_INTERVAL_MS = 15000;
    let refreshTimer = null;
    let prevRowsHash = new Map();
    let headers = [], rows = [];

    const el = id => document.getElementById(id);
    const thead = el('thead'), tbody = el('tbody'), lastUpdated = el('lastUpdated');

    const hashRow = arr => arr.map(v => String(v)).join('\u241F');

    function renderHead(){
      thead.innerHTML = '';
      const tr = document.createElement('tr');
      headers.forEach(h=>{
        const th = document.createElement('th');
        th.textContent = h;
        tr.appendChild(th);
      });
      thead.appendChild(tr);
    }

    function renderBody(displayRows){
      const newMap = new Map();
      const frag = document.createDocumentFragment();
      displayRows.forEach(r=>{
        const tr = document.createElement('tr');
        const key = r.join('|');
        const rowHash = hashRow(r);
        const changed = prevRowsHash.has(key) && prevRowsHash.get(key) !== rowHash;
        r.forEach(cell=>{
          const td = document.createElement('td');
          if(changed) td.classList.add('updated-cell');
          td.textContent = (cell===null||cell===undefined)?'':cell;
          tr.appendChild(td);
        });
        newMap.set(key, rowHash);
        frag.appendChild(tr);
      });
      tbody.innerHTML = '';
      tbody.appendChild(frag);
      prevRowsHash = newMap;
    }

    function updateLastUpdated(ts){
      lastUpdated.textContent = new Date(ts || Date.now()).toLocaleString();
    }

    async function fetchData(){
      try{
        const res = await fetch(DATA_URL, { cache:'no-store' });
        const data = await res.json();
        if(data.status !== 'ok') throw new Error(data.message || 'Unexpected response');
        headers = data.headers || [];
        rows = data.rows || [];
        renderHead();
        renderBody(rows);
        updateLastUpdated(data.updated_at);
      }catch(err){
        console.error(err);
        alert('Failed to load results. Check Apps Script deployment & URL in /results/config.php');
      }
    }

    function startAutoRefresh(){
      clearInterval(refreshTimer);
      refreshTimer = setInterval(fetchData, REFRESH_INTERVAL_MS);
    }

    document.addEventListener('DOMContentLoaded', ()=>{
      document.getElementById('refreshBtn').addEventListener('click', fetchData);
      fetchData();
      startAutoRefresh();
    });
  </script>
</body>
</html>
