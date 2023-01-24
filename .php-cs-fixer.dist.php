<?php

$finder = PhpCsFixer\Finder::create()
    //->exclude('tests/Fixtures')
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'ordered_class_elements' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'psr_autoloading' => true,
        'heredoc_to_nowdoc' => true,
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedException', 'expectedExceptionMessage', 'expectedExceptionMessageRegExp']],
        'class_attributes_separation' => ['elements' => ['method' => 'one', 'property' => 'one', 'trait_import' => 'none']],
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'blank_line_before_statement' => ['statements' => ['if', 'switch', 'case', 'default', 'declare', 'return', 'throw', 'try', 'foreach', 'while']],
    ))
    ->setFinder($finder)
;
