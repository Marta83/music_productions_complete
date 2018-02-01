<?php

namespace Tests\AppBundle\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Form\ArtistType;
use AppBundle\Entity\Artist;

class ArtistTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'name' => 'Artist name',
            'speciality' => 'Artist speciality',
        );

        $form = $this->factory->create(ArtistType::class);

        $artist = new Artist();
        $artist->setName($formData['name']);
        $artist->setSpeciality($formData['speciality']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($artist, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
