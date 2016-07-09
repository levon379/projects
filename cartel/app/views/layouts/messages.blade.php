{{-- ----------------------------------------------------- --}}    
{{-- Response errors and messages --}}
{{-- ----------------------------------------------------- --}}    
<div id="laravelmessages">

  {{-- Errors --}}
  <ul class="laravelerrors">
    @foreach($errors->all() as $error)
      <li style="background-color:{{ $error_color or "LightPink" }};">{{ $error }}</li>
    @endforeach
  </ul>
  
  {{-- with-> messages --}}
  @if(isset($messages))
    @if(is_array($messages) && count($messages) == 2) 
      <p style="background-color:{{ $messages[1] }}">&nbsp;{{ $messages[0] }}</p>
    @else
      {{ '<p>'. $messages .'</p>' }}
    @endif
  @endif
  
  {{-- session messages --}}
  @if(Session::has('messages'))
    @if(is_array(Session::get('messages')))
      <div style='background-color: {{{ Session::get('messages')[1] }}}'>&nbsp;
      {{{ Session::get('messages')[0] }}}
    @else
    <div>&nbsp;
      {{{ Session::get('messages') }}}
    @endif
    
    </div>
    <?php Session::forget('messages'); ?>
  @endif

</div>
