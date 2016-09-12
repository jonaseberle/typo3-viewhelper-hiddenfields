<?php
namespace Dm\Anbieter\ViewHelpers\Form;

class HiddenFieldsViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'input';

    /**
     * Renders the value as hidden field(s). Supports arrays.
     *
     * @return string
     * @api
     */
    public function render()
    {
        $this->tag->addAttribute('type', 'hidden');

        $name = $this->getName();

        $value = $this->getValue();
        $content = $this->renderHiddenFields($name, $value);

        return $content;
    }

    /**
     * Recursive generation of "hidden"-fields
     * @param string $name
     * @param mixed $value
     * @param string $content
     *
     * @return string
     */
    private function renderHiddenFields($name, $value, $content = '')
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $content .= $this->renderHiddenFields($name . '[' . $k . ']', $v);
            }
        } else {
            $this->registerFieldNameForFormTokenGeneration($name);
            $this->tag->addAttribute('name', $name);
            $this->tag->addAttribute('value', $value);

            $this->setErrorClassAttribute();

            $content .= $this->tag->render();
        }

        return $content;
    }
}