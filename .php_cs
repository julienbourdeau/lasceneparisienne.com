<?php

$finder = PhpCsFixer\Finder::create()
  ->in([
    __DIR__.'/app',
    __DIR__.'/nova-components',
    __DIR__.'/tests',
  ])
;

$config = PhpCsFixer\Config::create()
  ->setRules([
    '@PSR2' => true,
    '@PhpCsFixer' => true,
    'list_syntax' => ['syntax' => 'short'],
    'multiline_whitespace_before_semicolons' => false,
    'no_empty_comment' => false,
    'no_superfluous_elseif' => false,
  ])
  ->setFinder($finder)
;

return $config;
