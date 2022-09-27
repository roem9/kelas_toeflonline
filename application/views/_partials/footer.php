    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url()?>assets/js/tabler.min.js"></script>
    <script src="<?= base_url()?>assets/player/plyr.min.js" defer></script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.Plyr && (new Plyr('#player-youtube'));
      });
      // @formatter:on
    </script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.Plyr && (new Plyr('#player-charlotte'));
      });
      // @formatter:on
    </script>
  </body>
</html>