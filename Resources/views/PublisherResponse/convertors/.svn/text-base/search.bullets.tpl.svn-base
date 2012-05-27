<ul>
{foreach from=$source->rows->row item="row"}
	<li>
	{foreach from=$row item="cel"}
		{$cel} - 
	{/foreach}
	<a href="http://localhost/DaisyLib/test.php?id={$row.documentId}&amp;branch={$row.branchId}&amp;language={$row.languageId}&amp;version=live">view</a>
	</li>
{/foreach}	
</ul>