<footer id="footer">
  <div class="container">
    <p>&copy; 2014 Cartel Marketing Inc. </p>
    <p>Website by <a href="http://www.jevmarketing.com" target="_blank">JEV Marketing &amp; Communications</a>.
    <!-- Button trigger modal -->
    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#bidReceived">
      Launch "Bid Received" Demo
    </button> <img src="{{ URL::asset('images/logo.png') }}" alt="Cartel" style="width: 5%" class="pull-right"></p>
  </div>
</footer>

  <?php  /*
    echo "<font size=2>";
    echo var_dump(Session::all());
    echo "<br /><br />AuthID/UserID:";
    echo Auth::id();
    echo "<BR>Terms:";
    echo Session::get('terms', function() { return 'default'; });
    echo "<BR>Lang:";
    echo Session::get('default_lang', function() { return 'default'; });
    echo "<BR>loginAttempts:";
    echo Session::get('loginAttempts', function() { return '0'; });
    echo "<BR>lockoutTime:";
    echo Session::get('lockoutTime', function() { return '0'; });
    echo "<BR><A HREF='/logout'>Logout</A>";
    echo "</font>";
*/
    //print_r(array_keys(get_defined_vars()));

    //Util::ShowPre($pageData);
  ?>
 
