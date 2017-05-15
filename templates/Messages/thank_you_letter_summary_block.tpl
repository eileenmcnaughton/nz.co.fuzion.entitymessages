{assign var='contact_aggregate' value=0}

<table border="1" cellpadding="2" cellspacing="0" class="table" style="width: 500px;">
  <thead>
  <tr>
    <th>Date</th>
    <th>Reference</th>
    <th>Amount</th>
    <th>Financial Type</th>
  </tr>
  </thead>
  <tbody><!--
{foreach from=$contributions item=contribution}
 {if $contribution.contact_id == $messageContactID}
 {assign var='date' value=$contribution.receive_date|date_format:'%d %B %Y'}
 {assign var=contact_aggregate
  value=$contact_aggregate+$contribution.total_amount}
-->
  <tr>
    <td>{$date}</td>
    <td>{$contribution.id}</td>
    <td>{$contribution.total_amount|crmMoney}</td>
    <td>{$contribution.financial_type}</td>
  </tr>
  <!--
  {/if}
{/foreach}
-->
  <tr>
    <td><strong>Total</strong></td>
    <td>&nbsp;</td>
    <td><strong>{$contact_aggregate|crmMoney}</strong></td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
