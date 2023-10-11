<?php

declare(strict_types=1);

namespace RichId\TermsModuleSnappyBundle\Tests;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TermsModuleBundle\Domain\Entity\TermsVersionSignature;
use RichId\TermsModuleSnappyBundle\Infrastructure\Pdf\TermsVersionSignaturePdfSnappyGenerator;
use RichId\TermsModuleSnappyBundle\Tests\Resources\Entity\DummyUser;

/**
 * @covers \RichId\TermsModuleSnappyBundle\Infrastructure\Pdf\TermsVersionSignaturePdfSnappyGenerator
 * @TestConfig("fixtures")
 */
final class GeneratorTest extends TestCase
{
    /** @var TermsVersionSignaturePdfSnappyGenerator */
    public $generator;

    public function testGeneratorWithoutEditor(): void
    {
        $signature = $this->getReference(TermsVersionSignature::class, 'u42-signature-v1-terms-1');

        $output = ($this->generator)($signature);

        self::assertNotEmpty($output);
    }

    public function testGeneratorWithEditor(): void
    {
        $signature = $this->getReference(TermsVersionSignature::class, 'u42-signature-v1-terms-1');

        $output = ($this->generator)($signature, $this->getReference(DummyUser::class, '1'));

        self::assertNotEmpty($output);
    }
}
