@extends('frontend.layouts.master')

@section('content')
<main id="main">
  <section id="paket" class="paket" style="padding: 30px !important;">
    <div class="container">

      <div class="section-title">
        <p data-aos="fade-up"><hr></p>
        <h2 data-aos="fade-up">Cara Pembayaran Reservasi / Booking - {{ $booking['kode_booking'] }}</h2>
        <p data-aos="fade-up"><hr></p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-12">
          <h5 class="text-center font-weight-bold">
            Silahkan Lakukan Transfer Pembayaran DP Untuk Reservasi 
            <br>
            Silahkan Bayar Sebelum : {{ date('d-m-Y H:i:s', strtotime($booking['created_at'] . '+1 Hour')) }}
            <br>
            <div> - <span id="time"></span> - </div>
          </h5>
          <hr>
        </div>
        <div class="col-md-12 text-center">
          <p>
            Kode Booking : <b>{{ $booking['kode_booking'] }}</b> 
            <br>
            Nominal Yang Harus di-Bayar : <b>Rp. {{ number_format($booking['total_pembayaran'], 0, ',', '.') }}</b>
            <br>
            <hr>
          </p>
        </div>
        <div class="col-md-4" style="padding: 0px 40px !important;">
          <p>
            <b style="letter-spacing: 3px !important;">BCA</b>
            <br>
            
            <b>Nomor Rekening : </b> 
            <br>
            &ensp; &ensp; <b style="letter-spacing: 3px !important;">1122334455</b>

            <br>
            <b>Atas Nama :</b> 
            <br>
            &ensp; &ensp; <b style="letter-spacing: 3px !important;">Studio Afternoon Project</b>

          </p>
          <hr>
        </div>
        <div class="col-md-4" style="padding: 0px 40px !important;">
          <p>
            <b style="letter-spacing: 3px !important;">BRI</b>
            <br>
            
            <b>Nomor Rekening : </b> 
            <br>
            &ensp; &ensp; <b style="letter-spacing: 3px !important;">66778899101</b>

            <br>
            <b>Atas Nama :</b> 
            <br>
            &ensp; &ensp; <b style="letter-spacing: 3px !important;">Studio Afternoon Project</b>

          </p>
          <hr>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

@section('script')
<script>
  function startTimer(duration, display) {
    var start = Date.now(),
        diff,
        minutes,
        seconds;
    function timer() {
      // get the number of seconds that have elapsed since 
      // startTimer() was called
      diff = duration - (((Date.now() - start) / 1000) | 0);

      // does the same job as parseInt truncates the float
      minutes = (diff / 60) | 0;
      seconds = (diff % 60) | 0;

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.textContent = minutes + ":" + seconds; 

      if (diff <= 0) {
          // add one second so that the count down starts at the full duration
          // example 05:00 not 04:59
          start = Date.now() + 1000;
      }
    };
    // we don't want to wait a full second before the timer starts
    timer();
    setInterval(timer, 1000);
  }

  window.onload = function () {
    var timer = "{{ $timer }}";
    var cl = + timer;
    var fiveMinutes = cl,
      display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
  };
</script>
@endsection