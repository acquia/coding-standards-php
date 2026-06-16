<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

final class AcquiaPHPMinimalTest extends AbstractRulesetTestCase
{

    private const STANDARD = 'AcquiaPHPMinimal';

    private const FIXTURES = __DIR__ . '/../fixtures/AcquiaPHPMinimal';

    public function testPassFixtureProducesNoViolations(): void
    {
        $this->assertStandardPasses(self::STANDARD, self::FIXTURES . '/pass.php');
    }

    // Regression: Generic.Arrays.ArrayIndent was added in PR #71 after phpcbf
    // was found to strip all array indentation instead of enforcing it.
    public function testUnindentedArrayContentsAreReported(): void
    {
        $this->assertViolationWithCode(
            'Generic.Arrays.ArrayIndent.KeyIncorrect',
            self::STANDARD,
            self::FIXTURES . '/fail-array-indent.php',
        );
    }

}
