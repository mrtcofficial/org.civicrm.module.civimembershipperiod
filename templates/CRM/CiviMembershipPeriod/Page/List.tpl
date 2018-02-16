{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}
<div id="help">
  {ts}Details of Your Membership periods/terms table .{/ts}
</div>

{if $rows}
  <div id="period-list">
    {strip}
      {* handle enable/disable actions *}
      {include file="CRM/common/enableDisableApi.tpl"}
      {include file="CRM/common/jsortable.tpl"}
      <table id="options" class="display">
        <thead>
        <tr>
          <th >{ts}Term/Period{/ts}</th>
          <th >{ts}Membership{/ts}</th>
          <th>{ts}Start Date{/ts}</th>
          <th>{ts}End Date{/ts}</th>
          <th>{ts}Person{/ts}</th>
          <th>{ts}Contribution{/ts}</th>
        </tr>
        </thead>
        {foreach from=$rows item=row}
      {if $row}
        <tr id="period_code-{$row.id}" class="crm-entity">
            <td class="crm-period-code"> {$row.period}</td>
            <td class="crm-period-code"> {$row.membership_name}</td>
             <td>{if $row.start_date neq '0000-00-00 00:00:00'}{$row.start_date|truncate:10:''|crmDate}{/if}</td>
            <td>{if $row.end_date neq '0000-00-00 00:00:00'}{$row.end_date|truncate:10:''|crmDate}{/if}</td>
            <td class="right"><a href='{crmURL p='civicrm/contact/view' q="cid=`$row.contact_id`&reset=1"}' title="Click to See Person Details">{ts}{$row.display_name}{/ts}</a></td>
            <td class="right"><a href='{crmURL p='civicrm/contact/view/contribution' q="id=`$row.contribution_id`&cid=`$row.contact_id`&reset=1&action=view&context=dashboard&selectedChild=contribute"}' title="Click to see Contribution Record">{ts}Contribution Link{/ts}</a> </td>
           
          </tr>
      {/if}
    {/foreach} 
      </table>
    {/strip}
  </div>
{else}
  <div class="messages status no-popup">
    <div class="icon inform-icon"></div>
    {ts}There are no Membership Purchased Yet So theres no Term recorded.{/ts}
  </div>
{/if}

<div class="action-link">
  <a href='{crmURL p='civicrm/member/add?reset=1&action=add&context=standalone' q="reset=1"}' id="newperiodCode"
     class="button"><span class="icon ui-icon-circle-plus"></span> {ts}New Membership{/ts}</a>
</div>
