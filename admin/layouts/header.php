<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi SERASI - Verifikasi Denah PBF">
    <meta name="author" content="Tim IT">

    <title>SERASI - Dashboard Admin</title>

    <!-- Font Awesome -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- SB Admin 2 CSS (Bootstrap 4) -->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


    <!-- jQuery (wajib ada sebelum Bootstrap 4) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 Bundle (sudah termasuk Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing -->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- SB Admin 2 JS -->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2c5aa0;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
            color: #333;
        }

        .page-header {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 24px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #555;
            min-width: 180px;
        }

        .info-value {
            color: #222;
            font-weight: 400;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eaeaea;
        }

        .file-upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #fafbfc;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: var(--primary);
            background-color: #f0f7ff;
        }

        .file-upload-area.dragover {
            border-color: var(--primary);
            background-color: #e6f2ff;
        }

        .file-info {
            font-size: 0.85rem;
            color: var(--secondary);
            margin-top: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 10px 24px;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #234a8c;
            border-color: #234a8c;
        }

        .alert-section {
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .alert-icon {
            color: var(--danger);
            font-size: 1.5rem;
            margin-right: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .document-preview {
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* Otomatis beri bintang merah pada label required */
        label.required::after {
            content: " *";
            color: red;
        }

        h5.required::after {
            content: " *";
            color: red;
        }

        .dropzone {
            border: 2px dashed #28a745;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            color: #28a745;
            font-weight: 500;
        }

        .dropzone:hover {
            background-color: #e6f4ea;
        }

        @media (max-width: 768px) {
            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 4px;
            }
        }
    </style>

</head>


<body id="page-top">
    <div id="wrapper">
        <?php include '../layouts/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">