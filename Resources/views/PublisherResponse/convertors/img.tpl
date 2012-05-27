{ if !empty(originalImg) }
<a href="{{ originalImg }}">
<img src="{{ src }}"
title="{{ title }} Click to enlarge!"
label="{{ title }} Click to enlarge!"/>
</a>
{ else }
<img src="{{ src }}"
title="{{ title }}"
label="{{ title }}"/>
{/if}