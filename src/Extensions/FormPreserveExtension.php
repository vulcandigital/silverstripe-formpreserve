<?php

namespace Vulcan\FormPreserve\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\View\ArrayData;
use Vulcan\FormPreserve\FormPreserve;

/**
 * Class FormPreserveExtension
 * @package Vulcan\FormPreserve\Extensions
 *
 * @method Form getOwner()
 */
class FormPreserveExtension extends Extension
{
    public function retrievePreserved()
    {
        $data = FormPreserve::retrieve($this->getOwner());
        if ($data) {
            return ArrayData::create($data);
        }

        return ArrayData::create([]);
    }
}