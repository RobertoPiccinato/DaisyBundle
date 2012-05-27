<h1>{$source->publisherResponse->document.name}</h1>

<img src="http://localhost:9263/publisher/blob?
documentId={$source.documentId}&
branch={$source.branchId}&
language={$source.languageId}&
version={$source->publisherResponse->document.dataVersionId}&
partType=ImagePreview" />
<br/>
Parts:
<dl>
	{foreach from=$source->publisherResponse->document->parts->part item="part"}
	<li>{$part.label}: <a href="http://localhost:9263/publisher/blob?
						documentId={$source.documentId}&
						branch={$source.branchId}&
						language={$source.languageId}&
						version={$source->publisherResponse->document.dataVersionId}&
						partType={$part.name}" />source</a>
		({$part.mimeType} {$part.size} bytes);</li>
	{/foreach}
</dl>
Fields:
<ol>
	{foreach from=$source->publisherResponse->document->fields->field item="field"}
		<li> {$field.name} - {$field.valueFormatted}
	{/foreach}
</ol>