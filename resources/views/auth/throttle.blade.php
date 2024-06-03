<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ERROR</title>
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}"/>
    <style>
      .disabled {
        pointer-events: none;
        opacity: 0.6;
      }
    </style>
  </head>
  <body data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <div class="wrapper">
      <div class="gradient">
        <div class="container">
          <h2 class="mb-0 mt-4 text-white">¡Oops! Demasiados intentos.</h2>
          <p class="mt-2 text-white">Inténtelo de nuevo en <span id="countdown">{{ $seconds }}</span> segundos.</p>
          <a id="retryButton" class="btn bg-white text-primary d-inline-flex align-items-center disabled" href="{{ route('login') }}">Regresar</a>
        </div>  
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var seconds = {{ $seconds }};
        var countdownElement = document.getElementById('countdown');
        var retryButton = document.getElementById('retryButton');

        var interval = setInterval(function() {
          seconds--;
          countdownElement.textContent = seconds;

          if (seconds <= 0) {
            clearInterval(interval);
            retryButton.classList.remove('disabled');
            retryButton.textContent = 'Regresar';
          }
        }, 1000);
      });
    </script>
  </body>
</html>
