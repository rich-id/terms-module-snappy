<?php

declare(strict_types=1);

namespace RichId\TermsModuleSnappyBundle\Infrastructure\Pdf;

use Knp\Snappy\Pdf;
use RichId\TermsModuleBundle\Domain\Entity\TermsUserInterface;
use RichId\TermsModuleBundle\Domain\Entity\TermsVersionSignature;
use RichId\TermsModuleBundle\Domain\Pdf\TermsVersionSignaturePdfGeneratorInterface;
use Twig\Environment;

class TermsVersionSignaturePdfSnappyGenerator implements TermsVersionSignaturePdfGeneratorInterface
{
    /** @var Environment */
    protected $twig;

    /** @var Pdf */
    protected $snappyPdf;

    public function __construct(Environment $twig, Pdf $snappyPdf)
    {
        $this->twig = $twig;
        $this->snappyPdf = $snappyPdf;
    }

    public function __invoke(TermsVersionSignature $termsVersionSignature, ?TermsUserInterface $editor = null): string
    {
        $pdf = $this->snappyPdf->getOutputFromHtml(
            $this->twig->render(
                '@RichIdTermsModule/admin/signature-list/_partial/_pdf.html.twig',
                [
                    'signature' => $termsVersionSignature,
                    'editor'    => $editor,
                ]
            ),
            [
                'margin-bottom' => 22,
                'footer-html'   => $this->twig->render('@RichIdTermsModule/admin/signature-list/_partial/_pdf-footer-wk.html.twig'),
            ]
        );

        if (!\is_string($pdf)) {
            throw new \Exception('An error occured on pdf generation.');
        }

        return $pdf;
    }
}
