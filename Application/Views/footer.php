<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date: 10/4/2015
 * Time: 6:43 PM
 */
?>
</div><!--/container-fluid-->

<!-- Bottom navbar -->
<nav class="navbar navbar-default navbar-static-top footer-nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-footer" aria-expanded="false" aria-controls="navbar-footer">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar-footer" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?= ($rc->isRequestUrl('assembly') ? 'class="active"': ''); ?>><a href="#">About <?php site_info('name'); ?></a></li>
                <li <?= ($rc->isRequestUrl('assembly') ? 'class="active"': ''); ?>><a href="#">Terms of Use</a></li>
                <li <?= $s = ($rc->isRequestUrl('news') ? 'class="active"': ''); ?>><a href="#">Legal Notice</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php home_url('/admin-login')?>">Admin Login</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php home_url('/Assets/js/jquery.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/bootstrap.min.js'); ?>"></script>
</body>
</html>