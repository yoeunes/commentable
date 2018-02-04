<?php

use Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;
use Symfony\CS\Finder\DefaultFinder;

$fixers = [
    '-psr0',
    'blankline_after_open_tag',
    'braces',
    'concat_without_spaces',
    'double_arrow_multiline_whitespaces',
    'duplicate_semicolon',
    'elseif',
    'empty_return',
    'encoding',
    'eof_ending',
    'extra_empty_lines',
    'function_call_space',
    'function_declaration',
    'include',
    'indentation',
    'join_function',
    'line_after_namespace',
    'linefeed',
    'list_commas',
    'logical_not_operators_with_successor_space',
    'lowercase_constants',
    'lowercase_keywords',
    'method_argument_space',
    'multiline_array_trailing_comma',
    'multiline_spaces_before_semicolon',
    'multiple_use',
    'namespace_no_leading_whitespace',
    'no_blank_lines_after_class_opening',
    'no_empty_lines_after_phpdocs',
    'object_operator',
    'operators_spaces',
    'parenthesis',
    'phpdoc_indent',
    'phpdoc_inline_tag',
    'phpdoc_no_access',
    'phpdoc_no_package',
    'phpdoc_scalar',
    'phpdoc_short_description',
    'phpdoc_to_comment',
    'phpdoc_trim',
    'phpdoc_type_to_var',
    'phpdoc_var_without_name',
    'remove_leading_slash_use',
    'remove_lines_between_uses',
    'return',
    'self_accessor',
    'short_array_syntax',
    'short_echo_tag',
    'short_tag',
    'single_array_no_trailing_comma',
    'single_blank_line_before_namespace',
    'single_line_after_imports',
    'single_quote',
    'spaces_before_semicolon',
    'spaces_cast',
    'standardize_not_equal',
    'ternary_spaces',
    'trailing_spaces',
    'trim_array_spaces',
    'unalign_equals',
    'unary_operators_spaces',
    'unused_use',
    'visibility',
    'whitespacy_lines',
    'blank_line_after_namespace',
    'function_typehint_space',
    'encoding',
    '-psr0',
    'align_double_arrow',
    'binary_operator_spaces',
    'blank_line_after_namespace',
    'blank_line_after_opening_tag',
    'blank_line_before_return',
    'braces',
    'cast_spaces',
    'class_definition',
    'concat_without_spaces',
    'elseif',
    'encoding',
    'full_opening_tag',
    'function_declaration',
    'function_typehint_space',
    'hash_to_slash_comment',
    'heredoc_to_nowdoc',
    'include',
    'lowercase_cast',
    'lowercase_constants',
    'lowercase_keywords',
    'method_argument_space',
    'method_separation',
    'native_function_casing',
    'new_with_braces',
    'no_alias_functions',
    'no_blank_lines_after_class_opening',
    'no_blank_lines_after_phpdoc',
    'no_blank_lines_between_uses',
    'no_closing_tag',
    'no_duplicate_semicolons',
    'no_empty_phpdoc',
    'no_extra_consecutive_blank_lines',
    'no_leading_import_slash',
    'no_leading_namespace_whitespace',
    'no_multiline_whitespace_around_double_arrow',
    'no_multiline_whitespace_before_semicolons',
    'no_short_bool_cast',
    'no_singleline_whitespace_before_semicolons',
    'no_spaces_after_function_name',
    'no_spaces_inside_parenthesis',
    'no_tab_indentation',
    'no_trailing_comma_in_list_call',
    'no_trailing_comma_in_singleline_array',
    'no_trailing_whitespace',
    'no_trailing_whitespace_in_comment',
    'no_unneeded_control_parentheses',
    'no_unreachable_default_argument_value',
    'no_unused_imports',
    'no_useless_return',
    'no_whitespace_before_comma_in_array',
    'no_whitespace_in_blank_lines',
    'not_operator_with_successor_space',
    'object_operator_without_whitespace',
    'ordered_imports',
    'phpdoc_align',
    'phpdoc_indent',
    'phpdoc_inline_tag',
    'phpdoc_no_access',
    'phpdoc_no_package',
    'phpdoc_order',
    'phpdoc_params',
    'phpdoc_scalar',
    'phpdoc_separation',
    'phpdoc_short_description',
    'phpdoc_summary',
    'phpdoc_to_comment',
    'phpdoc_trim',
    'phpdoc_type_to_var',
    'phpdoc_types',
    'phpdoc_var_without_name',
    'print_to_echo',
    'psr4',
    'self_accessor',
    'short_array_syntax',
    'short_scalar_cast',
    'simplified_null_return',
    'single_blank_line_at_eof',
    'single_blank_line_before_namespace',
    'single_import_per_statement',
    'single_line_after_imports',
    'single_quote',
    'space_after_semicolon',
    'standardize_not_equals',
    'switch_case_semicolon_to_colon',
    'switch_case_space',
    'ternary_operator_spaces',
    'trailing_comma_in_multiline_array',
    'trim_array_spaces',
    'unalign_equals',
    'unary_operator_spaces',
    'unix_line_endings',
    'visibility_required',
    'whitespace_after_comma_in_array',
];

return Config::create()
    ->finder(DefaultFinder::create()->in(__DIR__))
    ->fixers($fixers)
    ->level(FixerInterface::PSR2_LEVEL)
    ->setUsingCache(false);
