<div class="container mt-3 mb-5">
  <div class="form-card">
    <p class="text-center text-muted mb-4">Sila lengkapkan butiran peserta untuk meneruskan pembayaran</p>

    <h5 class="form-section-title">Butiran Peserta</h5>

    <form action="/daftar" method="POST" novalidate>
      @csrf
      <div id="formAlert" class="alert alert-danger d-none" role="alert"></div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Peserta</label>
          <input type="text" name="nama" class="form-control" data-message="Sila isikan Nama Peserta" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No Kad Pengenalan Peserta</label>
          <input type="text" name="ic" class="form-control" inputmode="numeric" maxlength="14" pattern="\d{6}-\d{2}-\d{4}" placeholder="000000-00-0000" data-message="Sila isikan No Kad Pengenalan" required>
        </div>

        <div class="col-md-6">
          <label class="form-label d-block">Jantina</label>
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
          <label class="form-label">Agama</label>
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
          <label class="form-label">No Tel Ibu Bapa</label>
          <input type="text" name="telefon" class="form-control" placeholder="000-0000-0000" data-message="Sila isikan No Tel Ibu Bapa" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email (Pilihan)</label>
          <input type="email" name="email" class="form-control">
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
            @foreach ([3,4,5,6] as $tahap)
              @foreach (["AKASIA", "ALAMANDA", "ANGGERIK", "ANGSANA", "AZALEA"] as $kelas)
                <option value="{{ $tahap . ' ' . $kelas }}">{{ $tahap . ' ' . $kelas }}</option>
              @endforeach
            @endforeach
          </select>
        </div>

        <div class="col-md-12">
          <label class="form-label">Alergik Makanan / Masalah Kesihatan</label>
          <textarea name="alergik" rows="3" class="form-control" placeholder="Sila nyatakan jika ada alergik terhadap makanan tertentu atau masalah kesihatan"></textarea>
        </div>

        <div class="col-md-12">
          <label class="form-label">Sumbangan Ikhlas (Pilihan)</label>
          <div class="sumbangan-buttons mb-2">
            @foreach ([20, 50, 100, 200, 500] as $amount)
              <button type="button" class="btn btn-outline-secondary" onclick="setSumbangan({{ $amount }})">{{ $amount }}</button>
            @endforeach
            <button type="button" class="btn btn-outline-danger" onclick="setSumbangan(0)">Reset</button>
          </div>
          <input type="number" name="sumbangan" id="sumbangan" class="form-control" min="0" placeholder="Contoh: 10">
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
const sumbanganInput = document.getElementById('sumbangan');
const totalAmountDisplay = document.getElementById('total-amount');
const baseAmount = 190;

function updateTotal() {
  const extra = parseFloat(sumbanganInput.value) || 0;
  const total = baseAmount + extra;
  totalAmountDisplay.textContent = `RM ${total.toFixed(2)}`;
}

function setSumbangan(amount) {
  sumbanganInput.value = amount;
  updateTotal();
}

sumbanganInput?.addEventListener('input', updateTotal);

// Formatters
const icInput = document.querySelector('input[name="ic"]');
icInput?.addEventListener("input", function () {
  let value = icInput.value.replace(/\D/g, "").slice(0, 12);
  if (value.length >= 6) value = value.slice(0, 6) + '-' + value.slice(6);
  if (value.length >= 9) value = value.slice(0, 9) + '-' + value.slice(9);
  icInput.value = value;
});

const phoneInput = document.querySelector('input[name="telefon"]');
phoneInput?.addEventListener("input", function () {
  let value = phoneInput.value.replace(/\D/g, "");
  if (value.startsWith("60")) value = value.replace(/^60/, "");
  if (value.length > 3 && value.length <= 7)
    value = value.slice(0, 3) + "-" + value.slice(3);
  else if (value.length > 7)
    value = value.slice(0, 3) + "-" + value.slice(3, 7) + "-" + value.slice(7, 11);
  phoneInput.value = value;
});
</script>