<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

use PHPUnit\Framework\Attributes\DataProvider;

final class AcquiaPHPStrictTest extends AbstractRulesetTestCase
{

    private const STANDARD = 'AcquiaPHPStrict';

    private const FIXTURES = __DIR__ . '/../fixtures/AcquiaPHPStrict';

    public function testPassFixtureProducesNoViolations(): void
    {
        $this->assertStandardPasses(self::STANDARD, self::FIXTURES . '/pass.php');
    }

    public static function violationCases(): iterable
    {
        return [
            // Four cases cover the full custom DeclareStrictTypes config.
            'declare(strict_types=1) missing entirely' => [
                'fail-declare-strict-types.php',
                'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.DeclareStrictTypesMissing',
            ],
            // spacesCountAroundEqualsSign=0 overrides Slevomat default to avoid PSR-12 conflict.
            'declare with spaces around equals' => [
                'fail-declare-strict-types-spaces.php',
                'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.IncorrectStrictTypesFormat',
            ],
            'declare without blank line before (linesCountBeforeDeclare=1 config)' => [
                'fail-declare-strict-types-no-line-before.php',
                'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.IncorrectWhitespaceBeforeDeclare',
            ],
            'declare without blank line after (linesCountAfterDeclare=1 config)' => [
                'fail-declare-strict-types-no-line-after.php',
                'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.IncorrectWhitespaceAfterDeclare',
            ],

            'superglobal variable' => [
                'fail-superglobal.php',
                'SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable',
            ],
            'unsorted use statements' => [
                'fail-unsorted-uses.php',
                'SlevomatCodingStandard.Namespaces.AlphabeticallySortedUses.IncorrectlyOrderedUses',
            ],

            // Regression: rule was omitted from the v3 rewrite, re-added in PR #74.
            'unused use statement' => [
                'fail-unused-use.php',
                'Drupal.Classes.UnusedUseStatement.UnusedUse',
            ],

            // Regression: deprecated comma-separated array property syntax silently
            // broke both rules until fixed in PR #84.
            'forbidden @author annotation' => [
                'fail-forbidden-annotation.php',
                'SlevomatCodingStandard.Commenting.ForbiddenAnnotations.AnnotationForbidden',
            ],
            '"Class X." forbidden comment pattern' => [
                'fail-forbidden-comment.php',
                'SlevomatCodingStandard.Commenting.ForbiddenComments.CommentForbidden',
            ],

            'property without type hint' => [
                'fail-missing-type-hints.php',
                'SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint',
            ],
            'parameter without type hint' => [
                'fail-missing-type-hints.php',
                'SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint',
            ],
            'return without type hint' => [
                'fail-missing-type-hints.php',
                'SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint',
            ],
        ];
    }

    #[DataProvider('violationCases')]
    public function testViolationIsReported(string $fixture, string $sniffCode): void
    {
        $this->assertViolationWithCode($sniffCode, self::STANDARD, self::FIXTURES . '/' . $fixture);
    }

}
