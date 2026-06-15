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

}
