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

}
