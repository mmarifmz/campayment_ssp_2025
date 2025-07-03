<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
<style>
  .top-navbar {
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 1000;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    flex-wrap: wrap;
  }
  .top-navbar .logo-title {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .top-navbar img {
    height: 40px;
  }
  .top-navbar .event-title {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    white-space: nowrap;
  }
  .top-navbar .countdown-box {
    font-weight: bold;
    font-size: 0.95rem;
    flex: 1;
    text-align: center;
    margin: 5px 0;
  }
  .top-navbar .daftar-button {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    font-size: 1rem;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    box-shadow: 0 5px #2f6e2f;
    transition: all 0.2s ease;
    text-decoration: none;
  }
  .top-navbar .daftar-button:active {
    transform: translateY(3px);
    box-shadow: 0 2px #2f6e2f;
  }

  .carousel-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
  }
  .carousel-3d {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px;
    scroll-snap-type: x mandatory;
  }
  .carousel-3d img {
    height: 400px;
    max-width: 90vw;
    border-radius: 10px;
    transition: transform 0.3s ease;
    scroll-snap-align: center;
    cursor: pointer;
  }
  .carousel-3d img:hover {
    transform: scale(1.05);
  }
  @media (max-width: 768px) {
    .top-navbar {
      flex-direction: column;
      align-items: center;
    }
    .top-navbar img {
      height: 36px;
    }
    .carousel-3d img {
      height: 320px;
    }
    .top-navbar .event-title {
      font-size: 0.9rem;
    }
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
  }

  .modal.show {
    display: flex; /* use flex to center content */
  }

  .modal-content {
    max-width: 90vw;
    max-height: 85vh;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);
    z-index: 10001;
  }

  .modal-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10002;
  }
</style>

<div class="top-navbar">
  <div class="logo-title">
    <img src="https://yuranpibg.sripetaling.edu.my/storage/logo-ssp-167x168.png" alt="Logo SSP">
    <div class="event-title">Kem Kepimpinan SK Sri Petaling 2025</div>
  </div>
  <div class="countdown-box" id="countdown">Loading countdown...</div>
  <a href="/senarai-peserta" class="daftar-button">Lihat Senarai Peserta Berdaftar</a>
</div>

<div class="carousel-container">
  <div class="carousel-3d">
    <img src="{{ asset('images/kem-1.jpeg') }}" alt="Poster 1" onclick="openModal(this.src)">
    <img src="{{ asset('images/kem-3.jpeg') }}" alt="Poster 3" onclick="openModal(this.src)">
    <img src="{{ asset('images/kem-2.jpeg') }}" alt="Poster 2" onclick="openModal(this.src)">
  </div>
</div>

<div id="imgModal" class="modal">
  <span class="modal-close" onclick="closeModal()">&times;</span>
  <img class="modal-content" id="modalImage" alt="Preview">
</div>

<script>
  const countdownElement = document.getElementById('countdown');
  const eventTime = new Date('2025-07-12T07:00:00+08:00').getTime();

  const updateCountdown = () => {
    const now = new Date().getTime();
    const distance = eventTime - now;

    if (distance < 0) {
      countdownElement.innerHTML = "⏱️ Program sedang berlangsung!";
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `⏳ Tinggal ${days} hari ${hours} jam ${minutes} minit ${seconds} saat lagi!`;
  };
  setInterval(updateCountdown, 1000);

  function openModal(src) {
    const modal = document.getElementById("imgModal");
    const modalImage = document.getElementById("modalImage");
    modalImage.src = src;
    modal.classList.add("show");
  }

  function closeModal() {
    const modal = document.getElementById("imgModal");
    modal.classList.remove("show");
  }
</script>
@endsection
