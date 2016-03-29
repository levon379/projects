                </div>
            </div>
        </div>
    </div>
</div>


<!-- Start of warbble Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed || function (e, t) {
        var n, o, d, i, s, a = [], r = document.createElement("iframe");
        window.zEmbed = function () {
            a.push(arguments)
        }, window.zE = window.zE || window.zEmbed, r.src = "javascript:false", r.title = "", r.role = "presentation", (r.frameElement || r).style.cssText = "display: none", d = document.getElementsByTagName("script"), d = d[d.length - 1], d.parentNode.insertBefore(r, d), i = r.contentWindow, s = i.document;
        try {
            o = s
        } catch (c) {
            n = document.domain, r.src = 'javascript:var d=document.open();d.domain="' + n + '";void(0);', o = s
        }
        o.open()._l = function () {
            var o = this.createElement("script");
            n && (this.domain = n), o.id = "js-iframe-async", o.src = e, this.t = +new Date, this.zendeskHost = t, this.zEQueue = a, this.body.appendChild(o)
        }, o.write('<body onload="document._l();">'), o.close()
    }("https://assets.zendesk.com/embeddable_framework/main.js", "warbble.zendesk.com");/*]]>*/</script>
<!-- End of warbble Zendesk Widget script -->
<!-- jQuery -->

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo $base_url; ?>assets/admin-new/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>assets/admin/js/chosen.jquery.min.js"></script>
<!-- All functions for this theme + document.ready processing -->
<!--<script src="js/devoops.js"></script>-->
<?php foreach ($js_scripts as $script): ?>
    <?php if ($script['location'] == 'footer'): ?>
        <script src="<?php echo $base_url; ?>assets/<?php echo $script['type'] . '/js/' . $script['file'] ?>"></script>
    <?php endif; ?>
    <?php if ($script['location'] == 'outside_footer'): ?>
        <script src="<?php echo $script['url'] ?>" ></script>
    <?php endif; ?>
<?php endforeach; ?>
<script src="<?php echo $base_url; ?>assets/admin/js/global.js"></script>
<div class="alerts-container"></div>
</body>
</html>