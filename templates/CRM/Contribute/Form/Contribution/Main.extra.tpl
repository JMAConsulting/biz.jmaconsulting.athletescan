<div id="recur_text">
<div class="crm-public-form-item crm-section is_recur_new-section">
      <div class="label">&nbsp;</div>
      <div class="content">
        <input name="is_recur" id="recur_yes" type="radio" value="1" class="crm-form-checkbox"> <label for="recur_yes">Yes, please automate my annual contribution for me!</label>
        <div id="recurHelp" class="description" style="display: none;">
          Your recurring contribution will be processed automatically.
        </div><div class="clear"></div>
        <input name="is_recur" id="recur_no" type="radio" value="0" class="crm-form-checkbox"> <label for="recur_no">No thank you. I will make my next contribution when prompted.</label>
      </div>
      <div class="clear"></div>
    </div>
</div>

{literal}
<script type="text/javascript">
CRM.$(function($) {
  $("div.is_recur-section").replaceWith($('#recur_text'));
  var recurSelected = "{/literal}{$recur_selected}{literal}";
  if (recurSelected) {
    $('#recur_yes').attr("checked", "checked");
  } 
  else {
    $('#recur_no').attr("checked", "checked");
  }

  $('input[name="is_recur"]').on('change', function() {
    toggleRecurNew();
  });

  function toggleRecurNew( ) {
    var isRecur = $('input[name="is_recur"]:checked');
    var allowAutoRenew = {/literal}'{$allowAutoRenewMembership}'{literal};
    var quickConfig = {/literal}{$quickConfig}{literal};
    if ( allowAutoRenew && $("#auto_renew") && quickConfig) {
      showHideAutoRenew( null );
    }
    if (isRecur.val() > 0) {
      $('#recurHelp').show();
      $('#amount_sum_label').text('{/literal}{ts escape='js'}Regular amount{/ts}{literal}');
    }
    else {
      $('#recurHelp').hide();
      $('#amount_sum_label').text('{/literal}{ts escape='js'}Total Amount{/ts}{literal}');
    }
  }

});
</script>
{/literal}