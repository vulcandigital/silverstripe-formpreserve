# silverstripe-formpreserve
Easily preserve and clear user entered form data contents via session in the event of errors

# Requirements
* silverstripe/framework: ^4

# Usage
```php
class YourForm extends Form 
{
    private static $extensions = [
        FormPreserveExtension::class
    ];
    
    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME, FieldList $fields = null, FieldList $actions = null, $validator = null)
    {
        /** @var ArrayData $preserved */
        $preserved = $this->retrievePreserved();

        $fields = FieldList::create([
            TextField::create('FirstName', 'First name:', $preserved->FirstName)->setAttribute('required', true),
            EmailField::create('Email', 'Your email:', $preserved->Email)->setAttribute('placeholder', 'Where do we send our response?')->setAttribute('required', true),
        ]);

        $actions = FieldList::create([
            FormAction::create('doSubmit', 'Send')->setUseButtonTag(true)->setButtonContent('<i class="fal fa-paper-plane"></i> Send')->addExtraClass('btn btn-primary')
        ]);

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }
}
```

**Your form submit action:**

```php
class ContactPageController extends \PageController 
{
   public function doSubmit($data, Form $form)
    {
        FormPreserve::preserve($form, $data);

        if (!isset($data['Email']) || !filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
            return $this->redirectBack();
        }

        FormPreserve::clear($form);
        return $this->redirectBack();
    }
}
```
