<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

final class AcquiaDrupalMinimalTest extends AbstractRulesetTestCase
{

    private const STANDARD = 'AcquiaDrupalMinimal';

    private const FIXTURES = __DIR__ . '/../fixtures/AcquiaDrupalMinimal';

    public function testPassFixtureProducesNoViolations(): void
    {
        $this->assertStandardPasses(self::STANDARD, self::FIXTURES . '/pass.php');
    }

}
