# mockmodule

A mockmodule to use with the kirby [module](https://github.com/getkirby-plugins/modules-plugin) system + [patterns](https://github.com/getkirby-plugins/patterns-plugin).

If you've used kirby's modules together with the patterns plugin, you may have noticed that supporting the pattern previews in modules is hard.

This Plugin allows you to use a "mockmodule" to generate static content for the pattern preview.

As an example, here is a complete accordion module. 

```php
<?php
# accordion.config.php

// return the data in a format expected by the module/pattern
return [
    'preview' => function () {
        return [
            'module' => new Plusforta\MockModule([
                'headline'       => 'default heading',
                'headlineStyle'  => false,
                'headlineSize'   => '28px',
                'headlineColor'  => 'default',
                'headlineWeight' => 'default',
                'iconStyle'      => 'question-circle-o',
                'accordions'     => [
                    [
                        'subheading' => 'Heading 1',
                        'text'       => 'text 1',
                        'startopen'  => false,
                    ],
                    [
                        'subheading' => 'Heading 2',
                        'text'       => 'text 2',
                        'startopen'  => true,
                    ],
                    [
                        'subheading' => 'Heading 3',
                        'text'       => 'text 3',
                        'startopen'  => false,
                    ],
                ]
            ])
        ];
    }
];
```

```php
# accordion.html.php
<?php

$icon       = $module->iconStyle()->isEmpty() ? '' :
    '<i class="fa fa-' . $module->iconStyle()->html()->value() . '" aria-hidden="true"></i>&nbsp;&nbsp;';
$accordions = [];

foreach ($module->accordions()->toStructure() as $accordion) {
    $accordions [] = [
        'subheading' => $icon . $accordion->subheading()->kirbytextSans(),
        'content'    => $accordion->text()->kt(),
        'startopen'  => $accordion->startopen()->bool(),
    ];
}
?>
<div class="o-accordion">
    <?php

    pattern(
        'atoms/typography/heading',
        [
            'text'  => $module->headline()->kirbytextSans(),
            'style' => generateHeadlineStyle(
                $module->headlineStyle()->bool(),
                $module->headlineSize()->value(),
                $module->headlineColor()->value(),
                $module->headlineWeight()->value()
            ),
            'tag' => 'h2',
        ]
    );

    pattern('molecules/accordion', ['accordions' => $accordions]);
    ?>
</div>


<script type="application/javascript">
  // wait for jQuery to be loaded.
  var waitForJQuery<?= $module->hash() ?> = setInterval(function () {
    if (typeof $ != 'undefined') {

      // init the accordion
      $(function () {
        $('.m-accordion').Accordion()
      })

      clearInterval(waitForJQuery<?= $module->hash() ?>)
    }
  }, 10)

</script>
```

```YAML
# accordion.yml
title: Accordion
pages: false
files: true
fields:
  pfmodule:
    extends: pfmodule
  pfheadline:
    extends: pfheadline
  accordions:
    label: Accordions
    type: structure
    style: table
    fields:
      subheading:
        label:
          en: Heading
          de: Titel
        type: text
      content:
        extends: pfmdtext
      startopen:
        label:
          en: Start open?
          de: Beim Start aufklappen?
        type: toggle
        default: false
  iconStyle:
    label:
      en: Class name of the font from https://fontawesome.com/v4.7.0/icons/.  (Leave blank for none)
      de:
    default: question-circle-o
```
