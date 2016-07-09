<div class="modal fade" id="bidReceived">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="bidReceivedLabel">Bid Received</h2>
        <i class="fa fa-times fa-lg" data-dismiss="modal"></i>
      </div>
      <div class="modal-body">
        <p>You just received a bid, please click the button to view your bid.</p>
        <br />
        
        @if(isset($bidToViewId))
          <a href="view-bid/{{ $bidToViewId }}/view" class="btn btn-default modal-btn">View Bid</a>
        @endif
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
