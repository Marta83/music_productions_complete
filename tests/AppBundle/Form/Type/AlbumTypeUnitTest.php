<?php

namespace Tests\AppBundle\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Form\AlbumType;
use AppBundle\Entity\Album;

class AlbumTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $published = new \DateTime();
        $formData = array(
            'title' => 'Album title',
            'published_at' => null,
        );

        $form = $this->factory->create(AlbumType::class);

        $album = new Album($formData['title'], new \DateTime());

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
