</main>


<footer class="border-t border-slate-200 text-center text-sm text-slate-400 py-5">

    &copy; 2026 SIMPUS-Mini — Jobsheet 7

</footer>


<script src="<?php echo $base; ?>assets/js/app.js"></script>


<?php if (!empty($extra_scripts)): ?>

    <?php foreach ($extra_scripts as $script): ?>

        <script src="<?php echo $base . $script; ?>"></script>

    <?php endforeach; ?>

<?php endif; ?>


</body>

</html>