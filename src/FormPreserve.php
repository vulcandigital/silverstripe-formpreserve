<?php

namespace Vulcan\FormPreserve;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Forms\Form;
use SilverStripe\View\Parsers\URLSegmentFilter;

class FormPreserve
{
    use Injectable, Configurable;

    public static function preserve(Form $form, array $data)
    {
        $session = static::getSession();
        $key = static::getFilteredFormClass($form);

        $session->set("FormPreserve.{$key}", $data);
    }

    public static function retrieve(Form $form)
    {
        $session = static::getSession();
        $key = static::getFilteredFormClass($form);

        return $session->get("FormPreserve.{$key}");
    }

    public static function clear(Form $form = null)
    {
        $session = static::getSession();

        if (!$form) {
            $session->clear("FormPreserve");
            unset($_SESSION["FormPreserve"]);
            return;
        }

        $key = static::getFilteredFormClass($form);
        $session->clear("FormPreserve.{$key}");
        unset($_SESSION["FormPreserve"][$key]);
    }

    private static function getSession()
    {
        return Controller::curr()->getRequest()->getSession();
    }

    private static function getFilteredFormClass(Form $form)
    {
        return URLSegmentFilter::create()->filter(get_class($form));
    }
}