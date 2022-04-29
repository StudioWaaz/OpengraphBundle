## Installation 

```
composer require waaz/opengraph-bundle:dev-main

```

Add the following lines to base.html.twig

```
{% include "@WaazOpengraph/open_graph.html.twig" with {
    "opengraph": extension.opengraph|default([]),
    "localizations": localizations|default([]),
} %}

```



