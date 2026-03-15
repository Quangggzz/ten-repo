<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #2c3e50;
            --accent: #e67e22;
        }
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: all .3s;
        }
        #sidebar .brand {
            padding: 1.2rem 1rem;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        #sidebar .brand span { color: var(--accent); }
        #sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: .6rem 1.2rem;
            border-radius: 6px;
            margin: 2px 8px;
            font-size: .9rem;
            transition: all .2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: var(--accent);
            color: #fff;
        }
        #sidebar .nav-section {
            font-size: .72rem;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            padding: .8rem 1.2rem .3rem;
            letter-spacing: 1px;
        }
        #main { margin-left: var(--sidebar-width); min-height: 100vh; }
        #topbar {
            background: #fff;
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
        }
        .stat-card { border-radius: 12px; border: none; color: #fff; }
        .stat-card.orange { background: linear-gradient(135deg,#e67e22,#d35400); }
        .stat-card.blue   { background: linear-gradient(135deg,#3498db,#2980b9); }
        .stat-card.green  { background: linear-gradient(135deg,#2ecc71,#27ae60); }
        .stat-card.red    { background: linear-gradient(135deg,#e74c3c,#c0392b); }
        .stat-card.purple { background: linear-gradient(135deg,#9b59b6,#8e44ad); }
        .stat-card.teal   { background: linear-gradient(135deg,#1abc9c,#16a085); }
        .stat-card .icon { font-size: 2.5rem; opacity: .7; }
        .badge-dang_cam  { background: #e67e22; color:#fff; }
        .badge-da_chuoc  { background: #27ae60; color:#fff; }
        .badge-thanh_ly  { background: #c0392b; color:#fff; }
        .badge-qua_han   { background: #6c1c1c; color:#fff; }
        .table th { font-size: .82rem; text-transform: uppercase; letter-spacing: .5px; }
        .content-wrapper { padding: 1.5rem; }
        @media print {
            #sidebar, #topbar, .no-print { display: none !important; }
            #main { margin-left: 0 !important; }
        }
    </style>
</head>
<body>
