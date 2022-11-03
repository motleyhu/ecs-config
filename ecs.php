<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\CyclomaticComplexitySniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\NestingLevelSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\ClassCommentSniff;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\ControlStructure\NoTrailingCommaInListCallFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoTrailingCommaInSinglelineFunctionCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\FunctionNotation\UseArrowFunctionsFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();

    $ecsConfig->sets([SetList::PSR_12, SetList::CLEAN_CODE, SetList::DOCTRINE_ANNOTATIONS]);

    $ecsConfig->rules([
        ArrayIndentationFixer::class,
        BlankLineBeforeStatementFixer::class,
        ClassCommentSniff::class,
        CyclomaticComplexitySniff::class,
        DeclareStrictTypesFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        FunctionTypehintSpaceFixer::class,
        GlobalNamespaceImportFixer::class,
        HeredocIndentationFixer::class,
        IsNullFixer::class,
        LineLengthFixer::class,
        MethodChainingIndentationFixer::class,
        NativeFunctionInvocationFixer::class,
        NestingLevelSniff::class,
        NoEmptyPhpdocFixer::class,
        NoExtraBlankLinesFixer::class,
        NoTrailingCommaInListCallFixer::class,
        NoTrailingCommaInSinglelineArrayFixer::class,
        NoTrailingCommaInSinglelineFunctionCallFixer::class,
        NullableTypeDeclarationForDefaultNullValueFixer::class,
        ObjectOperatorWithoutWhitespaceFixer::class,
        PhpdocIndentFixer::class,
        PhpdocTrimFixer::class,
        SingleLineCommentSpacingFixer::class,
        StandaloneLinePromotedPropertyFixer::class,
        UseArrowFunctionsFixer::class,
        StaticLambdaFixer::class,
        SingleQuoteFixer::class,
        UpperCaseConstantNameSniff::class,
        ModernizeTypesCastingFixer::class,
        ExplicitStringVariableFixer::class,
        RemoveUselessDefaultCommentFixer::class,
        NoUselessElseFixer::class,
        NoUselessNullsafeOperatorFixer::class,
        NoUselessReturnFixer::class,
        NoUselessSprintfFixer::class,
        PhpdocNoUselessInheritdocFixer::class,
    ]);

    $isPhp7 = PHP_MAJOR_VERSION < 8;

    if (!$isPhp7) {
        $ecsConfig->rule(ModernizeStrposFixer::class);
        $ecsConfig->rule(GetClassToClassKeywordFixer::class);
    }

    $ecsConfig->ruleWithConfiguration(TrailingCommaInMultilineFixer::class, [
        'elements' => $isPhp7 < 8 ? ['arrays', 'arguments'] : ['arrays', 'arguments', 'parameters', 'match'],
    ]);
    $ecsConfig->ruleWithConfiguration(OrderedClassElementsFixer::class, [
        'order' => ['use_trait', 'constant', 'case', 'property', 'construct', 'destruct', 'magic', 'method'],
    ]);
    $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'method' => 'one',
        ],
    ]);
    $ecsConfig->ruleWithConfiguration(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
        'remove_inheritdoc' => true,
    ]);
};
