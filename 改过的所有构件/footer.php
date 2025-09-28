<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->

<footer id="footer" role="contentinfo">
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="https://typecho.org">Typecho</a> 强力驱动'); ?>.
</footer><!-- end #footer -->

<?php $this->footer(); ?>

<!-- 回到顶部按钮 -->
<a href="#" id="back-to-top" title="回到顶部">🔝</a>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const backToTopButton = document.getElementById('back-to-top');

    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    backToTopButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>

<style>
#back-to-top {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007acc;
    color: white;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border-radius: 50%;
    font-size: 20px;
    text-decoration: none;
    opacity: 0.8;
    transition: all 0.3s ease;
    z-index: 999;
}
#back-to-top:hover {
    background-color: #005a99;
    opacity: 1;
    transform: scale(1.1);
}
#back-to-top.show {
    display: block;
}
</style>

</body>
</html>
