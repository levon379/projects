(function ($) {
    $(function () {
        jQuery('#nxs_snapAddNew').bind('click', function (e) {
            e.preventDefault();
            jQuery('#nxs_spPopup').bPopup({
                modalClose: false,
                appendTo: '#nsStForm',
                opacity: 0.6,
                follow: [false, false],
                position: [65, 50]
            });
        });
    });
})(jQuery);

function doDelAcct(nt, blID, blName) {
    var answer = confirm("Remove " + blName + " account?");
    if (answer) {
        var data = {
            action: 'nxs_snap_aj',
            nxsact: 'nsDN',
            id: 0,
            nt: nt,
            id: blID,
            _wpnonce: jQuery('input#nxsSsPageWPN_wpnonce').val()
        };
        jQuery.post('snap-setup.php', data, function (response) {
            location.reload();
        });
    }
}

function testPost(nt, nid) {
    jQuery('#nxs_cntPopup').bPopup({
        contentContainer: '.nxsAJcnt',
        content: 'ajax',
        loadUrl: 'snap-setup.php',
        loadData: {action: 'nxs_snap_aj', nxsact: 'tst', nt: nt, nid: nid},
        modalClose: false,
        opacity: 0.6,
        positionStyle: 'fixed',
        onOpen: function () {
            jQuery('.nxs_pppSpinner').show();
        },
        loadCallback: function () {
            jQuery('.nxs_pppSpinner').hide();
        }
    });
}
function nxs_getPNBoards(u, p, ii) {
    jQuery("#pnLoadingImg" + ii).show();
    jQuery.post('snap-setup.php', {
        u: u,
        p: p,
        ii: ii,
        action: 'nxs_snap_aj',
        nxs_mqTest: "'",
        nxsact: 'getPNBoards',
        id: 0,
        _wpnonce: jQuery('input#nxsSsPageWPN_wpnonce').val()
    }, function (j) {
        var options = '';
        jQuery("select#apPNBoard" + ii).html(j);
        jQuery("#pnLoadingImg" + ii).hide();
    }, "html")
}

function doGetHideNTBlock(bl, ii) {
    if (jQuery('#apDoS' + bl + ii).length < 1 || jQuery('#apDoS' + bl + ii).val() == '0') {
        if (jQuery('#do' + bl + ii + 'Div').length < 1) {
            jQuery("#" + bl + ii + "LoadingImg").show();
            jQuery.post('snap-setup.php', {
                nxsact: 'getNTset',
                nt: bl,
                ii: ii,
                action: 'nxs_snap_aj',
                _wpnonce: jQuery('input#nxsSsPageWPN_wpnonce').val()
            }, function (j) {
                var options = '';
                //## Show data
                if (ii == 'N') {
                    jQuery('#nsx_addNT').html(j);
                    nxs_doTabsInd('#nsx_addNT');
                    jQuery('#nsx_addNT > div:first-child').show();
                } else {
                    jQuery('#nxsNTSetDiv' + bl + ii).html(j);
                    nxs_doTabsInd('#nxsNTSetDiv' + bl + ii);
                    jQuery("#" + bl + ii + "LoadingImg").hide();
                    jQuery('#do' + bl + ii + 'Div').show();
                    jQuery('#do' + bl + ii + 'AG').text('[Hide Settings]');
                    jQuery('#apDoS' + bl + ii).val('1');
                    if (jQuery('#rbtn' + bl.toLowerCase() + ii).attr('type') != 'checkbox') jQuery('#rbtn' + bl.toLowerCase() + ii).attr('type', 'checkbox');
                }
                // if (filtersReset) jQuery('#catSelA'+bl+ii).prop('checked', true);
            }, "html")
        } else {
            jQuery('#do' + bl + ii + 'Div').show();
            jQuery('#do' + bl + ii + 'AG').text('[Hide Settings]');
            jQuery('#apDoS' + bl + ii).val('1');
        }
    } else {
        jQuery('#do' + bl + ii + 'Div').hide();
        jQuery('#do' + bl + ii + 'AG').text('[Show Settings]');
        jQuery('#apDoS' + bl + ii).val('0');
    }
}

