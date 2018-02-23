<?php

namespace Vulcan\FormPreserve\Tests;

use SilverStripe\Control\RequestHandler;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Validator;
use SilverStripe\View\ArrayData;
use Vulcan\FormPreserve\Extensions\FormPreserveExtension;
use Vulcan\FormPreserve\FormPreserve;

class FormPreserveTest extends FunctionalTest
{
    public function testPreserve()
    {
        $this->assertTrue(true);
    }
}

class TestForm extends Form implements TestOnly
{
    private static $extensions = [
        FormPreserveExtension::class
    ];

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME, FieldList $fields = null, FieldList $actions = null, $validator = null)
    {
        /** @var ArrayData $preserve */
        $preserve = $this->retrievePreserved();

        $fields = FieldList::create([
            TextField::create('TestField', 'Test', $preserve->TestField)
        ]);

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }
}