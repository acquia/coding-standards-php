<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

final class AcquiaPHPStrictTest extends AbstractRulesetTestCase
{

    private const STANDARD = 'AcquiaPHPStrict';

    private const FIXTURES = __DIR__ . '/../fixtures/AcquiaPHPStrict';

    public function testPassFixtureProducesNoViolations(): void
    {
        $this->assertStandardPasses(self::STANDARD, self::FIXTURES . '/pass.php');
    }

    public function testMissingDeclareStrictTypesIsReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.DeclareStrictTypesMissing',
            self::STANDARD,
            self::FIXTURES . '/fail-declare-strict-types.php',
        );
    }

    // Validates the custom spacesCountAroundEqualsSign=0 configuration, which
    // overrides Slevomat's default to avoid conflict with PSR-12 spacing rules.
    public function testDeclareStrictTypesWithSpacesIsReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.TypeHints.DeclareStrictTypes.IncorrectStrictTypesFormat',
            self::STANDARD,
            self::FIXTURES . '/fail-declare-strict-types-spaces.php',
        );
    }

    public function testSuperglobalUsageIsReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable',
            self::STANDARD,
            self::FIXTURES . '/fail-superglobal.php',
        );
    }

    public function testUnsortedUseStatementsAreReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.Namespaces.AlphabeticallySortedUses.IncorrectlyOrderedUses',
            self::STANDARD,
            self::FIXTURES . '/fail-unsorted-uses.php',
        );
    }

    // Regression: UnusedUseStatement was omitted from the v3 ruleset and
    // re-added in PR #74 after being discovered missing.
    public function testUnusedUseStatementIsReported(): void
    {
        $this->assertViolationWithCode(
            'Drupal.Classes.UnusedUseStatement.UnusedUse',
            self::STANDARD,
            self::FIXTURES . '/fail-unused-use.php',
        );
    }

    // Regression: ForbiddenAnnotations used deprecated comma-separated array
    // syntax (issue #83 / PR #84), which silently broke the rule. This test
    // validates the <element> syntax fix actually fires the rule.
    public function testForbiddenAnnotationIsReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.Commenting.ForbiddenAnnotations.AnnotationForbidden',
            self::STANDARD,
            self::FIXTURES . '/fail-forbidden-annotation.php',
        );
    }

    // Regression: ForbiddenComments had the same deprecated array syntax issue
    // as ForbiddenAnnotations (issue #83 / PR #84).
    public function testForbiddenCommentPatternIsReported(): void
    {
        $this->assertViolationWithCode(
            'SlevomatCodingStandard.Commenting.ForbiddenComments.CommentForbidden',
            self::STANDARD,
            self::FIXTURES . '/fail-forbidden-comment.php',
        );
    }

}
