<?php if($login):?>
    </div>
<?php else: ?>
    </section>

<?php endif; ?>
<?php
echo "Confirm test";
?>
<p>Are you really want charge <?PHP echo $currency.$amount;?> ?</p>

<p class="button" ><a role="button" href="<?PHP echo BASE_URL."Payment/AddCard/".$pack_id."/".$token;?>" class="btn btn-lg btn-primary get_started btn_ btn-block">Confirm</a></p>


<p class="button" ><a role="button" href="<?PHP echo BASE_URL;?>" class="btn btn-lg btn-primary get_started btn_ btn-block">Cancel</a></p>