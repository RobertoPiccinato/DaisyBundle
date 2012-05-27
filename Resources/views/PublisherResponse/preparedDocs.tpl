<html>
	<head>
		<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>{$source->preparedDocuments->preparedDocument[0]->publisherResponse->document.name}</title>
	</head>
	<body>
	<table><tr>
	<td valign="top" align="left" width="80%">
	<div>
	{if !empty($source->availableVariants->availableVariant)}
		Document variants:
		<ul>
			{foreach from=$source->availableVariants->availableVariant item="variant"}
				<li>
					<a href="{$variant.href}">{$variant.branchName} - {$variant.languageName}</a>
				</li>
			{/foreach}
		</ul>
	{/if}
	
	{foreach from=$documentBody item="body"}
		{$body}
	{/foreach}
	
	{if !empty($source->versions)}
		<table cellspacing="2" cellpadding="2">
		<thead>Versions:</thead>
		<tr>
			<td>Id</td>
			<td>modified</td>
			<td>creator</td>
			<td>state</td>
			<td bgcolor="white"> </td>
		</tr>
		{foreach from=$source->versions->version item="version"}
			<tr bgcolor="yellow">
				<td>{$version.id}</td>
				<td>{$version.stateLastModifiedFormatted}</td>
				<td>{$version.creatorDisplayName}</td>
				<td>{$version.state}</td>
				{if $version.live}
					<td bgcolor="red">live</td>
				{else}
					<td bgcolor="white"> </td>
				{/if}
			</tr>
		{/foreach}
		</table>
	{/if}
	
	<hr border="3" />
	Comments:<br />
	{foreach from=$source->comments->comment item="comment"}
		On {$comment.createdOnFormatted}
		<strong>{$comment.createdByDisplayName}</strong> said:<br />
		{$comment->content}
		<br /><br />
	{/foreach}
	
	</td><td width="20%" valign="top" align="left">
	
	{if !empty($source->navigationTree)}
		<ul style="square">
		{if $source->navigationTree->doc.selected}
			{assign var="selectedId" value=$source->navigationTree->doc.id}
		{else}
			{assign var="selectedId" value="0"}
		{/if}
		{foreach from=$source->navigationTree->group->doc item="doc"}
			{if $doc.selected || $doc.id == $selectedId}
				<li><b><a href="{$doc.href}">{$doc.label}</a></b></li>
			{else}
				<li><a href="{$doc.href}">{$doc.label}</a></li>
			{/if}
		{/foreach}
		<ul>
	{/if}
	</td></tr></table>
	</body>
</html>