## Installation 

Add the following lines to base.html.twig

```
{% include "@WaazOpengraph/Extension/open_graph.html.twig" with {
    "opengraph": extension.opengraph|default([]),
    "localizations": localizations|default([]),
} %}

```



