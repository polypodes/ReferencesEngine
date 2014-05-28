<?php
namespace Application\Refactor\ReferenceBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Refactor\ReferenceBundle\Entity\Tag;

class TagToTitleTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;

    }//end __construct()

    /**
     * Transforms an object (tag) to a string (itle).
     *
     * @param  tag|null $title
     * @return string
     */
    public function transform($tag)
    {
        if (null === $tag) {
            return '';
        }

        return $tag->getTitle();

    }//end transform()

    /**
     * Transforms a string (title) to an object (tag).
     *
     * @param  string                        $title
     * @return tag|null
     * @throws TransformationFailedException if object (tag) is not found.
     */
    public function reverseTransform($title)
    {
        if (!$title) {
            return null;
        }

        $tag = $this->om
            ->getRepository('ApplicationRefactorReferenceBundle:Tag')
            ->findOneBy(array('title' => $title));

        if (null === $tag) {
            throw new TransformationFailedException(
                sprintf(
                    'Le problème avec le titre "%s" ne peut pas être trouvé!',
                    $title
                )
            );
        }

        return $tag;

    }//end reverseTransform()
}//end class
