<?php
require_once 'select.php';
$users = getUsers($pdo);

// متغيرات رسائل التنبيه
$msg = $_GET['msg'] ?? '';
$alertClass = '';
$alertText = '';
if ($msg === 'added') {
    $alertClass = 'alert-success';
    $alertText = '✅ User added successfully!';
} elseif ($msg === 'updated') {
    $alertClass = 'alert-success';
    $alertText = '🔄 User status updated successfully!';
} elseif ($msg === 'error') {
    $alertClass = 'alert-error';
    $alertText = '❌ Something went wrong. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        /* ===== خلفية الموشن جرافيك ===== */
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: #0b1120;
            overflow: hidden;
            position: relative;
        }

        .bg-animation {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -2;
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #0b1120, #1e293b);
            background-size: 400% 400%;
            animation: gradientShift 18s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.5;
            z-index: -1;
            animation: floatBlob 22s infinite alternate ease-in-out;
        }
        .blob-1 { width: 550px; height: 550px; background: #3b82f6; top: -15%; left: -15%; animation-duration: 20s; }
        .blob-2 { width: 650px; height: 650px; background: #8b5cf6; bottom: -20%; right: -15%; animation-duration: 28s; }
        .blob-3 { width: 450px; height: 450px; background: #06b6d4; top: 45%; left: 45%; transform: translate(-50%, -50%); animation-duration: 16s; opacity: 0.3; }
        @keyframes floatBlob {
            0%   { transform: translate(0, 0) scale(1); }
            33%  { transform: translate(60px, -70px) scale(1.15); }
            66%  { transform: translate(-40px, 50px) scale(0.85); }
            100% { transform: translate(30px, -30px) scale(1.05); }
        }

        /* ===== الحاوية الرئيسية ===== */
        .container {
            max-width: 980px;
            width: 100%;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 40px;
            padding: 40px 35px;
            border: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 40px 100px rgba(0,0,0,0.6);
            z-index: 1;
            position: relative;
        }

        /* ===== الهيدر الجديد ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            flex-wrap: wrap;
            gap: 10px;
        }
        .header-left h1 {
            font-size: 2.8rem;
            font-weight: 900;
            letter-spacing: 4px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #f8fafc 0%, #60a5fa 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }
        .header-left .subtitle {
            font-size: 0.75rem;
            color: #64748b;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 4px;
            font-weight: 300;
        }

        /* ===== رسائل التنبيه ===== */
        .alert {
            padding: 12px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-weight: 500;
            font-size: 0.9rem;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.05);
            animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes slideDown {
            0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border-color: rgba(34, 197, 94, 0.15);
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.15);
        }

        /* ===== نموذج الإدخال ===== */
        .form-card {
            background: rgba(255,255,255,0.03);
            border-radius: 20px;
            padding: 16px 22px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px 20px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .form-card label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-card input {
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 10px 16px;
            color: #f8fafc;
            font-size: 0.95rem;
            width: 160px;
            transition: 0.3s;
        }
        .form-card input:focus {
            outline: none;
            border-color: rgba(96, 165, 250, 0.4);
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.05);
            background: rgba(0,0,0,0.6);
        }
        .form-card input::placeholder { color: #475569; }
        .btn-submit {
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.02));
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 40px;
            padding: 10px 32px;
            color: #f8fafc;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-left: auto;
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
        }
        .btn-submit:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.2);
            transform: scale(1.03);
            box-shadow: 0 0 40px rgba(96, 165, 250, 0.05);
        }

        /* ===== الجدول ===== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.04);
            background: rgba(0,0,0,0.15);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            min-width: 550px;
        }
        thead {
            background: rgba(255,255,255,0.02);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        th {
            text-align: left;
            padding: 14px 18px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
        }
        td {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            color: #e2e8f0;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: rgba(255,255,255,0.02); }

        .status-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-1 {
            background: rgba(74,222,128,0.12);
            color: #4ade80;
            border: 1px solid rgba(74,222,128,0.08);
        }
        .status-0 {
            background: rgba(248,113,113,0.12);
            color: #f87171;
            border: 1px solid rgba(248,113,113,0.08);
        }

        .toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.04);
            padding: 6px 18px;
            border-radius: 40px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.04);
        }
        .toggle-btn:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            border-color: rgba(255,255,255,0.08);
        }
        .toggle-btn i { font-size: 0.7rem; }

        .empty-msg {
            text-align: center;
            padding: 40px 20px;
            color: #475569;
        }
        .empty-msg i { font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.2; }

        /* ===== عدّاد الصفوف ===== */
        .row-counter {
            font-size: 0.75rem;
            color: #475569;
            margin-top: 15px;
            text-align: right;
            letter-spacing: 0.5px;
        }
        .row-counter span { color: #94a3b8; font-weight: 600; }

        /* ===== استجابة ===== */
        @media (max-width: 700px) {
            .container { padding: 20px; }
            .header { flex-direction: column; align-items: flex-start; gap: 5px; }
            .header-left h1 { font-size: 2rem; letter-spacing: 2px; }
            .form-card { flex-direction: column; align-items: stretch; }
            .form-card input { width: 100%; }
            .btn-submit { margin-left: 0; justify-content: center; }
            .blob-1, .blob-2 { width: 300px; height: 300px; }
            .alert { font-size: 0.8rem; padding: 10px 16px; }
        }
    </style>
</head>
<body>

    <!-- ===== عناصر الموشن جرافيك ===== -->
    <div class="bg-animation"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- ===== المحتوى ===== -->
    <div class="container">

        <!-- ===== الهيدر الجديد ===== -->
        <div class="header">
            <div class="header-left">
                <h1>User Management</h1>
                <div class="subtitle">Control Panel · Dashboard</div>
            </div>
       </div>
        <!-- ===== رسائل التنبيه ===== -->
        <?php if ($alertText): ?>
            <div class="alert <?= $alertClass ?>">
                <?= $alertText ?>
            </div>
        <?php endif; ?>

        <!-- ===== نموذج الإدخال ===== -->
        <div class="form-card">
            <label><i class="fas fa-user"></i> Name</label>
            <input type="text" name="name" form="addForm" placeholder="Full name" required autofocus>

            <label><i class="fas fa-calendar-alt"></i> Age</label>
            <input type="number" name="age" form="addForm" placeholder="Age" required>

            <button type="submit" form="addForm" class="btn-submit">
                <i class="fas fa-plus-circle"></i> Add User
            </button>
        </div>
        <form id="addForm" action="insert.php" method="POST" style="display:none;"></form>

        <!-- ===== الجدول ===== -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php $counter = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td style="color:#64748b; font-weight:600;"><?= $counter++ ?></td>
                                <td><strong><?= htmlspecialchars($user['name']) ?></strong></td>
                                <td><?= htmlspecialchars($user['age']) ?></td>
                                <td>
                                    <span class="status-badge <?= $user['status'] == 1 ? 'status-1' : 'status-0' ?>">
                                        <?= $user['status'] == 1 ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <a href="update.php?id=<?= $user['id'] ?>" class="toggle-btn">
                                        <i class="fas fa-sync-alt"></i> Toggle
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-msg">
                                    <i class="fas fa-users-slash"></i>
                                    No users registered yet.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ===== عدّاد الصفوف ===== -->
        <?php if (count($users) > 0): ?>
            <div class="row-counter">
                <i class="fas fa-list-ul"></i> Total records: <span><?= count($users) ?></span>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>