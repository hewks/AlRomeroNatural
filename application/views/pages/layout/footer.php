</div>
<!-- //Page Container -->

<script src="<?= base_url() ?>assets/vendor/fontawesome/js/all.min.js"></script>

<script src="<?= base_url() ?>assets/js/main.js"></script>

<!-- Scripts -->
<?php foreach ($scripts as $script) : ?>
    <script src="<?= base_url() ?>assets/<?= $script ?>"></script>
<?php endforeach ?>
<!-- //Scripts -->

</body>

</html>