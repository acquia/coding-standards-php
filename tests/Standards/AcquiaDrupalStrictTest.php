<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

final class AcquiaDrupalStrictTest extends AbstractRulesetTestCase
{

    private const STANDARD = 'AcquiaDrupalStrict';

    private const FIXTURES = __DIR__ . '/../fixtures/AcquiaDrupalStrict';

    public function testPassFixtureProducesNoViolations(): void
    {
        $this->assertStandardPasses(self::STANDARD, self::FIXTURES . '/pass.php');
    }

}
