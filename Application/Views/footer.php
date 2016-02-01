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
<nav class="navbar navbar-default navbar-inverse navbar-static-top footer-nav <?= isset($mode) && is_string($mode) ? $mode : ''; ?>">
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
                <li <?= ($rc->isRequestUrl('page/terms-of-use') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/terms-of-use/'); ?>"><span class="glyphicon glyphicon-list"></span> Terms of Use</a></li>
                <li <?= ($rc->isRequestUrl('page/legal-notice') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/legal-notice/'); ?>"><span class="glyphicon glyphicon-bullhorn"></span> Legal Notice</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Designed by <?php site_info('designed-by'); ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#top"><span class="glyphicon glyphicon-circle-arrow-up"></span> Back to top</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php home_url('/Assets/js/jquery.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/barebones.js'); ?>"></script>
</body>
</html>