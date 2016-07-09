<header>
    <!-- header-left -->
    <div class="header-left">
      <a href="/">
        <img src="{{ URL::asset('images/cartel-logo.png') }}" alt="Cartel Marketing Inc. Logo" />
      </a>
    </div> <!-- header-left -->
    
    <!-- header-right -->
    <div class="header-right">
      <p class="region"> {{{ $pageData['localeName'] or 'LocaleName' }}} </p>
      <img src="{{ URL::asset('images/tv-screen.png') }}" alt="Switch Screen Size"
            class="switch-view"
            onclick="alert('Will be a toggle for making everything larger for displaying on TVs. Feature is temporarily disabled.');"  >
      
      <button class="btn btn-sm btn-primary btn-help" data-toggle="popover"
              title="{{ $helpTitle  or ""}}" data-placement="bottom"
                data-container="body" 
                data-content="{{ $help or "" }}">
            {{ Lang::get('site_content.header_Need_Help_Button') }}
      </button>
    </div> <!-- header-right -->
    
</header>
