<table border="1" cellspacing="2" cellpadding="2" boder-color="red" title="{$source->executionInfo->query}">
<tr>
{foreach from=$source->titles->title item="title"}
	<td>{$title}</td>
{/foreach}
<td> </td>
</tr>
{foreach from=$source->rows->row item="row"}
	<tr>
	{foreach from=$row item="cel"}
		<td>{$cel}</td>
	{/foreach}
	<td><a href="http://localhost/DaisyLib/test.php?id={$row.documentId}&amp;branch={$row.branchId}&amp;language={$row.languageId}&amp;version=live">view</a></td>
	</tr>
{/foreach}
</table>