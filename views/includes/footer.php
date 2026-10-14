  </main>
  <footer class="footer text-white text-center py-2">
    <p class="mb-0">Programación Avanzada © 2026</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <?php foreach ($scriptsExtra ?? [] as $src): ?>
  <script src="<?php echo $src; ?>"></script>
  <?php endforeach; ?>
</body>
</html>
