<footer class="pt-5 pb-5">
    <div class="text-center">
        <span class="text-secondary" style="font-size: 13px;">
            Copyright (c) <?php echo $siteDEV. ' ' .date('Y'); ?>
        </span>
    </div>
</footer>
<script type="text/javascript" src="<?php echo $siteURL; ?>/src/js/bootstrap.min.js"></script>
<script>
    document.querySeleqtorAll(".nav-link").forEach((link) =>{
        if (link.herf === window.location.herf) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        }
    })
</script>
</body>
</html>