function nxs_doTabsInd(iid) {
    //When page loads...
    jQuery(iid + " .nsx_tab_content").hide(); //Hide all content
    jQuery(iid + " ul.nsx_tabs > li:first-child").addClass("active").show(); //Activate first tab
    jQuery(iid + " .nsx_tab_container > .nsx_tab_content:first-child").show(); //Show first tab content

    //On Click Event
    jQuery(iid + " ul.nsx_tabs li").click(function () {
        jQuery(this).parent().children("li").removeClass("active"); //Remove any "active" class
        jQuery(this).addClass("active"); //Add "active" class to selected tab
        jQuery(this).parent().parent().children(".nsx_tab_container").children(".nsx_tab_content").hide(); //Hide all tab content
        var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
        jQuery(activeTab).show(); //Fade in the active ID content
        return false;
    });

}

/*================================================================================
 * @name: bPopup - if you can't get it up, use bPopup * @author: (c)Bjoern Klinggaard (twitter@bklinggaard) * @version: 0.9.4.min
 ================================================================================*/
(function (b) {
    b.fn.bPopup = function (z, F) {
        function K() {
            a.contentContainer = b(a.contentContainer || c);
            switch (a.content) {
                case "iframe":
                    var h = b('<iframe class="b-iframe" ' + a.iframeAttr + "></iframe>");
                    h.appendTo(a.contentContainer);
                    r = c.outerHeight(!0);
                    s = c.outerWidth(!0);
                    A();
                    h.attr("src", a.loadUrl);
                    k(a.loadCallback);
                    break;
                case "image":
                    A();
                    b("<img />").load(function () {
                        k(a.loadCallback);
                        G(b(this))
                    }).attr("src", a.loadUrl).hide().appendTo(a.contentContainer);
                    break;
                default:
                    A(), b('<div class="b-ajax-wrapper"></div>').load(a.loadUrl, a.loadData, function () {
                        k(a.loadCallback);
                        G(b(this))
                    }).hide().appendTo(a.contentContainer)
            }
        }

        function A() {
            a.modal && b('<div class="b-modal ' + e + '"></div>').css({
                backgroundColor: a.modalColor,
                position: "fixed",
                top: 0,
                right: 0,
                bottom: 0,
                left: 0,
                opacity: 0,
                zIndex: a.zIndex + t
            }).appendTo(a.appendTo).fadeTo(a.speed, a.opacity);
            D();
            c.data("bPopup", a).data("id", e).css({
                left: "slideIn" == a.transition || "slideBack" == a.transition ? "slideBack" == a.transition ? g.scrollLeft() + u : -1 * (v + s) : l(!(!a.follow[0] && m || f)),
                position: a.positionStyle || "absolute",
                top: "slideDown" == a.transition || "slideUp" == a.transition ? "slideUp" == a.transition ? g.scrollTop() + w : x + -1 * r : n(!(!a.follow[1] && p || f)),
                "z-index": a.zIndex + t + 1
            }).each(function () {
                a.appending && b(this).appendTo(a.appendTo)
            });
            H(!0)
        }

        function q() {
            a.modal && b(".b-modal." + c.data("id")).fadeTo(a.speed, 0, function () {
                b(this).remove()
            });
            a.scrollBar || b("html").css("overflow", "auto");
            b(".b-modal." + e).unbind("click");
            g.unbind("keydown." + e);
            d.unbind("." + e).data("bPopup", 0 < d.data("bPopup") - 1 ? d.data("bPopup") - 1 : null);
            c.undelegate(".bClose, ." + a.closeClass, "click." + e, q).data("bPopup", null);
            H();
            return !1
        }

        function G(h) {
            var b = h.width(), e = h.height(), d = {};
            a.contentContainer.css({height: e, width: b});
            e >= c.height() && (d.height = c.height());
            b >= c.width() && (d.width = c.width());
            r = c.outerHeight(!0);
            s = c.outerWidth(!0);
            D();
            a.contentContainer.css({height: "auto", width: "auto"});
            d.left = l(!(!a.follow[0] && m || f));
            d.top = n(!(!a.follow[1] && p || f));
            c.animate(d, 250, function () {
                h.show();
                B = E()
            })
        }

        function L() {
            d.data("bPopup", t);
            c.delegate(".bClose, ." + a.closeClass, "click." + e, q);
            a.modalClose && b(".b-modal." + e).css("cursor", "pointer").bind("click", q);
            M || !a.follow[0] && !a.follow[1] || d.bind("scroll." + e, function () {
                B && c.dequeue().animate({
                    left: a.follow[0] ? l(!f) : "auto",
                    top: a.follow[1] ? n(!f) : "auto"
                }, a.followSpeed, a.followEasing)
            }).bind("resize." + e, function () {
                w = y.innerHeight || d.height();
                u = y.innerWidth || d.width();
                if (B = E())clearTimeout(I), I = setTimeout(function () {
                    D();
                    c.dequeue().each(function () {
                        f ? b(this).css({left: v, top: x}) : b(this).animate({
                            left: a.follow[0] ? l(!0) : "auto",
                            top: a.follow[1] ? n(!0) : "auto"
                        }, a.followSpeed, a.followEasing)
                    })
                }, 50)
            });
            a.escClose && g.bind("keydown." + e, function (a) {
                27 == a.which && q()
            })
        }

        function H(b) {
            function d(e) {
                c.css({display: "block", opacity: 1}).animate(e, a.speed, a.easing, function () {
                    J(b)
                })
            }

            switch (b ? a.transition : a.transitionClose || a.transition) {
                case "slideIn":
                    d({left: b ? l(!(!a.follow[0] && m || f)) : g.scrollLeft() - (s || c.outerWidth(!0)) - C});
                    break;
                case "slideBack":
                    d({left: b ? l(!(!a.follow[0] && m || f)) : g.scrollLeft() + u + C});
                    break;
                case "slideDown":
                    d({top: b ? n(!(!a.follow[1] && p || f)) : g.scrollTop() - (r || c.outerHeight(!0)) - C});
                    break;
                case "slideUp":
                    d({top: b ? n(!(!a.follow[1] && p || f)) : g.scrollTop() + w + C});
                    break;
                default:
                    c.stop().fadeTo(a.speed, b ? 1 : 0, function () {
                        J(b)
                    })
            }
        }

        function J(b) {
            b ? (L(), k(F), a.autoClose && setTimeout(q, a.autoClose)) : (c.hide(), k(a.onClose), a.loadUrl && (a.contentContainer.empty(), c.css({
                height: "auto",
                width: "auto"
            })))
        }

        function l(a) {
            return a ? v + g.scrollLeft() : v
        }

        function n(a) {
            return a ? x + g.scrollTop() : x
        }

        function k(a) {
            b.isFunction(a) && a.call(c)
        }

        function D() {
            x = p ? a.position[1] : Math.max(0, (w - c.outerHeight(!0)) / 2 - a.amsl);
            v = m ? a.position[0] : (u - c.outerWidth(!0)) / 2;
            B = E()
        }

        function E() {
            return w > c.outerHeight(!0) && u > c.outerWidth(!0)
        }

        b.isFunction(z) && (F = z, z = null);
        var a = b.extend({}, b.fn.bPopup.defaults, z);
        a.scrollBar || b("html").css("overflow", "hidden");
        var c = this, g = b(document), y = window, d = b(y), w = y.innerHeight || d.height(), u = y.innerWidth || d.width(), M = /OS 6(_\d)+/i.test(navigator.userAgent), C = 200, t = 0, e, B, p, m, f, x, v, r, s, I;
        c.close = function () {
            a = this.data("bPopup");
            e = "__b-popup" + d.data("bPopup") + "__";
            q()
        };
        return c.each(function () {
            b(this).data("bPopup") || (k(a.onOpen), t = (d.data("bPopup") || 0) + 1, e = "__b-popup" + t + "__", p = "auto" !== a.position[1], m = "auto" !== a.position[0], f = "fixed" === a.positionStyle, r = c.outerHeight(!0), s = c.outerWidth(!0), a.loadUrl ? K() : A())
        })
    };
    b.fn.bPopup.defaults = {
        amsl: 50,
        appending: !0,
        appendTo: "body",
        autoClose: !1,
        closeClass: "b-close",
        content: "ajax",
        contentContainer: !1,
        easing: "swing",
        escClose: !0,
        follow: [!0, !0],
        followEasing: "swing",
        followSpeed: 500,
        iframeAttr: 'scrolling="no" frameborder="0"',
        loadCallback: !1,
        loadData: !1,
        loadUrl: !1,
        modal: !0,
        modalClose: !0,
        modalColor: "#000",
        onClose: !1,
        onOpen: !1,
        opacity: 0.7,
        position: ["auto", "auto"],
        positionStyle: "absolute",
        scrollBar: !0,
        speed: 250,
        transition: "fadeIn",
        transitionClose: !1,
        zIndex: 999997
    }
})(jQuery);