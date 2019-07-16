</div>
<!-- //Section Container -->

<footer class="hw-footer">
    <span href="#">2019 &copy; Al Romero Natural y Creador por: <a href="https://www.hewks.net">Hewks.net</a></span>
</footer>

<i class="hw-bg-icon hw-bg-icon-1 fab fa-pagelines"></i>
<i class="hw-bg-icon hw-bg-icon-2 fab fa-canadian-maple-leaf"></i>
<i class="hw-bg-icon hw-bg-icon-3 fas fa-tree"></i>
<i class="hw-bg-icon hw-bg-icon-4 fas fa-leaf"></i>
<i class="hw-bg-icon hw-bg-icon-5 fas fa-dove"></i>
<i class="hw-bg-icon hw-bg-icon-6 fas fa-feather"></i>
<i class="hw-bg-icon hw-bg-icon-7 fas fa-paw"></i>
<i class="hw-bg-icon hw-bg-icon-8 fas fa-apple-alt"></i>
<i class="hw-bg-icon hw-bg-icon-9 fas fa-carrot"></i>
<i class="hw-bg-icon hw-bg-icon-10 fas fa-moon"></i>
<i class="hw-bg-icon hw-bg-icon-11 fas fa-seedling"></i>

</div>
<!-- //Page Container -->

<script>
    var base_url = '<?= base_url() ?>'
</script>

<script src="<?= base_url() ?>assets/vendor/fontawesome/js/all.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/pnotify/js/PNotify.js"></script>
<script src="<?= base_url() ?>assets/vendor/pnotify/js/PNotifyMobile.js"></script>

<script src="<?= base_url() ?>assets/js/main.js"></script>

<!-- Scripts -->
<?php foreach ($scripts as $script) : ?>
    <script src="<?= base_url() ?>assets/<?= $script ?>"></script>
<?php endforeach ?>
<!-- //Scripts -->

</body>

</html>