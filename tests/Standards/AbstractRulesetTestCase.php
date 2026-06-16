<?php

declare(strict_types=1);

namespace Acquia\CodingStandards\Tests\Standards;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;

abstract class AbstractRulesetTestCase extends TestCase
{

    private const STANDARDS_DIR = __DIR__ . '/../../src/Standards';

    protected function assertStandardPasses(string $standard, string $fixture): void
    {
        $file = $this->processFixture($standard, $fixture);
        $errors = $file->getErrorCount();
        $warnings = $file->getWarningCount();

        $this->assertSame(
            0,
            $errors + $warnings,
            sprintf(
                "Expected no violations in %s under %s but found %d error(s) and %d warning(s):\n%s",
                basename($fixture),
                $standard,
                $errors,
                $warnings,
                $this->describeViolations($file),
            ),
        );
    }

    protected function assertViolationWithCode(string $sniffCode, string $standard, string $fixture): void
    {
        $file = $this->processFixture($standard, $fixture);
        $found = false;

        foreach ([$file->getErrors(), $file->getWarnings()] as $violationsByLine) {
            foreach ($violationsByLine as $lineViolations) {
                foreach ($lineViolations as $colViolations) {
                    foreach ($colViolations as $violation) {
                        if ($violation['source'] === $sniffCode) {
                            $found = true;
                            break 4;
                        }
                    }
                }
            }
        }

        $this->assertTrue(
            $found,
            sprintf(
                "Expected violation %s in %s under %s but did not find it.\nAll violations:\n%s",
                $sniffCode,
                basename($fixture),
                $standard,
                $this->describeViolations($file),
            ),
        );
    }

    private function processFixture(string $standard, string $fixture): LocalFile
    {
        $rulesetPath = self::STANDARDS_DIR . '/' . $standard . '/ruleset.xml';
        $config = new Config(['--standard=' . $rulesetPath]);
        $config->cache = false;
        $ruleset = new Ruleset($config);
        $file = new LocalFile($fixture, $ruleset, $config);
        $file->process();
        return $file;
    }

    private function describeViolations(LocalFile $file): string
    {
        $output = '';
        foreach ($file->getErrors() as $line => $lineErrors) {
            foreach ($lineErrors as $colErrors) {
                foreach ($colErrors as $error) {
                    $output .= "  ERROR   line {$line}: {$error['message']} ({$error['source']})\n";
                }
            }
        }
        foreach ($file->getWarnings() as $line => $lineWarnings) {
            foreach ($lineWarnings as $colWarnings) {
                foreach ($colWarnings as $warning) {
                    $output .= "  WARNING line {$line}: {$warning['message']} ({$warning['source']})\n";
                }
            }
        }
        return $output ?: "  (none)\n";
    }

}
