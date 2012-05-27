<h1>{$source->publisherResponse->document.name}</h1>
<b>Branch:</b> <i>{$source->publisherResponse->document.branch}</i>; <b>Language:</b> <i>{$source->publisherResponse->document.language}</i>; <b>Data Version:</b> <i>{$source->publisherResponse->document.dataVersionId}</i><br />
{if is_array($source->publisherResponse->document->parts->part)}
	{foreach from=$source->publisherResponse->document->parts->part item=part}
		{$part->html}
	{/foreach}
{else}
	{$source->publisherResponse->document->parts->part->html}
{/if}
<hr />

<b>Document Links:</b><br />
{foreach from=$source->publisherResponse->document->links->link item=link}
	<a href={$link.target}>{$link.title}</a><br />
{/foreach}
