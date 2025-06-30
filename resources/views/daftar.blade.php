<!-- resources/views/daftar.blade.php -->
@extends('layouts.app')

@section('content')
<style>
  .form-card {
    background-color: #f6f9ff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
  }
  .form-section-title {
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 20px;
    color: #1939a5;
  }
  .navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    padding: 10px 20px;
    position: sticky;
    top: 0;
    z-index: 1030;
  }
  .navbar-brand img {
    height: 50px;
  }
  .btn-primary {
    background-color: #28a745;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 4px 0 #218838;
  }
  .btn-primary:hover {
    background-color: #218838;
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }
  .summary-box {
    position: sticky;
    bottom: 0;
    background: #e6f9e6;
    border-top: 1px solid #dee2e6;
    padding: 20px;
    box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
    z-index: 1020;
  }
  .sumbangan-buttons .btn {
    margin-right: 10px;
    margin-bottom: 10px;
  }
</style>

<nav class="navbar d-flex justify-content-between align-items-center">
  <a href="/" class="navbar-brand d-flex align-items-center">
    <img src="https://yuranpibg.sripetaling.edu.my/storage/logo-ssp-167x168.png" alt="Logo SSP">
    <span class="ms-3 fw-bold fs-5 text-dark">Kem Kepimpinan SK Sri Petaling 2025</span>
  </a>
</nav>

<div class="container my-5">
  <div class="form-card">
    <h5 class="form-section-title">Butiran Peserta</h5>

    <form action="/daftar" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Peserta (Pelajar)</label>
          <input type="text" name="nama" class="form-control" data-message="Sila isikan Nama Peserta" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No MyKid Peserta (Pelajar)</label>
          <input type="text" name="ic" class="form-control" inputmode="numeric" maxlength="14" pattern="\d{6}-\d{2}-\d{4}" placeholder="000000-00-0000" data-message="Sila isikan No Kad Pengenalan" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Jawatan Peserta</label>
          <select name="jawatan" class="form-select" required>
            <option value="">Pilih Jawatan</option>
            <option value="Pengawas Sekolah">Pengawas Sekolah</option>
            <option value="Pengawas Pusat Sumber">Pengawas Pusat Sumber</option>
            <option value="Pembimbing Rakan Sebaya">Pembimbing Rakan Sebaya</option>
            <option value="Quartermaster">Quartermaster</option>
            <option value="Ketua Kelas">Ketua Kelas</option>
            <option value="Penolong Ketua Kelas">Penolong Ketua Kelas</option>
            <option value="Lain-lain">Lain-lain</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Kelas Peserta</label>
          <select name="kelas" class="form-select" required>
            <option value="">Pilih Kelas</option>
            <option value="3 AKASIA">3 AKASIA</option>
            <option value="3 ALAMANDA">3 ALAMANDA</option>
            <option value="3 ANGGERIK">3 ANGGERIK</option>
            <option value="3 ANGSANA">3 ANGSANA</option>
            <option value="3 AZALEA">3 AZALEA</option>
            <option value="4 AKASIA">4 AKASIA</option>
            <option value="4 ALAMANDA">4 ALAMANDA</option>
            <option value="4 ANGGERIK">4 ANGGERIK</option>
            <option value="4 ANGSANA">4 ANGSANA</option>
            <option value="4 AZALEA">4 AZALEA</option>
            <option value="5 AKASIA">5 AKASIA</option>
            <option value="5 ALAMANDA">5 ALAMANDA</option>
            <option value="5 ANGGERIK">5 ANGGERIK</option>
            <option value="5 ANGSANA">5 ANGSANA</option>
            <option value="5 AZALEA">5 AZALEA</option>
            <option value="6 AKASIA">6 AKASIA</option>
            <option value="6 ALAMANDA">6 ALAMANDA</option>
            <option value="6 ANGGERIK">6 ANGGERIK</option>
            <option value="6 ANGSANA">6 ANGSANA</option>
            <option value="6 AZALEA">6 AZALEA</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label d-block">Jantina Peserta</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="jantina" value="Lelaki">
            <label class="form-check-label">Lelaki</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="jantina" value="Perempuan">
            <label class="form-check-label">Perempuan</label>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Agama Peserta</label>
          <select name="agama" class="form-select" required>
            <option value="">Pilih Agama</option>
            <option value="Islam">Islam</option>
            <option value="Buddha">Buddha</option>
            <option value="Hindu">Hindu</option>
            <option value="Kristian">Kristian</option>
            <option value="Lain-lain">Lain-lain</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">No Tel Ibu Bapa / Penjaga</label>
          <input type="text" name="telefon" class="form-control" placeholder="000-0000-0000" data-message="Sila isikan No Tel Ibu Bapa" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email Ibu Bapa / Penjaga</label>
          <input type="email" name="email" required data-message="Sila isikan Email Ibu Bapa" class="form-control">
          <small class="form-text text-muted">Resit transaksi akan dihantar ke email ini</small>
        </div>

        

        <div class="col-md-12">
          <label class="form-label">Alergik Makanan / Masalah Kesihatan</label>
          <textarea name="alergik" rows="3" class="form-control" placeholder="Sila nyatakan jika ada alergik terhadap makanan tertentu atau masalah kesihatan"></textarea>
        </div>

        <div class="col-md-12">
          <label class="form-label">Sumbangan Ikhlas (Pilihan)</label>
          <div class="sumbangan-buttons mb-2">
            <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan(20)">20</button>
            <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan(50)">50</button>
            <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan(100)">100</button>
            <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan(200)">200</button>
            <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan(500)">500</button>
            <button type="button" class="btn btn-outline-danger" onclick="setSumbangan(0)">Reset</button>
          </div>
          <input type="number" name="sumbangan" id="sumbangan" class="form-control" min="0" value="0" placeholder="Contoh: 10">
        </div>

        <div class="col-md-12 mt-4">
          <button type="submit" class="btn btn-primary w-100">Hantar & Teruskan ke Pembayaran</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="summary-box text-center">
  <h6 class="mb-1">Ringkasan Pembayaran</h6>
  <p class="mb-0 text-muted">Yuran Penginapan dan Makanan</p>
  <strong class="fs-5" id="total-amount">RM 190.00</strong>
