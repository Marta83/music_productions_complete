<?php

namespace Tests\AppBundle\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Form\AlbumType;
use AppBundle\Entity\Album;

class AlbumTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'Album title',
        );

        $form = $this->factory->create(AlbumType::class);

        $album = new Album();
        $album->setTitle($formData['title']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($album, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
