{if $isHide}
{literal}
<script type="text/javascript">
CRM.$(function($) {
  // Hide employer, job title.
  $('#crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(3), #crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(2)').hide();
  $( document ).ajaxComplete(function( event, xhr, settings ) {
    $('#crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(3), #crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(2)').hide();
  });
});
</script>
{/literal}
{/if}

{literal}
<script type="text/javascript">
CRM.$(function($) {

  // Remove nickname
  $('#crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(4)').hide();
  $( document ).ajaxComplete(function( event, xhr, settings ) {
    $('#crm-contactinfo-content > div.crm-inline-block-content > div:nth-child(4)').hide();
  });

  // Remove Permission checkbox
  $('div.Permission_checkbox').hide();
  
  // Remove all other statuses other than one selected.
  var fieldsToHide = {/literal}{$fieldsToHide}{literal};
  $.each(fieldsToHide, function(i, obj) {
    var element = $("div.crm-label:contains('" + obj + "')");
    element.parent().hide();
  });
});
</script>
{/literal}