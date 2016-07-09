<nav>
    <ul>
      <li>
        <a href="/view-the-board"  >{{ Lang::get('site_content.nav_View_Board')	 }}</a>
      </li>
      <li>
        <a href="/create-edit-a-post"  >{{ Lang::get('site_content.nav_Create_Edit_Post') }}</a>
      </li>
      <li>
        <a href="/create-edit-a-post"  >{{ Lang::get('site_content.nav_View_Bid') }}</a>
      </li>
      <li>
        <a href="/contact-us"  >{{ Lang::get('site_content.nav_Contact_Us') }}</a>
      </li>
      @if($navLoginVisible)
        <li>
          <a href="/login"  >Login</a>
        </li>
      @endif
      @if($navLogoutVisible)
        <li>
          <a href="/logout">Logout, {{{ $userInfo['name'] }}}</a>
        </li>
      @endif
      @if($navAdminVisible)
        <li>
          <a href="/admin_menu"  >{{ Lang::get('site_content.nav_Admin_Menu') }}</a>
        </li>
      @endif
    </ul>
</nav>
