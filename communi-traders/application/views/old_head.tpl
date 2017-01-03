<div class="container">
    <div class="header_container">
        <div id="header" class="floatcontainer doc_header">
            <div>
                <a name="top" href="http://forums.binaryoptionsthatsuck.com/" class="logo-image">
                    <img src="{$forum_url}images/misc/vbulletin4_logo.png" alt="Binary Options That Suck Forum â€“ The first Real Binary Options Open Community - Powered by vBulletin" title="Binary Options That Suck Forum â€“ The first Real Binary Options Open Community - Powered by vBulletin"/>
                </a>
            </div>
            <div id="toplinks" class="toplinks">
                <ul class="isuser">
                    <li>
                        <a href="{$forum_url}login.php?do=logout&logouthash={$logouthash}" onclick="return log_out('Are you sure you want to log out?')">Log Out</a>
                    </li>
                    <li>
                        <a href="{$forum_url}register.php" rel="nofollow">Register</a>
                    </li>
                    <li>
                        <a href="{$forum_url}usercp.php">Settings</a>
                    </li>
                    <li>
                        <a href="{$forum_url}member.php/2-rado">My Profile</a>
                    </li>
                    <li class="popupmenu nonotifications" id="nonotifications">
                        <a class="popupctrl" href="{$forum_url}usercp.php" id="yui-gen1">Notifications</a>
                        <ul class="popupbody" id="yui-gen0">
                            <li>No new messages</li>
                            <li>
                                <a href="{$forum_url}private.php">Inbox</a>
                            </li>
                        </ul>
                    </li>
                    <li class="welcomelink">
                        Welcome, 
                        <a href="{$forum_url}member.php/{$userid}-{$username}">{$username}</a>
                    </li>
                </ul>
            </div>
            <div id="navbar" class="navbar">
                <ul id="navtabs" class="navtabs floatcontainer">
                    <li class="selected">
                        <a class="navtab" href="{$forum_url}forum.php">Forum</a>
                    </li>
                    <li>
                        <a class="navtab" href="http://www.binaryoptionsthatsuck.com/">BOTS.com HOME</a>
                    </li>
                    <ul class="floatcontainer">
                        <li>
                            <a href="{$forum_url}search.php?do=getnew&contenttype=vBForum_Post">New Posts</a>
                        </li>
                        <li>
                            <a href="{$forum_url}private.php" rel="nofollow">Private Messages</a>
                        </li>
                        <li>
                            <a rel="help" href="{$forum_url}faq.php" accesskey="5">FAQ</a>
                        </li>
                        <li>
                            <a href="{$forum_url}calendar.php">Calendar</a>
                        </li>

                        <li class="popupmenu" id="yui-gen2">
                            <a href="javascript://" class="popupctrl" accesskey="6" id="yui-gen4">Community</a>
                            <ul class="popupbody" id="yui-gen3">
                                <li>
                                    <a href="{$forum_url}group.php">Groups</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}album.php">Albums</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}profile.php?do=buddylist">Friends & Contacts</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}memberlist.php">Member List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="popupmenu" id="yui-gen5">
                            <a href="javascript://" class="popupctrl" id="yui-gen7">Forum Actions</a>
                            <ul class="popupbody" id="yui-gen6">ev
                                <li>
                                    <a href="{$forum_url}forumdisplay.php?do=markread&markreadhash=1353666967-3525bc2c915e191fa5003eccc0e49e5d58f33985">Mark Forums Read</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}profile.php?do=editoptions">General Settings</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}profile.php?do=editprofile">Edit Profile</a>
                                </li>
                            </ul>
                        </li>

                        <li class="popupmenu" id="yui-gen8">
                            <a href="javascript://" class="popupctrl" accesskey="3" id="yui-gen10">Quick Links</a>
                            <ul class="popupbody" id="yui-gen9">ev
                                <li>
                                    <a href="{$forum_url}search.php?do=getdaily&contenttype=vBForum_Post">Today's Posts</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}subscription.php" rel="nofollow">Subscribed Threads</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}javascript://" onclick="window.open(getBaseUrl() + 'misc.php?do=buddylist&focus=1','buddylist','statusbar=no,menubar=no,toolbar=no,scrollbars=yes,resizable=yes,width=250,height=300'); return false;">Open Contacts Popup</a>
                                </li>
                                <li>
                                    <a href="{$forum_url}showgroups.php" rel="nofollow"> View Forum Leaders </a>
                                </li>
                                <li>
                                    <a href="{$forum_url}online.php">Who's Online</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <li>
                        <a class="navtab" href="{$forum_url}search.php?do=getnew&contenttype=vBForum_Post" accesskey="2">What's New?</a>
                    </li>
                </ul>
                <div id="globalsearch" class="globalsearch">
                    <form action="{$forum_url}search.php?do=process" method="post" id="navbar_search" class="navbar_search">
                        <input type="hidden" name="securitytoken" value="1353666967-3525bc2c915e191fa5003eccc0e49e5d58f33985"/>
                        <input type="hidden" name="do" value="process"/>
                        <span class="textboxcontainer">
                            <span>
                                <input type="text" value="" name="query" class="textbox" tabindex="99"/>
                            </span>
                        </span>
                        <span class="buttoncontainer">
                            <span>
                                <input type="image" class="searchbutton" src="{$forum_url}images/buttons/search.png" name="submit" onclick="document.getElementById('navbar_search').submit;" tabindex="100" alt=""/>
                            </span>
                        </span>
                    </form>
                    <ul class="navbar_advanced_search">
                        <li>
                            <a href="{$forum_url}search.php" accesskey="4">Advanced Search</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>