</div>

<script>

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    // ========== IC FORMATTER ==========
    const icInput = document.querySelector('input[name="ic"]');
    icInput?.addEventListener("input", function (e) {
      let value = icInput.value.replace(/\D/g, "").slice(0, 12); // max 12 digits
      if (value.length >= 6) value = value.slice(0, 6) + '-' + value.slice(6);
      if (value.length >= 9) value = value.slice(0, 9) + '-' + value.slice(9);
      icInput.value = value;
    });

    // ========== PHONE FORMATTER ==========
    const phoneInput = document.querySelector('input[name="telefon"]');
    phoneInput?.addEventListener("input", function () {
      let value = phoneInput.value.replace(/\D/g, ""); // Remove non-digits
      if (value.startsWith("60")) value = value.replace(/^60/, ""); // Remove +60
      if (value.length > 3 && value.length <= 7)
        value = value.slice(0, 3) + "-" + value.slice(3);
      else if (value.length > 7)
        value = value.slice(0, 3) + "-" + value.slice(3, 7) + "-" + value.slice(7, 11);
      phoneInput.value = value;
    });

    // ========== CUSTOM VALIDATION ==========
    form.querySelectorAll("[required]").forEach(input => {
      input.addEventListener("invalid", function (e) {
        e.preventDefault();
        input.setCustomValidity(input.dataset.message || "Sila isi maklumat ini");
      });
      input.addEventListener("input", function () {
        input.setCustomValidity("");
      });
    });

    // ========== RADIO VALIDATION ==========
    form.addEventListener("submit", function (e) {
      const radioGroups = {
        jantina: "Sila pilih Jantina"
      };
      let stop = false;
      Object.keys(radioGroups).forEach(name => {
        const radios = form.querySelectorAll(`input[name="${name}"]`);
        const oneChecked = Array.from(radios).some(r => r.checked);
        if (!oneChecked) {
          alert(radioGroups[name]);
          stop = true;
        }
      });
      if (stop) e.preventDefault();
    });
  });

  // Sumbangan logic
    const sumbanganInput = document.getElementById('sumbangan');
    const totalAmountDisplay = document.getElementById('total-amount');
    const baseAmount = 190;

    function updateTotal() {
      const extra = parseFloat(sumbanganInput.value) || 0;
      totalAmountDisplay.textContent = `RM ${(baseAmount + extra).toFixed(2)}`;
    }

  function setSumbangan(amount) {
    sumbanganInput.value = amount;
    updateTotal();
  }

  sumbanganInput?.addEventListener('input', updateTotal);
</script>
@endsection