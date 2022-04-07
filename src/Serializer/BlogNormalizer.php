<?php
namespace App\Serializer;

use App\Entity\Blog;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BlogNormalizer implements ContextAwareNormalizerInterface
{
    private $urlHelper;
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer, UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
        $this->normalizer = $normalizer;
        
    }

    public function normalize($blog, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($blog, $format, $context);
        if (!empty($blog->getImage())) {
            $data['image'] = $this->urlHelper->getAbsoluteUrl('/storage/default/'. $blog->getImage());
        }
        // Here, add, edit, or delete some data:
        // $data['href']['self'] = $this->urlHelper->generate('blogs', [
        //     'id' => $blog->getId(),
        // ], UrlGeneratorInterface::ABSOLUTE_URL);
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Blog;
    }
}
?>