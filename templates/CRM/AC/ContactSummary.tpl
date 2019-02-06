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

  {/literal}
  {if $hideGender}
    $("div.crm-label:contains('Gender')").parent().hide();
  {/if}
  {literal}

  {/literal}
  {if $hideDOB}
    $("div.crm-label:contains('Date of Birth')").parent().hide();
    $("div.crm-label:contains('Age')").parent().hide();
  {/if}
  {literal}

  {/literal}
  {if $hideGender and $hideDOB}
    $("div.crm-summary-demographic-block").hide();
  {/if}
  {literal}

  {/literal}
  {if $hideAth}
    $('div.Athlete_Info').hide();
  {/if}
  {literal}

  {/literal}
  {if $hideInfo}
    $('div.more_athlete_info').hide();
  {/if}
  {literal}

  {/literal}
  {if $hideStatus}
    $('div.Status').hide();
  {/if}
  {literal}

  $.expr[':'].textEquals = $.expr[':'].textEquals || $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().match("^" + arg + "$");
    };
  });

  // Reorder fields
  var sport = $("div.crm-label:textEquals('Sport')").parent();
  var nonmember = $("div.crm-label:textEquals('Status non-member')").parent();
  var discipline = $("div.crm-label:contains('Discipline')").parent();
  var para = $("div.crm-label:contains('Are you a para athlete?')").parent();
  var retirement = $("div.crm-label:textEquals('Retirement date')").parent();
  var sportorg = $("div.crm-label:textEquals('Sport organization')").parent();
  var org = $("div.crm-label:textEquals('Organization/Organisation')").parent();
  retirement.insertAfter(nonmember);
  para.insertAfter(retirement);
  sport.insertAfter(para);
  sportorg.insertAfter(sport);
  org.insertAfter(sportorg);
  discipline.insertAfter(org);
  $('div.Athlete_Info').hide();

  // Address fields.
  var permaddress = $("div.crm-label:contains('Permanent Address')").parent().parent().parent();
  var hometownaddress = $("div.crm-label:contains('Home town Address')").parent().parent().parent();
  

  $('div.contactTopBar > div.contactCardLeft').prepend($('div.Status'));
  $('div.crm-summary-demographic-block').insertAfter($('div.Status'));
  $('#email-block').insertAfter($('div.crm-summary-demographic-block'));
  $('#phone-block').insertAfter($('#email-block'));
  hometownaddress.insertBefore($('#email-block'));
  permaddress.insertAfter($('#email-block'));
  // Remove Permission checkbox
  $('div.Permission_checkbox').hide();

  {/literal}
  {if $hidenonmember}
    $("div.crm-label:textEquals('Status non-member')").parent().hide();
  {/if}
  {literal}

  {/literal}
  {if $hidemember}
    $("div.crm-label:textEquals('Status')").parent().hide();
  {/if}
  {literal}

  {/literal}
  {if !$hidemember and !$hidenonmember}
    $(discipline).hide();
  {/if}
  {literal}
  
  // Remove all other statuses other than one selected.
  var fieldsToHide = {/literal}{$fieldsToHide}{literal};
  $.each(fieldsToHide, function(i, obj) {
    var element = $("div.crm-label:contains('" + obj + "')");
    element.parent().hide();
  });
});
</script>
{/literal}
