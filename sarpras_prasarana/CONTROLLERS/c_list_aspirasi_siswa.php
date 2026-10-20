<?php
session_start();
require_once '../MODELS/m_koneksi.php';
require_once '../MODELS/m_aspirasi.php';

if (!isset($_SESSION['nis']) || ($_SESSION['role'] ?? '') !== 'siswa') {
    header("Location: ../VIEWS/v_login.php");
    exit();
}

$modelAspirasi = new M_Aspirasi($conn);
$nis = $_SESSION['nis'];

// Siswa: "List Aspirasi" (Menunggu & Proses) milik siswa yang login.
// c_histori_aspirasi_siswa.php memakai file ini dengan $mode = 'histori' (Selesai).
$mode = $mode ?? 'list';
$statusTampil = $mode === 'histori' ? M_Aspirasi::STATUS_HISTORI : M_Aspirasi::STATUS_LIST;
$list_aspirasi = $modelAspirasi->getAspirasiByNis($nis, $statusTampil);

require_once $mode === 'histori'
    ? '../VIEWS/v_histori_aspirasi_siswa.php'
    : '../VIEWS/v_list_aspirasi_siswa.php';
