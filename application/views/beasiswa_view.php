<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Beasiswa - Fuzzy Tsukamoto</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-50px, -50px) rotate(360deg); }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
            align-items: start;
        }

        .form-section {
            background: #f8fafc;
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            position: sticky;
            top: 20px;
        }

        .form-section h2 {
            color: #1e293b;
            margin-bottom: 25px;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section h2::before {
            content: '📝';
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            transform: translateY(-1px);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .results-section h2 {
            color: #1e293b;
            margin-bottom: 25px;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .results-section h2::before {
            content: '📊';
            font-size: 1.2rem;
        }

        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            padding: 16px 12px;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }

        .status.layak {
            background: #dcfce7;
            color: #166534;
        }

        .status.tidak-layak {
            background: #fef2f2;
            color: #991b1b;
        }

        .nilai-z {
            font-weight: 600;
            color: #4f46e5;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .header p {
                font-size: 1rem;
            }
            
            .form-section {
                position: static;
            }
            
            table {
                font-size: 0.8rem;
            }
            
            th, td {
                padding: 12px 8px;
            }
        }

        .info-card {
            background: linear-gradient(135deg, #fef3c7, #fbbf24);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #f59e0b;
        }

        .info-card h3 {
            color: #92400e;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .info-card p {
            color: #78350f;
            font-size: 0.9rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistem Penilaian Beasiswa</h1>
            <p>Menggunakan Metode Fuzzy Tsukamoto</p>
        </div>

        <div class="content">
            <div class="form-section">
                <h2>Form Pendaftaran</h2>
                
                <div class="info-card">
                    <h3>ℹ️ Informasi</h3>
                    <p>Silakan isi data dengan lengkap untuk mendapatkan penilaian kelayakan beasiswa berdasarkan algoritma Fuzzy Tsukamoto.</p>
                </div>

                <form method="post" action="<?= base_url('index.php/beasiswa/simpan') ?>">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label for="nilai">Nilai Akademik (0-100)</label>
                        <input type="number" id="nilai" name="nilai" required min="0" max="100" placeholder="85">
                    </div>

                    <div class="form-group">
                        <label for="penghasilan">Penghasilan Orang Tua (Juta Rupiah)</label>
                        <input type="number" id="penghasilan" name="penghasilan" step="0.1" required min="0" placeholder="5.5">
                    </div>

                    <div class="form-group">
                        <label for="aktivitas">Aktivitas Ekstrakurikuler (Skala 0-10)</label>
                        <input type="number" id="aktivitas" name="aktivitas" required min="0" max="10" placeholder="7">
                    </div>

                    <button type="submit" class="submit-btn">
                        🎯 Cek Kelayakan Beasiswa
                    </button>
                </form>
            </div>

            <div class="results-section">
                <h2>Hasil Penilaian</h2>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nilai Akademik</th>
                                <th>Penghasilan (Jt)</th>
                                <th>Aktivitas</th>
                                <th>Nilai Z</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($calon) && count($calon) > 0): ?>
    <?php foreach($calon as $c): ?>
        <tr>
            <td><strong><?= htmlspecialchars($c['nama']) ?></strong></td>
            <td><?= number_format($c['nilai'], 0) ?></td>
            <td><?= $c['penghasilan'] ?> juta</td>
            <td><?= $c['aktivitas'] ?>/10</td>
            <td class="nilai-z"><?= $c['z'] ?></td>
            <td>
                <span class="status <?= strtolower(str_replace(' ', '-', $c['status'])) ?>">
                    <?= $c['status'] ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>

                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <h3>Belum Ada Data</h3>
                                            <p>Silakan isi form untuk melihat hasil penilaian beasiswa</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>
</html>