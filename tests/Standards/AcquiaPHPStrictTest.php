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

}
